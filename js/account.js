import * as Cmn from "./modules/Cmn.js";

const eventListeners = [
    {
        "dataListener": "updateAccount",
        "eventType": "submit",
        "function": updateAccount
    }, {
        "domObject": document,
        "eventType": "click",
        "function": Cmn.closeMenus
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
        setTimeout(() => window.location.href = "/login.php", 1000);
    } else {
        Cmn.toast(response.Message, "error");
    }
}

async function updateAccount() {
    event.preventDefault();
    if (!Cmn.checkErrors([...this.elements])) { return Cmn.toast("Errors in form fields", "error"); }

    let formData = new FormData(this);
    formData.append("formType", this.dataset.formType);

    let response = await (await fetch("/php/update-account.php", {method: "POST", body: formData})).json();
    response.Success ? Cmn.toast(response.Message, "success") : Cmn.toast(response.Message, "error");
}