import * as Cmn from "./modules/common.js";

const eventListeners = [
    {
        "id": "signout",
        "eventType": "submit",
        "function": logout
    }, {
        "dataListener": "updateAccount",
        "eventType": "submit",
        "function": updateAccount
    }, {
        "dataListener": "notImplemented",
        "eventType": "click",
        "function": () => { event.preventDefault(); Cmn.toast("Feature not implemented", "warning"); }
    }
];

window.addEventListener("DOMContentLoaded", async function() {
    Cmn.addListeners(eventListeners);
});

/******************************* ACCOUNT *******************************/
async function logout() {
    event.preventDefault();
    let response = await (await fetch("/php/logout.php")).json();
    if (response.Success) {
        Cmn.toast(response.Message, "success");
        setTimeout(() => window.location.href = "/feed", 300);
    } else {
        Cmn.toast(response.Message, "error");
    }
}

async function updateAccount() {
    event.preventDefault();
    //if (!Cmn.checkErrors([...this.elements])) { return Cmn.toast("Errors in form fields", "error"); }

    let formData = new FormData(this);
    formData.append("formType", this.dataset.formType);

    let response = await (await fetch("/php/update-account.php", {method: "POST", body: formData})).json();
    response.Success ? Cmn.toast(response.Message, "success") : Cmn.toast(response.Message, "error");
}