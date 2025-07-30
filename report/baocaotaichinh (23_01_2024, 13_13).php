<?php
// Lấy giá trị mặc định cho tháng và năm
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('n');
$selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y');
?>

<h3>Báo cáo tài chính Tháng <?php echo $selectedMonth; ?> Năm <?php echo $selectedYear; ?></h3>

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
    SELECT ps.name_status, SUM(b.total_price) AS total_money
    FROM payment_status ps
    LEFT JOIN billing b ON ps.id = b.pay_status
    WHERE MONTH(b.date_shipping) = $selectedMonth AND YEAR(b.date_shipping) = $selectedYear
    GROUP BY ps.id;
  ";

  $run_status_payment = $con->query($sql_status_payment);

  echo "<table border=\"1\" style=\"border-collapse: collapse;\" class=\"form-control\">
          <tr>
            <th>Tên Trạng Thái</th>
            <th>Tổng Tiền (VNĐ)</th>
          </tr>";

  while ($row_status_payment = mysqli_fetch_assoc($run_status_payment)) {
    echo "<tr>
            <td><strong>{$row_status_payment['name_status']}</strong></td>
            <td>" . number_format($row_status_payment['total_money'], 0, '', ',') . "</td>
          </tr>";
  }

  echo "</table>";
}
?>
