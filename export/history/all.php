<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include "../../../header.php"; ?>
  <style type="text/css">
    th {
      padding-left: 10px;
      padding-top: 10px;
      padding-bottom: 10px;
      padding-right: 10px;
      font-size: 14px;
      color: white;
      background-color: #7B77FC;
      white-space: nowrap;
    }
    td {
      padding-left: 10px;
      padding-top: 10px;
      padding-bottom: 10px;
      padding-right: 10px;
      font-size: 13px;
      /* Đặt các thuộc tính cho các ô trong bảng */
        /*white-space: nowrap; /* Ngăn chặn ngắt dòng */
        /*overflow: hidden; /* Ẩn nội dung dư thừa */
        /*text-overflow: ellipsis; /* Hiển thị dấu chấm ở cuối khi nội dung bị ẩn */
    }
    table {
        /* CSS để bảng tự động thay đổi kích thước hoặc cuộn ngang theo nhu cầu */
        width: 100%;
        overflow-x: auto;
      }
  </style>
  <title>TỔNG HỢP TOA THUỐC CHI TIẾT</title>
  

</head>
<body>
<!-- partial:index.partial.html -->
<html>
  <head>
    <title>TỔNG HỢP TOA THUỐC CHI TIẾT</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css'>
  </head>

  <body>
      
    <div class="container my-4" style="max-width: 100%;">

      <center><p class="h3">TOA THUỐC CHI TIẾT</p></center>
      <div class="card my-4 shadow">
        <div class="card-body">
          <?php 
            $id_toa = $_GET['id']; 

            $sql_pre = "SELECT * FROM prescription WHERE status =1 AND id = $id_toa";
            $run_pre = $con->query($sql_pre);
            $row_pre = mysqli_fetch_array($run_pre);
          ?>
          <form action="" method="post">    
            <center>
            <p><b>Ngày Dùng Thuốc:</b>
                <?php 
                $date_today=date_format(date_create(),'Y-m-d'); 
                $date_check = $_POST['date_check'];
                if($date_check==''){?>
                <input style="font-size: 18px;height: 30px;text-align:right; color: red" type="date" value="<?php echo $date_today ?>" name="date_check"></p> 
                <?php }else{?>
                <input style="font-size: 18px;height: 30px;text-align:right; color: red" type="date" value="<?php echo $date_check ?>" name="date_check"></p> 
                <?php } ?>
                <button class="btn btn-success">Lọc</button>
              </center>
            <button type="button" class="btn saveAsExcel">Xuất Excel</button> 
            <div id="dynamic-field-1" class="form-group dynamic-field" style="overflow-x:auto;">
              <br/>
              <!--Lấy Dữ Liệu Thuốc-->
                    <table  id="mytable" class="table table-bordered exportable">
                      <tr>
                        <th >STT</th>
                        <th >Mã Toa</th>
                        <th >Mã Vật Tư</th>
                        <th >Tên Thuốc</th>
                        <th >Đơn Vị Tính</th>
                        <th >Số Lượng</th>
                      </tr>
                      
                    
                  <?php
                  $x=0;
                  if($date_check==''){
                    $sql_pre_details = "SELECT * FROM details_prescription as d , prescription_date_use as u WHERE d.status =1 AND u.date_use LIKE '%$date_today%' AND d.id_prescription = u.id_prescription;";
                  }else{
                    $sql_pre_details = "SELECT * FROM details_prescription as d , prescription_date_use as u WHERE d.status =1 AND u.date_use LIKE '%$date_check%' AND d.id_prescription = u.id_prescription;";
                  }
                  $run_pre_details = $con->query($sql_pre_details);
                  foreach ($run_pre_details as $row_pre_details) {
                      $x++;
                      $id_med = $row_pre_details['id_medicine'];
                      //Lấy Tên Thuốc
                      $sql_medicine = "SELECT * FROM medicines WHERE code_med=$id_med AND status =1";
                      $run_medicine = $con->query($sql_medicine);
                      $row_medicine = mysqli_fetch_array($run_medicine);
                      $name_medicine = $row_medicine['name'];
                      $code_medicine = $row_medicine['code_med'];
                      $unit_medicine = $row_medicine['unit'];
                      $id_prescription = $row_pre_details['id_prescription'];
                      $amount = $row_pre_details['amount'];
                      echo "<tr>";
                      echo "<td>".$x."</td>";
                      echo "<td>".$id_prescription."</td>";
                      echo "<td>".$code_medicine."</td>";
                      echo "<td>".$name_medicine."</td>";
                      echo "<td>".$unit_medicine."</td>";
                      echo "<td>".$amount."</td>";
                      echo "</tr>";

                    }
                    echo "</table>";
                ?>
            <div class="clearfix mt-4">
              <?php 
              $id_farm = $row_staff['id_farm'];
              $level = $row['level'];
              //Lấy thông tin đã giao hàng chưa để enable nút Đã Nhận Đủ
              $sql_pre_log = "SELECT * FROM  prescription_log WHERE `id_prescription`='$id_toa' AND `status`=1 ORDER BY id DESC;";
              $run_pre_log = $con->query($sql_pre_log);
              $row_pre_log = mysqli_fetch_array($run_pre_log);
              $id_level_pre_log = $row_pre_log['level'];

              ?>
              <button type="submit" name="submit" value="3" class="btn btn-primary float-right text-uppercase shadow-sm" formaction="../">QUAY LẠI</button>
            </div>
          </form>
        </div>
      </div>
    </div>
   
  <!-- Định nghĩa nút để xuất file Excel -->


<!-- Script để xuất file Excel -->
 <script src='https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2014-11-29/FileSaver.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.12.13/xlsx.full.min.js'></script>
<script  src="./script.js"></script>
<script>
$(document).ready(function(){
    $(".saveAsExcel").click(function(){
        var workbook = XLSX.utils.book_new();
        
        //var worksheet_data  =  [['hello','world']];
        //var worksheet = XLSX.utils.aoa_to_sheet(worksheet_data);
      
        var worksheet_data  = document.getElementById("mytable");
        var worksheet = XLSX.utils.table_to_sheet(worksheet_data);
        
        workbook.SheetNames.push("Test");
        workbook.Sheets["Test"] = worksheet;
      
         exportExcelFile(workbook);
      
     
    });
})

function exportExcelFile(workbook) {
    var today = new Date();
  var year = today.getFullYear();
  var month = today.getMonth() + 1;
  var day = today.getDate();
  var fileName = "toathuoc_" + year + "-" + month + "-" + day + ".xlsx";
  return XLSX.writeFile(workbook, fileName);
}
</script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
<!-- partial -->
  <script  src="./script.js"></script>

</body>
</html>
