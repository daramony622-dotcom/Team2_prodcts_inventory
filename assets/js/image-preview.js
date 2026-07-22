document.addEventListener("DOMContentLoaded", function () {

    const image = document.getElementById("image");

    if (!image) return;

    image.addEventListener("change", function () {

        const preview = document.getElementById("preview");

        if (this.files && this.files[0]) {

            preview.src = URL.createObjectURL(this.files[0]);

            preview.style.display = "block";

        }

    });

});