<?php

echo "<br/>";
echo "<h3>Biểu đồ danh số Nhập Tháng 11</h3>";
$sql_nhap = "SELECT date_import, SUM(`price_total`) AS sum_value FROM import_details WHERE `status` = 1 and date_import LIKE '%2023-11%' GROUP BY date_import;";
$run_sql_nhap = $con->query($sql_nhap);

$data_nhap = array();
$labels_nhap = array();
$values_nhap = array();

while ($row_sql_nhap = mysqli_fetch_assoc($run_sql_nhap)) {
    $date_import_nhap = isset($row_sql_nhap['date_import']) ? $row_sql_nhap['date_import'] : null;
    $sum_value_nhap = isset($row_sql_nhap['sum_value']) ? (int)$row_sql_nhap['sum_value'] : 0;

    $labels_nhap[] = $date_import_nhap;
    $values_nhap[] = $sum_value_nhap;
}

$data_nhap['labels'] = $labels_nhap;
$data_nhap['values'] = $values_nhap;
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<div style="width: 50%; margin: auto;">
    <canvas id="myChartnhap" style="max-width: 600px; max-height: 400px;"></canvas>
</div>
<script>
    var ctx = document.getElementById('myChartnhap').getContext('2d');
    var data = <?php echo json_encode($data_nhap['values']); ?>;
    
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($data_nhap['labels']); ?>,
            datasets: [{
                label: 'Doanh số nhập hằng ngày trong tháng 11',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Ngày'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Số Tiền'
                    }
                }
            },
            plugins: {
                datalabels: {
                    color: 'black',
                    anchor: 'end',
                    align: 'end',
                    font: {
                        weight: 'bold',
                        size: 10,
                    },
                    formatter: function(value, context) {
                        return value;
                    }
                }
            }
        }
    });
</script>
