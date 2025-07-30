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
      font-size: 14px;
      color: white;
      background-color: #7B77FC;
    }
    td {
      padding-left: 10px;
      padding-right: 10px;
      padding-top: 10px;
      padding-bottom: 10px;
      font-size: 13px;
    }
    tr:nth-child(even){background-color: #f2f2f2}
    .pagination {
      display: inline-block;
    }
    table {
        /* CSS để bảng tự động thay đổi kích thước hoặc cuộn ngang theo nhu cầu */
        width: 100%;
        overflow-x: auto;
      }
  </style>
  <title>Chi Tiết Toa Thuốc - Anova Farm</title>
  

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

      <center><p class="h3">CHI TIẾT TOA THUỐC</p></center>
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
          <br/>
          <label for="field" class="font-weight-bold">Mã Toa: </label>
          <?php 
            echo $id_toa;
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
          <form action="" method="post">
            <label for="field" class="font-weight-bold">Nhà: </label>
            <?php 
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
            <!-- Lấy thông tin Người Duyệt -->
            <?php
                $slq_find_subaproval = "SELECT * FROM prescription_user_subapproval WHERE id_prescription ='$id_toa' and status =1 ORDER BY id DESC";
                $run_find_subaproval = $con->query($slq_find_subaproval);
                $row_find_subaproval = mysqli_fetch_array($run_find_subaproval);
                $id_subaproval = $row_find_subaproval['id'];
                $name_subaproval = $row_find_subaproval['fullname'];
              ?>
              <?php 
                if($approval ==3||$approval ==2){
                  ?><label for="field" class="font-weight-bold">Đã Duyệt Bởi: </label><?php
                  if($id_subaproval == ""){
                    $sql_man_approval = "SELECT * FROM prescription_user_approval WHERE `id_prescription` = '$id_toa';";
                    $run_man_approval = $con->query($sql_man_approval);
                    $row_man_approval = mysqli_fetch_array($run_man_approval);
                    $man_approval = $row_man_approval['fullname'];
                    echo $man_approval;
                    }else{
                      echo $name_subaproval;
                    } 
                  }
                if($approval ==1 || $approval ==7){ 
                  ?><label for="field" class="font-weight-bold">Người Duyệt:  </label><?php
                  if($levelid != 6){ 
                  $sql_man_approval = "SELECT * FROM prescription_user_approval WHERE `id_prescription` = '$id_toa';";
                  $run_man_approval = $con->query($sql_man_approval);
                  $row_man_approval = mysqli_fetch_array($run_man_approval);
                  $man_approval = $row_man_approval['fullname'];
                  echo $man_approval;
                  }else{
                    echo $client;
                    }
                  }
                  if($approval ==4){ 
                  }
                  if($approval ==5||$approval ==6){
                  ?><label for="field" class="font-weight-bold">Đã Duyệt Bởi: </label><?php
                  if($id_subaproval == ""){
                    $sql_man_approval = "SELECT * FROM prescription_user_approval WHERE `id_prescription` = '$id_toa';";
                    $run_man_approval = $con->query($sql_man_approval);
                    $row_man_approval = mysqli_fetch_array($run_man_approval);
                    $man_approval = $row_man_approval['fullname'];
                    echo $man_approval;
                    }else{
                      echo $name_subaproval;
                    } 
                  }
              ?>
            <?php 
            //THÔNG BÁO KHI NHẤP NÚT GIAO/NHẬN giữa admin/thủ kho với Kỹ Thuật
              $done = $_GET['done'];
              if($done==1){
            ?>
              <label for="field" class="font-weight-bold">Thông báo:  </label>
            <?php 
              echo "<a style='color:green'>ĐÃ GIAO HÀNG!</a>";
              echo "<br/>";

            } 
            else if($done==2){
                ?>
                  <label for="field" class="font-weight-bold">Thông báo:  </label>
                  <?php 
                    echo "<a style='color:red'>ĐÃ CÓ LỖI GIAO/NHẬN! VUI LÒNG THỬ LẠI hoặc liên hệ ADMINISTRATOR NCG</a>";
                    echo "<br/>";
                  } 

            ?>
            <?php 
              $done = $_GET['done'];
              if($done==3){
            ?>
              <label for="field" class="font-weight-bold">Thông báo:  </label>
            <?php 
              echo "<a style='color:green'>ĐÃ NHẬN HÀNG!</a>";
              echo "<br/>";
            } 
            else if($done==4){
                ?>
                  <label for="field" class="font-weight-bold">Thông báo:  </label>
                  <?php 
                    echo "<a style='color:red'>ĐÃ CÓ LỖI GIAO/NHẬN! VUI LÒNG THỬ LẠI hoặc liên hệ ADMINISTRATOR NCG</a>";
                    echo "<br/>";
                  } 

            ?>

            <!--THÔNG BÁO ĐÃ GIAO/NHẬN chưa-->
            <?php
            $sql_check_1 = "SELECT * FROM `prescription_log` WHERE `id_prescription`='$id_toa' ORDER BY id ASC";
            $run_check_1 = $con->query($sql_check_1);
            $row_check_1 = mysqli_fetch_array($run_check_1);
            $level_check_1 = $row_check_1['level'];
            $time_giao = $row_check_1['data_created'];
            $giao = date_format(date_create($time_giao),"d/m/Y - H:m");

            $sql_check_2 = "SELECT * FROM `prescription_log` WHERE `id_prescription`='$id_toa' ORDER BY id DESC";
            $run_check_2 = $con->query($sql_check_2);
            $row_check_2 = mysqli_fetch_array($run_check_2);
            $level_check_2 = $row_check_2['level'];
            $time_nhan = $row_check_2['data_created'];
            $nhan = date_format(date_create($time_nhan),"d/m/Y - H:m");


            $level_user = $row['level'];
            if($level_user==5 || $level_user==1 ||$level_user==2){ ?>
                <label for="field" class="font-weight-bold">Giao/Nhận: </label>
                <?php if($level_check_1==1){
                  echo "<a style='color:green'>Đã giao hàng!</a>"." (".$giao.")";
                }else {
                  echo "<a style='color:red'>Chưa giao hàng!</a>";
                } ?>
              <?php } if($level_user==3 ||$level_user==2 || $level_user==1){ ?>
                <label for="field" class="font-weight-bold">Giao/Nhận: </label>
                <?php if($level_check_2==2){
                  echo "<a style='color:green'>Đã nhận hàng!</a>"." (".$nhan.")";
                }else {
                  echo "<a style='color:red'>Chưa nhận hàng!</a>";
                } ?>
              <?php } ?>

              <br/>
              
            <div id="dynamic-field" class="form-group dynamic-field">
              <label for="field" class="font-weight-bold">Chi Tiết Toa: </label>
              <br/>
              <!--Lấy Dữ Liệu Thuốc-->
                    <table border="1" style="width:100%;">
                      <tr>
                        <th >STT</th>
                        <th >Mã Vật Tư</th>
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
                      $sql_medicine = "SELECT * FROM medicines WHERE code_med=$id_med AND status =1";
                      $run_medicine = $con->query($sql_medicine);
                      $row_medicine = mysqli_fetch_array($run_medicine);
                      $name_medicine = $row_medicine['name'];
                      $code_medicine = $row_medicine['code_med'];
                      $unit_medicine = $row_medicine['unit'];
                      $amount = $row_pre_details['amount'];
                      echo "<tr>";
                      echo "<td>".$x."</td>";
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
              $id_farm  = $row_staff['id_farm'];
              $level = $row['level'];
              //Lấy thông tin đã giao hàng chưa để enable nút Đã Nhận Đủ
              $sql_pre_log = "SELECT * FROM  prescription_log WHERE `id_prescription`='$id_toa' AND `status`=1 ORDER BY id DESC;";
              $run_pre_log = $con->query($sql_pre_log);
              $row_pre_log = mysqli_fetch_array($run_pre_log);
              $id_level_pre_log = $row_pre_log['level'];
              

              //Lấy thông tin user Yêu Cầu toa thuốc
              $id_pre = $row_pre_log['id_prescription'];
              $sql_user_re = "SELECT * FROM prescription WHERE id = '$id_pre'";
              $run_user_re = $con->query($sql_user_re);
              $row_user_re = mysqli_fetch_array($run_user_re);
              $id_user_re = $row_user_re['id_user'];
              $id_client = $row_staff['id'];

              if($level ==4 ||$level ==6 AND $approval ==1){ ?>
              <button type="submit" name="submit" value="9" class="btn btn-primary float-left text-uppercase shadow-sm" formaction="../../approval/?id=<?php echo $id_toa; ?>">PHÊ DUYỆT</button> <?php }?>
              
              <?php if($level ==4 ||$level ==6 AND $approval ==7 ){ ?>
              <button type="submit" name="submit" value="9" class="btn btn-primary float-left text-uppercase shadow-sm" formaction="../../approval-cancel/?id=<?php echo $id_toa; ?>">PHÊ DUYỆT HUỶ</button> <?php }?>

              <?php if($level ==2 ||$level ==3 AND $approval ==1 AND $id_client == $user_request){ ?>
              <button type="submit" name="submit" value="9" class="btn btn-primary float-left text-uppercase shadow-sm" formaction="../../self-cancel/?id=<?php echo $id_toa; ?>">HUỶ PHIẾU</button> <?php }?>

              <?php if($level ==2 ||$level ==3 AND $approval ==3 AND $id_client == $user_request AND $level_check_1!=1 AND $level_check_2!=2){ ?>
              <button style='margin-right: 4px' type="submit" name="submit" value="9" class="btn btn-primary float-left text-uppercase shadow-sm" formaction="/admin/import/prescription/history/preview-cancel.php/?id=<?php echo $id_toa; ?>">YÊU CẦU HUỶ PHIẾU</button> <?php }?>

              <?php if($level !=4 || $level !=6 AND $approval !=1  ){  ?>
                  <button class="btn btn-primary float-mid text-uppercase shadow-sm" onclick="window.print()">IN PHIẾU</button>
              <?php } ?>

              <?php if($level ==5 AND $approval==3 || $approval==5  AND $id_level_pre_log !=1 AND $id_level_pre_log !=2 ){  ?>
                  <button class="btn btn-primary float-mid text-uppercase shadow-sm" type="submit" value="6" name="submit">XÁC NHẬN GIAO</button>
              <?php } ?>

              <?php if($level ==3 || $level ==2 AND $approval==3 || $approval==5 AND $id_level_pre_log ==1 AND  $id_user_re==$id_client){ ?>
                <button class="btn btn-primary float-mid text-uppercase shadow-sm" type="submit" value="7" name="submit">ĐÃ NHẬN ĐỦ</button>
              <?php } ?>

              <?php if($level ==1 ){ ?>
              <button style='margin-right: 4px' type="submit" name="submit" value="9" class="btn btn-primary float-left text-uppercase shadow-sm" formaction="/admin/import/prescription/edit-prescription.php/?id=<?php echo $id_toa; ?>">SỬA PHIẾU</button> <?php }?>

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
            //SEND EMAIL 
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
            //TÌM EMAIL NGƯỜI NHẬN THUỐC
                  $sql_receive = "SELECT * FROM staff as s , prescription as p WHERE s.id = p.id_user and p.id = '$id_toa';";
                  $run_receive = $con->query($sql_receive);
                  $row_receive = mysqli_fetch_array($run_receive);
                  $mail_receive = $row_receive['email'];
                  $name_receive = $row_receive['fullname'];
            //TÌM EMAIL ADMIN
                  $sql_farm_admin = "SELECT * FROM prescription WHERE id = '$id_toa'";
                  $run_farm_admin= $con->query($sql_farm_admin);
                  $row_farm_admin = mysqli_fetch_array($run_farm_admin);
                  $idfarmadmin = $row_farm_admin['id_farm'];

                  $sql_admin = "SELECT * FROM staff WHERE id_farm LIKE '$idfarmadmin' and admin_farm='1' and status='1';";
                  $run_admin = $con->query($sql_admin);
                  $row_admin = mysqli_fetch_array($run_admin);
                  $email_admin = $row_admin['email'];
                  $name_admin = $row_admin['fullname'];

            $email_vinh ="vinh.nguyentan@novaconsumer.com.vn";

            //XÁC NHẬN GIAO HÀNG BUTTON
            if($_POST['submit']==6){
                  $id_client = $row_staff['id'];
                  //INSERT PRESCRIPTION AFTER SUBMIT
                    $sql_prescription_log = "INSERT INTO `prescription_log` (`id`, `id_prescription`, `id_user_process`, `level`, `status`, `data_created`) VALUES (NULL, '$id_toa', '$id_client', '1', '1', CURRENT_TIMESTAMP);";
                    $run_prescription_log = $con->query($sql_prescription_log);
                    if($run_prescription_log==TRUE){
                      ?><meta http-equiv="refresh" content="0; url='?done=1&id=<?php echo $id_toa; ?>'" /><?php
                    }else{
                      ?><meta http-equiv="refresh" content="0; url='?done=2&id=<?php echo $id_toa; ?>'" /><?php
                    }
                  

                  //Nội Dung gửi mail
                  //Tiêu Đề Gửi mail cho Người Nhận Thuốc
                  $subject = '[GIAO THUỐC] Toa Thuốc của  '.$name_receive;
                  //Nội Dung Gửi mail cho Admin Trại
                  $message = "Dear {$name_receive},";
                  $message .= "<br/><br/> THỦ KHO đã xác nhận đủ thuốc giao hàng cho Anh/Chị. Mời Anh/Chị về kho thuốc để nhận hàng!";
                  $message .= "<br/> <p>Chi Tiết Nhận Thuốc Tại: <a href='http://traiheo.anovafarm.com.vn/admin/import/prescription/history/chitiet.php/?id={$id_toa}'>XEM NGAY</a></p>";
                  $message .= "<br/><img src='https://traiheo.anovafarm.com.vn/admin/mail/signature.png' alt='Signature Of Anova Farm' style='width:50%; text-align:left'>";
                  // Set the sender and recipient email addresses
                  $mail->setFrom($sender, "TOA THUỐC - ANOVAFARM");
                  $mail->addAddress($mail_receive, $name_receive);
                  $mail->addAddress($email_vinh, 'Vinh');

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
            }
            //XÁC NHẬN NHẬN HÀNG BUTTON
            if($_POST['submit']==7){
            $id_client = $row_staff['id'];
            //INSERT PRESCRIPTION AFTER SUBMIT
              $sql_prescription_log = "INSERT INTO `prescription_log` (`id`, `id_prescription`, `id_user_process`, `level`, `status`, `data_created`) VALUES (NULL, '$id_toa', '$id_client', '2', '1', CURRENT_TIMESTAMP);";
              $run_prescription_log = $con->query($sql_prescription_log);
              if($run_prescription_log==TRUE){
                ?><meta http-equiv="refresh" content="0; url='?done=3&id=<?php echo $id_toa; ?>'" /><?php
              }else{
                ?><meta http-equiv="refresh" content="0; url='?done=4&id=<?php echo $id_toa; ?>'" /><?php
              }
                  

                  //Nội Dung gửi mail
                  //Tiêu Đề Gửi mail cho Admin
                  $subject = '[HOÀN TẤT] Toa Thuốc của  '.$name_receive;
                  //Nội Dung Gửi mail cho Admin Trại
                  $message = "Dear {$name_admin},";
                  $message .= "<br/><br/> Toa thuốc đã được THỦ KHO và NGƯỜI NHẬN THUỐC hoàn tất Giao Nhận tại kho!";
                  $message .= "<br/> <p>Chi Tiết Nhận Thuốc Tại: <a href='http://traiheo.anovafarm.com.vn/admin/import/prescription/history/chitiet.php/?id={$id_toa}'>XEM NGAY</a></p>";
                  $message .= "<br/><img src='https://traiheo.anovafarm.com.vn/admin/mail/signature.png' alt='Signature Of Anova Farm' style='width:50%; text-align:left'>";
                  // Set the sender and recipient email addresses
                  $mail->setFrom($sender, "TOA THUỐC - ANOVAFARM");
                  $mail->addAddress($email_admin, '$name_admin');
                  $mail->addAddress($email_vinh, 'Vinh');

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

            }
            ?><!--<meta http-equiv="refresh" content="0; url='/prescription/successful.php'" />--><?php
        //}
    ?>
  <script  src="./script.js"></script>

</body>
</html>
