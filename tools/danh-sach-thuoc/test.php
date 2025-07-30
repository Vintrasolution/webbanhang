<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "anovaagr_traiheo";
$password = "anovafarm@315";
$dbname = "anovaagr_traiheo";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Kết nối thất bại: " . $conn->connect_error);
}

// Thực hiện truy vấn để cập nhật dữ liệu trong bảng
$sql_medicines = "SELECT * FROM `medicines`";
  $run_medicines  = $conn->query($sql_medicines);
  if ($run_medicines->num_rows > 0) {
  foreach($run_medicines as $row_medicines){
    $code_med = $row_medicines['code_med'];
    $code_med = $row_medicines['code_med'];
    $sql_data = "SELECT * FROM dataload_erp WHERE `ITEMNUMBER`=$code_med";
    $run_data = $conn->query($sql_data);
    $row_data = mysqli_fetch_array($run_data);
    $amount = $row_data['ONHAND'];
    $id_farm = $row_data['ORGANIZATIONNAME'];
    $sql_warehouse = "SELECT * FROM warehouse WHERE `id_medicine`=$code_med";
    $run_warehouse = $conn->query($sql_warehouse);
    $row_warehouse = mysqli_fetch_array($run_warehouse);
    $id = $row_warehouse['id'];
    if($id==0){
      $sql_ware = "INSERT INTO `warehouse` (`id`, `id_medicine`, `id_farm`, `amount`, `status`, `date_created`) VALUES (NULL, '$code_med', '$id_farm', '$amount', '1', CURRENT_TIMESTAMP);"
      if ($conn->query($sql_ware) === TRUE) {
        echo "Cập nhật dữ liệu thành công";
        echo exit;
        } else {
        echo "Lỗi khi cập nhật dữ liệu: " . $conn->error;
        echo exit;
        }
    }
}
}

// Đóng kết nối
$conn->close();
?>
