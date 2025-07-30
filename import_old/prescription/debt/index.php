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
        white-space: nowrap; /* Ngăn chặn ngắt dòng */
        overflow: hidden; /* Ẩn nội dung dư thừa */
        text-overflow: ellipsis; /* Hiển thị dấu chấm ở cuối khi nội dung bị ẩn */
    }
    table {
        /* CSS để bảng tự động thay đổi kích thước hoặc cuộn ngang theo nhu cầu */
        width: 100%;
        overflow-x: auto;
      }
  </style>
  <title>KHO CHAI THUỐC - Anova Farm</title>
  

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

      <center><p class="h3">DANH SÁCH TẠM GIỮ CHAI</p></center>
      <?php 
        $ok = $_GET['success'];
        if($ok==1){
          echo "<p style='color:green; text-align:center; font-size: 18px '>ĐÃ CẬP NHẬP THÀNH CÔNG</p>";}
      ?>
      <div class="card my-4 shadow">
        <div class="card-body" style="overflow-x:auto;">
          <form action="" method="post">
            <button type="button" class="btn saveAsExcel">Xuất Excel</button> 
            <table id="mytable" class="table table-bordered exportable" border="1" style="width:100%;">
                      <tr>
                        <th >STT</th>
                        <th >Trại</th>
                        <th >NV Tạm Giữ</th>
                        <th >Mã Toa</th>
                        <th >Mã Thuốc</th>
                        <th >Tên Chai</th>
                        <th >Số Lượng</th>
                        <!--<th >Trạng Thái</th>-->
                        <th >Ngày</th>
                        <?php $level = $row['level']; if($level ==5){ ?>
                        <th >Công Cụ</th>
                      <?php } ?>
                      </tr>
                      
                    
                  <?php
                  $id_farm = $row_staff['id_farm'];
                  $level = $row['level'];
                  $id_staff = $row_staff['id'];
                  /*if($level !=1 ){
                  $sql_debt = "SELECT * FROM debt WHERE status =1 AND `id_farm`='$id_farm' ORDER BY date_create DESC";
                  }else{
                    $sql_debt = "SELECT * FROM debt ORDER BY date_create DESC";
                  }*/
                  //LỌC LEVEL XEM DEBT
                  if($level ==1 ){
                    $sql_debt = "SELECT * FROM debt ORDER BY date_create DESC";
                  }else { 
                      if($level==5 ||$level==4||$level==6){
                        $sql_debt = "SELECT * FROM debt WHERE `id_farm` LIKE '$id_farm' ORDER BY date_create DESC";
                      } else{
                        $sql_debt = "SELECT * FROM debt WHERE `status` =1 AND `id_farm` LIKE '$id_farm' AND `id_staff`='$id_staff' ORDER BY date_create DESC";
                      }
                  }
                  $run_debt = $con->query($sql_debt);
                  $x =0;
                  
                  foreach ($run_debt as $row_debt) {
                      //MÃ TOA THUỐC 
                      if($row_debt['id_prescription']==""){
                        $id_prescription = "-";
                      }else{
                        $id_prescription = $row_debt['id_prescription'];
                      }
                      //ID TOA THUOC 
                      $id_debt = $row_debt['id'];
                      //Lấy Tên Trại
                      $farm = $row_debt['id_farm'];
                      $sql_farm = "SELECT * FROM farm WHERE `code_farm` = '$farm' AND status =1";
                      $run_farm = $con->query($sql_farm);
                      $row_farm = mysqli_fetch_array($run_farm);
                      $name_farm = $row_farm['name'];

                      //Lấy Tên Nhà
                      $farm_place = $row_debt['id_farm_place'];
                      $sql_farm_place = "SELECT * FROM farm_place WHERE id=$farm_place AND status =1";
                      $run_farm_place = $con->query($sql_farm_place);
                      $row_farm_place = mysqli_fetch_array($run_farm_place);
                      $name_farm_place = $row_farm_place['name'];

                      //Lấy Tên Nhân Viên
                      $id_user = $row_debt['id_staff'];
                      $sql_user = "SELECT * FROM staff WHERE id=$id_user AND status =1";
                      $run_user = $con->query($sql_user);
                      $row_user = mysqli_fetch_array($run_user);
                      $name_user = $row_user['fullname'];

                       //Lấy Tên Thuốc
                      $id_med = $row_debt['id_med'];
                      $sql_med = "SELECT * FROM medicines WHERE `code_med` LIKE $id_med AND status =1";
                      $run_med = $con->query($sql_med);
                      $row_med = mysqli_fetch_array($run_med);
                      $name_med = $row_med['name'];

                      // Lấy Số Lượng Debt
                      $amount_box = $row_debt['amount_box'];

                      //Số lượng đã trả 
                      $amount_back  = $row_debt['amount_back'];

                      // Thời gian lưu giữ
                      $date_start = $row_debt['date_start'];

                      //Lấy Tên Trạng Thái
                      /*$status = $row_debt['status'];
                      if($status==1){
                        $thongbao = "Chưa Trả";
                      }*/
                      
                      //Thời Gian yêu cầu
                      $time = $row_debt['date_created'];
                      $x++;
                      if($amount_back == $amount_box){
                        echo "<tr>";
                        echo "<td>".$x."</td>";
                        echo "<td>".$name_farm."</td>";
                        echo "<td>".$name_user."</td>";
                        echo "<td>".$id_prescription."</td>";
                        echo "<td>".$id_med."</td>";
                        echo "<td>".$name_med."</td>";
                        echo "<td><a href='log.php/?id=".$id_debt."' style='text-decoration:none'>".$amount_back."/".$amount_box."</a></td>";
                        echo "<td>".$date_start."</td>";
                        echo "<td></td>";
                      }else{
                        echo "<tr style='background-color:yellow;'>";
                        echo "<td>".$x."</td>";
                        echo "<td>".$name_farm."</td>";
                        echo "<td>".$name_user."</td>";
                        echo "<td>".$id_prescription."</td>";
                        echo "<td>".$id_med."</td>";
                        echo "<td>".$name_med."</td>";
                        echo "<td style='color:red;'><a href='log.php/?id=".$id_debt."' style='text-decoration:none'>".$amount_back."/".$amount_box."</a></td>";
                       // echo "<td>".$thongbao."</td>";
                        echo "<td>".$date_start."</td>";
                        if($level ==5){
                        echo "<td> <a style='text-decoration:none' href='chitiet.php/?id=".$id_debt."'><center>THU</center></a> </td>";
                        }
                      }
                      
                      echo "</tr>";

                    }
                    echo "</table>";
                ?>
            <div class="clearfix mt-4">
            </div>
          </form>
        </div>
      </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
