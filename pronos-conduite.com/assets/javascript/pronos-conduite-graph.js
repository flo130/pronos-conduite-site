$(function () {

	Highcharts.theme = {
	   colors: ['#3c2d61', '#bfa01d', '#bb5c19', '#3aad2f', '#8a1720', '#bebebe', '#058DC7', '#ED561B', '#DDDF00', '#24CBE5', '#64E572', '#FF9655', '#FFF263', '#6AF9C4'],
	   chart: {
			backgroundColor: {
				linearGradient: { x1: 0, y1: 0, x2: 1, y2: 1 },
				stops: [
					[0, 'rgb(255, 255, 255)'],
					[1, 'rgb(240, 240, 255)']
				]
			},
			plotShadow: true
	   },
	};

	var highchartsOptions = Highcharts.setOptions(Highcharts.theme);

	Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function(color) {
		return {
			radialGradient: { cx: 0.5, cy: 0.3, r: 0.7 },
			stops: [
				[0, color],
				[1, Highcharts.Color(color).brighten(-0.3).get('rgb')]
			]
		};
	});


	/******************
	 *	page du compte
	******************/
	if (typeof graph_user != "undefined") {
		$('#graph-user').highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				backgroundColor: 'rgba(255, 255, 255, 0.1)'
			},
			title: {
				text: 'Répartition des pronostiques de l\'utilisateur',
				style: {
					color: "#FFFFFF"
				}
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						color: '#000000',
						connectorColor: '#000000',
						format: '<b>{point.name}</b>: {point.percentage:.1f} %'
					}
				}
			},
			series: [{
				type: 'pie',
				name: 'Pourcentage',
				data: graph_user
			}],
			exporting: {
				enabled: false
			},
			credits: {
				enabled: false
			}
		});
	}
	
	
	if (typeof graph_eag != "undefined") {
		$('#graph-eag').highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				backgroundColor: 'rgba(255, 255, 255, 0.1)'
			},
			title: {
				text: 'Répartition des résultats de Guingamp',
				style: {
					color: "#FFFFFF"
				}
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						color: '#000000',
						connectorColor: '#000000',
						format: '<b>{point.name}</b>: {point.percentage:.1f} %'
					}
				}
			},
			series: [{
				type: 'pie',
				name: 'Pourcentage',
				data: graph_eag
			}],
			exporting: {
				enabled: false
			},
			credits: {
				enabled: false
			}
		});
	}
	
	
	
	
	
	
	
	if (typeof graph_bet_time != "undefined") {
		$('#graph-bet-time').highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				backgroundColor: 'rgba(255, 255, 255, 0.1)'
			},
			title: {
				text: 'Heure des pronos',
				style: {
					color: "#FFFFFF"
				}
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						color: '#000000',
						connectorColor: '#000000',
						format: '<b>{point.name}</b>: {point.percentage:.1f} %'
					}
				}
			},
			series: [{
				type: 'pie',
				name: 'Pourcentage',
				data: graph_bet_time
			}],
			exporting: {
				enabled: false
			},
			credits: {
				enabled: false
			}
		});
	}
	
	
	if (typeof graph_bet_histo != "undefined") {
		$('#graph-bet-histo').highcharts({
			chart: {
				type: 'column',
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				backgroundColor: 'rgba(255, 255, 255, 0.1)'
			},
			title: {
				text: 'Historique des pronostiques',
				style: {
					color: "#FFFFFF"
				}
			},
			xAxis: {
				min: 1,
				title: {
					text: ''
				},
				labels: {
					align: 'right',
					style: {
						color: "#FFFFFF",
						fontFamily: 'Cabin,Arial,sans-serif'
					}
				}
			},
			yAxis: {
				categories: [
					'',
					'Pas trouvé',
					'Match trouvé',
					'Score trouvé'
				],
				labels: {
					align: 'right',
					style: {
						color: "#FFFFFF",
						fontFamily: 'Cabin,Arial,sans-serif'
					}
				}
			},
			plotOptions: {
				column: {
					pointPadding: 0.1,
					borderWidth: 0
				}
			},
			series: [{
					name: 'Point(s)',
					data: graph_bet_histo
			}],
			exporting: {
				enabled: false
			},
			credits: {
				enabled: false
			},
			legend: {
				enabled: false
			}
		});
	}
	
	
	

	
	/******************
	 *	page de stats
	******************/
	if (typeof graph_users_pronos != "undefined") {
		$('#graph-users-pronos').highcharts({
			chart: {
				type: 'column',
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				backgroundColor: 'rgba(255, 255, 255, 0.1)'
			},
			title: {
				text: 'Pronostiques',
				style: {
					color: "#FFFFFF"
				}
			},
			xAxis: {
				categories: [
					'Match nuls',
					'Defaites',
					'Victoires'
				]
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Nombre de matchs'
				}
			},
			exporting: {
				enabled: false
			},
			credits: {
				enabled: false
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
			series: graph_users_pronos
		});
	}
	
	
	if (typeof graph_eag != "undefined") {
		$('#graph-eag').highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				backgroundColor: 'rgba(255, 255, 255, 0.1)'
			},
			title: {
				text: 'EAG',
				style: {
					color: "#FFFFFF"
				}
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						color: '#000000',
						connectorColor: '#000000',
						format: '<b>{point.name}</b>: {point.percentage:.1f} %'
					}
				}
			},
			series: [{
				type: 'pie',
				name: 'Pourcentage',
				data: graph_eag
			}],
			exporting: {
				enabled: false
			},
			credits: {
				enabled: false
			}
		});
	}
	
	
	if (typeof graph_site != "undefined") {
		$('#graph-site').highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				backgroundColor: 'rgba(255, 255, 255, 0.1)'
			},
			title: {
				text: 'Pronos-conduite',
				style: {
					color: "#FFFFFF"
				}
			},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					dataLabels: {
						enabled: true,
						color: '#000000',
						connectorColor: '#000000',
						format: '<b>{point.name}</b>: {point.percentage:.1f} %'
					}
				}
			},
			series: [{
				type: 'pie',
				name: 'Pourcentage',
				data: graph_site
			}],
			exporting: {
				enabled: false
			},
			credits: {
				enabled: false
			}
		});
	}
});
