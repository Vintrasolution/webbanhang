
<!DOCTYPE HTML>  
<html>
<head>
  <title>Thêm Nhà Cung Cấp | Lilly Flower</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
  <?php 
        include "../header.php"; 
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

$supplier_name = $address = $street = $ward = $district = $city = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["supplier_name"])) {
    $supplier_name_not = "Bắt buộc phải nhập Tên NCC";
  } else {
    $supplier_name = test_input($_POST["supplier_name"]);
  }
  if (empty($_POST["address"])) {
    $address_not = "Bắt buộc phải nhập Đầy Đủ Địa Chỉ";
  } else {
    $address = test_input($_POST["address"]);
  }
  if (empty($_POST["street"])) {
    $address_not = "Bắt buộc phải nhập Đầy Đủ Địa Chỉ";
  } else {
    $street = test_input($_POST["street"]);
  }
  if (empty($_POST["ward"])) {
    $address_not = "Bắt buộc phải nhập Đầy Đủ Địa Chỉ";
  } else {
    $ward = test_input($_POST["ward"]);
  }
  if (empty($_POST["district"])) {
    $address_not = "Bắt buộc phải nhập Đầy Đủ Địa Chỉ";
  } else {
    $district = test_input($_POST["district"]);
  }
  if (empty($_POST["city"])) {
    $address_not = "Bắt buộc phải nhập Đầy Đủ Địa Chỉ";
  } else {
    $city = test_input($_POST["city"]);
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
<h3>Thêm Nhà Cung Cấp</h3>
<p><span class="error">* Thông tin bắt buộc</span></p>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
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
              <td><label>Tên NCC: </label></td>
              <td><input type="text" name="supplier_name" style="width: 100%;" value="<?php echo $supplier_name;?>">
                <span class="error"><?php echo $supplier_name_not;?></span>
              </td>
            </tr>
            <tr>
              <td><label>Địa Chỉ: </label></td>
              <td><input type="text" name="address" placeholder="Số Nhà" style="width: 20%;" value="<?php echo $address;?>"><input type="text" name="street" placeholder="Đường" style="width: 20%;" value="<?php echo $street;?>"><input type="text" name="ward" placeholder="Phường/Xã" style="width: 20%;" value="<?php echo $ward;?>"><input type="text" name="district" placeholder="Quận/Huyện" style="width: 20%;" value="<?php echo $district;?>"><input type="text" name="city" placeholder="Thành Phố" style="width: 20%;" value="<?php echo $city;?>"><span class="error"><?php echo $address_not;?></span></td>
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
 $sup_name = $_POST['supplier_name'];
 $sql_supplier_check = "SELECT * FROM supplier WHERE supplier_name='$sup_name'";
 $run_supplier_check = $con->query($sql_supplier_check);

 //Lay Du Lieu Submit
$supplier_name = $_POST['supplier_name'];
$address = $_POST['address'];
$street = $_POST['street'];
$ward = $_POST['ward'];
$district = $_POST['district'];
$city = $_POST['city'];

if(empty($_POST["supplier_name"])||empty($_POST["address"])||empty($_POST["street"])||empty($_POST["ward"])||empty($_POST["district"])||empty($_POST["city"])){
	echo "";
}else {
	if($run_supplier_check->num_rows > 0){
		echo '<br/><center>Nhà Cung Cấp Tồn Tại </center>';
	}else{
    $sql_add_supplier = "INSERT INTO `supplier` (`id`, `supplier_name`, `address`, `street`, `ward`, `district`, `city`, `status`, `date_created`) VALUES (NULL, '$supplier_name', '$address','$street','$ward','$district','$city', '1', CURRENT_TIMESTAMP);";
    $run_add_supplier = $con->query($sql_add_supplier);
    echo '<br/><center> Thêm <strong>'.$supplier_name.'</strong> thành công</center>';
    echo '<meta http-equiv="refresh" content="2">';
	}
	
}
  
$con->close();
?> 
  <script>
      function quay_lai_trang_truoc(){
          history.back();
      }
  </script>