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
  <title>Thành Công - Anova Farm</title>
  

</head>
<body>
<!-- partial:index.partial.html -->
<html>
  <head>
    <title>Gửi Mail Thành Công</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
  </head>

  <body>
      
    <div class="container my-4">
      <?php
            $id_prescription = $_GET['id']; 
      ?>
      <center><p class="h1">GỬI YÊU CẦU THÀNH CÔNG</p></center>
      <div class="card my-4 shadow">
        <div class="card-body">
          <form action="" method="post">
            <p>Email đã được gửi thành công tới Người Duyệt</p>
            <p>Trạng Thái Hiện Tại: <a style="color:blue; font-size:18px"><b>Đang Chờ Duyệt</b></a></p> 
            <p>Kiểm tra tiến độ phê duyệt tại: <a href="history/chitiet.php/?id=<?php echo $id_prescription; ?>">XEM NGAY</a></p>
            <div class="clearfix mt-4">
              <button type="submit" name="submit" value="3" class="btn btn-primary float-left text-uppercase shadow-sm" formaction="../prescription">THÊM MỚI</button>
              <button type="submit" name="submit" value="3" class="btn btn-primary float-left text-uppercase shadow-sm" formaction="/admin/index.php" style="margin-left: 10px;">TRANG CHỦ</button>
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
<!--<?php 
            if($_POST['submit']==2){
            //ID FARM
            $id_trai = $row_staff['id_farm'];
            $sql_farmp = "SELECT * FROM farm WHERE status =1 AND id = '$id_trai'";
            $run_farm = $con->query($sql_farmp);
            $row_farm = mysqli_fetch_array($run_farm); 
            $run_farm = $con->query($sql_farmp);
            $id_farm = $row_farm['id'];

            //ID FARM PLACE
            $farmplace = $_POST['farmplace1'];
            $id_farmplace = $farmplace;
            // ID USER
            $id_client = $row_staff['id'];
            $sql_fullname = "SELECT * FROM staff WHERE status =1 AND id = '$id_client'";
            $run_fullname = $con->query($sql_fullname);
            $row_fullname = mysqli_fetch_array($run_fullname); 
            //INSERT PRESCRIPTION AFTER SUBMIT
              $sql_prescription = "INSERT INTO `prescription` (`id`, `id_farm`, `id_farm_place`, `id_user`, `status`, `approval`, `date_created`) VALUES (NULL, '$id_farm', '$id_farmplace', '$id_client', '1', '1', CURRENT_TIMESTAMP);";
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
            if($run_prescription > 0 AND $medicine1!='' AND $amount1!=''){
              
              foreach(array_combine($medicine1, $amount1) as $med1 => $amou1) {
              $sql_details = "INSERT INTO `details_prescription` (`id`, `id_prescription`, `id_medicine`, `amount`, `status`, `date_created`) VALUES (NULL, '$id_prescription', '$med1', '$amou1', '1', CURRENT_TIMESTAMP);";
              $run_details = $con->query($sql_details);
                
              }
            }
        } 
    ?>-->
<?php

// ID USER
$id_client = $row_staff['id'];
$sql_fullname = "SELECT * FROM staff WHERE status =1 AND id = '$id_client'";
$run_fullname = $con->query($sql_fullname);
$row_fullname = mysqli_fetch_array($run_fullname);
$email = $row_fullname['email'];
$id_trai = $row_fullname['id_farm'];

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../mail/O365/Exception.php';
require '../../mail/O365/PHPMailer.php';
require '../../mail/O365/SMTP.php';

// Recipient email address
$sql_mailtrai = "SELECT * FROM farm WHERE `code_farm` LIKE '$id_trai' AND status =1";
$run_mailfarm = $con->query($sql_mailtrai);
$row_mailtrai = mysqli_fetch_array($run_mailfarm);
//$emailtrai = $row_mailtrai['email'];
//$to = $emailtrai;

//Email Trưởng Trại
$sql_tt_mail = "SELECT * FROM user as u , staff as s WHERE u.id_staff = s.id AND u.level = 4 AND s.id_farm LIKE '$id_trai' AND s.status =1 AND u.status=1";
$run_tt_mail = $con->query($sql_tt_mail);
$row_tt_mail = mysqli_fetch_array($run_tt_mail);
$to = $row_tt_mail['email'];

//Email Phó Trại
$sql_pt_mail = "SELECT * FROM user as u , staff as s WHERE u.id_staff = s.id AND u.level = 6 AND s.id_farm LIKE '$id_trai' AND s.status =1 AND u.status=1";
$run_pt_mail = $con->query($sql_pt_mail);
$row_pt_mail = mysqli_fetch_array($run_pt_mail);
$to_pt = $row_pt_mail['email'];


