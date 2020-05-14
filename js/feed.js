import * as Cmn from "./modules/common.js";

const eventListeners = [
    {
        "id": "loadPage",
        "eventType": "click",
        "function": () => loadPage(FeedG.curPage + 1)
    }, {
        "dataListener": "notImplemented",
        "eventType": "click",
        "function": () => { event.preventDefault(); Cmn.toast("Feature not implemented", "warning"); }
    }
];

const FeedG = {
    curPage: 0,
    posts: [],
    postsContainer: "",
    postsPerPage: 14
}

const ImageObserver = new MutationObserver(mutations => {
    mutations.forEach(m => {
        try {
            if (m.addedNodes.length > 0) {
                let unloaded = [];
                m.addedNodes.forEach(e => {
                    let wrapper = e.querySelector(".MediaBgColorWrapper--withRatio"),
                        img = wrapper.firstElementChild;
                    (img.naturalWidth == 0 || img.naturalHeight == 0) ? unloaded.push(wrapper) : wrapper.style = `padding-top: ${100 / (img.naturalWidth / img.naturalHeight)}%`;
                });
                setTimeout(() => {
                    unloaded.forEach(e => {
                        let img = e.firstElementChild;
                        e.style = `padding-top: ${100 / (img.naturalWidth / img.naturalHeight)}%`;
                    });
                }, 50);
            }
        } catch (err) {
            console.error([err.message, m]);
        }
    });
});

window.addEventListener("DOMContentLoaded", async function() {
    Cmn.addListeners(eventListeners);
    FeedG.postsContainer = document.getElementById("posts-container");
    ImageObserver.observe(FeedG.postsContainer, { childList: true, subtree: true });
    FeedG.posts = await getPosts();
    if(!checkEmpty(FeedG.posts)) { loadPage(1); }
});

/******************************* MODAL *******************************/
function modalClose(del = false, modalID = null) {
    event.stopPropagation();
    let modal = document.getElementById(modalID || event.target.dataset.modal);
	if ((modalID && modal) || event.target == modal || event.target.classList.contains("close")) { del ? modal.remove() : modal.classList.add("hidden"); }
}

function modalPost(post) {
    Cmn.toast("Modals not implemented", "warning");
}

/******************************* POSTS *******************************/
function checkEmpty(arr) {
    if (arr == undefined) { return console.error("Undefined reference passed to 'checkEmpty(arr)' function"); }
    return arr.length < 1 ? true : false;
}

function createPost(post) {
    let shareHtml = (post.Sharer == undefined || post.Sharer == post.Author) ? "" :
                    `<a href="/${post.Sharer}">${post.Sharer}</a>
                    <span class="css-lhb07k e14t7ikp0">
                        <svg width="14" height="14" viewBox="0 0 24 24" class="css-uk6cul" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 5v2H6l-.001 9.726L8.326 14.4l1.43 1.417-4.713 4.697L.3 15.817 1.76 14.4 4 16.659 4 5h8zm7-1.4l4.743 4.697-1.46 1.417-2.284-2.304L20 19h-8v-2h6l-.001-9.569-2.282 2.283-1.43-1.417L19 3.6z" fill="#888" fill-rule="evenodd"></path>
                        </svg>
                    </span>`;
    let postHtml = `<figure class="MediaThumbnail grid-item">
                        <a href="${post.PostURL}" id="p${post.PostID}">
                            <div class="MediaImage relative">
                                <div class="MediaBgColorWrapper--withRatio relative">
                                    <img src="${post.ImagePath}">
                                </div>
                            </div>
                        </a>
                        <figcaption class="MediaThumbnailCaption">
                            <h6 class="MediaThumbnailCaption-author truncate">
                                ${shareHtml}
                                <a href="/${post.Author}">${post.Author}</a>
                            </h6>
                        </figcaption>
                    </figure>`;

    let frag = document.createRange().createContextualFragment(postHtml);
    frag.querySelector(`#p${post.PostID}`).addEventListener("click", () => { event.preventDefault(); modalPost(post); });
	return frag;
}

function createPosts(container, posts) {
    let docFrag = document.createDocumentFragment();
    posts.forEach(post => docFrag.appendChild(createPost(post)));
    container.appendChild(docFrag);
}

async function getPosts() {
    let response = await (await fetch("/php/get-posts.php")).json();
    if (!response.Success) { Cmn.toast("Error getting posts", "error"); }
    return response.Posts;
}

/******************************* PAGINATION *******************************/
function loadPage(page) {
    let end =  page * FeedG.postsPerPage,
        start = end - FeedG.postsPerPage,
        addedPosts = FeedG.posts.slice(start, end);
    addedPosts.length > 0 ? createPosts(FeedG.postsContainer, addedPosts) : Cmn.toast("No more posts found", "blue");
    FeedG.curPage = page;
}