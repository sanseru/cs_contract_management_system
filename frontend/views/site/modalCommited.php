<canvas id="comboChart"></canvas>

<?php

use yii\web\JsExpression;


// $currentDate = new DateTime(); // Tanggal saat ini
// $startDate = clone $currentDate;
// $startDate->modify('-35 months'); // Tanggal 35 bulan yang lalu

// $labels = [];
// while ($startDate <= $currentDate) {
//     $labels[] = "'" . $startDate->format('M Y') . "'";
//     $startDate->modify('+1 month'); // Tambah 1 bulan
// }

// $labelx = implode(',', $labels);

// $currentDate = new DateTime(); // Tanggal saat ini
// $startDate = clone $currentDate;
// $startDate->modify('-35 months'); // Tanggal 35 bulan yang lalu

// $data = [];
// while ($startDate <= $currentDate) {
//     // Generate data sesuai kebutuhan Anda, misalnya data acak antara 0 dan 100
//     $value = rand(0, 100);
//     $data[] = $value;

//     $startDate->modify('+1 month'); // Tambah 1 bulan
// }
// $datas =  implode(',', $data);

$jsTables = <<<JS
$(document).ready(function() {
    var ctx = document.getElementById('comboChart').getContext('2d');

        var comboChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Label 1', 'Label 2', 'Label 3'],
                datasets: [
                    {
                        type: 'bar',
                        label: 'Legend 1',
                        data: [10, 20, 30],
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        type: 'bar',
                        label: 'Legend 2',
                        data: [15, 25, 35],
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        type: 'bar',
                        label: 'Legend 3',
                        data: [5, 10, 15],
                        backgroundColor: 'rgba(75, 192, 192, 0.5)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        type: 'line',
                        label: 'Line',
                        data: [], // The data will be computed dynamically
                        fill: false,
                        borderColor: 'rgba(255, 206, 86, 1)',
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        stacked: true
                    },
                    y: {
                        stacked: true
                    }
                },
                plugins: {
                    tooltip: {
                        mode: 'index',
                        intersect: false
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