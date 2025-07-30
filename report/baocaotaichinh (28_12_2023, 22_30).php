<?php 
  $currentMonth = date('m');
?>
<h3>Báo cáo tài chính Tháng <?php echo $currentMonth; ?></h3>
<div>
  
  <table border="1" style="border-collapse: collapse;" class="form-control">
    <tr>
      <th>Tên Trạng Thái</th>
      <th>Tổng Tiền (VNĐ)</th>
    </tr>
    
      <?php 
        $sql_status_payment = "
                                SELECT ps.name_status, SUM(b.total_price) AS total_money
                                FROM payment_status ps
                                LEFT JOIN billing b ON ps.id = b.pay_status
                                WHERE MONTH(b.date_shipping) = '$currentMonth'
                                GROUP BY ps.id;
                            ";
        echo $sql_status_payment;
        $run_status_payment = $con->query($sql_status_payment);
        while ($row_status_payment = mysqli_fetch_assoc($run_status_payment)){ ?>
          <tr>
            <td><strong><?php echo $row_status_payment['name_status']; ?></strong></td>
            <td><?php echo number_format($row_status_payment['total_money'], 0, '', ','); ?></td>
          </tr>
    <?php } ?>

  </table>  
</div>