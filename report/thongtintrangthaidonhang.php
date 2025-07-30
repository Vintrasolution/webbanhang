<?php
// Lấy giá trị mặc định cho tháng và năm
$selectedMonth = isset($_GET['month']) ? $_GET['month'] : date('n');
$selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y');
?>

<h3>Thông Tin Trạng Thái Đơn Hàng Tháng <?php echo $selectedMonth; ?> Năm <?php echo $selectedYear; ?></h3>

<!-- Form chọn tháng năm -->
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

  <input type="submit" value="Lọc đơn hàng">
</form>

<div>
  <table border="1" style="border-collapse: collapse;" class="form-control">
    <tr>
      <th>Tên Trạng Thái</th>
      <th>Số Đơn Hiện Tại</th>
    </tr>
    
    <?php 
      // Truy vấn để lấy tất cả các trạng thái, kể cả khi không có đơn hàng
      $sql_status_ship = "
        SELECT ss.name_shipping, COALESCE(COUNT(b.status_ship), 0) AS status_count 
        FROM shipping_status ss 
        LEFT JOIN billing b ON ss.id = b.status_ship 
        AND MONTH(b.date_shipping) = $selectedMonth 
        AND YEAR(b.date_shipping) = $selectedYear
        GROUP BY ss.id;
      ";
      $run_status_ship = $con->query($sql_status_ship);
      while ($row_status_ship = mysqli_fetch_assoc($run_status_ship)){ ?>
        <tr>
          <td><strong><?php echo $row_status_ship['name_shipping']; ?></strong></td>
          <td><?php echo $row_status_ship['status_count']; ?></td>
        </tr>
    <?php } ?>

  </table>  
</div>