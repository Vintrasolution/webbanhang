<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include "../../header.php"; ?>
  <style type="text/css">
    th {
      padding-left: 10px;
    }
    td {
      padding-left: 10px;
    }
  </style>
  <title>Toa Thuốc - Anova Farm</title>
  

</head>
<body>
<!-- partial:index.partial.html -->
<html>
  <head>
    <title>TOA THUỐC</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
  </head>

  <body>
      
    <div class="container my-4">

      <center><p class="h3">TOA THUỐC</p></center>
      <div class="card my-4 shadow">
        <div class="card-body">
            <?php //ID FARM
              //ID FARM PLACE
              $farmplace = $_POST['farmplace'];
              $id_farmplace = $farmplace;
              // ID USER
              $id_client = $row_staff['id'];
            ?>
          <!-- Lấy dữ liệu Trại-->
          <?php 

            $id_trai = $row_staff['id_farm'];
            $sql_farmp = "SELECT * FROM farm WHERE status =1 AND code_farm = '$id_trai'";
            $run_farm = $con->query($sql_farmp);
            $row_farm = mysqli_fetch_array($run_farm); 

          ?> 
          <label for="field" class="font-weight-bold">Trại</label>
          <input type="hidden" name="farm1" value="<?php echo $row_farm['id']; ?>">

          

          <p><?php echo $row_farm['name']; ?> </p>
          
          <form action="" method="post">
            <!--Ngày áp dụng toa thuốc -->
            <?php $date_use = $_POST['date_use']; ?>
            <label for="field" class="font-weight-bold">Ngày Áp Dụng</label>
            <input type="hidden" name="date_use" value="<?php echo $date_use; ?>">
            <?php $day = date_format(date_create($date_use),"d/m/Y "); ?>
            <p><?php echo $day; ?></p>


            <label for="field" class="font-weight-bold">Nhà</label>
            <br/>
            <!--Lấy Dữ Chuồng Trại-->

                <?php 
                  $name_farm_place_arr = array(); 
                  foreach($id_farmplace as $farmplace_id) {
                    $sql_farmplace = "SELECT * FROM farm_place WHERE status =1 AND id='$farmplace_id'";
                    $run_farmplace = $con->query($sql_farmplace);
                    $row_farmplace = mysqli_fetch_array($run_farmplace);
                    $name_farm_place = $row_farmplace['name'];
                    $name_farm_place_arr[] = $name_farm_place;
                ?>
                <input type="hidden" name="farmplace1[]" value="<?php echo $row_farmplace['id']; ?> ">

              <?php } ?>
              <span><?php echo implode(', ', $name_farm_place_arr); ?> </span> 

            <div id="dynamic-field-1" class="form-group dynamic-field">
              <br/>
              <label for="field" class="font-weight-bold">Chi Tiết Toa: </label>
              <br/>
              <!--Lấy Dữ Liệu Thuốc-->
                <?php 
                  $medicine = $_POST['medicine'];
                  $amount = $_POST['amount'];
                  ?>
                    <table border="1" style="width:100%;">
                      <tr>
                        <th >Tên Thuốc</th>
                        <th >Mã Thuốc</th>
                        <th >Đơn Vị Tính</th>
                        <th >Số Lượng</th>
                      </tr>
                      
                    
                  <?php
                  foreach(array_combine($medicine, $amount) as $str => $amou) {
                      $arr = explode("-", $str);
                      $med = trim($arr[0]);
                      ?>
                      <input type="hidden" name="medicine1[]" value="<?php echo $med; ?>">
                      <input type="hidden" name="amount1[]" value="<?php echo $amou; ?>">
                      <?php 
                      $sql_namemedicine = "SELECT * FROM medicines WHERE status =1 AND code_med='$med'";
                      $run_namemedicine = $con->query($sql_namemedicine);
                      $row_namemedicine = mysqli_fetch_array($run_namemedicine);
                      $name_medicine = $row_namemedicine['name'];
                      $unit_medicine = $row_namemedicine['unit'];
                      echo "<tr>";
                      echo "<td>".$name_medicine."</td>";
                      echo "<td>".$med."</td>";
                      echo "<td>".$unit_medicine."</td>";
                      echo "<td>".$amou."</td>";
                      echo "</tr>";

                    }
                    echo "</table>";
                ?>
            <div class="clearfix mt-4">
              <button type="button" class="btn btn-primary float-left text-uppercase shadow-sm" onclick="window.location.href='https://traiheo.anovafarm.com.vn/admin/import/prescription/';">NHẬP LẠI</button>
              <button type="submit" name="submit" value="4" class="btn btn-primary float-right text-uppercase shadow-sm">GỬI YÊU CẦU</button>
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
              echo $_POST['medicine1'];

              echo $_POST['amount1'];

             if($_POST['submit']==4){
              //Kiểm tra dữ liệu có thiếu không sau khi submit
              if($_POST['medicine1']=="" AND $_POST['amount1']==""){
                ?> <meta http-equiv="refresh" content="0; url='index.php?error=1'" /> <?php
              }else{
            //ID FARM
            $id_trai = $row_staff['id_farm'];
            $sql_farmp = "SELECT * FROM farm WHERE status =1 AND `code_farm` LIKE '$id_trai'";
            $run_farm = $con->query($sql_farmp);
            $row_farm = mysqli_fetch_array($run_farm); 
            $run_farm = $con->query($sql_farmp);
            $id_farm = $row_farm['code_farm'];

            //ID FARM PLACE
            $farmplace = $_POST['farmplace1'];
            $id_farmplace = $farmplace;
            // ID USER
            $id_client = $row_staff['id'];
            $sql_fullname = "SELECT * FROM staff WHERE status =1 AND id = '$id_client'";
            $run_fullname = $con->query($sql_fullname);
            $row_fullname = mysqli_fetch_array($run_fullname); 
            //INSERT PRESCRIPTION AFTER SUBMIT
              $sql_prescription = "INSERT INTO `prescription` (`id`, `id_farm`, `id_farm_place`, `id_user`, `status`, `approval`, `date_created`) VALUES (NULL, '$id_farm', '0', '$id_client', '1', '1', CURRENT_TIMESTAMP);";
              $run_prescription = $con->query($sql_prescription);
            //DETAILS ID PRESCRIPTION AFTER SUBMIT
            $sql_idprescription = "SELECT * FROM prescription ORDER BY id DESC";
            $run_idprescription = mysqli_query($con,$sql_idprescription);
            $row_idprescription = mysqli_fetch_array($run_idprescription); 
            $id_prescription = $row_idprescription['id']; 
            //ID MEDICINE AND AMOUNT MEDICINE
            //INSERT DETAILS PRESCRIPTION AFTER SUMIT
            $medicine1 = $_POST['medicine1'];
            $amount1 = $_POST['amount1'];
            $farmplace1 = $_POST['farmplace1'];
            if($run_prescription > 0 AND $medicine1!='' AND $amount1!=''){
              
              foreach(array_combine($medicine1, $amount1) as $med1 => $amou1) {

              $sql_details = "INSERT INTO `details_prescription` (`id`, `id_prescription`, `id_medicine`, `amount`, `status`, `date_created`) VALUES (NULL, '$id_prescription', '$med1', '$amou1', '1', CURRENT_TIMESTAMP);";
              $run_details = $con->query($sql_details);

              //UPDATE AMOUNT MEDICINE AFTER SUBMIT
              //Lấy dữ liệu số lượng tồn kho
              $sql_ware = "SELECT * FROM warehouse WHERE `id_farm` LIKE '$id_farm' AND `id_medicine` = '$med1'";
              $run_ware = mysqli_query($con,$sql_ware);
              $row_ware = mysqli_fetch_array($run_ware);
              $amount_ware = $row_ware['amount'];
              $final_amount = $amount_ware - $amou1;     
              //Cập nhập dữ liệu tồn kho còn lại sau khi gửi yêu cầu
              $sql_update = "UPDATE `warehouse` SET `amount` = '$final_amount' WHERE `id_medicine` = '$med1' AND `id_farm` LIKE '$id_farm'";
              $run_update = mysqli_query($con,$sql_update);
              //-------------------------//
              //Kiểm tra Có lên toa thuốc là CHAI không. để thêm vào nợ chai
              /*$sql_check = "SELECT * FROM medicines WHERE code_med =$med1";
              $run_check = $con->query($sql_check);
              $row_check = mysqli_fetch_array($run_check);
              $unit_check = $row_check['unit'];
              
              $id_staff = $row_staff['id'];
                if($unit_check=="Chai"){
                  $sql_debt = "INSERT INTO `debt` (`id`, `id_farm`, `id_staff`, `id_med`, `amount_box`, `date_start`, `date_end`, `status`, `date_create`) VALUES (NULL, '$id_trai', '$id_staff', '$med1', '$amou1', CURRENT_TIMESTAMP, NULL, '1', CURRENT_TIMESTAMP);";
                  $run_debt = $con->query($sql_debt);
                }*/
              }
              foreach($farmplace1 as $place1){
               $sql_insert_farmplace = "INSERT INTO `prescription_farm_place` (`id`, `id_prescription`, `id_farm_place`, `status`, `created_time`) VALUES (NULL, '$id_prescription', '$place1', '1', CURRENT_TIMESTAMP)"; 
               $run_insert_farmplace = mysqli_query($con,$sql_insert_farmplace);
              }
              //INSERT DATE USE PRESCRIPTION
              $date_use1= $_POST['date_use'];
              $sql_date_use = "INSERT INTO `prescription_date_use` (`id`, `id_prescription`, `date_use`, `status`) VALUES (NULL, '$id_prescription', '$date_use1', '1');";
              $run_date_use = $con->query($sql_date_use);

              //SEARCH Họ tên trưởng trại
              $sql_tt_mail = "SELECT * FROM user as u , staff as s WHERE u.id_staff = s.id AND u.level = 4 AND s.id_farm LIKE '$id_trai' AND s.status =1 AND u.status=1";
              $run_tt_mail = $con->query($sql_tt_mail);
              $row_tt_mail = mysqli_fetch_array($run_tt_mail);
              $id_user_approval = $row_tt_mail['id_staff'];
              $fullname_approval = $row_tt_mail['fullname'];

              //INSERT USER APPROVAL - Trưởng Trại

              $sql_user_approval = "INSERT INTO `prescription_user_approval` (`id`, `id_prescription`, `id_user`,`fullname`, `status`, `date_created`) VALUES (NULL, '$id_prescription', '$id_user_approval','$fullname_approval', '1', CURRENT_TIMESTAMP);";
              $run_user_approval = $con->query($sql_user_approval);
            }
            

            ?><meta http-equiv="refresh" content="0; url='successful.php?id=<?php echo $id_prescription; ?>'" /><?php
        }}
    ?>

<script>
  function goBack() {
    window.history.back();
    window.close(); 
  }
</script>
  <script  src="./script.js"></script>

</body>
</html>
