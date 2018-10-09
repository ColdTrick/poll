
elgg.provide('elgg.poll.results');

elgg.poll.results.init_chart = function (elem) {
	
	require(['jquery', 'elgg', 'chartjs'], function($, elgg, Chart){

		var data = $(elem).data();
		if (data.initialized) {
			return;
		}
		
		if (!$(elem).is(':visible')) {
			return;
		}
		
		var ctx = elem.getContext('2d');
		var maxWidth = $(elem).parent().innerWidth();
		if (maxWidth < 500) {
			ctx.canvas.width = maxWidth;
		}

		switch (data.chartType) {
			case 'pie':
				var chart = new Chart(ctx, {
					type: data.chartType,
					data: data.chartData,
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
	
	$('.elgg-menu-poll-tabs a').on('click', function(event) {
		event.preventDefault();
		var $container = $(this).parents('.elgg-menu-poll-tabs').parent();
		$container.find('.elgg-menu-poll-tabs .elgg-state-selected').removeClass('elgg-state-selected');
		$container.find('.poll-content').hide();
		
		var data = $(this).data();
		if (data.toggleSelector) {
			$container.find(data.toggleSelector).show();
			
			if (data.isChart) {
				var chart = $container.find(data.toggleSelector).find('.poll-result-chart').get(0);
				elgg.poll.results.init_chart(chart);
			}
		}
		
		$(this).parent().addClass('elgg-state-selected');
	});
};

elgg.register_hook_handler('init', 'system', elgg.poll.results.init);
