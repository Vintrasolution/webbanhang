 <?php

  echo "<br/>";
  echo "<h3>Biểu đồ danh số Tháng</h3>";
  $sql = "SELECT date_billing, SUM(`total_price`) AS sum_value FROM billing WHERE `status` = 1 GROUP BY date_billing;";
  $run_sql = $con->query($sql);

  $chartData = array();
  $chartData[] = ['Ngày', 'Doanh thu'];

  while ($row_sql = mysqli_fetch_assoc($run_sql) || $row_import = mysqli_fetch_assoc($run_sql_import)) {
      $date_billing = isset($row_sql['date_billing']) ? $row_sql['date_billing'] : null;
      $sum_value = isset($row_sql['sum_value']) ? (int)$row_sql['sum_value'] : 0;
    
      $chartData[] = [$date_billing, $sum_value];
  }

  echo json_encode($chartData);

?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<div id="chart_div"></div>

<script>
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable(<?php echo json_encode($chartData); ?>);

    var options = {
      title: 'Doanh thu',
      curveType: 'function',
      legend: { position: 'bottom' }
    };

    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

    chart.draw(data, options);
  }
</script>

