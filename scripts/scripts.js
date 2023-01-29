let modal = document.getElementById('myModal');
let span = document.getElementsByClassName("close")[0];
let doneBtn = document.getElementById("doneBtn");
let actionForm = document.getElementById("actionForm");
let divPhoto = document.getElementById("photos");
let btns = document.querySelectorAll("#myBtn");
let goodId = null;
let title = document.getElementById("title");
let description = document.getElementById("description");


modal_badyaga()
function modal_badyaga()
{
    for (const btn of btns) {
        btn.addEventListener("click", async (e) => {
            goodId = parseInt(btn.getAttribute("goodId"));

            if (parseInt(btn.getAttribute("edit")) === 0) {
                doneBtn.innerText = "Загрузить";
                doneBtn.setAttribute("type", "upload");
                actionForm.setAttribute("action", "../php_scripts/upload.php");
            } else {
                doneBtn.setAttribute("type", "edit");
                doneBtn.setAttribute("name", "edit_process");
                doneBtn.innerText = "Сохранить";
                actionForm.setAttribute("action", "../panel/edit.php?id=" + goodId);

                let res = await req("GET", goodId);
                title.value = res[0]["good"]["title"];
                description.innerText = res[0]["good"]["description"];

                for (const key in res[0]["photo"])
                {
                    const img = document.createElement("img");
                    img.setAttribute("src", res[0]["photo"][key]["path_to_photo"]);
                    img.setAttribute("width", "100");
                    img.setAttribute("height", "100");
                    img.setAttribute("class", "");
                    //img.setAttribute("goodId", goodId);
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

async function onclick_image(divPhoto) {
    let images = divPhoto.querySelectorAll("img");
    for (let i = 0; i < images.length; ++i) {
        images[i].addEventListener("click", (e) => {
            if (!e.target.classList.contains("selected_photo")) {
                e.target.classList.add("selected_photo");
            } else {
                e.target.classList.remove("selected_photo");
            }
        });
    }
}

function req(method, goodId)
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