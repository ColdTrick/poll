import 'jquery';
import 'chart.js';

var poll = {
	init: function (elem) {
		var data = $(elem).data();
		if (data.initialized) {
			return;
		}
		
		if (!$(elem).is(':visible')) {
			return;
		}
		
		var ctx = elem[0].getContext('2d');
		
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
	}
}

export default poll;
