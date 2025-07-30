
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
$id_staff_url = $_GET['id'];
//GET INFO USER
$sql_user ="SELECT * FROM customer WHERE `id`=$id_staff_url";
$run_user = mysqli_query($con,$sql_user);
$row_user = mysqli_fetch_array($run_user);
$username = $row_user['username'];
$leveluser = $row_user['level'];
$password = $row_user['password'];

//GET LEVEL NAME USER
$sql_level_name = "SELECT * FROM level WHERE `id`=$leveluser";
$run_level_name = mysqli_query($con,$sql_level_name);
$row_level_name = mysqli_fetch_array($run_level_name);
$name_level = $row_level_name['name'];


//GET INFO STAFF

$sql_staff = "SELECT * FROM staff WHERE `id`=$id_staff_url";
$run_staff = mysqli_query($con,$sql_staff);
$row_staff= mysqli_fetch_array($run_staff);
$fullname_staff = $row_staff['fullname'];
$position_staff = $row_staff['position'];
$email_staff = $row_staff['email'];
$admin_farm_staff = $row_staff['admin_farm'];

//GET FARM STAFF
$id_trai = $row_staff['id_farm'];
$sql_farmp = "SELECT * FROM farm WHERE status =1 AND code_farm LIKE '$id_trai'";
$run_farm = $con->query($sql_farmp);
$row_farm = mysqli_fetch_array($run_farm); 
$name_farm = $row_farm['name'];

//GET FULL FARM
$sql_full_farm = "SELECT * from farm WHERE code_farm NOT LIKE '$id_trai'";
$run_full_farm = mysqli_query($con,$sql_full_farm);

//GET FULL LEVEL
$sql_full_level = "SELECT * from level WHERE id != '$leveluser' and id !=1";
$run_full_level = mysqli_query($con,$sql_full_level);



$username_user  = $fullname = $password_user = $department = $level =$email = $farm = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["level"])) {
    $level_not = "Bắt buộc phải nhập Phân Quyền";
  } else {
    $level = test_input($_POST["level"]);
  }
  if (empty($_POST["email"])) {
    $email_not = "Bắt buộc phải nhập Email";
  } else {
    $email = test_input($_POST["email"]);
  }
  if (empty($_POST["code_farm"])) {
    $farm_not = "Bắt buộc phải nhập Trại";
  } else {
    $farm = test_input($_POST["code_farm"]);
  }
}

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
  $id_customer = $_GET['id'];
  $sql_customer ="SELECT * FROM customer WHERE `id`=$id_customer";
  $run_customer = $con->query($sql_customer);
  $row_cusomter = mysqli_fetch_array($run_customer);
  $code_customer = $row_cusomter['code'];
  $fullname_customer = $row_cusomter['fullname'];
  $phone_customer = $row_cusomter['phone'];


?>
<div class="container my-4">
      <div class="card my-4 shadow">
        <div class="card-body">
          <table>
            <!--<tr>
              <td><label>Trại: </label><span class="error">*</span></td>
              <td><select name="code_farm" class="form-control" id="phanquyen">
                  <option value="<?php echo $id_trai ?>"><?php echo $name_farm ?> </option>
                  <?php while ($row_full_farm = mysqli_fetch_array($run_full_farm)) { ?>
                  <option value="<?php echo $row_full_farm['code_farm'] ?>"><?php echo $row_full_farm['name'] ?> </option>
                <? } ?>
              </select></td>
            </tr>-->
            <tr>
              <td><input type="hidden" name="id_customer" value="<?php echo $id_customer; ?>"></td>
            </tr>
            <tr>
              <td><label>Mã Khách Hàng: </label></td>
              <td><input type="text" name="code_customer" value="<?php echo $code_customer; ?>" ></td>
            </tr>
            <tr>
              <td><label>Tên Khách Hàng:</label></td>
              <td><input type="text" name="fullname_customer" value="<?php echo $fullname_customer; ?>" ></td>
            </tr>
            <tr>
              <td><label>Số Điện Thoại:</label><span class="error">* </span></td>
              <td><input type="text" name="phone_customer" value="<?php echo $phone_customer; ?>">
              <span class="error"><?php echo $position_not;?></span></td>
            </tr>
            <!--<tr>
              <td><label>Password: </label><span class="error">* </span></td>
              <td><input type="password" name="password_user" value="<?php echo "00000000"; ?>" disabled><a style="color: blue;text-decoration: none" href="reset-pass.php?id=<?php echo $id_staff_url; ?>">Reset</a>
          <span class="error"> <?php echo $password_user_not;?></span></td>
            </tr>-->
            
            <!--<tr>
              <td><label>Email:</label><span class="error">* </span></td>
              <td><input type="text" name="email" value="<?php echo $email_staff; ?>">
          <span class="error"><?php echo $email_not;?></span></td>
            </tr>
            
            <tr>
              <td><label>Quyền:</label><span class="error">* </span></td>
              <td>
                  <select name="level" class="form-control" id="phanquyen">
                    <option value="<?php echo $leveluser ?>"><?php echo $name_level ?> </option>
                    <?php while ($row_full_level = mysqli_fetch_array($run_full_level)) { ?>
                    <option value="<?php echo $row_full_level['id'] ?>"><?php echo $row_full_level['name'] ?> </option>
                  <? } ?>
                  </select>
                  <span class="error"><?php echo $level_not;?></span>
            </td>
            </tr>
            <tr>
              <td><label>Admin ? </label></td>
              <td>
                  <?php if ($admin_farm_staff==0) {?>
                  <input type="checkbox" name="admin_farm" value="1">
                <?php }else{ ?>
                  <input type="checkbox" name="admin_farm" value="0" checked>
                <?php } ?>
              </td>
            </tr>-->
          </table>
          <div class="clearfix mt-4">
              <button type="submit" name="submit" class="btn btn-primary float-center text-uppercase shadow-sm" style="margin-bottom: 20px">CẬP NHẬP</button>
              <button formaction="/admin/tools/danh-sach-khach-hang/" class="btn btn-primary float-center text-uppercase shadow-sm" style="margin-bottom: 20px">QUAY LẠI</button>
          </div>
        </div>
      </div>
    </div>  
  
</form>
</body>
</html>

	</center>
 <?php
 //Kiem tra du lieu database ton tai chua?
    $id_customer = $_POST["id_customer"];
    $code_customer = $_POST["code_customer"];
    $fullname_customer = $_POST["fullname_customer"];
    $phone_customer = $_POST["phone_customer"];

// Create connection
// Check connection
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}


if(empty($_POST["id_customer"])||empty($_POST["fullname_customer"])||empty($_POST["code_customer"])||empty($_POST["phone_customer"])){
	echo "";
}else {
	$sql_update_customer = "UPDATE `customer` SET `code` = '$code_customer', `fullname` = '$fullname_customer', `phone` = '$phone_customer' WHERE `customer`.`id` = $id_customer;";
  //$sql_update_user = "UPDATE `user` SET `level` = '$level' WHERE `user`.`id_staff` = '$id_stafff';";

}
$run_update_customer = mysqli_query($con,$sql_update_customer);
//$run_update_user = mysqli_query($con,$sql_update_user);
$con->close();
?> 

<center>
<?php if($run_update_customer===TRUE){?>
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL='edit-user.php/?success=1&id=<?php echo $id_customer; ?>'">';
<?php }?>
</center>
<?php }else{echo "<center><strong style='font-size:20px; color:red'>Bạn không có quyền truy cập thông tin này!</strong><br/><a href='../' style='font-size:15px'>Trở Lại</a></center>";}