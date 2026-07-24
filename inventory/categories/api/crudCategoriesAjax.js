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

	$("#categoryForm").on("submit", function (e) {
		e.preventDefault();

		const id = $("#categoryId").val();
		const formData = $(this).serialize();

		showFormMessage("Saving category...", "info");

		$.ajax({
			url: "insertCategories.php",
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

	$(document).on("click", ".delete-btn", function () {
		const id = $(this).data("id");

		if (confirm("Are you sure you want to delete this category?")) {
			$.ajax({
				url: "deleteCategories.php",
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

	function loadCategories() {
		$.ajax({
			url: "getCategories.php",
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
			error: function () {
				showError("Error connecting to controller.");
			},
		});
	}

	function renderCategories() {
		let rows = "";
		let filtered = categoryData.filter(function (cat) {
			if (!searchTerm) return true;
			return (
				(cat.name || "").toLowerCase().includes(searchTerm) ||
				(cat.description || "").toLowerCase().includes(searchTerm)
			);
		});

		if (filtered.length === 0) {
			rows = `
                <tr>
                    <td colspan="4" class="py-12 text-center text-slate-400 bg-white rounded-2xl shadow-sm">
                        <i class="fa-solid fa-folder-open text-3xl mb-2 block"></i>
                        <p class="text-sm font-medium">No categories found.</p>
                    </td>
                </tr>`;
			$("#tableSummary").text(
				searchTerm ? "No matching results" : "Showing all categories",
			);
		} else {
			$.each(filtered, function (index, cat) {
				rows += `
                    <tr class="align-top">
                        <td class="py-4 px-6 font-medium text-gray-900 bg-white rounded-l-xl shadow-sm">#${cat.id}</td>
                        <td class="py-4 px-6 font-semibold text-blue-600 bg-white shadow-sm">
                            <div class="flex items-center space-x-2">
                                <span class="w-2 h-2 bg-blue-500 rounded-full inline-block"></span>
                                <span>${cat.name}</span>
                            </div>
                        </td>
                        <td class="py-4 px-6 text-gray-500 max-w-md bg-white shadow-sm">
                            <div class="line-clamp-2">${cat.description || "-"}</div>
                        </td>
                        <td class="py-4 px-6 text-center bg-white rounded-r-xl shadow-sm">
                            <div class="flex justify-center space-x-2">
                                <button class="edit-btn px-2.5 py-1 bg-amber-50 hover:bg-amber-100 text-amber-700 font-medium rounded-md text-xs transition flex items-center space-x-1"
                                        data-id="${cat.id}"
                                        data-name="${cat.name}"
                                        data-desc="${cat.description || ""}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Edit</span>
                                </button>
                                <button class="delete-btn px-2.5 py-1 bg-red-50 hover:bg-red-100 text-red-600 font-medium rounded-md text-xs transition flex items-center space-x-1"
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
				"bg-blue-50 border-blue-200 text-blue-700 bg-emerald-50 border-emerald-200 text-emerald-700 bg-red-50 border-red-200 text-red-700",
			);
			return;
		}

		box.removeClass("hidden");
		box.removeClass(
			"bg-blue-50 border-blue-200 text-blue-700 bg-emerald-50 border-emerald-200 text-emerald-700 bg-red-50 border-red-200 text-red-700",
		);

		if (type === "success") {
			box.addClass("bg-emerald-50 border-emerald-200 text-emerald-700");
		} else if (type === "error") {
			box.addClass("bg-red-50 border-red-200 text-red-700");
		} else {
			box.addClass("bg-blue-50 border-blue-200 text-blue-700");
		}

		box.text(message);
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
});
