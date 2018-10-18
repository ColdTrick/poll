
elgg.provide('elgg.poll.results');

elgg.poll.results.init_chart = function (elem) {
	
	require(['jquery', 'elgg', 'chartjs'], function($, elgg, Chart){

		var data = $(elem).data();
		console.log(elem);
		console.log(data);
		if (data.initialized) {
			return;
		}
		
		if (!$(elem).is(':visible')) {
			return;
		}
		
		var ctx = elem.getContext('2d');
		var maxWidth = $(elem).parent().innerWidth();
		console.log(ctx);
		if (maxWidth < 500) {
			ctx.canvas.width = maxWidth;
		}
		console.log(ctx);

		switch (data.chartType) {
			case 'pie':
				var chart = new Chart(ctx, {
					type: data.chartType,
					data: data.chartData,
					options: {
						legend: {
							display: false,
						},
					}
				});
				break;
			case 'bar':
				var chart = new Chart(ctx, {
					type: data.chartType,
					data: data.chartData,
					options: {
						legend: {
							display: false,
						},
						scales: {
				            yAxes: [{
				                ticks: {
				                    beginAtZero: true
				                }
				            }]
				        }
					},
				});
				break;
		}
		
		$(elem).data('initialized', true);
	});
};

elgg.poll.results.init = function() {
	
	$('.poll-result-chart').each(function(index, elem) {

		elgg.poll.results.init_chart(elem);
	});
};

elgg.register_hook_handler('init', 'system', elgg.poll.results.init);
