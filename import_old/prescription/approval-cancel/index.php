<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include "../../../header.php"; ?>
  <?php
      
  ?>
  <style type="text/css">
    th {
      padding-left: 10px;
    }
    td {
      padding-left: 10px;
    }
  </style>
  <title>PHÊ DUYỆT HUỶ PHIẾU - Anova Farm</title>
  

</head>
<body>
<!-- partial:index.partial.html -->
<html>
  <head>
    <title>PHÊ DUYỆT HUỶ PHIẾU</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
  </head>

  <body>
      
    <div class="container my-4">

      <center><p class="h3">PHÊ DUYỆT HUỶ PHIẾU</p></center>
      <div class="card my-4 shadow">
        <div class="card-body">
          <?php 
            $id_toa = $_GET['id']; 
            $sql_pre = "SELECT * FROM prescription WHERE status =1 AND id = $id_toa";
            $run_pre = $con->query($sql_pre);
            $row_pre = mysqli_fetch_array($run_pre);
          ?>
          <label for="field" class="font-weight-bold">Trại: </label>
          <?php 
            //Lấy Tên Trại
            $farm = $row_pre['id_farm'];
            $sql_farm = "SELECT * FROM farm WHERE `code_farm` LIKE '$farm' AND status =1";
            $run_farm = $con->query($sql_farm);
            $row_farm = mysqli_fetch_array($run_farm);
            $name_farm = $row_farm['name'];
            echo $name_farm;
          ?>
          <form action="" method="post">
            <label for="field" class="font-weight-bold">Nhà: </label>
            <?php 
              //Lấy Tên Nhà
              /*$farm_place = $row_pre['id_farm_place'];
              $sql_farm_place = "SELECT * FROM farm_place WHERE `id` = '$farm_place' AND status =1";
              $run_farm_place = $con->query($sql_farm_place);
              $row_farm_place = mysqli_fetch_array($run_farm_place);
              $name_farm_place = $row_farm_place['name'];
              echo $name_farm_place;*/
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
                      
                      }
                      echo implode(', ', $name_farm_place_arr); 
            ?>
            <br/>
            <label for="field" class="font-weight-bold">Ngày Sử Dụng: </label>
            <?php 
              //Lấy Ngày Sử Dụng Toa Thuốc
              $sql_date_use = "SELECT * FROM prescription_date_use WHERE `id_prescription` = '$id_toa' AND status =1";
              $run_date_use = $con->query($sql_date_use);
              $row_date_use = mysqli_fetch_array($run_date_use);
              $date_use = $row_date_use['date_use'];
              $day = date_format(date_create($date_use),"d/m/Y ");
              if($date_use ==""){
                echo "Không Có Dữ Liệu";
              }else{
                echo $day;
              }
            ?>
            <br/>
            <label for="field" class="font-weight-bold">Trạng Thái: </label>
            <?php 
              //Lấy Tên Trạng Thái
              $approval = $row_pre['approval'];
              $sql_approval = "SELECT * FROM level_approval WHERE id=$approval AND status =1";
              $run_approval = $con->query($sql_approval);
              $row_approval = mysqli_fetch_array($run_approval);
              $name_approval= $row_approval['name'];
              echo $name_approval;
            ?>
            <br/>
            <!-- Lấy thông tin Người Yêu Cầu -->
            <label for="field" class="font-weight-bold">Người Yêu Cầu:  </label>
            <?php
                $id_user = $row_pre['id_user'];
                $sql_user_request = "SELECT * FROM user WHERE `id_staff` = '$id_user';";
                $run_user_request= $con->query($sql_user_request);
                $row_user_request = mysqli_fetch_array($run_user_request);
                $user_request = $row_user_request['id_staff'];
                $sql_staff_request = "SELECT * FROM staff WHERE `id`='$user_request';";
                $run_staff_request = $con->query($sql_staff_request);
                $row_staff_request = mysqli_fetch_array($run_staff_request);
                echo $row_staff_request['fullname'];
            ?>
            <br/>
            <?php
                $slq_find_subaproval = "SELECT * FROM prescription_user_subapproval WHERE id_prescription ='$id_toa' and level_approval ='5' or level_approval=6 and status =1 ORDER BY id DESC";
                $run_find_subaproval = $con->query($slq_find_subaproval);
                $row_find_subaproval = mysqli_fetch_array($run_find_subaproval);
                $id_subaproval = $row_find_subaproval['id'];
                $name_subaproval = $row_find_subaproval['fullname'];
              ?>
              <?php 
                if($approval ==5||$approval ==6){
                  ?><label for="field" class="font-weight-bold">Đã Duyệt Bởi: </label><?php
                  if($id_subaproval == ""){
                    $sql_man_approval = "SELECT * FROM prescription_user_approval WHERE `id_prescription` = '$id_toa' ORDER BY id DESC;";
                    $run_man_approval = $con->query($sql_man_approval);
                    $row_man_approval = mysqli_fetch_array($run_man_approval);
                    $man_approval = $row_man_approval['fullname'];
                    echo $man_approval;
                    }else{
                      echo $name_subaproval;
                    } 
                  }
                if($approval ==7){ 
                  ?><label for="field" class="font-weight-bold">Người Duyệt:  </label><?php
                  if($levelid != 6){ 
                  $sql_man_approval = "SELECT * FROM prescription_user_approval WHERE `id_prescription` = '$id_toa' ORDER BY id DESC;";
                  $run_man_approval = $con->query($sql_man_approval);
                  $row_man_approval = mysqli_fetch_array($run_man_approval);
                  $man_approval = $row_man_approval['fullname'];
                  echo $man_approval;
                  }else{
                    echo $client;
                    }
                  }
              ?>
            <br/>
            <div id="dynamic-field-1" class="form-group dynamic-field">
              <label for="field" class="font-weight-bold">Chi Tiết Toa: </label>
              <br/>
              <!--Lấy Dữ Liệu Thuốc-->
                    <table border="1" style="width:100%;">
                      <tr>
                        <th >STT</th>
                        <th >Tên Thuốc</th>
                        <th >Đơn Vị Tính</th>
                        <th >Số Lượng</th>
                      </tr>
                      
                    
                  <?php
                  $x=0;
                  $sql_pre_details = "SELECT * FROM details_prescription WHERE status =1 AND id_prescription = $id_toa";
                  $run_pre_details = $con->query($sql_pre_details);
                  foreach ($run_pre_details as $row_pre_details) {
                      $x++;
                      $id_med = $row_pre_details['id_medicine'];
                      //Lấy Tên Thuốc
                      $sql_medicine = "SELECT * FROM medicines WHERE `code_med`=$id_med AND status =1";
                      $run_medicine = $con->query($sql_medicine);
                      $row_medicine = mysqli_fetch_array($run_medicine);
                      $name_medicine = $row_medicine['name'];
                      $unit_medicine = $row_medicine['unit'];
                      $amount = $row_pre_details['amount'];
                      echo "<tr>";
                      echo "<td>".$x."</td>";
                      echo "<td>".$name_medicine."</td>";
                      echo "<td>".$unit_medicine."</td>";
                      echo "<td>".$amount."</td>";
                      echo "</tr>";

                    }
                    echo "</table>";
                ?>
            <div class="clearfix mt-4" style="text-align: center;">
              <?php if($levelid==4||$levelid==6){ if($approval==7){?>
              <button  type="submit" name="submit" value="6" class="btn btn-primary float-center text-uppercase shadow-sm" >ĐỒNG Ý</button>
              <button style="margin-left: 30px;" type="submit" name="submit" value="5" class="btn btn-primary float-center text-uppercase shadow-sm" >TỪ CHỐI</button>
              <?php }else{?>
              <button style="margin-left: 30px;background-color:  lightgray;color:black" class="btn btn-primary float-center text-uppercase shadow-sm" disabled>ĐÃ ĐƯỢC DUYỆT</button>
              <?php }}?>
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
            
            $id_pheduyet = $_GET['id'];
            //SEND EMAIL 
            // ID USER
                $id_client = $row_staff['id'];
                use PHPMailer\PHPMailer\PHPMailer;
                use PHPMailer\PHPMailer\Exception;
                require '../../../mail/O365/Exception.php';
                require '../../../mail/O365/PHPMailer.php';
                require '../../../mail/O365/SMTP.php';




                // Create a new PHPMailer instance
                $mail = new PHPMailer();
                //Lấy Email Account Sent
                $sql_sent = "SELECT * FROM mailsend WHERE status =1";
                $run_sent = $con->query($sql_sent);
                $row_sent = mysqli_fetch_array($run_sent);
                $host = $row_sent['host'];
                $usermail = $row_sent['email'];
                $password = $row_sent['password'];
                $smtpsecure = $row_sent['smtp_secure'];
                $port = $row_sent['port'];
                //Email Sender As
                $sender = $row_sent["email_sender"];

                // Use Office 365 as the email server
                $mail->isSMTP();
                $mail->Host = "{$host}";
                $mail->SMTPAuth = true;
                $mail->Username = "{$usermail}";
                $mail->Password = "{$password}";
                $mail->SMTPSecure = "{$smtpsecure}";
                $mail->Port = "{$port}";

            //END SEND EMAIL


            //DENY CANCEL
            if($_POST['submit']==5){
            //RUN UPDATE DENY CANCEL
            $sql_update = "UPDATE `prescription` SET `approval` = '5' , `date_approval`= CURRENT_TIMESTAMP WHERE `prescription`.`id` = $id_pheduyet;";
            $run_update = $con->query($sql_update);

            //Kiểm tra xem trưởng trại hay phó trại duyệt lệnh
            if($levelid ==6){
              $insert_subaproval = "INSERT INTO `prescription_user_subapproval` (`id`, `id_prescription`, `id_user`, `fullname`, `level_approval`, `status`, `date_created`) VALUES (NULL, '$id_pheduyet', '$id_client', '$client', '5', '1', CURRENT_TIMESTAMP);";
              $run_insert_subaproval = $con->query($insert_subaproval);
            }

            //Nếu Trưởng Trại Từ Chối Sẽ Gửi Mail cho Cá Nhân
            //Tìm Email Người Yêu Cầu
            $sql_farm = "SELECT * FROM staff WHERE status =1 AND id = '$id_user'";
            $run_farm = $con->query($sql_farm);
            $row_farm = mysqli_fetch_array($run_farm);
            $email_requester = $row_farm['email'];

            $to = $email_requester;
            //Tiêu Đề Gửi mail cho Cá Nhân Yêu Cầu
            $subject = '[TỪ CHỐI HUỶ] Toa Thuốc của  '.$row_farm['fullname'];
            //Nội Dung Gửi mail cho Admin Trại
            $message = "Dear {$row_farm['fullname']},";
            $message .= "<br/><br/>Toa thuốc đã bị trưởng trại từ chối huỷ bỏ.";
            $message .= "<br/> <p>Chi Tiết Toa Thuốc Tại: <a href='http://traiheo.anovafarm.com.vn/admin/import/prescription/history/chitiet.php/?id={$id_pheduyet}'>XEM NGAY</a></p>";
            $message .= "<br/><img src='https://traiheo.anovafarm.com.vn/admin/mail/signature.png' alt='Signature Of Anova Farm' style='width:50%; text-align:left'>";
            // Set the sender and recipient email addresses
            $mail->setFrom($sender, "TOA THUỐC - ANOVAFARM");
            $mail->addAddress($to, 'Recipient Name');

            // Set the subject and message
            $mail->IsHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $subject;
            $mail->Body = $message;
            //Chạy Lệnh Gửi mail cho admin trại
            if (!$mail->send()) {
                echo 'Failed to send email.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Email sent successfully!';
            }
            ?><meta http-equiv="refresh" content="0; url='?id=<?php echo $id_pheduyet;?>'" /><?php


            //APROVAL CANCEL
              }else if($_POST['submit']==6){
                //RUN UPDATE APPROVAL DENY
                $sql_update = "UPDATE `prescription` SET `approval` = '6' , `date_approval`= CURRENT_TIMESTAMP WHERE `prescription`.`id` = $id_pheduyet;";
                $run_update = $con->query($sql_update);
                //Kiểm tra xem trưởng trại hay phó trại duyệt lệnh
                if($levelid ==6){
                  $insert_subaproval = "INSERT INTO `prescription_user_subapproval` (`id`, `id_prescription`, `id_user`, `fullname`, `level_approval`, `status`, `date_created`) VALUES (NULL, '$id_pheduyet', '$id_client', '$client', '6', '1', CURRENT_TIMESTAMP);";
                  $run_insert_subaproval = $con->query($insert_subaproval);
                }
                
                //Cập Nhập Dữ Liệu Tồn Kho khi trưởng trại từ chối
                //Lấy dữ liệu tồn kho hiện tại
                $sql_pre_details_1 = "SELECT * FROM details_prescription WHERE status =1 AND id_prescription = $id_toa";
                $run_pre_details_1 = $con->query($sql_pre_details_1);
                foreach ($run_pre_details_1 as $row_pre_details_1) {
                  $id_med_1 = $row_pre_details_1['id_medicine'];
                  $amount_1 = $row_pre_details_1['amount'];
                  $sql_ware = "SELECT * FROM warehouse WHERE `id_farm` LIKE '$farm' AND `id_medicine`='$id_med_1'";
                  $run_ware = $con->query($sql_ware);
                  $row_ware = mysqli_fetch_array($run_ware);
                  $amount_ware = $row_ware['amount'];
                  $final_amount = $amount_ware + $amount_1;
                  //Cập nhập dữ liệu tồn kho còn lại sau khi gửi yêu cầu
                  $sql_update = "UPDATE `warehouse` SET `amount` = '$final_amount' WHERE `id_medicine` = '$id_med_1' AND `id_farm` LIKE '$farm'";
                  echo $sql_update;
                  $run_update = mysqli_query($con,$sql_update);
                  }
                  //Cập nhập lại các nhà đã được chọn cho 1 toa thuốc. Update status từ 1 về 0
                $sql_update_farm_place = "UPDATE `prescription_farm_place` SET `status` = '0' WHERE `prescription_farm_place`.`id_prescription` = $id_toa;";
                $run_update_farm_place = $con -> query($sql_update_farm_place);
            //Nếu Trưởng Trại Đồng Ý Huỷ Sẽ Gửi Mail cho Người Tạo email
            //Tìm Email User Tạo Toa Thuốc
            $sql_user_prescription = "SELECT * FROM prescription WHERE id= '$id_pheduyet' AND status =1";
            $run_user_prescription = $con->query($sql_user_prescription);
            $row_user_prescription = mysqli_fetch_array($run_user_prescription);
            $id_user = $row_user_prescription['id_user']; 

            $sql_emailad = "SELECT * FROM staff WHERE status =1 AND id = '$id_user'";
            $run_emailad = $con->query($sql_emailad);
            $row_emailad = mysqli_fetch_array($run_emailad);
            $email = $row_emailad['email'];
            $to = $email;
            //Tiêu Đề Gửi mail cho User Tạo Toa Thuốc
            $subjectdeny = '[ĐỒNG Ý HUỶ] Toa Thuốc của  '.$row_emailad['fullname'];
            //Nội Dung Gửi mail cho User Tạo Toa Thuốc
            $message = "Dear {$row_emailad['fullname']},";
            $message .= "<br/><br/>Toa thuốc đã được đồng ý huỷ bởi trưởng trại.";
            $message .= "<br/> <p>Chi Tiết Toa Thuốc Tại: <a href='http://traiheo.anovafarm.com.vn/admin/import/prescription/history/chitiet.php/?id={$id_pheduyet}'>XEM NGAY</a></p>";
            $message .= "<br/><img src='https://traiheo.anovafarm.com.vn/admin/mail/signature.png' alt='Signature Of Anova Farm' style='width:50%; text-align:left'>";
            // Set the sender and recipient email addresses
            $mail->setFrom($sender, "TOA THUỐC - ANOVAFARM");
            $mail->addAddress($to, 'Recipient Name');

            // Set the subject and message
            $mail->IsHTML(true);
            $mail->CharSet = 'UTF-8';
            $mail->Subject = $subjectdeny;
            $mail->Body = $message;
            //Chạy Lệnh Gửi mail cho admin trại
            if (!$mail->send()) {
                echo 'Failed to send email.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
            } else {
                echo 'Email sent successfully!';
            }

            ?><meta http-equiv="refresh" content="0; url='?id=<?php echo $id_pheduyet;?>'" /><?php
        }
    ?>
  <script  src="./script.js"></script>

</body>
</html>
