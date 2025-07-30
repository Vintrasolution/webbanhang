
<!DOCTYPE HTML>  
<html>
<head>
  <title>Thêm Nhà Trại | Anova Farm</title>
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

$id_trai = $row_staff['id_farm'];
if($row_level['level']==1){
  $sql_farmp = "SELECT * FROM farm WHERE status =1 ";
}else{
  $sql_farmp = "SELECT * FROM farm WHERE status =1 AND code_farm LIKE '$id_trai'";
}
$run_farm = $con->query($sql_farmp);
$row_farm = mysqli_fetch_array($run_farm); 
$name_farm = $row_farm['name'];
$farm = "";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_GET["farm"])) {
    $farm_not = "Bắt buộc phải nhập Trại";
  } else {
    $farm = test_input($_GET["farm"]);
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<?php if($row_level['level']==2|| $row_level['level']==1){?>
<center>
  <br/>
<h3>Thêm Nhà Trại</h3>
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
              <td><label>Trại: </label></td>
              <!--<td><input type="text" name="farm" value="<?php echo $name_farm;?>" disabled>-->
              <td><select name="id_farm" class="form-control" id="phanquyen">
                  <option value="<?php echo $id_trai ?>"><?php echo $name_farm ?> </option>
                  <?php while ($row_full_farm = mysqli_fetch_array($run_farm)) { ?>
                  <option value="<?php echo $row_full_farm['code_farm'] ?>"><?php echo $row_full_farm['name'] ?> </option>
                <? } ?>
              </select></td>
            </tr>
            <tr>
              <td><label>Tên Nhà: </label></td>
              <td><input type="text" name="farm">
          <span class="error">* <?php echo $farm_not;?></span></td>
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
    $id_farm = $_GET["id_farm"];
    $farm = $_GET["farm"];
 $sql_farm_check = "SELECT * FROM farm_place WHERE id_farm='$id_farm' AND name ='$farm'";
 $run_farm_check = $con->query($sql_farm_check);

//$result_code_sub_ser = $conn->query($code_sub_ser);

// Create connection
// Check connection
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}


if(empty($_GET["id_farm"])||empty($_GET["farm"])){
	echo "";
}else {
	if($run_farm_check->num_rows > 0){
		echo '<br/><center>Nhà Đã Tồn Tại </center>';
	}else{
    $sql_add_farmplace = "INSERT INTO `farm_place` (`id`, `id_farm`, `name`, `status`, `date_created`) VALUES (NULL, '$id_farm', '$farm', '1', CURRENT_TIMESTAMP);";
    $run_add_farmplace = $con->query($sql_add_farmplace);
    echo '<br/><center> Thêm '.$farm.' thành công</center>';
	}
	
}
  
$con->close();
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
      <td><b>Nhà: </b></td>
      <td><?php echo $_GET["farm"];?></td>
    </tr>
    
  </table>
</div></div></div>
<?php }?>
</center>
<?php }else{echo "<center><strong style='font-size:20px; color:red'>Bạn không có quyền truy cập thông tin này!</strong><br/><a href='../' style='font-size:15px'>Trở Lại</a></center>";}