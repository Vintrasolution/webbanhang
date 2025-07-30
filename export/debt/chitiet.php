<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include "../../../header.php"; ?>
  <style type="text/css">
    th {
      padding-left: 10px;
    }
    td {
      padding-left: 10px;
    }
  </style>
  <title>Thu Vỏ Chai - Anova Farm</title>
  

</head>
<body>
<!-- partial:index.partial.html -->
<html>
  <head>
    <title>CHI TIẾT TOA THUỐC</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
  </head>

  <body>
      
    <div class="container my-4">

      <center><p class="h3">THU VỎ CHAI</p></center>
      <div class="card my-4 shadow">
        <div class="card-body">
          <?php 
            $id_debt = $_GET['id']; 
            $sql_debt = "SELECT * FROM debt WHERE status =1 AND id = $id_debt";
            $run_debt = $con->query($sql_debt);
            $row_debt = mysqli_fetch_array($run_debt);
          ?>
          <label for="field" class="font-weight-bold">Trại: </label>
          <?php 
            //Lấy Tên Trại
            $farm = $row_debt['id_farm'];
            $sql_farm = "SELECT * FROM farm WHERE `code_farm` LIKE '$farm' AND status =1";
            $run_farm = $con->query($sql_farm);
            $row_farm = mysqli_fetch_array($run_farm);
            $name_farm = $row_farm['name'];
            echo $name_farm;
          ?>
          <form action="" method="post">
            <label for="field" class="font-weight-bold">Nhân Viên: </label>
            <?php 
              //Lấy Tên Nhân Viên
              $id_staff = $row_debt['id_staff'];
              $sql_staff = "SELECT * FROM staff WHERE `id`='$id_staff' AND status =1";
              $run_staff = $con->query($sql_staff);
              $row_staff = mysqli_fetch_array($run_staff);
              $name_staff = $row_staff['fullname'];
              echo $name_staff;
            ?>
            <br/>
            <label for="field" class="font-weight-bold">Trạng Thái: </label>
            <?php 

              //Lấy Tên Trạng Thái
            $status = $row_debt['status'];
            if($status!=0){
              echo "<strong style='color:red; font-size:20px'>Chưa Trả</strong>";
            }else{
              echo "<strong style='color:green; font-size:20px'>Đã Trả</strong>";
            }
              /*$approval = $row_debt['approval'];
              $sql_approval = "SELECT * FROM level_approval WHERE id=$approval AND status =1";
              $run_approval = $con->query($sql_approval);
              $row_approval = mysqli_fetch_array($run_approval);
              $name_approval= $row_approval['name'];
              echo $name_approval;*/
            ?>

            <br/>
            <!-- Nhập Số Lượng Thu Hồi -->
            <?php 
              //SỐ LƯỢNG cần THU HỒI
              $amount_to_back = $row_debt['amount_box']; 
              //Số lượng đã thu hồi 
              $amount_back = $row_debt['amount_back'];
              //Số còn lại 
              $final_debt = $amount_to_back - $amount_back;

              if($amount_back != $amount_to_back){
            ?>

            <label for="field" class="font-weight-bold">Số Lượng Thu Hồi:  </label>
            <input type="number" name="back_amount" placeholder="Số lượng" min="1" max="<?php echo $final_debt;?>" style="width:10%;">
            <button type="submit" name="submit" value="5" class="btn btn-primary text-uppercase shadow-sm" formaction="">Xác Nhận</button>
            <?php }else {
              //Cập nhập tình trạng nợ vỏ chai
              $sql_update_debt = "UPDATE `debt` SET `status` = '0' WHERE `debt`.`id` = '$id_debt';";
              $run_update_debt = $con->query($sql_update_debt);
              header("Location: ../?success=1");
            } 
            $success = $_GET['success'];
            if($success==1){
              echo "<span style='color:green'>Đã cập nhập vỏ chai thành công! </span>";
            }
            ?> 
            <div id="dynamic-field-1" class="form-group dynamic-field">
              <label for="field" class="font-weight-bold">Chi Tiết Toa: </label>
              <br/>
              <!--Lấy Dữ Liệu Thuốc-->
                    <table border="1" style="width:100%;">
                      <tr>
                        <th >STT</th>
                        <th >Mã Vật Tư</th>
                        <th >Tên Thuốc</th>
                        <th >Số Lượng</th>
                      </tr>
                      
                    
                  <?php
                  $x=0;
                  $sql_debt_details = "SELECT * FROM debt WHERE status =1 AND id = $id_debt";
                  $run_debt_details = $con->query($sql_debt_details);
                  foreach ($run_debt_details as $row_debt_details) {
                      $x++;
                      $id_med = $row_debt_details['id_med'];
                      //Lấy Tên Thuốc
                      $sql_medicine = "SELECT * FROM medicines WHERE `code_med` LIKE '$id_med' AND status =1";
                      $run_medicine = $con->query($sql_medicine);
                      $row_medicine = mysqli_fetch_array($run_medicine);
                      $name_medicine = $row_medicine['name'];
                      $code_medicine = $row_medicine['code_med'];
                      $unit_medicine = $row_medicine['unit'];
                      $amount = $row_debt_details['amount_box'];
                      
                      echo "<tr>";
                      echo "<td>".$x."</td>";
                      echo "<td>".$code_medicine."</td>";
                      echo "<td>".$name_medicine."</td>";
                      echo "<td>".$amount_back."/".$amount."</td>";
                      echo "</tr>";

                    }
                    echo "</table>";
                ?>
            <div class="clearfix mt-4">
              <?php 
              $id_farm = $row_staff['id_farm'];
              $level = $row['level'];?>
              <button type="submit" name="submit" value="3" class="btn btn-primary float-right text-uppercase shadow-sm" formaction="../">QUAY LẠI</button>
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
            if($_POST['submit']==5){
              //ID debt
              $id_debts = $id_debt;
              //Số Lượng Trả Về 
              $back_amount = $_POST['back_amount'];
              //Số lượng còn lại 
              $back_amount_final = $amount_back + $back_amount;
              //Chạy Lệnh update amount back 
              $sql_update  = "UPDATE `debt` SET `amount_back` = '$back_amount_final' WHERE `debt`.`id` = '$id_debts';";
              $run_update  = $con->query($sql_update);
              ?><<meta http-equiv='refresh' content="0; url='/admin/import/prescription/debt/chitiet.php/?id=<?php echo $id_debts; ?>&success=1'"><?php
              //Ghi log trả thuốc
             $sql_log = "INSERT INTO `debt_log` (`id`, `id_debt`, `amount_back`, `status`, `date_created`) VALUES (NULL, '$id_debts', '$back_amount', '1', CURRENT_TIMESTAMP);";
              $run_log = $con->query($sql_log);
            }
            ?><?php
        //}
    ?>
  <script  src="./script.js"></script>
</body>
</html>
