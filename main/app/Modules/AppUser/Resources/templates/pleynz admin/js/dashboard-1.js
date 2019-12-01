$(function () {

    // Chart Area 1
    var chartjs1 = $('#chart-area');
    new Chart(chartjs1, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                data: [15, 34, 21, 10, 22, 20],
                backgroundColor: 'rgba(101,39,178,0.1)',
                fill: false,
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
                        fontSize: 10,
                        max: 50
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


    // Chart Donut
    var chartjs2 = $('#chart-donut');
    new Chart(chartjs2, {
        type: 'doughnut',
        data: {
            labels: ["Android", "IOS", "Windows", "Other"],
            datasets: [
                {
                    label: "TeamA Score",
                    data: [1277, 916, 869, 175],
                    backgroundColor: [
                        "#3e2bce",
                        "#3AA4F5",
                        "#DB3847",
                        "#F3BB00"
                    ],
                    borderColor: [
                        "#fff",
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

    var chartjs3 = $("#chart-line1").get(0).getContext("2d");
    var areaChart = new Chart(chartjs3, {
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

    var chartjs4 = $("#chart-line2").get(0).getContext("2d");
    var areaChart = new Chart(chartjs4, {
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
});