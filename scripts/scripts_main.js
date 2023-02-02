let btns = document.querySelectorAll("#myBtn");
let modal = document.getElementById('myModal');



open_modal();
function open_modal() {
    for (const btn of btns) {
        btn.addEventListener("click", (e) => {
            modal.style.display = "block";
        });
    }
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
