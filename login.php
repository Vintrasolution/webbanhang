<?php
?>
<!--<?php include 'checkip.php'?>-->
<!DOCTYPE html>
<html>
<head>
      <!-- Show ICON SHORTCUT FOR MOBILE-->
  <link rel="shortcut icon" type="image/png" href="img/logo.png"/>
  <link rel="apple-touch-icon" sizes="57x57" href="img/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="img/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="img/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="img/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="img/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="img/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="img/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="img/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="img/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="img/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="img/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
<link rel="manifest" href="img/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
<link rel="icon" href="img/favicon.ico" type="image/x-icon">

  <!-- END SHOT ICON SHORTCUT FOR MOBILE-->
<meta charset="utf-8">
<title>Đăng nhập - AnovaFarm</title>
<link rel="stylesheet" href="css/style.css" />
</head>
<body>
  <?php
  require('db.php');
  session_start();
  
    if (isset($_POST['username'])){
    
    $username = stripslashes($_REQUEST['username']);
    $username = mysqli_real_escape_string($con,$username);
    $password = stripslashes($_REQUEST['password']);
    $password = mysqli_real_escape_string($con,$password);
    $query = "SELECT * FROM `user` WHERE username='$username' and password LIKE MD5('$password') and status=1";
    $result = mysqli_query($con,$query) or die(mysql_error());
    $rows = mysqli_num_rows($result);
    $row_u = mysqli_fetch_array($result);
    $id_user = $row_u['id'];
    if($rows==1){
      $sql_event = "INSERT INTO `eventlog` (`id`, `id_user`, `time_login`) VALUES (NULL, '$id_user', CURRENT_TIMESTAMP);";
      $run_event = $con->query($sql_event);
      $_SESSION['username'] = $username;
        //header("Location: index.php");
        if (isset($_SESSION['previous_page'])) { // Kiểm tra xem có đường dẫn trước đó không
          header('Location: ' . $_SESSION['previous_page']); // Chuyển hướng đến đường dẫn trước đó
          exit;
        } else {
          //Nếu không có đường dẫn trước đó thì chuyển hướng đến trang chính
          header('Location: index.php');
          exit;
        }
      }else{
        $message =  "<center><h4>Tên đăng nhập hoặc mật khẩu không đúng!</h4></center>";
      }
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

/* Set a style for all buttons */
button {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

/* Extra styles for the cancel button */
.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

/* Center the image and position the close button */
.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
  position: relative;
}

img.avatar {
  width: 40%;
  border-radius: 50%;
}

.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  padding-top: 60px;
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* The Close Button (x) */
.close {
  position: absolute;
  right: 25px;
  top: 0;
  color: #000;
  font-size: 35px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: red;
  cursor: pointer;
}

/* Add Zoom Animation */
.animate {
  -webkit-animation: animatezoom 0.6s;
  animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
  from {-webkit-transform: scale(0)} 
  to {-webkit-transform: scale(1)}
}
  
@keyframes animatezoom {
  from {transform: scale(0)} 
  to {transform: scale(1)}
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
</style>
</head>
<body>
  
  <form class="modal-content animate" action="" method="post">
    <div class="imgcontainer">
      <a href="/"><img src="anovacorp.png"  width=250></a>
    </div>

    <div class="container">
      
      <center><label for="uname"><b>Tài Khoản / User</b></label></center>
      <input style="text-align: center" type="text" placeholder="Nhập tài khoản của bạn" name="username" required>

      <center><label for="psw"><b>Mật Khẩu / Password</b></label></center>
      <input style="text-align: center" type="password" placeholder="Nhập mật khẩu của bạn" name="password" required>
      <span style="color: red"><?php echo $message ?></span><br/>
      <center><input style="text-align: center" type="submit" name="submit" value="Đăng Nhập" /></center>
     <!-- <label>
        <input type="checkbox"  name="remember" value="1"> Remember me
      </label>-->
      <!--<p>Bạn chưa có tài khoản? <a href='registration.php'>Đăng ký ngay</a></p><br/>-->
    </div>
  </form>


<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>