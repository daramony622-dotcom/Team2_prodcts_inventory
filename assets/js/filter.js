document.addEventListener("DOMContentLoaded", function () {

    const category = document.getElementById("categoryFilter");

    if (!category) return;

    category.addEventListener("change", function () {

        let id = this.value;

        fetch("../products/filter.php?category_id=" + id)
            .then(response => response.text())
            .then(data => {

                document.getElementById("productTable").innerHTML = data;

            });

    });

});