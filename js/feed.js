import * as Cmn from "./modules/common.js";

const eventListeners = [
    {
        "id": "loadPage",
        "eventType": "click",
        "function": () => { loadPage(FeedG.curPage + 1); FeedG.curPage++; }
    }, {
        "dataListener": "modalClose",
        "eventType": "mousedown",
        "function": modalClose
    }, {
        "dataListener": "notImplemented",
        "eventType": "click",
        "function": () => { event.preventDefault(); Cmn.toast("Feature not implemented", "warning"); }
    }, {
        "domObject": document,
        "eventType": "click",
        "function": Cmn.closeMenus
    }
];

const FeedG = {
    curPage: 1,
    posts: [],
    postsPerPage: 14
}

window.addEventListener("DOMContentLoaded", async function() {
    Cmn.addListeners(eventListeners);
    FeedG.posts = await getPosts();
    if(!checkEmpty(FeedG.posts)) { createPosts(FeedG.posts); }
});

/******************************* MODAL *******************************/
function modalClose(del = false, modalID = null) {
    event.stopPropagation();
    let modal = document.getElementById(modalID || event.target.dataset.modal);
	if ((modalID && modal) || event.target == modal || event.target.classList.contains("close")) { del ? modal.remove() : modal.classList.add("hidden"); }
}

function modalPost(post) {

}

/******************************* POSTS *******************************/
function checkEmpty(arr) {
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
                            <h6 class="MediaThumnailCaption-author truncate">
                                ${shareHtml}
                                <a href="/${post.Author}">${post.Author}</a>
                            </h6>
                        </figcaption>
                    </figure>`;

    let frag = document.createRange().createContextualFragment(postHtml);
    frag.querySelector(`#p${post.PostID}`).addEventListener("click", () => modalPost(post));
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
        displayedPosts = FeedG.posts.slice(start, end);
    createPosts(FeedG.postsContainer, displayedPosts);
}