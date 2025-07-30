
<?php

// ID USER
$id_client = $row_staff['id'];
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '/O365/Exception.php';
require '/O365/PHPMailer.php';
require '/O365/SMTP.php';


$to = $email;

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

?>