<!-- partial -->
<?php 
            /*if($_POST['submit']==2){
            //ID FARM
            $run_farm = $con->query($sql_farmp);
            $id_farm = $row_farm['id'];
            //ID FARM PLACE
            $farmplace = $_POST['farmplace1'];
            $id_farmplace = $farmplace;
            // ID USER
            $id_client = $row_staff['id'];
            //INSERT PRESCRIPTION AFTER SUBMIT
              $sql_debtscription = "INSERT INTO `prescription` (`id`, `id_farm`, `id_farm_place`, `id_user`, `status`, `date_created`) VALUES (NULL, '$id_farm', '$id_farmplace', '$id_client', '1', CURRENT_TIMESTAMP);";
              $run_debtscription = $con->query($sql_debtscription);
            //DETAILS ID PRESCRIPTION AFTER SUBMIT
            $sql_idprescription = "SELECT * FROM prescription ORDER BY id DESC";
            $run_idprescription = mysqli_query($con,$sql_idprescription);
            $row_idprescription = mysqli_fetch_array($run_idprescription); 
            $id_prescription = $row_idprescription['id']; 
            //ID MEDICINE AND AMOUNT MEDICINE
            //INSERT DETAILS PRESCRIPTION AFTER SUMIT
            $medicine1 = $_POST['medicine1'];
            $amount1 = $_POST['amount1'];
            if($run_debtscription > 0 AND $medicine1!='' AND $amount1!=''){
              
              foreach(array_combine($medicine1, $amount1) as $med1 => $amou1) {
              $sql_details = "INSERT INTO `details_prescription` (`id`, `id_prescription`, `id_medicine`, `amount`, `status`, `date_created`) VALUES (NULL, '$id_prescription', '$med1', '$amou1', '1', CURRENT_TIMESTAMP);";
              $run_details = $con->query($sql_details);
                
              }
            }*/
            ?><!--<meta http-equiv="refresh" content="0; url='/prescription/successful.php'" />--><?php
        //}
    ?>
<!-- Script để xuất file Excel -->
 <script src='https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2014-11-29/FileSaver.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.12.13/xlsx.full.min.js'></script>
<script  src="./vochaitamgiu.js"></script>
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
      var fileName = "vochaitamgiu_" + year + "-" + month + "-" + day + ".xlsx";
      return XLSX.writeFile(workbook, fileName);
    }
    </script>
      <script  src="./vochaitamgiu.js"></script>
</body>
</html>
