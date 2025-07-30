<!DOCTYPE HTML>
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
	<title>APP BÁN HÀNG| LILLY FLOWER</title>
	<style type="text/css">

.button {
  display: inline-block;
  border-radius: 4px;
  background-color: #4CAF50;
  border: none;
  color: #FFFFFF;
  text-align: center;
  padding: 14px;
  width: 210px;
  transition: all 0.5s;
  cursor: pointer;
  margin: 5px;
}

.button span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: 0.5s;
}

.button span:after {
  content: '\00bb';
  position: absolute;
  opacity: 0;
  top: 0;
  right: -20px;
  transition: 0.5s;
}

.button:hover span {
  padding-right: 25px;
}

.button:hover span:after {
  opacity: 1;
  right: 0;
}
a.non-textdecoration{
    color: white;
    text-decoration: none;
}
</style>
</head>
<body>
	<?php
	include "auth.php";
	include "header.php";
	$user = $_POST["username"];
	echo $user;
	?>

	<div class="column col-6 col-sm-12 col-mx-auto">
	<center>
		<!--<h2>APP TRẠI HEO</h2>--><br/><br/>
    <?php include "id_level_user.php"; ?>
    
    <?php if($row['id_level']==1||$row['id_level']==2||$row['id_level']==3){?>
		<a class="button non-textdecoration" href="export/">Tạo Đơn Hàng</a>
    <?php } ?>
    <?php if($row['id_level']==1||$row['id_level']==2||$row['id_level']==3){?>
    <a class="button non-textdecoration" href="export/history/">Danh Sách Đơn Hàng</a>
    <?php } ?>
    <?php if($row['id_level']==1||$row['id_level']==2||$row['id_level']==3){?>
    <a class="button non-textdecoration" href="tools/danh-sach-khach-hang/">Danh Sách Khách Hàng</a>
    <?php } ?>
    <br/>
    <?php if($row['id_level']==1||$row['id_level']==2||$row['id_level']==3){?>
    <a class="button non-textdecoration" href="export/shippingtoday/">Hôm Nay Có Gì</a>
    <?php } ?>
    <?php if($row['id_level']==1||$row['id_level']==2||$row['id_level']==3){?>
    <a class="button non-textdecoration" href="import/">Nhập Hàng</a>
    <?php } ?>
    <?php if($row['id_level']==1){?>
    <a class="button non-textdecoration" href="tools/instancam/">Quét QRcode</a>
    <?php } ?>
    <br/>
    <?php if($row['id_level']==1){?>
    <a class="button non-textdecoration" href="report/">Báo Cáo Lilly Flower</a>
    <?php } ?>


    
	</center>
	</div>
  <?php include "footer.php"; ?>
</body>