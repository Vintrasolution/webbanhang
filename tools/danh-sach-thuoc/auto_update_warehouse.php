<?php
  // Kết nối đến cơ sở dữ liệu
  $servername = "localhost";
  $username = "anovacorp_traiheo";
  $password = "anovafarm@315";
  $dbname = "anovacorp_traiheo";
  $conn = new mysqli($servername, $username, $password, $dbname);
  if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
  }
  $conn->set_charset("utf8");
  //Lấy Code Medicines
  //$sql_medicines = "SELECT * FROM `medicines`";
  //$run_medicines  = $conn->query($sql_medicines);
  //while ($row_medicines = mysqli_fetch_array($run_medicines)){
  //foreach ($run_medicines as $row_medicines){
   // $code_med = $row_medicines['code_med'];
    $sql_data = "SELECT * FROM dataload_erp WHERE 'UOM' NOT LIKE 'Con'";
    $run_data = $conn->query($sql_data);
    foreach ($run_data as $row_data){
      $code_med = $row_data['ITEMNUMBER'];
      $itemdecription = $row_data['ITEMDESCRIPTION'];
      $unit = $row_data['UOM'];
      $amount = $row_data['ONHAND'];
      $id_erp = $row_data['id'];
      $id_farm = $row_data['ORGANIZATIONNAME'];
      //Kiểm tra Medicines đã tồn tại thuốc này chưa
      $sql_medicine = "SELECT * FROM medicines WHERE `code_med` LIKE '$code_med'";
      $run_medicine = $conn -> query($sql_medicine);
      $row_medicine = mysqli_fetch_array($run_medicine);
      $id_med = $row_medicine['id'];
      if($id_med==""){
        $sql_insert_med = "INSERT INTO `medicines` (`id`, `code_med`, `name`, `unit`, `status`, `date_created`) VALUES (NULL, '$code_med', '$itemdecription', '$unit', '1', CURRENT_TIMESTAMP);";
        $run_insert_med = $conn -> query($sql_insert_med);
      }
      $sql_warehouse = "SELECT * FROM warehouse WHERE `id_medicine`=$code_med AND `id_farm` LIKE '$id_farm'";
      $run_warehouse = $conn->query($sql_warehouse);
      $row_warehouse = mysqli_fetch_array($run_warehouse);
      //Chạy select lần nữa để kiểm tra tồn tại của thuốc sau khi chạy insert phía trên
      $sql_check_medicine = "SELECT * FROM medicines WHERE `code_med` LIKE '$code_med'";
      $run_check_medicine = $conn->query($sql_check_medicine);
      $row_check_medicine = mysqli_fetch_array($run_check_medicine);
      $id_check_medicine = $row_check_medicine['id'];
      $id = $row_warehouse['id'];
      if($id>0){
          $sql_update = "UPDATE `warehouse` SET `amount` = '$amount' WHERE `id_medicine` = '$code_med' AND `id_farm` LIKE '$id_farm';";
          $conn->query($sql_update);
      }else if($id_check_medicine!=""){
          $sql_insert = "INSERT INTO `warehouse` (`id_medicine`, `id_farm`, `amount`, `status`, `date_created`) VALUES ('$code_med', '$id_farm', '$amount', '1', CURRENT_TIMESTAMP);";
          $conn->query($sql_insert);
      }
    }

  //Kiểm tra tồn tại thuốc warehouse trong Dataload ERP
  //Nếu Không tồn tại thuốc warehouse trong Dataload ERP thì Update AMount về 0
  $sql_data_warehouse = "SELECT * FROM warehouse ";
  $run_data_warehouse = $conn->query($sql_data_warehouse);
  foreach ($run_data_warehouse as $row_data_warehouse){
    $id_med_warehouse = $row_data_warehouse['id_medicine'];
    $id_farm_warehouse = $row_data_warehouse['id_farm'];
    $sql_med_dataload_erp = "SELECT * FROM dataload_erp WHERE `ITEMNUMBER` ='$id_med_warehouse' AND `ORGANIZATIONNAME` LIKE '$id_farm_warehouse'";
    $run_med_dataload_erp = $conn->query($sql_med_dataload_erp);
    $row_med_dataload_erp = mysqli_fetch_array($run_med_dataload_erp);
    $id_med_dataload_erp = $row_med_dataload_erp['id'];
    if($id_med_dataload_erp==""){
      $sql_update_warehouse = "UPDATE `warehouse` SET `amount` = '0' WHERE `id_medicine` = '$id_med_warehouse' AND `id_farm` LIKE '$id_farm_warehouse';";
      $conn->query($sql_update_warehouse);
    }

  }



  //}
  $conn->close();
?>
