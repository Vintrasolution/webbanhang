<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include "../../header.php"; ?>
  <style type="text/css">
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
  <title>DANH SÁCH ĐƠN HÀNG- Anova Farm</title>
  

</head>
<body>
<!-- partial:index.partial.html -->
<html>
  <head>
    <title>DANH SÁCH ĐƠN HÀNG</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
  </head>

  <body>
      
    <div class="container my-4" style="max-width: 100%;">

      <center><p class="h3">DANH SÁCH ĐƠN HÀNG</p></center>
      <div class="card my-4 shadow" style="overflow-x:auto;">
        <div class="card-body" >
          <form action="" method="post">
            <table border="1" style="width:100%;">
                      <tr >
                        <th >STT</th>
                        <th  style="width: 15%;">Người Tạo Đơn</th>
                        <th  style="width: 15%;">Người Nhận Đơn</th>
                        <th  style="width: 15%;">Thời Gian Giao</th>
                        <th  style="width: 15%;">Địa Chỉ</th>
                        <th  style="width: 12%;">Hình Thức TT</th>
                        <th  style="width: 12%;">Trạng Thái TT</th>
                        <th  style="width: 12%;">Số Tiền</th>
                        <th >Chi Tiết</th>
                      </tr>
                      
                    
                  <?php
                  $id_farm = $row_staff['id_farm'];
                  $level = $row['level'];

                  //Phân Trang
                  $query = "SELECT COUNT(*) as total_records FROM billing";
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
                  
                  //$query = "SELECT * FROM records LIMIT $startIndex, $recordsPerPage";
                  //$result = mysqli_query($connection, $query);

                    $sql_pre = "SELECT * FROM billing ORDER BY date_created DESC LIMIT $startIndex, $recordsPerPage";
                    


                  $run_pre = $con->query($sql_pre);
                  $x =0;
                  
                  foreach ($run_pre as $row_pre) {
                      //ID Blling
                      $id_bill = $row_pre['id'];
                      $date_ship = $row_pre['date_ship'];
                      $fullname_customer = $row_pre['fullname_customer']; 
                      $phone_customer = $row_pre['phone_customer']; 
                      $fullname_receiver = $row_pre['fullname_receiver']; 
                      $phone_receiver = $row_pre['phone_receiver']; 
                      $address_receiver = $row_pre['address']; 
                      $street_receiver = $row_pre['street']; 
                      $ward_receiver = $row_pre['ward']; 
                      $district_receiver = $row_pre['district']; 
                      $city_receiver = $row_pre['city']; 
                      $total_price = $row_pre['total_price']; 
                      $pay_method = $row_pre['pay_method']; 
                      $pay_status = $row_pre['pay_status']; 
                      $status_ship = $row_pre['status_ship']; 
                      $details = $row_pre['details'];
                      $time_shipping = $row_pre['time_shipping'];
                      $date_shipping = $row_pre['date_shipping']; 
                      //Thời gian Sử Dụng Thuốc
                      $sql_timuse = "SELECT * FROM prescription_date_use WHERE id_prescription = '$id_toa'";
                      $run_timeuse = $con->query($sql_timuse);
                      $row_timeuse = mysqli_fetch_array($run_timeuse);
                      $time = $row_timeuse['date_use'];
                      $timeuse = date_format(date_create("$time"),"d/m/Y");

                      $time_ship = date_format(date_create("$time_shipping"),"H:i");
                      $date_ship = date_format(date_create("$date_shipping"),"d/m/Y");


                      $x++;
                      echo "<tr>";
                      echo "<td>".$x."</td>";
                      echo "<td>".$fullname_customer."</td>";
                      echo '<td>' .$fullname_receiver. '</td>'; // Xuất chuỗi HTML hoàn chỉnh
                      echo "<td>".$time_ship." - ".$date_ship."</td>";
                      echo "<td>"."Số ".$address_receiver.', Đường '.$street_receiver.', Phường '.$ward_receiver.', Quận '.$district_receiver.', '.$city_receiver."</td>";
                      $sql_paymethod = "SELECT * FROM payment_method WHERE id ='$pay_method' and status =1";
                      $run_paymethod = $con->query($sql_paymethod);
                      $row_paymethod = mysqli_fetch_array($run_paymethod);
                      $name_paymethod = $row_paymethod['name_method'];
                      echo "<td>".$name_paymethod."</td>";
                      $sql_paystatus = "SELECT * FROM payment_status WHERE id ='$pay_status' and status =1";
                      $run_paystatus = $con->query($sql_paystatus);
                      $row_paystatus= mysqli_fetch_array($run_paystatus);
                      $name_paystatus = $row_paystatus['name_status'];
                      echo "<td>".$name_paystatus."</td>";
                      echo "<td>".number_format($total_price, 0, '', ',')."</td>";
                      
                      //echo "<td>".$time_approval."</td>";
                      echo "<td> <a style='text-decoration:none' href='chitiet.php/?id=".$id_bill."'> Xem</a> </td>";
                      echo "</tr>";

                    }
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
                    echo "<a style='text-decoration:none' href='?page=$i'>$i</a> ";
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
  <script  src="./script.js"></script>

</body>
</html>
