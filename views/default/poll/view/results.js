define(['jquery', 'elgg', 'chart.js/chart.min'], function($, elgg, Chart) {

	init_chart = function (elem) {
		var data = $(elem).data();
		if (data.initialized) {
			return;
		}
		
		if (!$(elem).is(':visible')) {
			return;
		}
		
		var ctx = elem.getContext('2d');
		var maxWidth = $(elem).closest('.elgg-image-block').find(' > .elgg-body').innerWidth();
		ctx.canvas.width = 500;
		if (maxWidth < 500) {
			ctx.canvas.width = maxWidth;
		}
	
		switch (data.chartType) {
			case 'pie':
				var chart = new Chart(ctx, {
					type: data.chartType,
					data: data.chartData,
					options: {
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
