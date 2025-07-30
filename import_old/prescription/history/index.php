<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include "../../../header.php"; ?>
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
  <title>Toa Thuốc - Anova Farm</title>
  

</head>
<body>
<!-- partial:index.partial.html -->
<html>
  <head>
    <title>Lịch Sử TOA</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
  </head>

  <body>
      
    <div class="container my-4" style="max-width: 100%;">

      <center><p class="h3">TOA THUỐC</p></center>
      <div class="card my-4 shadow" style="overflow-x:auto;">
        <div class="card-body" >
          <form action="" method="post">
            <table border="1" style="width:100%;">
                      <tr >
                        <th >STT</th>
                        <th style="width: 10%;" >Trại</th>
                        <th style="width: 300px;">Nhà</th>
                        <th style="width: 6%;" >Mã Toa</th>
                        <th  style="width: 15%;">Người Yêu Cầu</th>
                        <th  style="width: 12%;">Trạng Thái</th>
                        <th >Giao</th>
                        <th >Nhận</th>
                        <th >Ngày Sử Dụng</th>
                        <!--<th >Duyệt</th>-->
                        <th >Chi Tiết</th>
                      </tr>
                      
                    
                  <?php
                  $id_farm = $row_staff['id_farm'];
                  $level = $row['level'];

                  //Phân Trang
                  $query = "SELECT COUNT(*) as total_records FROM prescription";
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

                  if($level ==1){
                    $sql_pre = "SELECT * FROM prescription ORDER BY date_created DESC LIMIT $startIndex, $recordsPerPage";
                    
                  }else if($level ==5 ||$level ==2||$level ==4 ||$level ==6){
                    $sql_pre = "SELECT * FROM prescription WHERE `id_farm`='$id_farm' ORDER BY date_created DESC LIMIT $startIndex, $recordsPerPage";
                  } else{
                    $sql_pre = "SELECT * FROM prescription WHERE `id_farm`='$id_farm' AND `id_user`='$id_client' ORDER BY date_created DESC LIMIT $startIndex, $recordsPerPage";
                  }


                  $run_pre = $con->query($sql_pre);
                  $x =0;
                  
                  foreach ($run_pre as $row_pre) {
                      //ID TOA THUOC 
                      $id_toa = $row_pre['id'];
                      //Lấy Tên Trại
                      $farm = $row_pre['id_farm'];
                      $sql_farm = "SELECT * FROM farm WHERE `code_farm` = '$farm' AND status =1";
                      $run_farm = $con->query($sql_farm);
                      $row_farm = mysqli_fetch_array($run_farm);
                      $name_farm = $row_farm['name'];

                      //Lấy Tên Nhà
                      /*$farm_place = $row_pre['id_farm_place'];
                      $sql_farm_place = "SELECT * FROM farm_place WHERE id=$farm_place AND status =1";
                      $run_farm_place = $con->query($sql_farm_place);
                      $row_farm_place = mysqli_fetch_array($run_farm_place);
                      $name_farm_place = $row_farm_place['name'];*/
                      //Lấy Tên Nhà
                      $sql_farmplace = "SELECT * FROM prescription_farm_place WHERE id_prescription = $id_toa";
                      $run_farmplace = $con -> query($sql_farmplace);
                      $name_farm_place_arr = array(); 
                      foreach($run_farmplace as $row_farmplace){
                      $id_farmplace = $row_farmplace['id_farm_place'];
                      $sql_farm_place = "SELECT * FROM farm_place WHERE `id` = '$id_farmplace' AND status =1";
                      $run_farm_place = $con->query($sql_farm_place);
                      $row_farm_place = mysqli_fetch_array($run_farm_place);
                      $name_farm_place = $row_farm_place['name'];
                      $name_farm_place_arr[] = $name_farm_place;
                      //echo '- '.$name_farm_place;
                      }

                      //Lấy Tên Nhân Viên
                      $id_user = $row_pre['id_user'];
                      $sql_user_request = "SELECT * FROM user WHERE `id_staff` = '$id_user';";
                      $run_user_request= $con->query($sql_user_request);
                      $row_user_request = mysqli_fetch_array($run_user_request);
                      $user_request = $row_user_request['id_staff'];
                      $sql_staff_request = "SELECT * FROM staff WHERE `id`='$user_request';";
                      $run_staff_request = $con->query($sql_staff_request);
                      $row_staff_request = mysqli_fetch_array($run_staff_request);

                      $name_user = $row_staff_request['fullname'];

                      //Lấy Tên Trạng Thái
                      $approval = $row_pre['approval'];
                      $sql_approval = "SELECT * FROM level_approval WHERE id=$approval AND status =1";
                      $run_approval = $con->query($sql_approval);
                      $row_approval = mysqli_fetch_array($run_approval);
                      $name_approval= $row_approval['name'];
                      
                      //Thời Gian yêu cầu
                      //$time = $row_pre['date_created'];

                      //Thời gian Sử Dụng Thuốc
                      $sql_timuse = "SELECT * FROM prescription_date_use WHERE id_prescription = '$id_toa'";
                      $run_timeuse = $con->query($sql_timuse);
                      $row_timeuse = mysqli_fetch_array($run_timeuse);
                      $time = $row_timeuse['date_use'];
                      $timeuse = date_format(date_create("$time"),"d/m/Y");

                      //Thời Gian duyệt 
                      if($approval=='3' ||$approval=='2'||$approval=='4' ||$approval=='5'||$approval=='6' ){
                        $time_approvals = $row_pre['date_approval'];
                      }else{
                        $time_approvals ="";
                      }
                      $time_approval = date_format(date_create("$time_approvals"),"H:m - d/m/Y");

                      //Kiểm tra Toa Thuốc Đã Giao
                      $sql_log = "SELECT * FROM prescription_log WHERE id_prescription = $id_toa and status=1 and level =1";
                      $run_log = $con->query($sql_log);
                      $row_log = mysqli_fetch_array($run_log);
                      $checl_log = $row_log['id'];

                      //Kiểm tra Toa Thuốc Đã nhận
                      $sql_log_receive = "SELECT * FROM prescription_log WHERE id_prescription = $id_toa and status=1 and level =2";
                      $run_log_receive = $con->query($sql_log_receive);
                      $row_log_receive = mysqli_fetch_array($run_log_receive);
                      $checl_log_receive = $row_log_receive['id'];

                      $x++;
                      echo "<tr>";
                      echo "<td>".$x."</td>";
                      echo "<td>".$name_farm."</td>";
                      echo '<td>' . implode(', ', $name_farm_place_arr) . '</td>'; // Xuất chuỗi HTML hoàn chỉnh
                      echo "<td>".$id_toa."</td>";
                      echo "<td>".$name_user."</td>";
                      echo "<td>".$name_approval."</td>";
                      
                      if(!empty($row_log)){ ?>
                        <td style="color: blue">
                          <strong><center><a onClick="check_log_giaonhan('<?php echo $id_toa ?>')"> X </a></center></strong>
                        </td>
                      <?php }else{
                        echo "<td></td>";
                      }
                      if(!empty($checl_log_receive)){ ?>
                        <td style="color: blue">
                          <strong><center><a onClick="check_log_giaonhan('<?php echo $id_toa ?>')"> X </a></center></strong>
                        </td>
                      <?php }else{
                        echo "<td></td>";
                      }
                      echo "<td>".$timeuse."</td>";
                      //echo "<td>".$time_approval."</td>";
                      echo "<td> <a style='text-decoration:none' href='chitiet.php/?id=".$id_toa."'> Xem</a> </td>";
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
