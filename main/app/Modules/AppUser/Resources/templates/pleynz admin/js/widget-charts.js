$(function(){

 	// 1 - ChartJs
   var chartjs1 = $('#chart1');
   new Chart(chartjs1, {
       type: 'doughnut',
       data: {
           labels: ["BTC", "ETH", "XRP"],
           datasets: [
               {
                   label: "Portfolio",
                   data: [66, 25, 9],
                   backgroundColor: [
                       "#3e2bce",
                       "#3AA4F5",
                       "#DB3847"
                   ],
                   borderColor: [
                       "#fff",
                       "#fff",
                       "#fff"
                   ],
                   borderWidth: 0,
                   hoverBorderColor: 'transparent'
               }
           ]
       },
       options: {
           cutoutPercentage: 80,
           responsive: true,
           maintainAspectRatio: false,
           title: {
               display: false,
               position: "top",
               text: "Pie Chart",
               fontSize: 18,
               fontColor: "#333"
           },
           legend: {
               display: false,
               position: "bottom",
               labels: {
                   fontColor: "#666",
                   fontSize: 12
               }
           },
       }
   });

   // 2 - Morris
   new Morris.Line({
       element: 'chart2',
       data: [
           { y: '8:00 AM', a: 120},
           { y: '10:00 AM', a: 720},
           { y: '12:00 AM', a: 800},
           { y: '1:00 PM', a: 50},
           { y: '3:00 PM', a: 250},
           { y: '5:00 PM', a: 380},
           { y: '7:00 PM', a: 600},
           { y: '9:00 PM', a: 550},
           { y: '11:00 PM', a: 700},
       ],
       xkey: 'y',
       ykeys: ['a'],
       labels: ['Value'],
       lineColors: ['#F7931A'],
       lineWidth: 2,
       grid : false,
       axes: false,
       gridTextSize: 10,
       padding:5,
       hideHover: 'auto',
       resize: true,
       pointSize: 0
   });

  	// 3 - Morris
   new Morris.Line({
       element: 'chart3',
       data: [
           { y: '8:00 AM', a: 120},
           { y: '10:00 AM', a: 720},
           { y: '12:00 AM', a: 800},
           { y: '1:00 PM', a: 50},
           { y: '3:00 PM', a: 250},
           { y: '5:00 PM', a: 380},
           { y: '7:00 PM', a: 600},
           { y: '9:00 PM', a: 550},
           { y: '11:00 PM', a: 700},
       ],
       xkey: 'y',
       ykeys: ['a'],
       labels: ['Value'],
       lineColors: ['#BA9F33'],
       lineWidth: 2,
       grid : false,
       axes: false,
       gridTextSize: 10,
       padding:5,
       hideHover: 'auto',
       resize: true,
       pointSize: 0
   });

   // 4 - ChartJs
   var chartjs2 = $('#chart4');
   new Chart(chartjs2, {
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

   	// 5 - ChartJs
   	var chartjs3 = $('#chart5');
   	new Chart(chartjs3, {
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

	// 6 - ChartJs
	var chartjs4 = $('#chart6');
	new Chart(chartjs4, {
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

	// 7 - ChartJs
	var chartjs5 = $('#chart7');
	new Chart(chartjs5, {
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

	// 8 - ChartJs
	var chartjs6 = $("#chart8").get(0).getContext("2d");
	var areaChart = new Chart(chartjs6, {
	   type: 'line',
	   data: {
	       labels: ["2013", "2014", "2015", "2016", "2017"],
	       datasets: [{
	           label: '# of Votes',
	           data: [0, 9, 1, 4, 2, 0],
	           backgroundColor: [
	               'rgba(219,56,71,0.2)'
	           ],
	           borderColor: [
	               'rgba(219,56,71,1)'
	           ],
	           borderWidth: 1,
	           fill: true, // 3: no fill
	       }]
	   },
	   options: {
	       maintainAspectRatio: false,
	       ticks: {
	           beginAtZero: true
	       },
	       tooltips: {
	           enabled: false
	       },
	       elements: {
	           line: {
	               tension: 0
	           }
	       },
	       legend: {
	           display: false
	       },
	       scales: {
	           xAxes: [{
	               display: false,
	               gridLines: {
	                   display: false
	               }
	           }],
	           yAxes: [{
	               display: false,
	               gridLines: {
	                   display: false
	               }
	           }]
	       }
	   }
	});

	var chartjs7 = $("#chart9").get(0).getContext("2d");
	var areaChart = new Chart(chartjs7, {
	   type: 'line',
	   data: {
	       labels: ["2013", "2014", "2015", "2016", "2017"],
	       datasets: [{
	           label: '# of Votes',
	           data: [9, 1, 4, 6, 4, 7],
	           backgroundColor: [
	               'rgba(243,187,59,0.2)'
	           ],
	           borderColor: [
	               'rgb(243,187,59)'
	           ],
	           borderWidth: 1,
	           fill: true, // 3: no fill
	       }]
	   },
	   options: {
	       maintainAspectRatio: false,
	       ticks: {
	           beginAtZero: true
	       },
	       tooltips: {
	           enabled: false
	       },
	       elements: {
	           line: {
	               tension: 0
	           }
	       },
	       legend: {
	           display: false
	       },
	       scales: {
	           xAxes: [{
	               display: false,
	               gridLines: {
	                   display: false
	               }
	           }],
	           yAxes: [{
	               display: false,
	               gridLines: {
	                   display: false
	               }
	           }]
	       }
	   }
	});

	// 10 - ChartJs
	var chartjs8 = $('#chart10');
	new Chart(chartjs8, {
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
	            labels: {
	                display: false
	            }
	        },
	        scales: {
	            yAxes: [{
	                display: false,
	                ticks: {
	                    beginAtZero: true,
	                    fontSize: 10
	                }
	            }],
	            xAxes: [{
	                display: false,
	                ticks: {
	                    beginAtZero: true,
	                    fontSize: 12
	                }
	            }]
	        }
	    }
	});

});