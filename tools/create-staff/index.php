
<!DOCTYPE HTML>  
<html>
<head>
  <title>Thêm Tài Khoản | LillyFlower</title>
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
$username = $_SESSION["username"];

$sql_level = "SELECT * FROM user WHERE `username`='$username' ";

$run_level = mysqli_query($con,$sql_level);

$row_level = mysqli_fetch_array($run_level);

$username_user  = $fullname = $password_user = $department = $level =$email = $farm = "";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_GET["username_user"])) {
    $username_user_not = "Bắt buộc phải nhập Tài khoản";
  } else {
    $username_user = test_input($_GET["username_user"]);
  }
  if (empty($_GET["fullname"])) {
    $fullname_not = "Bắt buộc phải nhập Họ và Tên";
  } else {
    $fullname = test_input($_GET["fullname"]);
  }
  if (empty($_GET["password_user"])) {
    $password_user_not = "Bắt buộc phải nhập Mật Khẩu";
  } else {
    $password_user = test_input($_GET["password_user"]);
  }
  if (empty($_GET["level"])) {
    $level_not = "Bắt buộc phải nhập Phân Quyền";
  } else {
    $level = test_input($_GET["level"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<?php if($row_level['id_level']==1){?>
<center>
  <br/>
<h3>Thêm Tài Khoản</h3>
<p><span class="error">* Thông tin bắt buộc</span></p>
<form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
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
              <td><label>Họ và Tên: </label></td>
              <td><input type="text" name="fullname">
          <span class="error">* <?php echo $fullname_not;?></span></td>
            </tr>
            <tr>
              <td><label>Tài Khoản:</label></td>
              <td><input type="text" name="username_user">
          <span class="error">* <?php echo $username_user_not;?></span></td>
            </tr>
            
            <tr>
              <td><label>Mật Khẩu: </label><span class="error">*</span></td>
              <td><input type="password" name="password_user">
          <span class="error">*<?php echo $password_user_not;?></span></td>
            </tr>
            
            <tr>
              <td><label>Phân Quyền:</label><span class="error">* </span></td>
              <td>
                    <select id='phanquyen' name="level" id="field" class="form-control">
                         <option value=''>Lựa Chọn</option>
                         <option value='1'>Manager</option>
                         <option value='2'>Casher</option>
                    </select>
                  <span class="error"> <?php echo $level_not;?></span>
            </td>
            </tr>
          </table>
          <div class="clearfix mt-4">
              <button type="submit" name="submit" class="btn btn-primary float-center text-uppercase shadow-sm" >THÊM VÀO</button>
              <button type="button" class="btn btn-primary float-center text-uppercase shadow-sm" onclick="quay_lai_trang_truoc()" style="margin-left: 50px;">QUAY LẠI</button>
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
    $username_user = $_GET["username_user"];
    $fullname = $_GET["fullname"];
    $username_user = $_GET["username_user"];
    $password_user = $_GET["password_user"];
    $level = $_GET["level"];

    //Kiềm tra thông tin đã tồn tại chưa
    $worker_name_ser = "SELECT username FROM user WHERE username='$username_user'";
    $result_worker_name_ser = $con->query($worker_name_ser);
    if(empty($_GET["username_user"])||empty($_GET["fullname"])||empty($_GET["password_user"])||empty($_GET["level"])){
    	echo "";
    }else {
  	if($result_worker_name_ser->num_rows > 0 ){
  		echo '<br/><center><span style="color:red; font-size:18pt">Tài khoản Đã Tồn Tại !!!</span></center>';
  	}else{
    
    //Thêm UserName
    $sql_user ="INSERT INTO `user` (`id`, `username`, `password`, `fullname`, `id_level`, `status`, `date_created`) VALUES (NULL, '$username_user', MD5('$password_user'), '$fullname', '$level', '1', current_timestamp());";
    $run_user= $con->query($sql_user);
    echo '<br/><center> Thêm '.$fullname.' thành công</center>';
	}
	
}
  
$conn->close();
?> 
<script>
      function quay_lai_trang_truoc(){
          history.back();
      }
  </script>
<center>
<?php if($run_user===TRUE ){?>
    <br/>
    <div class="container my-4">
      <div class="card my-4 shadow">
        <div class="card-body">
    <table>
    <tr>
      <td><b>Tài Khoản</b></td>
      <td><?php echo $username_user ?></td>
    </tr>
    <tr>
      <td><b>Mật Khẩu</b></td>
      <td><?php echo $password_user ?></td>
    </tr>
  </table>
</div></div></div>
<?php }?>
</center>
<?php }else{echo "<center><strong style='font-size:20px; color:red'>Bạn không có quyền truy cập thông tin này!</strong><br/><a href='../' style='font-size:15px'>Trở Lại</a></center>";}