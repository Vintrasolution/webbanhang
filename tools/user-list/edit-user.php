
<!DOCTYPE HTML>  
<html>
<head>
  <title>Cập Nhập Khách Hàng | Lilly Flower</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
  <?php 
        include "../../header.php"; 
        include "../../level_user.php"; 

  ?>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
$success = $_GET['success'];
?>
<?php if($row['level']!=1){?>
<center>
  <br/>
<h3>Cập Nhập Khách Hàng</h3>
<p><span class="error">* Thông tin bắt buộc</span></p>
<?php 
  if($success==1){
    echo "<span style='color:green'>Cập nhập thông tin nhân viên thành công!</span>";
  }
?>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
<style>
  table {
    width: 100%;
    border-collapse: collapse;
    font-size: 18px;
  }

  th, td {
    padding: 8px;
    text-align: left;
    border: 0px;
  }

  th {
    background-color: #ddd;
  }
  input {
    width: 90%;
    height: 35px;
    font-size: 18px;
  }
  #button {
    width: 30%;
    height: 40px;
  }
  input[type="checkbox"] {
    width: 30px;
    height: 30px;
  }
  #phanquyen{
    width: 90%;
    height: 40px;
    font-size: 18px;
  }
  label{
    font-weight: bold;
  }
</style> 
<?php
  $id_user = $_GET['id'];
  $sql_user="SELECT * FROM user WHERE `id`=$id_user";
  $run_user = $con->query($sql_user);
  $row_user = mysqli_fetch_array($run_user);
  $fullname = $row_user['fullname'];
  $username = $row_user['username'];
  $id_level = $row_user['id_level'];
  //Lấy Tên Phân Quyền
  $sql_level_name = "SELECT * FROM level_user WHERE id = '$id_level'";
  $run_level_name = $con->query($sql_level_name);
  $row_level_name = mysqli_fetch_array($run_level_name);
  $level_name = $row_level_name['level_name'];


?>
<div class="container my-4">
      <div class="card my-4 shadow">
        <div class="card-body">
          <table>
            <tr>
              <td><input type="hidden" name="id_user" value="<?php echo $id_user; ?>"></td>
            </tr>
            <tr>
              <td><label>Họ và Tên:</label></td>
              <td><input type="text" name="fullname" value="<?php echo $fullname; ?>" ></td>
            </tr>
            <tr>
              <td><label>Tài Khoản:</label></td>
              <td><input type="text" name="username" value="<?php echo $username; ?>" ></td>
            </tr>
            <tr>
              <td><label>Phân Quyền</label><span class="error">* </span></td>
              <td><input type="text" name="level_name" value="<?php echo $level_name; ?>">
              <span class="error"><?php echo $position_not;?></span></td>
            </tr>
            <tr>
              <td><label>Mật Khẩu Mới</label><span class="error"></span></td>
              <td><input type="text" name="password" placeholder="**********">
            </tr>
            <tr>
              <td><label>Nhập Lại Mật Khẩu Mới</label><span class="error"></span></td>
              <td><input type="text" name="password" placeholder="**********">
            </tr>
          </table>
          <div class="clearfix mt-4">
              <button type="submit" name="submit" class="btn btn-primary float-center text-uppercase shadow-sm" style="margin-bottom: 20px">CẬP NHẬP</button>
              <button formaction="/admin/tools/user-list/" class="btn btn-primary float-center text-uppercase shadow-sm" style="margin-bottom: 20px">QUAY LẠI</button>
          </div>
        </div>
      </div>
    </div>  
  
</form>
</body>
</html>

	</center>
 <?php


if(empty($_POST["id_user"])||empty($_POST["fullname"])||empty($_POST["username"])||empty($_POST["level_name"])){
	echo "";
}else {
	$sql_update_customer = "UPDATE `customer` SET `code` = '$code_customer', `fullname` = '$fullname_customer', `phone` = '$phone_customer' WHERE `customer`.`id` = $id_customer;";
  //$sql_update_user = "UPDATE `user` SET `level` = '$level' WHERE `user`.`id_staff` = '$id_stafff';";

}
$run_update_customer = mysqli_query($con,$sql_update_customer);
$con->close();
?> 

<center>
<?php if($run_update_customer===TRUE){?>
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL='edit-user.php/?success=1&id=<?php echo $id_customer; ?>'">';
<?php }?>
</center>
<?php }else{echo "<center><strong style='font-size:20px; color:red'>Bạn không có quyền truy cập thông tin này!</strong><br/><a href='../' style='font-size:15px'>Trở Lại</a></center>";}