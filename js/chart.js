// config
const config = {
    type: 'line',
    data: {}, // Initialize with empty data
    options: {
        scales: {
            x: {
                type: 'time',
                time: {
                    unit: 'hour'
                },
                min: new Date('2024-01-01T00:00:00'),
                max: new Date('2024-12-31T23:59:59')
            },
            y: {
                ticks: {
                    callback: function(value, index, values) {
                        return '$' + value;
                    }
                },
                beginAtZero: true
            }
        }
    }
};

// Fetch data from PHP script
fetch('../actions/get_chart_data.php')
    .then(response => response.json())
    .then(data => {
        // Use fetched data to populate the datasets
        config.data = {
            datasets: [{
                label: 'sales ($)',
                data: data,

                backgroundColor: [
                    'rgba(255, 26, 104, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 26, 104, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(0, 0, 0, 1)'
                ],
                borderWidth: 1
            }]
        };
    })
    .catch(error => {
        console.error('Error fetching data:', error);
    });

// Render the chart with the fetched data
const myChart = new Chart(
    document.getElementById('myChart'),
    config
);

// render init block
function dateFilter(time) {
    myChart.config.options.scales.x.time.unit = time;

    // Set min and max values based on time unit
    const currentDate = new Date();
    let minDate, maxDate;

    if (time === 'hour') {
        minDate = new Date(currentDate);
        minDate.setHours(currentDate.getHours() - 1);
        maxDate = new Date(currentDate);
    } else if (time === 'day') {
        minDate = new Date(currentDate);
        minDate.setDate(currentDate.getDate() - 1);
        maxDate = new Date(currentDate);
    } else if (time === 'week') {
        minDate = new Date(currentDate);
        minDate.setDate(currentDate.getDate() - 7);
        maxDate = new Date(currentDate);
    } else if (time === 'month') {
        minDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, currentDate.getDate());
        maxDate = new Date(currentDate);
    } else if (time === 'year') {
        minDate = new Date(currentDate.getFullYear() - 1, currentDate.getMonth(), currentDate.getDate());
        maxDate = new Date(currentDate);
    } else {// Default to the entire year
        minDate = new Date(currentDate.getFullYear(), 0, 1);
        maxDate = new Date(currentDate.getFullYear(), 11, 31, 23, 59, 59);
    }

    myChart.config.options.scales.x.min = minDate;
    myChart.config.options.scales.x.max = maxDate;

    myChart.update();
}

// Instantly assign Chart.js version
// const chartVersion = document.getElementById('chartVersion');
// chartVersion.innerText = Chart.version;

// default
dateFilter('day');
