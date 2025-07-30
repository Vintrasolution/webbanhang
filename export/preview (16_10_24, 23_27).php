<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include "../header.php"; ?>
  <style type="text/css">
    th {
      padding-left: 10px;
    }
    td {
      padding-left: 10px;
    }
  </style>
  <title>THÔNG TIN ĐƠN HÀNG- LILLY FLOWER</title>
  

</head>
<body>
<!-- partial:index.partial.html -->
<html>
  <head>
    <title>THÔNG TIN ĐƠN HÀNG</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
  </head>

  <body>
      
    <div class="container my-4">

      <center><p class="h3">THÔNG TIN ĐƠN HÀNG</p></center>
      <div class="card my-4 shadow">
        <div class="card-body">
          <form action="" method="post">
            <!--Ngày áp dụng toa thuốc -->
            <?php 
              $date_use = $_POST['date_use']; 
              $date_ship = $_POST['date_ship'];
              $fullname_customer = $_POST['fullname_customer']; 
              $phone_customer = $_POST['phone_customer']; 
              $fullname_receiver = $_POST['fullname_receiver']; 
              $phone_receiver = $_POST['phone_receiver']; 
              $address_receiver = $_POST['address_receiver']; 
              $street_receiver = $_POST['street_receiver'];  

              $wardId = $_POST['ward_receiver']; 
              $districtId = $_POST['district_receiver']; 
              $cityId = $_POST['city_receiver']; 

              $total_price = $_POST['total_price']; 
              $pay_method = $_POST['pay_method']; 
              $pay_status = $_POST['pay_status']; 
              $details = $_POST['details']; 
              $shipping_price = $_POST['shipping_price']; 
              $all_price = $_POST['all_price']; 
              $code_customer = $_POST['code_customer'];
              $product_type = $_POST['product_type'];
              //Đọc từ ID Product Type thành Name Product Type
              $sql_name_product = "SELECT * FROM product_type WHERE id='$product_type'";
              $run_name_product = $con->query($sql_name_product);
              $row_name_product = mysqli_fetch_array($run_name_product);
              $name_product_type = $row_name_product['name'];
              // Đọc nội dung từ tệp JSON
              $jsonData = file_get_contents('diagioihanhchinhvn.json');

              // Giải mã JSON thành một mảng đa cấp
              $data = json_decode($jsonData, true);

              // Hàm để tìm thông tin dựa trên ID
              function findInfoById($data, $cityId, $districtId, $wardId) {
                  foreach ($data as $city) {
                      if ($city['Id'] == $cityId) {
                          foreach ($city['Districts'] as $district) {
                              if ($district['Id'] == $districtId) {
                                  foreach ($district['Wards'] as $ward) {
                                      if ($ward['Id'] == $wardId) {
                                          return $ward;
                                      }
                                  }
                              }
                          }
                      }
                  }
                  return null;
              }

              // Thay đổi ID theo thông tin bạn muốn hiển thị
              //$cityId = '01'; // ID của thành phố
              //$districtId = '001'; // ID của quận
              //$wardId = '00001'; // ID của phường

              // Tìm thông tin dựa trên ID
              $wardInfo = findInfoById($data, $cityId, $districtId, $wardId);

              if ($wardInfo !== null) {
                  $ward_receiver = $wardInfo['Name']; // Tên phường
                  $wardLevel = $wardInfo['Level']; // Cấp phường

                  // Tìm tên thành phố và quận tương ứng
                  $city_receiver = '';
                  $district_receiver = '';

                  foreach ($data as $city) {
                      if ($city['Id'] == $cityId) {
                          $city_receiver = $city['Name']; // Tên thành phố
                          foreach ($city['Districts'] as $district) {
                              if ($district['Id'] == $districtId) {
                                  $district_receiver = $district['Name']; // Tên quận
                                  break;
                              }
                          }
                          break;
                      }
                  }
              } else {
                  echo "Không tìm thấy thông tin với ID cung cấp.";
              } 


            ?>
            <!-- Ngày Nhận Đơn -->
            <label for="field" class="font-weight-bold">Ngày Nhận Đơn:</label> <input type="hidden" name="date_use" value="<?php echo $date_use; ?>">
            <?php $day = date_format(date_create($date_use),"d/m/Y "); ?><?php echo $day; ?>
            <br/>
            <!-- Tên + SDT người đặt hoa -->
            <label for="field" class="font-weight-bold">Tên Người Đặt Hoa: </label><input type="hidden" name="code_customer" value="<?php echo $code_customer; ?>"><input type="hidden" name="fullname_customer" value="<?php echo $fullname_customer; ?>"><?php echo $fullname_customer.'&nbsp'.'&nbsp'.'&nbsp'.'  -  '.'&nbsp'.'&nbsp'.'&nbsp'; ?>  <label for="field" class="font-weight-bold">Số Điện Thoại: </label><input type="hidden" name="phone_customer" value="<?php echo $phone_customer; ?>"><?php echo $phone_customer; ?>
            <br/><br/>
            <!-- Ngày Giao Đơn -->
            <label for="field" class="font-weight-bold">Ngày Giao Đơn:</label> <input type="hidden" name="date_ship" value="<?php echo $date_ship; ?>">
            <?php $day_ship = date_format(date_create($date_ship),"H:i - d/m/Y"); ?><?php echo $day_ship; ?>

            <br/>
              <!-- Tên + SDT người nhận hoa -->
            <label for="field" class="font-weight-bold">Tên Người Nhận Hoa: </label><input type="hidden" name="fullname_receiver" value="<?php echo $fullname_receiver; ?>"><?php echo $fullname_receiver.'&nbsp'.'&nbsp'.'&nbsp'.'  -  '.'&nbsp'.'&nbsp'.'&nbsp'; ?>  <label for="field" class="font-weight-bold">Số Điện Thoại: </label><input type="hidden" name="phone_receiver" value="<?php echo $phone_receiver; ?>"><?php echo $phone_receiver; ?>

            
            <br/>
            <!-- Địa chỉ giao hàng -->
            <label for="field" class="font-weight-bold">Địa Chỉ Giao Hàng: </label>
            <input type="hidden" name="address_receiver" value="<?php echo $address_receiver; ?>">
            <input type="hidden" name="street_receiver" value="<?php echo $street_receiver; ?>">
            <input type="hidden" name="ward_receiver" value="<?php echo $ward_receiver; ?>">
            <input type="hidden" name="district_receiver" value="<?php echo $district_receiver; ?>">
            <input type="hidden" name="city_receiver" value="<?php echo $city_receiver; ?>">

            <?php echo $address_receiver.', Đường '.$street_receiver.', '.$ward_receiver.', '.$district_receiver.', '.$city_receiver; ?> 
            <br/><br/>
            <label for="field" class="font-weight-bold">Loại Sản Phẩm: </label><input type="hidden" name="product_type" value="<?php echo $product_type; ?>"><?php echo " ".$name_product_type;?> 
            <br/><br/>
            <!-- Chi Tiết Đơn Hàng -->
            <label for="field" class="font-weight-bold">Chi Tiết Đơn Hàng: </label><input type="hidden" name="details" value="<?php echo $details; ?>"><?php echo " ".$details;?> 
            <br/><br/>
            <!-- Thành tiền chưa VAT-->
            <label for="field" class="font-weight-bold">Giá Tiền (chưa VAT)(1): </label><input type="hidden" name="total_price" value="<?php echo $total_price; ?>"><?php echo ' '.number_format($total_price, 0, '', ',').' VNĐ';?> 
            <br/>
            <label for="field" class="font-weight-bold">Phí Vận Chuyển(2): </label><input type="hidden" name="shipping_price" value="<?php echo $shipping_price; ?>"><?php echo ' '.number_format($shipping_price, 0, '', ',').' VNĐ';?> 
            <br/>
            <label for="field" class="font-weight-bold">Tồng Đơn (chưa VAT)(1+2): </label><input type="hidden" name="all_price" value="<?php echo $all_price; ?>"><?php echo ' '.number_format($all_price, 0, '', ',').' VNĐ';?> 
            <br/>
            <!-- Hình thức thanh toán -->
            <?php 
            $sql_paymethod = "SELECT * FROM payment_method WHERE id ='$pay_method' and status =1";
            $run_paymethod = $con->query($sql_paymethod);
            $row_paymethod = mysqli_fetch_array($run_paymethod);
            $name_paymethod = $row_paymethod['name_method'];
            ?>
            <label for="field" class="font-weight-bold">Hình Thức Thanh Toán: </label><input type="hidden" name="pay_method" value="<?php echo $pay_method; ?>"><?php echo $name_paymethod;?> 
            <br/>
            <!-- Trạng thái thanh toán -->
            <?php 
            $sql_paystatus = "SELECT * FROM payment_status WHERE id ='$pay_status' and status =1";
            $run_paystatus = $con->query($sql_paystatus);
            $row_paystatus= mysqli_fetch_array($run_paystatus);
            $name_paystatus = $row_paystatus['name_status'];
            ?>
            <label for="field" class="font-weight-bold">Trạng Thái Thanh Toán: </label><input type="hidden" name="pay_status" value="<?php echo $pay_status; ?>"><?php echo $name_paystatus;?> 
            <div class="clearfix mt-4">
              <button type="button" class="btn btn-primary float-left text-uppercase shadow-sm" onclick="window.location.href='https://banhang.lillyflower.com.vn/admin/export/';">NHẬP LẠI</button>
              <button type="submit" name="submit" value="4" class="btn btn-primary float-right text-uppercase shadow-sm">XÁC NHẬN ĐƠN</button>
            </div>
          </form>
      </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>
