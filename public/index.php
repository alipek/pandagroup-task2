<?php
include_once '../src/autoload.php';
$config = include __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'container.php';
$container = \Recruitment\Dependency\Container::getInstance($config);
$connection = $container->get(\Recruitment\Dbal\Connection::class);
$data = $connection->getCountryCount();
$labels = json_encode(array_column($data, 'country'));
$values = json_encode(array_column($data, 'count'));
?>
<html lang="pl">
<head>
    <title>Chart group by country</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3"></script>
</head>
<body>
<div id="container" style="width: 100%;">
    <canvas id="canvas"></canvas>
</div>
<script>


    window.onload = function () {
        let data = <?= $values ?>;
        let canvasHeight = data.length * 2.5;
        let canvas = document.getElementById('canvas');
        canvas.height =  Math.round(canvasHeight);
        var ctx = canvas.getContext('2d');
        window.myHorizontalBar = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: <?= $labels ?>,
                datasets: [{
                    label: 'Users',
                    backgroundColor: 'rgb(75, 192, 192)',
                    borderColor: 'rgb(75, 192, 192)',
                    borderWidth: 1,
                    data: data
                }]
            },
            options: {
                // Elements options apply to all of the options unless overridden in a dataset
                // In this case, we are setting the border of each horizontal bar to be 2px wide
                elements: {
                    rectangle: {
                        borderWidth: 2,
                    }
                },
                responsive: true,
                legend: {
                    position: 'right',
                },
                title: {
                    display: true,
                    text: 'Chart.js Horizontal Bar Chart'
                }
            }
        });

    };
</script>
</body>
</html>