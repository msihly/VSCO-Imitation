import * as Cmn from "./modules/common.js";

const eventListeners = [
    {
        "id": "loginForm",
        "eventType": "submit",
        "function": () => login()
    }, {
        "dataListener": "notImplemented",
        "eventType": "click",
        "function": () => { event.preventDefault(); Cmn.toast("Feature not implemented", "warning"); }
    }
];

window.addEventListener("DOMContentLoaded", async function() {
    Cmn.addListeners(eventListeners);
});

async function login() {
    event.preventDefault();

    let form = this || event.target;
    //if (!Cmn.checkErrors([...form.elements])) { return Cmn.toast("Errors in form fields", "error"); }

    let formData = new FormData(form),
        response = await (await fetch("/php/login.php", {method: "POST", body: formData})).json();
    if (response.Success) {
        Cmn.toast(response.Message, "success");
        setTimeout(() => window.location.href = "/feed.php", 300);
    } else {
        Cmn.toast(response.Message, "error");
    }
}

/*
async function register() {
    event.preventDefault();

    let form = this || event.target;
    if (!Cmn.checkErrors([...form.elements])) { return Cmn.toast("Errors in form fields", "error"); }

    let formData = new FormData(form),
        response = await (await fetch("/php/register.php", {method: "POST", body: formData})).json();
    if (response.Success) {
        Cmn.insertInlineMessage("after", "register", response.Message, {type: "success"});
        setTimeout(() => window.location.href = "/feed.php", 300);
    } else {
        Cmn.insertInlineMessage("after", "register", response.Message, {type: "error"});
    }
}
*/