$(function(){
	// ChartJS 1
	var chartjs1 = $('#chart-1');
	new Chart(chartjs1, {
	    type: 'line',
	    data: {
	        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
	        datasets: [{
	            data: [900, 1220, 700, 1300, 1616, 1400, 1200, 950],
	            backgroundColor: 'rgba(101,39,178,0.1)',
	            fill: true,
	            borderWidth: 3,
	            borderColor: 'rgba(101,39,178,1)'
	        }]
	    },
	    options: {
	        legend: {
	            display: false,
	        },
	        scales: {
	            yAxes: [{
	                display: false,
	                ticks: {
	                    beginAtZero: true,
	                    fontSize: 10,
                    	fontColor: '#bbb'
	                },

	                gridLines: { color: "#f5f5f5" }
	            }],
	            xAxes: [{
	                ticks: {
	                    beginAtZero: true,
	                    fontSize: 10,
                    	fontColor: '#bbb'
	                },
	                gridLines: { color: "#f5f5f5" }
	            }]
	        }
	    }
	});	

	// ChartJS 2
	var chartjs2 = $('#chart-2');
	new Chart(chartjs2, {
	    type: 'line',
	    data: {
	        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
	        datasets: [{
	            data: [14250, 11235, 13400, 13540, 17000, 17000, 16000],
	            backgroundColor: 'rgba(219,56,71,0.1)',
	            fill: true,
	            borderWidth: 3,
	            borderColor: 'rgba(219,56,71,1)'
	        }]
	    },
	    options: {
	        legend: {
	            display: false,
	        },
	        scales: {
	            yAxes: [{
	                ticks: {
	                    beginAtZero: true,
	                    fontSize: 10,
                    	fontColor: '#bbb'
	                },

					gridLines: {
						display: false,
						color: '#f5f5f5'
					},
	            }],
	            xAxes: [{
	                ticks: {
	                    beginAtZero: true,
	                    fontSize: 10,
                    	fontColor: '#bbb'
	                },
	                gridLines: { color: "#f5f5f5" }
	            }]
	        }
	    }
	});

	// ChartJS 3
	var chartjs3 = $('#chart-3');
	new Chart(chartjs3, {
	    type: 'line',
	    data: {
	        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
	        datasets: [{
	            data: [90, 122, 189, 235, 190, 175, 135, 155],
	            backgroundColor: 'rgba(29,207,59,0.1)',
	            fill: true,
	            borderWidth: 3,
	            borderColor: 'rgba(29,207,59,1)'
	        }]
	    },
	    options: {
	        legend: {
	            display: false,
	        },
	        scales: {
	            yAxes: [{
	                display: false,
	                ticks: {
	                    beginAtZero: true,
	                    fontSize: 10,
                    	fontColor: '#bbb'
	                },

	                gridLines: { color: "#f5f5f5" }
	            }],
	            xAxes: [{
	                ticks: {
	                    beginAtZero: true,
	                    fontSize: 10,
                    	fontColor: '#bbb'
	                },

	                gridLines: { color: "#f5f5f5" }
	            }]
	        }
	    }
	});

	// ChartJS 4 bar
    var chartjs4 = $('#chart-bar3');
    new Chart(chartjs4, {
        type: 'bar',
        data: {
            labels: ['1-W', '2-W', '3-W', '4-W', '5-W', '6-W', '7-W'],
            datasets: [{
                data: [10, 30, 25, 15, 27, 22, 10],
                backgroundColor: 'rgba(101,39,178,1)',
                fill: true
            }, {
                data: [10, 24, 25, 15, 32, 17, 10],
                backgroundColor: 'rgba(101,39,178,0.7)',
                fill: true
            },
             {
                data: [10, 24, 25, 15, 32, 17, 10],
                backgroundColor: 'rgba(101,39,178,0.3)',
                fill: true
            }]
        },
        options: {
            legend: {
                display: false,
                labels: {
                    display: false,
                }
            },
            scales: {
                yAxes: [{
                    stacked: true,
                    ticks: {
	                    fontSize: 10,
	                	fontColor: '#bbb'
                    }
                }],
                xAxes: [{
                    stacked: true,
                    barThickness:15,
                    ticks: {
	                    fontSize: 10,
	                	fontColor: '#bbb'
                    }
                }]
            }
        }
    });

    // ChartJS 5 donut
    var chartjs5 = $('#chart-donut');
    new Chart(chartjs5, {
        type: 'doughnut',
	    data: {
	        labels: ["Smart Phones", "Computers", "Components"],
	        datasets: [
	            {
	                label: "Category Product",
	                data: [55, 25, 20],
	                backgroundColor: [
	                    "rgba(101,39,178,.7)",
	                    "rgba(219,56,71,.7)",
	                    "rgba(29,207,59,.7)"
	                ],
	                borderColor: [
	                    "#fff",
	                    "#fff",
	                    "#fff"
	                ],
	                borderWidth: 0
	            }
	        ]
	    },
	    options: {
	            responsive: true,
             	cutoutPercentage: 80,
	            title: {
	                display: false,
	                position: "top",
	                text: "Pie Chart",
	                fontSize: 18,
	                fontColor: "#333"
	            },
	            legend: {
	                display: true,
	                position: "bottom",
	                labels: {
	                    fontColor: "#bbb",
	                    fontSize: 10,
                		padding:20
	                }
	            }
	        }
    });

});