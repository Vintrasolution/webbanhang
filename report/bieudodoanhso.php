<?php

echo "<br/>";
// Lấy tên tháng hiện tại
$currentMonthNumber = date('n');
echo "<h3>Biểu đồ danh số Tháng và Nhập Tháng $currentMonthNumber</h3>";

// Biểu đồ danh số Tháng
// Lấy ngày tháng hiện tại
$currentMonth = date('Y-m');
$sql = "SELECT date_shipping, SUM(`total_price`) AS sum_value FROM billing WHERE `status` = 1 and date_shipping LIKE '%$currentMonth%' GROUP BY date_shipping;";
$run_sql = $con->query($sql);

$data = array();
$labels = array();
$values = array();

while ($row_sql = mysqli_fetch_assoc($run_sql)) {
    $date_billing = isset($row_sql['date_shipping']) ? $row_sql['date_shipping'] : null;
    $sum_value = isset($row_sql['sum_value']) ? (int)$row_sql['sum_value'] : 0;

    $labels[] = $date_billing;
    $values[] = $sum_value;
}

$data['labels'] = $labels;
$data['values'] = $values;

// Biểu đồ danh số Nhập Tháng hiện tại
$currentMonth = date('Y-m');
$sql_nhap = "SELECT date_import, SUM(`price_total`) AS sum_value FROM import_details WHERE `status` = 1 and date_import LIKE '%$currentMonth%' GROUP BY date_import;";
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

<div style="display: flex; justify-content: space-between; width: 80%; margin: auto;">
    <!-- Biểu đồ danh số Tháng -->
    <div style="width: 55%;">
        <canvas id="myChart" style="max-width: 400px; max-height: 300px;"></canvas>
    </div>

    <!-- Biểu đồ danh số Nhập Tháng 11 -->
    <div style="width: 55%;">
        <canvas id="myChartnhap" style="max-width: 400px; max-height: 300px;"></canvas>
    </div>
</div>

<script>
    // Biểu đồ danh số Tháng
    var ctx = document.getElementById('myChart').getContext('2d');
    var data = <?php echo json_encode($data['values']); ?>;
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($data['labels']); ?>,
            datasets: [{
                label: 'Doanh số hằng ngày trong tháng ' + <?php echo $currentMonthNumber; ?>,
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(0, 128, 0, 1)',
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

    // Biểu đồ danh số Nhập Tháng 11
    var ctx_nhap = document.getElementById('myChartnhap').getContext('2d');
    var data_nhap = <?php echo json_encode($data_nhap['values']); ?>;

    var myChartNhap = new Chart(ctx_nhap, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($data_nhap['labels']); ?>,
            datasets: [{
                label: 'Doanh số nhập hằng ngày trong tháng ' + <?php echo $currentMonthNumber; ?>,
                data: data_nhap,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(255, 0, 0, 1)',
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
