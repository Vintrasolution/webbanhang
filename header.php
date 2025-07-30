<!DOCTYPE HTML>  
<head>
<?php 
	include "auth.php";
	include "db.php"; 
	date_default_timezone_set('Asia/Bangkok');
	?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	      <!-- Show ICON SHORTCUT FOR MOBILE-->
	<link rel="shortcut icon" type="image/png" href="img/favicon.ico"/>
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
<style type="text/css">
	a.non-textdecoration{
    color: white;
    text-decoration: none;


}

</style>

<!--Dropdown hover menu-->
<style>
.dropbtn {
  background-color: #4CAF50;
  color: white;
  padding: 10px;
  font-size: 16px;
  border: none;
}

.dropdown {
  position: relative;
  display: inline-block;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: #f1f1f1;
  min-width: 100%;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
  text-decoration:none
}
.noline {
	text-decoration:none; 
	color: black;
}

.dropdown-content a:hover {background-color: #ddd;}

.dropdown:hover .dropdown-content {display: block;}

.dropdown:hover .dropbtn {background-color: #3e8e41;}
</style>

<div>
	<div style="text-align: right;">
		<?php 
		$user = $_SESSION["username"];
		//Select ID STAFF
		$sql = "SELECT * FROM user WHERE username = '$user'";
		$run = mysqli_query($con,$sql);
		$row = mysqli_fetch_array($run);
		$id_user = $row['id']; 
		$levelid = $row['id_level'];
		$client = $row['fullname'];
		?>
		<div class="dropdown">
  		<button class="dropbtn">Xin chào <?php echo $client; ?></button>
			  <div class="dropdown-content">
			  	<center>
				    <?php if($levelid==1){ ?>
				    	<a href="/admin/tools/user-list/" style="text-decoration:none; color: black;">Quản Lý Tài Khoản</a>
				  	<?php } ?>
				    <a href="/admin/tools/reset-pass/" style="text-decoration:none; color: black;">Đổi Mật Khẩu</a>
				    <a href="/admin/logout.php" style="text-decoration:none; color: black;">Đăng Xuất</a>
			  	</center>
			  </div>
		</div>
		<br/><br/><br/>
	</div>
	<!-- Google Dịch <div id="google_translate_element"><b>Language: </b></div>-->
	<center>

		<a href="/admin/"><img src="/admin/img/logo.png" width="250px"></a><br/>
	</center>
</div>
</head>
<body>

</body>