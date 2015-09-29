
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
				var chart = new Chart(ctx).Pie(data.chartData, {
					legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend mrm\" style=\"display: inline-block;\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>; width:16px; height: 16px; display:inline-block; margin-right: 5px;\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>",
					animation: false,
				});
				var legend = chart.generateLegend();
				$(elem).after(legend);
				break;
			case 'bar':
				var chart = new Chart(ctx).Bar(data.chartData, {
					animation: false,
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
		
		$('.elgg-menu-poll-tabs .elgg-state-selected').removeClass('elgg-state-selected');
		$('.poll-content').hide();
		
		var data = $(this).data();
		if (data.toggleSelector) {
			$(data.toggleSelector).show();
			
			if (data.isChart) {
				var chart = $(data.toggleSelector).find('.poll-result-chart').get(0);
				elgg.poll.results.init_chart(chart);
			}
		}
		
		$(this).parent().addClass('elgg-state-selected');
	});
};

elgg.register_hook_handler('init', 'system', elgg.poll.results.init);
