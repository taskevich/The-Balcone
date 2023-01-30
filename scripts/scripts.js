let modal = document.getElementById('myModal');
let span = document.getElementsByClassName("close")[0];
let doneBtn = document.getElementById("doneBtn");
let actionForm = document.getElementById("actionForm");
let divPhoto = document.getElementById("photos");
let btns = document.querySelectorAll("#myBtn");
let title = document.getElementById("title");
let description = document.getElementById("description");
let viewImage = document.getElementById("viewImage");
let hideImage = document.getElementById("hideImage");

let onEditVisibility = [];
let goodId = null;
let status = null;

change_visibility()
modal_badyaga()
function modal_badyaga()
{
    for (const btn of btns) {
        btn.addEventListener("click", async (e) => {
            goodId = parseInt(btn.getAttribute("goodId"));
            status = parseInt(btn.getAttribute("status"));

            if (parseInt(btn.getAttribute("edit")) === 0) {
                doneBtn.innerText = "Загрузить";
                doneBtn.setAttribute("type", "upload");
                doneBtn.setAttribute("name", "upload_process");
                actionForm.setAttribute("action", "../php_scripts/upload.php");
                viewImage.style.display = "none";
                hideImage.style.display = "none";
            } else {
                doneBtn.setAttribute("type", "edit");
                doneBtn.setAttribute("name", "edit_process");
                doneBtn.setAttribute("status", `${status}`);
                actionForm.setAttribute("action", "../panel/edit.php?id=" + goodId);
                doneBtn.innerText = "Сохранить";
                viewImage.style.display = "block";
                hideImage.style.display = "block";

                let res = await request_returns("GET", goodId);
                title.value = res[0]["good"]["title"];
                description.innerText = res[0]["good"]["description"];
                for (const key in res[0]["photo"])
                {
                    const img = document.createElement("img");
                    img.setAttribute("src", res[0]["photo"][key]["path_to_photo"]);
                    img.setAttribute("width", "100");
                    img.setAttribute("height", "100");
                    img.setAttribute("class", "");
                    img.setAttribute("status", res[0]["photo"][key]["status"]);
                    img.setAttribute("imageId", res[0]["photo"][key]["id"]);

                    if (res[0]["photo"][key]["status"] === 0) {
                        img.classList.add("hided_image");
                    }

                    divPhoto.appendChild(img);
                }
                if (divPhoto.hasChildNodes()) {
                    await onclick_image(divPhoto);
                }
            }
            modal.style.display = "block";
        });
    }
}

function change_visibility() {
    let prepared = []
    hideImage.addEventListener("click", (e) => {

        if (onEditVisibility) {
            e.preventDefault();
            post_request(e, "../php_scripts/requests.php", "hideImage", onEditVisibility);
        }
    });

    viewImage.addEventListener("click", (e) => {
        console.log(onEditVisibility);
        if (onEditVisibility) {
            e.preventDefault();
            post_request(e, "../php_scripts/requests.php", "viewImage", onEditVisibility);
        }
    })
}

async function onclick_image(divPhoto) {
    let images = divPhoto.querySelectorAll("img");
    for (let i = 0; i < images.length; ++i) {
        images[i].addEventListener("click", (e) => {
            let status = images[i].getAttribute("status");
            if (!e.target.classList.contains("selected_photo")) {
                if (e.target.classList.contains("hided_image") && status === "0") {
                    e.target.classList.remove("hided_image");
                }

                e.target.classList.add("selected_photo");
                onEditVisibility.push(parseInt(images[i].getAttribute("imageId")));
            } else {
                if (!e.target.classList.contains("hided_image") && status === "0") {
                    e.target.classList.add("hided_image");
                }

                e.target.classList.remove("selected_photo");
                onEditVisibility.pop();
            }
        });
    }
}

function post_request(e, url, ...args) {
    $.ajax({
        url: url,
        method: "POST",
        data: { type: args[0], goodId: goodId, imageIds: args[1]},
    })
}


function request_returns(method, goodId)
{
    return $.ajax({
        url: "../php_scripts/requests.php",
        type: method,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        data: { goodId: goodId }
    }).done(function(msg)
    {
        if (msg)
            return msg
    });
}

span.onclick = function()
{
    modal.style.display = "none";
    clear_all()
}


window.onclick = function(event)
{
    if (event.target === modal)
    {
        modal.style.display = "none";
        clear_all()
    }
}

function clear_all()
{
    title.value = "";
    description.innerHTML = "";
    let imgs = divPhoto.querySelectorAll("img");
    for (const img of imgs) {
        divPhoto.removeChild(img);
    }
    actionForm.removeAttribute("action");
}