<?php
// Kết nối đến cơ sở dữ liệu
  $servername = "localhost";
  $username = "anovacorp_traiheo";
  $password = "anovafarm@315";
  $dbname = "anovacorp_traiheo";
  $con = new mysqli($servername, $username, $password, $dbname);
  if ($con->connect_error) {
    die("Kết nối thất bại: " . $con->connect_error);
  }
$option = $_POST['selectedOption'];
$idfarm = $_POST['additionalData']['idfarm'];
	$sql = "SELECT * FROM `warehouse` WHERE `id_medicine`='$option' AND `id_farm` LIKE '$idfarm'";
  $run = mysqli_query($con, $sql);
  $row = mysqli_fetch_array($run);
  $amount = $row['amount'];
  echo "
      <div id='results' name='tonkho[]'>Số Lượng tồn kho: ".$amount."</div>
      <input type='number' class='form-control' name='amount[]'' placeholder='Số Lượng Thuốc' min='0' max='".$amount."' step='any'/>
  ";
?>