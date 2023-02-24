define(['jquery', 'elgg', 'chart.js/chart.min'], function($, elgg, Chart) {
	function init_chart(elem) {
		var data = $(elem).data();
		if (data.initialized) {
			return;
		}
		
		if (!$(elem).is(':visible')) {
			return;
		}
		
		var ctx = elem.getContext('2d');
		
		switch (data.chartType) {
			case 'pie':
				var chart = new Chart(ctx, {
					type: data.chartType,
					data: data.chartData,
					options: {
						maintainAspectRatio: false,
						plugins: {
							legend: {
								display: false,
							},
						},
					}
				});
				break;
			case 'bar':
				var chart = new Chart(ctx, {
					type: data.chartType,
					data: data.chartData,
					options: {
						maintainAspectRatio: false,
						plugins: {
							legend: {
								display: false,
							},
						},
						scales: {
							y: {
								beginAtZero: true,
							},
						}
					},
				});
				break;
		}
		
		$(elem).data('initialized', true);
	};
	
	$('.poll-result-chart').each(function(index, elem) {
		init_chart(elem);
	});
});
