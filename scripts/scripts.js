let modal = document.getElementById('myModal');
let span = document.getElementsByClassName("close")[0];
let btns = document.querySelectorAll("#myBtn");
let hidePost = document.querySelectorAll("#hidePost");
let showPost = document.querySelectorAll("#showPost");
let deletePost = document.querySelectorAll("#deletePost");

let status = null;


open_modal();
function open_modal() {
    for (const btn of btns) {
        btn.addEventListener("click", (e) => {
            modal.style.display = "block";
        });
    }
}

for (const post of deletePost) {
    post.addEventListener("click", (e) => {
        post_request(e, "../php_scripts/requests.php", { type: post.getAttribute("id"),
            goodId: post.getAttribute("goodId") })
    });
}

for (const post of hidePost) {
    post.addEventListener("click", (e) => {
        post_request(e, "../php_scripts/requests.php", { type: post.getAttribute("id"),
            goodId: parseInt(post.getAttribute("goodId")) });
    });
}

for (const post of showPost) {
    post.addEventListener("click", (e) => {
        post_request(e, "../php_scripts/requests.php", { type: post.getAttribute("id"),
            goodId: parseInt(post.getAttribute("goodId")) });
    });
}

function post_request(e, url, data) {
    $.ajax({
        url: url,
        method: "POST",
        data: data,
        success: () => {
            location.reload();
        }
    })
    return true;
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
}


window.onclick = function(event)
{
    if (event.target === modal)
    {
        modal.style.display = "none";
    }
}
