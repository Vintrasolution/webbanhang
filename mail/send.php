<?php include "../../header.php"; ?>

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
$sql_mailtrai = "SELECT * FROM farm WHERE id = $id_trai AND status =1";
$run_mailfarm = $con->query($sql_mailtrai);
$row_mailtrai = mysqli_fetch_array($run_mailfarm);
$emailtrai = $row_mailtrai['email'];
$to = $emailtrai;
// Subject of the email
//$subject = '[Thông Báo] Yêu Cầu Lấy Thuốc Của '.$row_fullname['fullname'];

// Message to be sent in the email
              $sql_details_pre = "SELECT * FROM details_prescription WHERE id_prescription = $id_prescription;";
              $run_details_pre = $con->query($sql_details_pre);
              /*$message ='
              <html>
                <head>
                  <title>TOA THUỐC</title>
                </head>
                <body>
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
                    $sql_medicine = "SELECT * FROM medicines WHERE id=$med1 AND status =1";
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
$message .= "<br/> <p>Phê Duyệt Tại: <a href='http://traiheo.anovafarm.com.vn/admin/import/prescription/approval/?id={$id_prescription}'>XEM NGAY</a></p>";*/
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


// Use Office 365 as the email server
$mail->isSMTP();
$mail->Host = "{$host}";
$mail->SMTPAuth = true;
$mail->Username = "{$usermail}";
$mail->Password = "{$password}";
$mail->SMTPSecure = "{$smtpsecure}";
$mail->Port = "{$port}";

// Set the sender and recipient email addresses
$mail->setFrom($usermail, "TOA THUỐC - ANOVAFARM");
$mail->addAddress($to, 'Recipient Name');

// Set the subject and message
$mail->IsHTML(true);
$mail->CharSet = 'UTF-8';
$mail->Subject = $subject;
$mail->Body = $message;

// Send the email

/*if (!$mail->send()) {
    echo 'Failed to send email.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
  
    //echo 'Email sent successfully!';
}*/
?>