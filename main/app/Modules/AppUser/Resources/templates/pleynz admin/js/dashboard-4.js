$(function(){
	var chartjs1 = $('#chart-1');
	new Chart(chartjs1, {
	    type: 'line',
	    data: {
	        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
	        datasets: [{
	            data: [22350, 28752, 29346, 41246, 30000, 37360, 42000],
	            backgroundColor: 'rgba(101,39,178,.3)',
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
});