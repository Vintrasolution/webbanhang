  <?php
  require('../db.php');
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
          header('Location: ../index.php');
          exit;
        }
      }else{
        $message =  "<center><h4>Tên đăng nhập hoặc mật khẩu không đúng!</h4></center>";
      }
    }
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Login Page - Anova Farm</title>
  <link rel="stylesheet" href="style.css">

</head>
<body>
<!-- partial:index.partial.html -->

<!DOCTYPE html>
<html>
<head>
	<title>Login Page - Anova Farm</title>
	      <!-- Show ICON SHORTCUT FOR MOBILE-->
<link rel="shortcut icon" type="image/png" href="../img/logo.png"/>
<link rel="apple-touch-icon" sizes="57x57" href="../img/apple-icon-57x57.png">
<link rel="apple-touch-icon" sizes="60x60" href="../img/apple-icon-60x60.png">
<link rel="apple-touch-icon" sizes="72x72" href="../img/apple-icon-72x72.png">
<link rel="apple-touch-icon" sizes="76x76" href="../img/apple-icon-76x76.png">
<link rel="apple-touch-icon" sizes="114x114" href="../img/apple-icon-114x114.png">
<link rel="apple-touch-icon" sizes="120x120" href="../img/apple-icon-120x120.png">
<link rel="apple-touch-icon" sizes="144x144" href="../img/apple-icon-144x144.png">
<link rel="apple-touch-icon" sizes="152x152" href="../img/apple-icon-152x152.png">
<link rel="apple-touch-icon" sizes="180x180" href="../img/apple-icon-180x180.png">
<link rel="icon" type="image/png" sizes="192x192"  href="../img/android-icon-192x192.png">
<link rel="icon" type="image/png" sizes="32x32" href="../img/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="96x96" href="../img/favicon-96x96.png">
<link rel="icon" type="image/png" sizes="16x16" href="../img/favicon-16x16.png">
<link rel="manifest" href="../img/manifest.json">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
<meta name="theme-color" content="#ffffff">
<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
<link rel="icon" href="../img/favicon.ico" type="image/x-icon">

  <!-- END SHOT ICON SHORTCUT FOR MOBILE-->
	<link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<img class="wave" src="https://raw.githubusercontent.com/sefyudem/Responsive-Login-Form/master/img/wave.png">
	<div class="container">
		<div class="img">
			<img src="img/logo.png" style="width: 400px;margin-right: 100px;">
		</div>
		<div class="login-content">
			<form action="" method="post">
				<img src="img/logo-small.png">
				<h2 class="title">XIN CHÀO</h2><br/>
           		<div class="input-div one">
           		   <div class="i">
           		   		<i class="fas fa-user"></i>
           		   </div>
           		   <div class="div">
           		   		<h5>Tài Khoản</h5>
           		   		<input type="text" class="input" name="username" required>
           		   </div>
           		</div>
           		<div class="input-div pass">
           		   <div class="i"> 
           		    	<i class="fas fa-lock"></i>
           		   </div>
           		   <div class="div">
           		    	<h5>Mật Khẩu</h5>
           		    	<input type="password" class="input" name="password" required>
            	   </div>
            	</div>
              <span style="color: red"><?php echo $message ?></span><br/>
            	<a href="#" onclick="myFunction()">Quên Mật Khẩu?</a>
            	<input type="submit" class="btn" name="submit" value="ĐĂNG NHẬP">
            </form>
        </div>
    </div>
    
</body>
</html>
<!-- partial -->
  <script>
// Get the modal
function myFunction() {
  alert("Rất tiếc tính năng này không khả dụng. Vui lòng liên hệ Administrator để được hỗ trợ đặt lại mật khẩu!");
}
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
  <script  src="script.js"></script>

</body>
</html>
