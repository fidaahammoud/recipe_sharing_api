<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bar Chart Example</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    /* Style to create a two-column layout */
    .row {
      display: flex;
    }

    .column {
      flex: 50%;
      padding: 10px;
    }
  </style>    
</head>


<body>

    <div class="row">
    <div class="column" id="xxx">
        <canvas id="barChart"></canvas>
    </div>
    <div class="column" id="yyy">
        <canvas id="barChart2"></canvas>
    </div>
    </div>

    <script>
        var ctx = document.getElementById('barChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($data['labels']),
                datasets: [{
                    label: 'Data',
                    data: @json($data['data']),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Custom Chart Subtitle'
                    }
                }                
            }
        });

        var ctx2 = document.getElementById('barChart2').getContext('2d');
        var myChart2 = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: @json($data['labels']),
                datasets: [{
                    label: 'Data',
                    data: @json($data['data']),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Custom Chart Subtitle 2'
                    }
                }                
            }
        });

    </script>
    </body>
</html>