<!-- partial -->
<?php         

             if($_POST['submit']==4){
                  $date_use = $_POST['date_use']; 
                  $day_receipt = date_format(date_create($date_use),"Y-m-d");
                  $date_ship = $_POST['date_ship'];
                  $day_shipping = date_format(date_create($date_ship),"Y-m-d");
                  $time_shipping = date_format(date_create($date_ship),"H:i:m");
                  $fullname_customer = $_POST['fullname_customer']; 
                  $phone_customer = $_POST['phone_customer']; 
                  $fullname_receiver = $_POST['fullname_receiver']; 
                  $phone_receiver = $_POST['phone_receiver']; 
                  $address_receiver = $_POST['address_receiver']; 
                  $street_receiver = $_POST['street_receiver']; 
                  $ward_receiver = $_POST['ward_receiver']; 
                  $district_receiver = $_POST['district_receiver']; 
                  $city_receiver = $_POST['city_receiver']; 
                  $total_price = $_POST['total_price']; 
                  $pay_method = $_POST['pay_method']; 
                  $pay_status = $_POST['pay_status']; 
                  $details = $_POST['details']; 
                  $shipping_price = $_POST['shipping_price']; 
                  $all_price = $_POST['all_price']; 
                  $code_customer = $_POST['code_customer'];
                  $product_type = $_POST['product_type'];

                  //Kiểm tra Code_Customer có được nhập vào không - Nếu có dữ liệu thì sẽ chạy tiếp điều kiện bên trong
                  if($code_customer!=""){
                    //Kiểm tra tồn tài Code_Customer
                    $sql_code = "SELECT * FROM customer WHERE code ='$code_customer'";
                    $run_code = $con->query($sql_code);
                    $row_code = mysqli_fetch_array($run_code);
                    if($row_code==""){
                      //Tạo khách hàng nếu không tồn tại trong Customer
                      $sql_insertcode = "INSERT INTO `customer` (`id`, `code`, `fullname`, `phone`, `status`, `date_create`) VALUES (NULL, '$code_customer', '$fullname_customer', '$phone_customer', '1', CURRENT_TIMESTAMP);";
                      $run_insertcode  = $con->query($sql_insertcode);
                    }
                  }
                  //Thêm đơn hàng vào database
                  $sql_insertbill = "INSERT INTO `billing` (`id`, `fullname_customer`, `phone_customer`, `fullname_receiver`, `phone_receiver`, `address`, `street`, `ward`, `district`, `city`, `details`, `total_price`, `shipping_price`, `all_price`,`date_billing`, `time_shipping`, `date_shipping`, `pay_method`, `pay_status`, `status`, `status_ship`, `date_created`) VALUES (NULL, '$fullname_customer', '$phone_customer', '$fullname_receiver', '$phone_receiver', '$address_receiver', '$street_receiver', '$ward_receiver', '$district_receiver', '$city_receiver', '$details', '$total_price','$shipping_price', '$all_price', '$day_receipt', '$time_shipping', '$day_shipping', '$pay_method', '$pay_status', '1','1', CURRENT_TIMESTAMP);";
                  //Lấy ID Billing
                  //$sql_billing = "SELECT * FROM `billing` ORDER BY `id` DESC";
                  //$run_billing = $con->query($sql_billing);
                  //$row_billing = mysqli_fetch_array($run_billing);
                  //$id_billing = $row_billing['id'];
                  

                  //Chạy Lệnh SQL thêm vào DB
                  $run_insertbill = $con->query($sql_insertbill);
                  //Lấy ID Billing
                  $sql_selectbill = "SELECT * FROM billing ORDER BY id DESC";
                  $run_selectbill = $con->query($sql_selectbill);
                  $row_selectbill = mysqli_fetch_array($run_selectbill);
                  $id_bill = $row_selectbill['id'];

                  //Thêm đơn hàng bao gồm Prodcut Type vào Database
                  $sql_insertproducttype = "INSERT INTO `billing_product_type` (`id`, `id_billing`, `id_product_type`, `price_total`, `status`, `date_created`) VALUES (NULL, '$id_bill', '$product_type', '$all_price', '1', CURRENT_TIMESTAMP);";
                  $run_insertproducttype = $con->query($sql_insertproducttype);


            ?><meta http-equiv="refresh" content="0; url='successful.php?id=<?php echo $id_bill; ?>'" /><?php
          }
    ?>

<script>
  function goBack() {
    window.history.back();
    window.close(); 
  }
</script>
  <script  src="./script.js"></script>

</body>
</html>
