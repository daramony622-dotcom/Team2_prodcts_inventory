document.addEventListener("DOMContentLoaded", function () {
	const canvas = document.getElementById("inventoryChart");
	const fallback = document.getElementById("chartFallback");

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

	const ctx = canvas.getContext("2d");
	const gradient = ctx.createLinearGradient(0, 0, 0, canvas.height);
	gradient.addColorStop(0, "rgba(56, 189, 248, 0.55)");
	gradient.addColorStop(0.7, "rgba(14, 165, 233, 0.18)");
	gradient.addColorStop(1, "rgba(15, 23, 42, 0.05)");

	new Chart(canvas, {
		type: "line",
		data: {
			labels: labels,
			datasets: [
				{
					label: "Inventory totals",
					data: data,
					borderColor: "rgba(56, 189, 248, 0.95)",
					backgroundColor: gradient,
					tension: 0.35,
					pointRadius: 4,
					pointBackgroundColor: "#38bdf8",
					pointBorderColor: "rgba(255,255,255,0.85)",
					pointHoverRadius: 6,
					fill: true,
					borderWidth: 3,
				},
			],
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			scales: {
				x: {
					ticks: { color: "#cbd5e1" },
					grid: { display: false },
				},
				y: {
					beginAtZero: true,
					ticks: { color: "#cbd5e1", precision: 0 },
					grid: { color: "rgba(203, 213, 225, 0.1)" },
				},
			},
			plugins: {
				legend: { display: false },
				tooltip: {
					backgroundColor: "rgba(15, 23, 42, 0.96)",
					borderColor: "rgba(56, 189, 248, 0.3)",
					borderWidth: 1,
					callbacks: {
						label: function (context) {
							return context.parsed.y + " items";
						},
					},
				},
			},
			elements: {
				line: {
					borderJoinStyle: "round",
				},
			},
		},
	});
});
