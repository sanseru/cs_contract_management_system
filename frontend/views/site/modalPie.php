<canvas id="comboChart1"></canvas>

<?php

use yii\web\JsExpression;

$bar1 = [];
$myear = [];
$line = [];


foreach ($model as $key => $value) {
    $bar1[] = $value['bar'];
    $myear[] = $value['month_year'];
    $line [] = $value['line']* 0.009;

}

$bar1 = json_encode($bar1);
$myear = json_encode($myear);
$line = json_encode($line);

// var_dump($line);die;
$jsTables = <<<JS
$(document).ready(function() {
    var ctx = document.getElementById('comboChart1').getContext('2d');

        var comboChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: $myear,
                datasets: [
                    {
                        type: 'bar',
                        label: 'Commited',
                        data: $bar1,
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        type: 'line',
                        label: 'High Value',
                        data: $line, // The data will be computed dynamically
                        fill: false,
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                // scales: {
                //     x: {
                //         stacked: true
                //     },
                //     y: {
                //         stacked: true
                //     }
                // },
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    },
                    title: {
                        display: true,
                        text: 'Chart Bar And Line Request Order'
                    }
                }
            }
        });

        // Calculate line chart values from bar chart legends
        var barDatasets = comboChart.data.datasets.slice(0, 3);
        var lineDataset = comboChart.data.datasets[3];

        for (var i = 0; i < comboChart.data.labels.length; i++) {
            var sum = 0;
            for (var j = 0; j < barDatasets.length; j++) {
                sum += barDatasets[j].data[i];
            }
            lineDataset.data.push(sum);
        }

        comboChart.update();
});
JS;
$this->registerJs(new JsExpression($jsTables));

?>