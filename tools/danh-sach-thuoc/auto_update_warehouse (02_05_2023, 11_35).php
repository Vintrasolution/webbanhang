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
  //Lấy Code Medicines
  $sql_medicines = "SELECT * FROM `medicines`";
  $run_medicines  = $conn->query($sql_medicines);
  //while ($row_medicines = mysqli_fetch_array($run_medicines)){
  foreach ($run_medicines as $row_medicines){
    $code_med = $row_medicines['code_med'];
    $sql_data = "SELECT * FROM dataload_erp WHERE `ITEMNUMBER`=$code_med";
    $run_data = $conn->query($sql_data);
    foreach ($run_data as $row_data){
      $amount = $row_data['ONHAND'];
      $id_erp = $row_data['id'];
      $id_farm = $row_data['ORGANIZATIONNAME'];
      $sql_warehouse = "SELECT * FROM warehouse WHERE `id_medicine`=$code_med AND `id_farm`=$id_farm";
      $run_warehouse = $conn->query($sql_warehouse);
      $row_warehouse = mysqli_fetch_array($run_warehouse);
      $id = $row_warehouse['id'];
      if($id>0){
          $sql_update = "UPDATE `warehouse` SET `amount` = '$amount' WHERE `id_medicine` = '$code_med' AND `id_farm`=$id_farm;";
          echo $sql_update;
          $conn->query($sql_update);
      }else{
          $sql_insert = "INSERT INTO `warehouse` (`id_medicine`, `id_farm`, `amount`, `status`, `date_created`) VALUES ('$code_med', '$id_farm', '$amount', '1', CURRENT_TIMESTAMP);";
          $conn->query($sql_insert);
      }
    }
  }
  $conn->close();
?>
