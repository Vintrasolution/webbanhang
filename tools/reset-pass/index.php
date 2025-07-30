
<!DOCTYPE HTML>  
<html>
<head>
  <title>Thêm Tài Khoản | Anova Farm</title>
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
$id_trai = $row_staff['id_farm'];
$sql_farmp = "SELECT * FROM farm WHERE status =1 AND code_farm LIKE '$id_trai'";
$run_farm = $con->query($sql_farmp);
$row_farm = mysqli_fetch_array($run_farm); 
$name_farm = $row_farm['name'];
$old_password  = $new_password = $retype_new_password;



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if ($_POST["old_password"] =="") {
    $old_password_not = "Bắt buộc phải nhập Mật Khẩu Cũ";
  } else {
    $old_password = test_input($_POST["old_password"]);
  }
  if ($_POST["new_password"] =="") {
    $new_password_not = "Bắt buộc phải nhập Mật Khẩu Mới";
  } else {
    $new_password = test_input($_POST["new_password"]);
  }
  if ($_POST["retype_new_password"] =="") {
    $retype_new_password_not = "Bắt buộc phải nhập lại Mật Khẩu Mới";
  } else {
    $retype_new_password = test_input($_POST["retype_new_password"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<center>
  <br/>
<h3>Thay Đổi Mật Khẩu</h3>
<p><span class="error">* Thông tin bắt buộc</span></p>
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
<div class="container my-4">
      <div class="card my-4 shadow">
        <div class="card-body">
          <table>
            <tr>
              <td><label>Trại: </label></td>
              <td><input type="text" name="farm" value="<?php echo $name_farm;?>" disabled>
            </tr>
            <tr>
              <td><label>Họ và Tên: </label></td>
              <td><input type="text" name="fullname" value="<?php echo $client;?>" disabled>

            </tr>
            <tr>
              <td><label>User:</label></td>
              <td><input type="text" name="username_user" value="<?php echo $user; ?>" disabled>
            </tr>
            
            <tr>
              <td><label>Mật Khẩu Cũ: </label><span class="error">*</span></td>
              <td><input type="password" name="old_password" value="<?php echo $old_password; ?>" placeholder="Nhập mật khẩu cũ">
            <br/><span class="error"><?php if($old_password =="") {echo $old_password_not;} 
              //Kiểm Tra Password cũ có trùng khớp chưa
               $check_old_pass = "SELECT * FROM user WHERE `id` = $id_user AND `password`= MD5('$old_password')";
               $results_check_old_pass = $con->query($check_old_pass);
               $row_check_old = mysqli_fetch_array($results_check_old_pass);
               $id_check_old = $row_check_old['id'];
               if($id_check_old =="" AND $_POST['submit']==1){
                echo "Mật Khẩu Cũ Không Đúng!";
               }
            ?></span></td>
            </tr>
            <tr>
              <td><label>Mật khẩu mới: </label><span class="error">*</span></td>
              <td><input type="password" name="new_password" value="<?php echo $new_password; ?>" placeholder="Nhập mật khẩu mới">
          <br/><span class="error"><?php if($new_password==""){echo $new_password_not;}?></span></td>
            </tr>
            <tr>
              <td><label>Nhập Lại: </label><span class="error">*</span></td>
              <td><input type="password" name="retype_new_password" value="<?php echo $retype_new_password; ?>" placeholder="Nhập lại mật khẩu mới">
          <br/><span class="error"><?php if($retype_new_password==""){echo $retype_new_password_not;} if($new_password!=$retype_new_password){echo "Mật Khẩu Không Khớp";} ?></span></td>
            </tr>
          </table>
          <div class="clearfix mt-4">
              <button type="submit" name="submit" value="1" class="btn btn-primary float-center text-uppercase shadow-sm" style="margin-bottom: 20px">XÁC NHẬN</button>
              <button type="submit" formaction="/admin/" class="btn btn-primary float-center text-uppercase shadow-sm" style="margin-bottom: 20px">QUAY LẠI</button>
              <br/><?php $success = $_GET['success']; if($success ==1){echo "<span style='color:green'>Cập nhập mật khẩu thành công!</span>";}?>
          </div>
        </div>
      </div>
    </div>  
  
</form>
</body>
</html>

	</center>
 <?php
  //Lấy Dữ Liệu Pass Cũ và Pass Mới
   $old_password = $_POST["old_password"];
   $new_password = $_POST["new_password"];
   $retype_new_password = $_POST["retype_new_password"];
   

// Create connection
// Check connection
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}
if($_POST["old_password"]==""|| $_POST["new_password"]==""||$_POST["retype_new_password"]==""||$id_check_old==""||$new_password!=$retype_new_password){
  echo "";
}else {
		$update = "UPDATE `user` SET `password` = MD5('$new_password') WHERE `user`.`id` = $id_user;";

	}
$run_update = $con->query($update);
$conn->close();
?> 

<center>

<?php if($run_update===TRUE ){?>
  echo '<META HTTP-EQUIV="Refresh" Content="0; URL='index.php?success=1'">';
<?php }?>
</center>