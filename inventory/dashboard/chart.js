document.addEventListener("DOMContentLoaded", function () {
	const canvas = document.getElementById("inventoryChart");
	const fallback = document.getElementById("chartFallback");

	// Guard: Chart.js library not loaded (CDN missing/blocked)
	if (typeof Chart === "undefined") {
		console.error(
			"Chart.js is not loaded. Check the CDN <script> tag in layout.php <head>.",
		);
		if (fallback) fallback.classList.remove("hidden");
		return;
	}

	if (!canvas) {
		console.error("Canvas #inventoryChart not found in DOM.");
		return;
	}

	// Data is injected by dashboard/index.php via data-* attributes on the canvas
	let labels = [];
	let data = [];
	let colors = [];

	try {
		labels = JSON.parse(canvas.dataset.labels || "[]");
		data = JSON.parse(canvas.dataset.values || "[]");
		colors = JSON.parse(canvas.dataset.colors || "[]");
	} catch (err) {
		console.error("Failed to parse chart data attributes:", err);
		if (fallback) fallback.classList.remove("hidden");
		return;
	}

	new Chart(canvas, {
		type: "bar",
		data: {
			labels: labels,
			datasets: [
				{
					label: "Inventory totals",
					data: data,
					backgroundColor: colors,
					borderColor: colors.map((c) => c.replace("0.8", "1")),
					borderWidth: 1,
					borderRadius: 12,
					maxBarThickness: 40,
				},
			],
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			scales: {
				x: {
					ticks: { color: "#334155" },
					grid: { display: false },
				},
				y: {
					beginAtZero: true,
					ticks: { color: "#334155", precision: 0 },
					grid: { color: "rgba(148, 163, 184, 0.2)" },
				},
			},
			plugins: {
				legend: { display: false },
				tooltip: {
					callbacks: {
						label: function (context) {
							return context.parsed.y + " items";
						},
					},
				},
			},
		},
	});
});
