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

      <center><p class="h1">GỬI YÊU CẦU THÀNH CÔNG</p></center>
      <div class="card my-4 shadow">
        <div class="card-body">
          <form action="" method="post">
            <p>Email đã được gửi thành công tới Người Duyệt</p>
            <p>Trạng Thái Hiện Tại: <a style="color:blue; font-size:18px"><b>Đang Chờ Duyệt</b></a></p> 
            <p>Kiểm tra tiến độ phê duyệt tại: <a href="history/chitiet.php/?id=">XEM NGAY</a></p>
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
<?php 
            if($_POST['submit']==2){
            //ID FARM
            $id_trai = $row_staff['id_farm'];
            $sql_farmp = "SELECT * FROM farm WHERE status =1 AND `code_farm` LIKE '$id_trai'";
            $run_farm = $con->query($sql_farmp);
            $row_farm = mysqli_fetch_array($run_farm); 
            $run_farm = $con->query($sql_farmp);
            $id_farm = $row_farm['id'];
            //ID FARM PLACE
            $farmplace = $_POST['farmplace1'];
            $id_farmplace = $farmplace;
            // ID USER
            $id_client = $row_staff['id'];
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
    ?>
    <?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../mail/O365/Exception.php';
require '../../mail/O365/PHPMailer.php';
require '../../mail/O365/SMTP.php';

// Recipient email address
$to = 'vinh.nguyentanhcm@gmail.com';

// Subject of the email
$subject = '[Thông Báo] Yêu Cầu Lấy Thuốc Của '.$row_staff['name'];

// Message to be sent in the email
$message = "
<html>
<head>
<title>TOA THUỐC</title>
</head>
<body>
<p>Thông tin Toa Thuốc như bảng bên dưới: </p>
<table>
<tr>
<th>Tên Thuốc/th>
<th>Đơn Vị Tính</th>
<th>Số Lượng</th>
</tr>
<tr>
<td>John</td>
<td>Doe</td>
<td>Doe</td>
</tr>
</table>
</body>
</html>
";

// Create a new PHPMailer instance
$mail = new PHPMailer();

// Use Office 365 as the email server
$mail->isSMTP();
$mail->Host = 'smtp.office365.com';
$mail->SMTPAuth = true;
$mail->Username = 'vinh.nt@novaconsumer.vn';
$mail->Password = 'Aa112233@@';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

// Set the sender and recipient email addresses
$mail->setFrom('vinh.nt@novaconsumer.vn', 'Toa Thuoc - AnovaFarm');
$mail->addAddress($to, 'Recipient Name');

// Set the subject and message
$mail->Subject = $subject;
$mail->Body = $message;

// Send the email

/*if (!$mail->send()) {
    echo 'Failed to send email.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
  
    echo 'Email sent successfully!';
}*/
?>

  <script  src="./script.js"></script>

</body>
</html>
