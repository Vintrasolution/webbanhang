
<!DOCTYPE HTML>  
<html>
<head>
  <title>Sửa Thuốc Điều Trị | Anova Agri</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include "../header.php"; 
        include "../level_user.php";
  ?>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>  

<?php
// define variables and set to empty values
$id_medicines= $id_sick  = $name_medicine =$dosage =$user_guide="";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["id_sick"])) {
    $id_sick_not = "Bắt buộc phải nhập Tên Bệnh";
  } else {
    $id_sick = test_input($_POST["id_sick"]);
  }
  if (empty($_POST["name_medicine"])) {
    $name_medicine_not = "Bắt buộc phải nhập Tên Thuốc";
  } else {
    $name_medicine = test_input($_POST["name_medicine"]);
  }
  if (empty($_POST["dosage"])) {
    $dosage_not = "Bắt buộc phải nhập Liều lượng";
  } else {
    $dosage = test_input($_POST["dosage"]);
  }
  $user_guide = test_input($_POST["user_guide"]);
  $id_medicines_1 = test_input($_POST["id_medicines_1"]);

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<?php if($row['level']==0){?>
<center>
<h3>Sửa Thuốc Điều Trị</h3>
<p><span class="error">* Thông tin bắt buộc</span></p>
<?php
  include 'database.php';
  $id_medicines = $_GET["id"];
  $sql_medicines = "SELECT * FROM `medicines` WHERE `id`='$id_medicines'";
  $run_medicines  = $conn->query($sql_medicines);
  $row_medicines  = mysqli_fetch_array($run_medicines);
  $id_namesick = $row_medicines['id_sicks'];
  $sql_namesick = "SELECT * FROM `sicks` WHERE `id`='$id_namesick'";
  $run_namesick  = $conn->query($sql_namesick);
  $row_namesick  = mysqli_fetch_array($run_namesick);
?>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
  <table>
    <input type="hidden" name="id_medicines_1" value="<?php echo $row_medicines['id'];?>">
    <tr>
      <td>Tên Bệnh</td>
      <td> </td>
      <td><input type="text" name="name_medicines" value="<?php echo $row_namesick['name_sick']; ?>" disabled></td>
    </tr>
    <tr>
      <td>Tên Thuốc:</td>
      <td> </td>
      <td><input type="text" name="name_medicine" value="<?php echo $row_medicines['name_medicine'] ?>">
  <span class="error">* <?php echo $name_medicine_not;?></span></td>
    </tr>
    <tr>
      <td>Liều Lượng:</td>
      <td> </td>
      <td><input type="text" name="dosage" value="<?php echo $row_medicines['dosage'] ?>">
  <span class="error">* <?php echo $dosage_not;?></span></td>
    </tr>
    <tr>
      <td>Hướng Dẫn Sử Dụng:</td>
      <td> </td>
      <td><textarea name="user_guide" placeholder="Nhập dữ liệu..." style="height:50px;width: 250px"><?php echo $row_medicines['user_guide'] ?></textarea></td>
    </tr>
  </table>
  <!--Mô Tả: <input type="text" name="decription">-->
  <!--<span class="error"><?php echo $websiteErr;?></span>-->
   
  <br><br>
  <input type="submit" name="submit" value="Cập Nhật">
  
</form>
</body>
</html>

  </center>
 <?php
 include 'database.php';
 

// Create connection
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
  if($name_medicine == ''||$dosage ==''){ echo "";}else{
    $sql = "UPDATE `medicines` SET `name_medicine` = '$name_medicine',`dosage` ='$dosage',`user_guide`='$user_guide' WHERE `id` = '$id_medicines_1' ";}
if ($conn->query($sql) === TRUE) {
  echo '<br/><center> Cập Nhật '.$name_medicine.' thành công</center>';
  ?>
    <meta http-equiv="refresh" content="0; url='/admin/tools/danh-sach-thuoc/?alert=ok'" />
  <?php
}
  
$conn->close();
?> 

<center>
<br/><br/><?php $previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
} ?><button><a href="<?= $previous ?>" style="text-decoration: none">Quay Lại</a> </button>
</center>
<?php }else{echo "<center><strong style='font-size:20px; color:red'>Bạn không có quyền truy cập thông tin này!</strong><br/><a href='../' style='font-size:15px'>Trở Lại</a></center>";}