// Subject of the email
$subject = '[Thông Báo] Yêu Cầu Lấy Thuốc Của '.$row_fullname['fullname'];

// Message to be sent in the email

              //Kiểm tra Dữ Liệu nếu 1 đơn có nhiều nhà
              $sql_multiple_place = "SELECT * FROM prescription_farm_place WHERE id_prescription = $id_prescription AND status =1";
              $run_multiple_place = $con -> query($sql_multiple_place);

              //Kiểm tra Trại từ Đơn Thuốc
              $sql_farm = "SELECT * FROM prescription WHERE id = $id_prescription AND status =1";
              $run_farm = $con -> query($sql_farm);
              $row_farm = mysqli_fetch_array($run_farm);
              $farmid = $row_farm['id_farm'];


              $sql_details_pre = "SELECT * FROM details_prescription WHERE id_prescription = $id_prescription;";
              $run_details_pre = $con->query($sql_details_pre);

              //Lấy Dữ Liệu Ngày Sử Dụng Thuốc 
              $sql_date_use = "SELECT * FROM prescription_date_use WHERE id_prescription = $id_prescription";
              $run_date_use = $con -> query($sql_date_use);
              $row_date_use = mysqli_fetch_array($run_date_use);
              $date_use = $row_date_use['date_use'];
              $day = date_format(date_create($date_use),"d/m/Y ");

              $message ="
              <html>
                <head>
                  <title>TOA THUỐC</title>
                </head>
                <body>
                  <p>Dữ liệu thuốc của: </p>";
                  $name_farm_place_arr = array(); 
                  foreach($run_multiple_place as $row_multiple_place){
                    $id_farm_place = $row_multiple_place['id_farm_place'];
                    $sql_farm_place = "SELECT * FROM farm_place WHERE `id` = '$id_farm_place' and `id_farm` LIKE '$farmid'";
                    $run_farm_place = $con -> query($sql_farm_place);
                    $row_farm_place = mysqli_fetch_array($run_farm_place);
                    $name_farm_place = $row_farm_place['name'];
                    $name_farm_place_arr[] = $name_farm_place;
                    
                  }
                  $all_place = implode(', ', $name_farm_place_arr);
                  $message .="<span> - {$all_place} </span>";
                  $message .="
                              <p>Ngày Sử Dụng: </p>
                              <span> {$day} </span>
                              ";
                  $message .='
                  <p>Thông tin Toa Thuốc như bảng bên dưới: </p>
                  <table border="1">
                    <tr>
                      <th>Tên Thuốc</th>
                      <th>Đơn Vị Tính</th>
                      <th>Số Lượng</th>
                    </tr>';
                    foreach ($run_details_pre as $row_pre_details) {
                    $med1 = $row_pre_details['id_medicine'];  
                    $amount1 = $row_pre_details['amount'];                
                    $sql_medicine = "SELECT * FROM medicines WHERE code_med=$med1 AND status =1";
                    $run_medicine = $con->query($sql_medicine);
                    $row_medicine = mysqli_fetch_array($run_medicine);
                    $name_medicine = $row_medicine['name'];
                    $unit_medicine = $row_medicine['unit'];  
                    $message .= "
                    <tr>
                      <td>{$name_medicine}</td>
                      <td>{$unit_medicine}</td>
                      <td>{$amount1}</td>
                    </tr>";
                    }
                  $message .= '
                  </table>
                </body>
              </html>
              ';
$message .= "<br/> <p>Phê Duyệt Tại: <a href='http://traiheo.anovafarm.com.vn/admin/import/prescription/approval/?id={$id_prescription}'>XEM NGAY</a></p>";
$message .= "<br/><img src='https://traiheo.anovafarm.com.vn/admin/mail/signature.png' alt='Signature Of Anova Farm' style='width:50%; text-align:left'>";
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



// Set the sender and recipient email addresses
$mail->setFrom($sender, "TOA THUỐC - ANOVAFARM");
$mail->addAddress($to, 'Truong Trai');
$mail->addAddress($to_pt, 'Pho Trai');

// Set the subject and message
$mail->IsHTML(true);
$mail->CharSet = 'UTF-8';
$mail->Subject = $subject;
$mail->Body = $message;

// Send the email

if (!$mail->send()) {
    echo 'Failed to send email.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
  
    //echo 'Email sent successfully!';
}
?>

  <script  src="./script.js"></script>

</body>
</html>
