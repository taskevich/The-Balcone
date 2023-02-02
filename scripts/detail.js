let hideImage = document.getElementById("hideImage");
let showImage = document.getElementById("showImage");
let divPhoto = document.getElementById("image_grid");

//let goodId = parseInt ((new URLSearchParams(window.location.search)).get("id"));
let onEditVisibility = []

onclick_image();
function onclick_image() {
    let images = divPhoto.querySelectorAll("img");
    for (let i = 0; i < images.length; ++i) {
        images[i].addEventListener("click", (e) => {
            let status = parseInt(images[i].getAttribute("status"));
            if (!e.target.classList.contains("selected_photo")) {
                if (e.target.classList.contains("hided_image")) {
                    e.target.classList.remove("hided_image");
                }

                e.target.classList.add("selected_photo");
                onEditVisibility.push(parseInt(images[i].getAttribute("imageId")));
            } else {
                if (status === 0) {
                    e.target.classList.add("hided_image");
                }

                e.target.classList.remove("selected_photo");
                let index = onEditVisibility.indexOf(status);
                if (index !== -1) {
                    onEditVisibility.splice(index, 1);
                }
            }
        });
    }
}

hideImage.onclick = (e) => {
    e.preventDefault();
    post_request(e, "../php_scripts/requests.php", { type: "hideImage", imageIds: onEditVisibility });
};

showImage.onclick = (e) => {
    e.preventDefault();
    post_request(e, "../php_scripts/requests.php", { type: "showImage", imageIds: onEditVisibility });
};
