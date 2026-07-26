$(document).ready(function () {
	let categoryData = [];
	let searchTerm = "";

	loadCategories();

	$("#btnRefresh").on("click", function () {
		loadCategories();
	});

	$("#searchCategories").on("input", function () {
		searchTerm = $(this).val().trim().toLowerCase();
		renderCategories();
	});

	$("#btnAddCategory").on("click", function () {
		$("#categoryForm")[0].reset();
		$("#categoryId").val("");
		$("#modalTitle").text("Add Category");
		$("#btnSaveCategory").text("Save Category");
		showFormMessage("", "hidden");
		$("#categoryModal").removeClass("hidden").addClass("flex");
	});

	$("#closeModal, #btnCancelModal").on("click", function () {
		$("#categoryModal").addClass("hidden").removeClass("flex");
		$("#categoryForm")[0].reset();
		showFormMessage("", "hidden");
	});

	// 1. SAVE / UPDATE CATEGORY
	$("#categoryForm").on("submit", function (e) {
		e.preventDefault();

		const id = $("#categoryId").val();
		const formData = $(this).serialize();

		showFormMessage("Saving category...", "info");

		$.ajax({
			url: "insertCategories.php", // Make sure this PHP file is in the same folder as index.php
			type: "POST",
			data: formData,
			dataType: "json",
			success: function (response) {
				if (response.status === "success") {
					showFormMessage(
						id
							? "Category updated successfully."
							: "Category created successfully.",
						"success",
					);
					setTimeout(function () {
						$("#categoryModal").addClass("hidden").removeClass("flex");
						$("#categoryForm")[0].reset();
						loadCategories();
					}, 700);
				} else {
					showFormMessage(
						response.message || "Error processing request.",
						"error",
					);
				}
			},
			error: function () {
				showFormMessage("Server error occurred. Please try again.", "error");
			},
		});
	});

	// 2. EDIT CATEGORY
	$(document).on("click", ".edit-btn", function () {
		const id = $(this).data("id");
		const name = $(this).data("name");
		const desc = $(this).data("desc");

		$("#categoryId").val(id);
		$("#categoryName").val(name);
		$("#categoryDesc").val(desc);
		$("#modalTitle").text("Edit Category #" + id);
		$("#btnSaveCategory").text("Update Category");
		showFormMessage("", "hidden");
		$("#categoryModal").removeClass("hidden").addClass("flex");
	});

	// 3. DELETE CATEGORY
	$(document).on("click", ".delete-btn", function () {
		const id = $(this).data("id");

		if (confirm("Are you sure you want to delete this category?")) {
			$.ajax({
				url: "deleteCategories.php", // Relative URL to delete file
				type: "POST",
				data: { id: id },
				dataType: "json",
				success: function (response) {
					if (response.status === "success") {
						loadCategories();
					} else {
						alert(response.message || "Delete failed.");
					}
				},
				error: function () {
					alert("Failed to delete category.");
				},
			});
		}
	});

	// 4. LOAD CATEGORIES
	function loadCategories() {
		$.ajax({
			url: "getCategories.php", // Relative URL to get categories file
			type: "GET",
			dataType: "json",
			success: function (response) {
				if (response.status === "success") {
					categoryData = Array.isArray(response.data) ? response.data : [];
					$("#totalCategories").text(categoryData.length);
					renderCategories();
				} else {
					showError("Failed to load categories.");
				}
			},
			error: function (xhr, status, error) {
				console.error("AJAX Error:", status, error);
				showError("Error connecting to server endpoint.");
			},
		});
	}

	function renderCategories() {
		let rows = "";
		let filtered = categoryData.filter(function (cat) {
			if (!searchTerm) return true;
			return (
				(cat.name || cat.category_name || "")
					.toLowerCase()
					.includes(searchTerm) ||
				(cat.description || "").toLowerCase().includes(searchTerm)
			);
		});

		if (filtered.length === 0) {
			rows = `
                <tr>
                    <td colspan="4" class="py-12 text-center text-slate-400 bg-slate-900 rounded-2xl shadow-sm">
                        <i class="fa-solid fa-folder-open text-3xl mb-2 block text-sky-400"></i>
                        <p class="text-sm font-medium">No categories found.</p>
                    </td>
                </tr>`;
			$("#tableSummary").text(
				searchTerm ? "No matching results" : "Showing all categories",
			);
		} else {
			$.each(filtered, function (index, cat) {
				const catName = cat.name || cat.category_name || "Unnamed";
				rows += `
                    <tr class="align-top">
                        <td class="py-4 px-6 font-medium text-slate-100 bg-slate-900 rounded-l-xl shadow-sm">#${cat.id}</td>
                        <td class="py-4 px-6 font-semibold text-slate-100 bg-slate-900 shadow-sm">
                            <div class="flex items-center space-x-2">
                                <span class="w-2 h-2 bg-sky-400 rounded-full inline-block"></span>
                                <span>${catName}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-slate-300 max-w-md bg-slate-900 shadow-sm">
                            <div class="line-clamp-2">${cat.description || "-"}</div>
                        </td>
                        <td class="py-4 px-6 text-center bg-slate-900 rounded-r-xl shadow-sm">
                            <div class="flex justify-center space-x-2">
                                <button class="edit-btn px-2.5 py-1 bg-sky-500 hover:bg-sky-600 text-white font-medium rounded-md text-xs transition flex items-center space-x-1"
                                        data-id="${cat.id}"
                                        data-name="${catName}"
                                        data-desc="${cat.description || ""}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Edit</span>
                                </button>
                                <button class="delete-btn px-2.5 py-1 bg-rose-600 hover:bg-rose-700 text-white font-medium rounded-md text-xs transition flex items-center space-x-1"
                                        data-id="${cat.id}">
                                    <i class="fa-solid fa-trash"></i>
                                    <span>Delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>`;
			});
			$("#tableSummary").text(
				searchTerm
					? `Showing ${filtered.length} match${filtered.length > 1 ? "es" : ""}`
					: `Showing all ${filtered.length} categories`,
			);
		}

		$("#categoriesBody").html(rows);
	}

	function showFormMessage(message, type) {
		const box = $("#formMessage");

		if (!message) {
			box.addClass("hidden");
			box.removeClass(
				"bg-slate-950/75 border-slate-700 text-slate-100 bg-slate-950/75 border-slate-700 text-slate-100 bg-slate-950/75 border-slate-700 text-slate-100",
			);
			return;
		}

		box.removeClass("hidden");
		box.removeClass(
			"bg-slate-950/75 border-slate-700 text-slate-100 bg-slate-950/75 border-slate-700 text-slate-100 bg-slate-950/75 border-slate-700 text-slate-100",
		);

		if (type === "success") {
			box.addClass("bg-slate-950/75 border-sky-500/20 text-sky-200");
		} else if (type === "error") {
			box.addClass("bg-slate-950/75 border-rose-500/20 text-rose-200");
		} else {
			box.addClass("bg-slate-950/75 border-sky-500/20 text-slate-100");
		}

		function showError(msg) {
			$("#categoriesBody").html(`
            <tr>
                <td colspan="4" class="py-8 text-center text-red-500 font-medium">
                    <i class="fa-solid fa-triangle-exclamation mb-1 text-lg block"></i> ${msg}
                </td>
            </tr>
        `);
		}
	}
});
