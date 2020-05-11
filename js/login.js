import * as Cmn from "./modules/common.js";

const eventListeners = [
    {
        "id": "login-form",
        "eventType": "submit",
        "function": login
    }, {
        "dataListener": "errorCheck",
        "eventType": "input",
        "function": Cmn.errorCheck
    }
];

window.addEventListener("DOMContentLoaded", async function() {
    Cmn.addListeners(eventListeners);
});

async function login() {
    event.preventDefault();

    var form = this || event.target;
    if (!Cmn.checkErrors([...form.elements])) { return Cmn.toast("Errors in form fields", "error"); }

    var formData = new FormData(form),
        response = await (await fetch("/php/login.php", {method: "POST", body: formData})).json();
    if (response.Success) {
        Cmn.insertInlineMessage("after", "login", response.Message, {type: "success"});
        setTimeout(() => window.location.href = "/feed.php", 500);
    } else {
        Cmn.insertInlineMessage("after", "login", response.Message, {type: "error"});
    }
}

async function register() {
    event.preventDefault();

    var form = this || event.target;
    if (!Cmn.checkErrors([...form.elements])) { return Cmn.toast("Errors in form fields", "error"); }

    var formData = new FormData(form),
        response = await (await fetch("/php/register.php", {method: "POST", body: formData})).json();
    if (response.Success) {
        Cmn.insertInlineMessage("after", "register", response.Message, {type: "success"});
        setTimeout(() => window.location.href = "/feed.php", 500);
    } else {
        Cmn.insertInlineMessage("after", "register", response.Message, {type: "error"});
    }
}