<?php
                include "../header.php";
                use PHPMailer\PHPMailer\PHPMailer;
                use PHPMailer\PHPMailer\Exception;
                require '../../admin/mail/O365/Exception.php';
                require '../../admin/mail/O365/PHPMailer.php';
                require '../../admin/mail/O365/SMTP.php';




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

                $sender = $row_sent["email_sender"];

                $email1 = "vinh.nguyentanhcm@gmail.com";
                $email2= "nguyentanvinhit@gmail.com";
                $email3= "vinh.nguyentan@novaconsumer.com.vn";
                $email4= "nhoxwin2031@gmail.com";
             
                //TÌM MAIL THỦ KHO
                //$sql_thukho = "SELECT * FROM user as u , staff as s WHERE u.id_staff = s.id AND u.level = 4 AND s.id_farm LIKE '086' AND s.status =1 AND u.status=1";
                //$run_thukho = $con->query($sql_thukho);
                //$row_thukho = mysqli_fetch_array($run_thukho);
                //$mailthukho = $row_thukho['email'];

                //echo $mailthukho;
                //echo exit;

                //TÌM MAIL TẠO PHIẾU


                //implode(", ", $recipients);
                //Tiêu Đề Gửi mail cho Admin Trại
                $subject = '[ĐỒNG Ý] Toa Thuốc của  ';
                //Nội Dung Gửi mail cho Admin Trại
                $message = "Dear ,";
                $message .= "<br/><br/>Toa thuốc đã được trưởng trại phê duyệt.";
                $message .= "<br/> <p>Chi Tiết Toa Thuốc Tại: <a href='http://traiheo.anovafarm.com.vn/admin/import/prescription/history/chitiet.php/?id='>XEM NGAY</a></p>";
                $message .= "<br/><img src='https://traiheo.anovafarm.com.vn/admin/mail/signature.png' alt='Signature Of Anova Farm' style='width:50%; text-align:left'>";
                // Set the sender and recipient email addresses
                $mail->setFrom($sender, "TOA THUỐC - ANOVAFARM");
                $mail->addAddress($email1, 'Thủ Kho 1');
                $mail->addAddress($email2, 'Thủ Kho 2');
                $mail->addAddress($email3, 'Thủ Kho 3');
                $mail->addAddress($email4, 'Thủ Kho 4');

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

?>