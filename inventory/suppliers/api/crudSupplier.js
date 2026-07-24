$(document).ready(function () {
	// Fetch and display all suppliers on page load
	loadSuppliers();

	function loadSuppliers() {
		$.ajax({
			url: "getSupplier.php",
			type: "GET",
			dataType: "json",
			success: function (data) {
				let rows = "";
				if (data.length === 0) {
					rows = `<tr><td colspan="6" class="py-12 text-center text-slate-400 bg-white rounded-2xl shadow-sm">
                            <i class="fa-solid fa-inbox text-3xl mb-2 block"></i>
                            <p class="text-sm font-medium">No suppliers found.</p>
                        </td></tr>`;
				} else {
					data.forEach(function (s) {
						rows += `
                        <tr class="align-top">
                            <td class="py-4 px-4 font-medium text-gray-900 bg-white rounded-l-xl shadow-sm">#${s.id}</td>
                            <td class="py-4 px-4 font-semibold text-gray-900 bg-white shadow-sm">${s.supplier_name}</td>
                            <td class="py-4 px-4 text-gray-600 bg-white shadow-sm">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-phone text-orange-500 text-xs"></i>
                                    ${s.phone || '<span class="text-gray-400">-</span>'}
                                </div>
                            </td>
                            <td class="py-4 px-4 text-gray-600 bg-white shadow-sm">
                                <div class="flex items-center gap-2">
                                    <i class="fa-solid fa-envelope text-blue-500 text-xs"></i>
                                    ${s.email ? '<a href="mailto:' + s.email + '" class="text-blue-600 hover:underline">' + s.email + "</a>" : '<span class="text-gray-400">-</span>'}
                                </div>
                            </td>
                            <td class="py-4 px-4 text-gray-600 bg-white shadow-sm">
                                <div class="flex items-start gap-2">
                                    <i class="fa-solid fa-map-marker-alt text-red-500 text-xs mt-0.5"></i>
                                    <span class="line-clamp-2">${s.address || '<span class="text-gray-400">-</span>'}</span>
                                </div>
                            </td>
                            <td class="py-4 px-4 text-center bg-white rounded-r-xl shadow-sm">
                                <div class="flex justify-center gap-2">
                                    <button type="button" onclick="editSupplier(${s.id})" 
                                        class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded text-xs font-semibold transition">
                                        <i class="fa-solid fa-edit mr-1"></i>Edit
                                    </button>
                                    <button type="button" onclick="deleteSupplier(${s.id})" 
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-xs font-semibold transition">
                                        <i class="fa-solid fa-trash mr-1"></i>Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        `;
					});
				}
				$("#supplierTableBody").html(rows);
			},
			error: function () {
				$("#supplierTableBody")
					.html(`<tr><td colspan="6" class="py-12 text-center text-red-500 bg-white rounded-2xl shadow-sm">
                    <i class="fa-solid fa-exclamation-circle text-3xl mb-2 block"></i>
                    <p class="text-sm font-medium">Failed to load suppliers.</p>
                </td></tr>`);
			},
		});
	}

	// Modal triggers
	$("#openAddModalBtn").click(function () {
		$("#supplierForm")[0].reset();
		$("#supplier_id").val("");
		$("#modalTitle").text("Add Supplier");
		$("#supplierModal").removeClass("hidden").addClass("flex");
	});

	$("#closeModalBtn").click(function () {
		$("#supplierModal").addClass("hidden").removeClass("flex");
	});

	// Create / Update via AJAX
	$("#supplierForm").submit(function (e) {
		e.preventDefault();
		$.ajax({
			url: "save.php",
			type: "POST",
			data: $(this).serialize(),
			dataType: "json",
			success: function (res) {
				if (res.status === "success") {
					$("#supplierModal").addClass("hidden").removeClass("flex");
					loadSuppliers();
				} else {
					alert(res.message);
				}
			},
			error: function () {
				alert("An error occurred while saving the supplier.");
			},
		});
	});

	// Edit Supplier Trigger
	window.editSupplier = function (id) {
		$.ajax({
			url: "getSupplier.php?id=" + id,
			type: "GET",
			dataType: "json",
			success: function (data) {
				if (Array.isArray(data) && data.length > 0) {
					data = data[0];
				}
				$("#supplier_id").val(data.id);
				$("#supplier_name").val(data.supplier_name);
				$("#phone").val(data.phone || "");
				$("#email").val(data.email || "");
				$("#address").val(data.address || "");

				$("#modalTitle").text("Edit Supplier");
				$("#supplierModal").removeClass("hidden").addClass("flex");
			},
			error: function () {
				alert("Failed to load supplier details.");
			},
		});
	};

	// Delete Supplier Trigger
	window.deleteSupplier = function (id) {
		if (confirm("Are you sure you want to delete this supplier?")) {
			$.ajax({
				url: "delete.php",
				type: "POST",
				data: {
					id: id,
				},
				dataType: "json",
				success: function (res) {
					if (res.status === "success") {
						loadSuppliers();
					} else {
						alert(res.message);
					}
				},
				error: function () {
					alert("An error occurred while deleting the supplier.");
				},
			});
		}
	};
});
