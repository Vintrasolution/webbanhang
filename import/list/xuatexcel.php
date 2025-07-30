<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php 

    include "../../db.php"; 

  ?>
  <style type="text/css">
    .hidden-content {
        display: none;
    }
    th {
      padding-left: 10px;
      padding-right: 10px;
      padding-top: 8px;
      padding-bottom: 8px;
      #white-space: nowrap;
      font-size: 14px;
      color: white;
      background-color: #7B77FC;
    }
    td {
      padding-left: 10px;
      padding-right: 10px;
      padding-top: 10px;
      padding-bottom: 10px;
      #white-space: nowrap;
      font-size: 13px;
      word-break: nowrap;

    }
    tr:nth-child(even){background-color: #f2f2f2}
    .pagination {
      display: inline-block;
    }

    .pagination a {
      color: black;
      float: left;
      padding: 5px 8px;
      text-decoration: none;
      transition: background-color .3s;
      border: 1px solid #ddd;
      margin: 0 2px;
      text-decoration: none;
    }

    .pagination a.active {
      background-color: #4CAF50;
      color: white;
      border: 1px solid #4CAF50;
      text-decoration: none;
    }
        /* Đặt các quy tắc rớt dòng cho các thiết bị có màn hình rộng tối đa 480px */
      table {
        /* CSS để bảng tự động thay đổi kích thước hoặc cuộn ngang theo nhu cầu */
        width: 100%;
        overflow-x: auto;
      }
      td {
        /* Đặt các thuộc tính cho các ô trong bảng */
        white-space: nowrap; /* Ngăn chặn ngắt dòng */
        overflow: hidden; /* Ẩn nội dung dư thừa */
        text-overflow: ellipsis; /* Hiển thị dấu chấm ở cuối khi nội dung bị ẩn */
      }
    }

    .pagination a:hover:not(.active) {background-color: #ddd;}
  </style>
   <script src="jquery-3.2.1.min.js"></script>
  <title>DANH SÁCH NHẬP HÀNG - LILLY FLOWER</title>
  

</head>
<body>
<!-- partial:index.partial.html -->
<html>
  <head>
    <title>DANH SÁCH NHẬP HÀNG</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
  </head>

  <body>
      
    <div class="container my-4 hidden-content" style="max-width: 100%;" >

      <center>
        <p class="h3">DANH SÁCH ĐƠN HÀNG</p>
        <?php 
          $datestart = $_GET['datestart'];
          $dateend = $_GET['dateend'];
          $submit_date = $_GET['submit'];
        ?>
        <form action="" method="GET">
        Từ Ngày:<input type="date" name="datestart" style="width:10%; margin-left: 5px;padding-top: 5px ;padding-bottom: 5px;padding-right: 5px;padding-left: 5px;" value="<?php if(isset($datestart)){echo $datestart;} ?>"> - Đến Ngày: <input value="<?php if(isset($dateend)){echo $dateend;} ?>" type="date" name="dateend" style="width:10%; margin-left: 5px;padding-top: 5px ;padding-bottom: 5px;padding-right: 5px;padding-left: 5px;">
        <br/><button class="btn btn-primary float-mid text-uppercase shadow-sm" value="7" type="submit" name="submit" style="padding: 7px; margin-top:8px ;">TÌM KIẾM</button>
      </form>
      </center>
              
      <div class="card my-4 shadow" style="overflow-x:auto;">

        <div class="card-body" >
          
          <form action="" method="post">
            <!--<button type="button" class="btn saveAsExcel" style="margin-bottom: 5px;">Xuất Excel</button> -->
            <table id="mytableEx" class="exportable"  border="1" style="width:100%;">
                      <tr >
                        <th style="width: 3%;">STT</th>
                        <th  style="width: 20%;">Nhà Cung Cấp</th>
                        <th  style="width: 20%;">Loại Sản Phẩm</th>
                        <th  style="width: 7%;">Đơn Giá</th>
                        <th  style="width: 7%;">Số Lượng</th>
                        <th  style="width: 7%;">Tổng Tiền</th>
                        <th  style="width: 12%;">Hình Thức TT</th>
                        <th  style="width: 12%;">Ngày Nhập</th>
                        <!--<th >Chi Tiết</th>-->
                      </tr>
                      
                    
                  <?php
                  $id_farm = $row_staff['id_farm'];
                  $level = $row['level'];

                  
                  
                  //$query = "SELECT * FROM records LIMIT $startIndex, $recordsPerPage";
                  //$result = mysqli_query($connection, $query);

                  
                  if($submit_date==7){
                    if(empty($datestart) && empty($dateend)){
                      $query = "SELECT COUNT(*) as total_records FROM import_details";
                      $result = mysqli_query($con, $query);
                      $row = mysqli_fetch_assoc($result);
                      $totalRecords = $row['total_records'];
                      $recordsPerPage = 20;
                      $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                      if($_GET['page']==""){
                        $startIndex = 0;
                      }else{
                        $startIndex = ($currentPage - 1) * $recordsPerPage;
                      }
                      $sql_pre = "SELECT * FROM import_details ORDER BY date_import DESC LIMIT $startIndex, $recordsPerPage";
                      
                    }elseif($datestart!=="" && $dateend===""){
                      $query = "SELECT COUNT(*) as total_records FROM import_details WHERE `date_import` >= '$datestart'";
                      $result = mysqli_query($con, $query);
                      $row = mysqli_fetch_assoc($result);
                      $totalRecords = $row['total_records'];
                      $recordsPerPage = 20;
                      $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                      if($_GET['page']==""){
                        $startIndex = 0;
                      }else{
                        $startIndex = ($currentPage - 1) * $recordsPerPage;
                      }
                      $sql_pre = "SELECT * FROM import_details WHERE `date_import` >= '$datestart' ORDER BY date_created DESC LIMIT $startIndex, $recordsPerPage";
                      
                    }elseif($datestart==="" && $dateend !==""){
                      $query = "SELECT COUNT(*) as total_records FROM import_details WHERE `date_import` <= '$dateend'";
                      $result = mysqli_query($con, $query);
                      $row = mysqli_fetch_assoc($result);
                      $totalRecords = $row['total_records'];
                      $recordsPerPage = 20;
                      $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                      if($_GET['page']==""){
                        $startIndex = 0;
                      }else{
                        $startIndex = ($currentPage - 1) * $recordsPerPage;
                      }
                      $sql_pre = "SELECT * FROM import_details WHERE `date_import` <= '$dateend' ORDER BY date_created DESC LIMIT $startIndex, $recordsPerPage";
                      
                    }else{
                      $query = "SELECT COUNT(*) as total_records FROM import_details WHERE `date_import` BETWEEN '$datestart' AND '$dateend'";
                      $result = mysqli_query($con, $query);
                      $row = mysqli_fetch_assoc($result);
                      $totalRecords = $row['total_records'];
                      $recordsPerPage = 20;
                      $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                      if($_GET['page']==""){
                        $startIndex = 0;
                      }else{
                        $startIndex = ($currentPage - 1) * $recordsPerPage;
                      }
                      $sql_pre = "SELECT * FROM import_details WHERE `date_import` BETWEEN '$datestart' AND '$dateend' ORDER BY date_created DESC";

                    }}
                  if(empty($datestart) && empty($dateend)){
                    //Phân Trang
                    $query = "SELECT COUNT(*) as total_records FROM import_details";
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_assoc($result);
                    $totalRecords = $row['total_records'];
                    $recordsPerPage = 20;
                    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                    if($_GET['page']==""){
                      $startIndex = 0;
                    }else{
                      $startIndex = ($currentPage - 1) * $recordsPerPage;
                    }
                    $sql_pre = "SELECT * FROM import_details ORDER BY date_created DESC";
                  }

                  $run_pre = $con->query($sql_pre);
                  $check_pre = mysqli_fetch_array($run_pre);
                  $x =0;
                  if($check_pre){
                  foreach ($run_pre as $row_pre) {
                      //ID Blling
                      $id_bill = $row_pre['id'];
                      $product_type = $row_pre['product_type'];
                      $id_supplier = $row_pre['id_supplier'];
                      $price_unit = $row_pre['price_unit']; 
                      $quantity = $row_pre['quantity'];
                      $price_total_check = $row_pre['price_total'];  
                      if($price_total_check==$id_supplier){
                        $price_total = $price_unit * $quantity;
                      }else{
                        $price_total = $row_pre['price_total'];  
                      }
                      $id_pay_method_import = $row_pre['id_pay_method_import'];
                      $date_import_sql = $row_pre['date_import']; 

                      /*Thời gian Sử Dụng Thuốc
                      $sql_timuse = "SELECT * FROM prescription_date_use WHERE id_prescription = '$id_toa'";
                      $run_timeuse = $con->query($sql_timuse);
                      $row_timeuse = mysqli_fetch_array($run_timeuse);
                      $time = $row_timeuse['date_use'];
                      $timeuse = date_format(date_create("$time"),"d/m/Y");*/

                      //$date_import = date_format(date_create("$time_shipping"),"H:i");
                      $date_import = date_format(date_create("$date_import_sql"),"d/m/Y");

                      //Get Name Supplier
                      $sql_supplier = "SELECT * FROM supplier WHERE id ='$id_supplier'";
                      $run_sql_supplier = $con->query($sql_supplier);
                      $row_sql_supplier = mysqli_fetch_array($run_sql_supplier);
                      $name_supplier = $row_sql_supplier['supplier_name'];


                      $x++;
                      echo "<tr>";
                      echo "<td>".$x."</td>";
                      echo "<td>".$name_supplier."</td>";
                      echo "<td>".$product_type."</td>";
                      echo "<td>".number_format($price_unit, 0, '', ',')."</td>";
                      echo "<td>".$quantity."</td>";
                      echo "<td>".number_format($price_total, 0, '', ',')."</td>";
                      $sql_paymethod = "SELECT * FROM payment_method_import WHERE id ='$id_pay_method_import' and status =1";
                      $run_paymethod = $con->query($sql_paymethod);
                      $row_paymethod = mysqli_fetch_array($run_paymethod);
                      $name_paymethod = $row_paymethod['name_method'];
                      echo "<td>".$name_paymethod."</td>";
                      echo "<td>".$date_import."</td>";
                      //echo "<td>".$time_approval."</td>";
                      //echo "<td> <a style='text-decoration:none' href='chitiet.php/?id=".$id_bill."'> Xem</a> </td>";
                      echo "</tr>";

                    }}else{echo "<tr><td colspan='9' style='color: red;font-size:16px'><center><strong>KHÔNG CÓ DỮ LIỆU!</strong></center></td></tr>";}
                    echo "</table>";
                ?>
            <div class="clearfix mt-4">
            </div>
          </form>
          <?php 
            
            $totalPages = ceil($totalRecords / $recordsPerPage);
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
            $startIndex = ($currentPage - 1) * $recordsPerPage;
            $visiblePages = 5; // Number of page links to display
            $halfVisible = floor($visiblePages / 2); // Number of page links on each side of the current page

            $startPage = max(1, $currentPage - $halfVisible);
            $endPage = min($startPage + $visiblePages - 1, $totalPages);

            if ($endPage - $startPage + 1 < $visiblePages) {
                $startPage = max(1, $endPage - $visiblePages + 1);
            }
            
            echo "<div class='pagination justify-content-center'>";
            
            if ($startPage > 1) {
                echo "<a style='text-decoration:none' href='?page=1'>1</a> ";
                if ($startPage > 2) {
                    echo "<a style='text-decoration:none'>... </a>";
                }
            }

            for ($i = $startPage; $i <= $endPage; $i++) {
                if ($i == $currentPage) {
                    echo "<a style='text-decoration:none;background-color:#ddd'><strong >$i</strong></a>";
                } else {
                    echo "<a style='text-decoration:none' href='?page=$i&datestart=".$datestart."&dateend=".$dateend."&submit=7'>$i</a> ";
                }
            }

            if ($endPage < $totalPages) {
                if ($endPage < $totalPages - 1) {
                    echo "<a style='text-decoration:none'>... </a>";
                }
                echo "<a  style='text-decoration:none'href='?page=$totalPages'>$totalPages</a> ";
            }
            
            echo "</div>";
            
          ?>
        </div>
      </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
      //Chi tiết ghi nhận GIAO/NHẬN vỏ chai
      function check_log_giaonhan(id) {
                   $.ajax({
                        url : "details.php",
                        type : "post",
                        dataType:"text",
                        data : {
                           id : id
                        },
                        success : function (result){
                          alert (result);
                          if (result==1){
                            alert ("THÔNG BÁO");
                            location.reload();
                          }
                          //$('#result').html(result);
                        }
                      });
                }
  </script>
  <!-- Xuất Excel Code -->
  <script src='https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2014-11-29/FileSaver.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.12.13/xlsx.full.min.js'></script>
  <script>
    $(document).ready(function(){
        $(".saveAsExcel").click(function(){
            var workbook = XLSX.utils.book_new();
            
            //var worksheet_data  =  [['hello','world']];
            //var worksheet = XLSX.utils.aoa_to_sheet(worksheet_data);
          
            var worksheet_data  = document.getElementById("mytableEx");
            var worksheet = XLSX.utils.table_to_sheet(worksheet_data);
            
            workbook.SheetNames.push("Danh Sach");
            workbook.Sheets["Danh Sach"] = worksheet;
          
             exportExcelFile(workbook);
          
         
        });
    })

    function exportExcelFile(workbook) {
        var today = new Date();
      var year = today.getFullYear();
      var month = today.getMonth() + 1;
      var day = today.getDate();
      var fileName = "DanhSachNhapHang_" + year + "-" + month + "-" + day + ".xlsx";
      return XLSX.writeFile(workbook, fileName);
    }
  </script>
  <!-- Kết thúc Script xuất Excel -->
</body>
</html>
