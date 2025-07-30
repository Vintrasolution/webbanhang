<?php
// Lấy giá trị mặc định cho tháng và năm
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('n');
$selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y');
?>

<h3>Báo cáo Dữ Liệu Nhập Hàng Tháng <?php echo $selectedMonth; ?> Năm <?php echo $selectedYear; ?></h3>

<form method="get" action="" id="reportForm">
  <label for="month">Chọn tháng:</label>
  <select name="month" id="month">
    <?php
      for ($i = 1; $i <= 12; $i++) {
        $selected = ($i == $selectedMonth) ? 'selected' : '';
        echo "<option value=\"$i\" $selected>$i</option>";
      }
    ?>
  </select>

  <label for="year">Chọn năm:</label>
  <select name="year" id="year">
    <?php
      $currentYear = date("Y");
      for ($i = $currentYear; $i >= $currentYear - 10; $i--) {
        $selected = ($i == $selectedYear) ? 'selected' : '';
        echo "<option value=\"$i\" $selected>$i</option>";
      }
    ?>
  </select>

  <input type="submit" value="Xem báo cáo">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $sql_status_payment = "
    SELECT pm.name_method, SUM(im.price_total) AS total_money
    FROM payment_method_import pm
    LEFT JOIN import_details im ON pm.id = im.id_pay_method_import
    WHERE MONTH(im.date_import) = $selectedMonth AND YEAR(im.date_import) = $selectedYear
    GROUP BY pm.id;
  ";

  $run_status_payment = $con->query($sql_status_payment);

  echo "<table border=\"1\" style=\"border-collapse: collapse;\" class=\"form-control\">
          <tr>
            <th>Trạng Thái Thanh Toán</th>
            <th>Tổng Tiền (VNĐ)</th>
          </tr>";

  $totalRevenuen = 0; // Initialize total revenue variable

  while ($row_status_payment = mysqli_fetch_assoc($run_status_payment)) {
    echo "<tr>
            <td><strong>{$row_status_payment['name_method']}</strong></td>
            <td>" . number_format($row_status_payment['total_money'], 0, '', ',') . "</td>
          </tr>";

    // Accumulate total revenue during each iteration
    $totalRevenuen += $row_status_payment['total_money'];
  }

  // Display total revenue in a single row after the loop
  echo "<tr>
          <td><strong>TỔNG XUẤT</strong></td>
          <td>" . number_format($totalRevenuen, 0, '', ',') . "</td>
        </tr>";

  echo "</table>";
}


?>
