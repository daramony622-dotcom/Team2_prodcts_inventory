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
					rows = `<tr><td colspan="6" class="text-center py-4 text-gray-500">No suppliers found.</td></tr>`;
				} else {
					data.forEach(function (s) {
						rows += `
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-4">${s.id}</td>
                                    <td class="py-3 px-4 font-semibold">${s.supplier_name}</td>
                                    <td class="py-3 px-4">${s.phone || "-"}</td>
                                    <td class="py-3 px-4">${s.email || "-"}</td>
                                    <td class="py-3 px-4">${s.address || "-"}</td>
                                    <td class="py-3 px-4 text-center space-x-2">
                                        <button onclick="editSupplier(${s.id})" class="bg-amber-500 text-white px-3 py-1 rounded hover:bg-amber-600">Edit</button>
                                        <button onclick="deleteSupplier(${s.id})" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Delete</button>
                                    </td>
                                </tr>
                            `;
					});
				}
				$("#supplierTableBody").html(rows);
			},
		});
	}

	// Modal triggers
	$("#openAddModalBtn").click(function () {
		$("#supplierForm")[0].reset();
		$("#supplier_id").val("");
		$("#modalTitle").text("Add Supplier");
		$("#supplierModal").removeClass("hidden");
	});

	$("#closeModalBtn").click(function () {
		$("#supplierModal").addClass("hidden");
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
					$("#supplierModal").addClass("hidden");
					loadSuppliers();
				} else {
					alert(res.message);
				}
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
				$("#supplier_id").val(data.id);
				$("#supplier_name").val(data.supplier_name);
				$("#phone").val(data.phone);
				$("#email").val(data.email);
				$("#address").val(data.address);

				$("#modalTitle").text("Edit Supplier");
				$("#supplierModal").removeClass("hidden");
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
			});
		}
	};
});
