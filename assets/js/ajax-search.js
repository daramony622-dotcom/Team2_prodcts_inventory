document.addEventListener("DOMContentLoaded", function () {

    const search = document.getElementById("search");

    if (!search) return;

    search.addEventListener("keyup", function () {

        let keyword = this.value;

        fetch("../products/search.php?keyword=" + encodeURIComponent(keyword))
            .then(response => response.text())
            .then(data => {
                document.getElementById("productTable").innerHTML = data;
            });

    });

});