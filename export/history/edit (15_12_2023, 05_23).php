<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include "../../header.php"; ?>
  <title>Sửa Đơn Hàng - Lilly Flower</title>
  

</head>
<body>
<!-- partial:index.partial.html -->
<html>
  <head>
    <title>Sửa Đơn Hàng - Lilly FLower</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="css/select2.min.css" rel="stylesheet" />
    <script src="js/select2.min.js"></script>
    <style type="text/css">
      datalist { 
        display: none;
      }
    </style>
  </head>

  <body>
      
    <div class="container my-4">

      <center><p class="h2">Thông Tin Đơn Hàng</p></center>
      <?php
          $error = $_GET['error'];

            if($error ==1){
              echo "<center><a style ='color:red'>Vui lòng nhập lại TOA THUỐC <br/> Lý do: Dữ liệu trước đó của Anh/Chị đã bị lỗi!</a></center>";
            }
      ?>
      <div class="card my-4 shadow">
        <div class="card-body">
          <!-- Lấy dữ liệu Trại-->
          <?php 
            // Bắt đầu session
            session_start();
            
            $id_bill = $_GET['id'];
            $sql_bill = "SELECT * FROM billing WHERE status =1 AND id = '$id_bill'";
            $run_bill = $con->query($sql_bill);
            $row_bill = mysqli_fetch_array($run_bill); 

            //Thông Tin Bill Trước chỉnh sửa
              $date_use = $row_bill['date_use'];
              $dayuse = date_format(date_create($date_use),"d/m/Y ");
              $date_ship = $row_bill['date_shipping'];
              $time_ship = $row_bill['time_shipping'];
              $day_ship = date("Y-m-d\TH:i", strtotime("$date_ship $time_ship"));
              $fullname_customer = $row_bill['fullname_customer']; 
              $phone_customer = $row_bill['phone_customer']; 
              $fullname_receiver = $row_bill['fullname_receiver']; 
              $phone_receiver = $row_bill['phone_receiver']; 
              $address_receiver = $row_bill['address']; 
              $street_receiver = $row_bill['street']; 
              $ward_receiver = $row_bill['ward']; 
              $district_receiver = $row_bill['district']; 
              $city_receiver = $row_bill['city']; 
              $total_price = $row_bill['total_price'];
              $shipping_price = $row_bill['shipping_price'];
              $all_price = $row_bill['all_price']; 
              $pay_method = $row_bill['pay_method']; 
              $pay_status = $row_bill['pay_status']; 
              $status_ship = $row_bill['status_ship']; 
              $details = $row_bill['details']; 
          ?> 
          
          <!-- Thông tin trại --> 
          <form onsubmit="return validateForm()" action="" method="post" name="myForm">
            <!-- Ngày sử dụng toa thuốc -->
            <p><input name="id_bill" class="form-control" value="<?php echo $id_bill; ?>" hidden></p>
            <label for="field" class="font-weight-bold">Ngày Nhận Đơn:</label> 
            <p><input name="date_use" class="form-control" value="<?php echo $dayuse; ?>" disabled></p>
            <label for="field" class="font-weight-bold">Thời Gian Giao Hàng:<a style="color:red">*</a></label> 
            <p><input type="datetime-local" name="date_ship" class="form-control" value="<?php echo $day_ship; ?>"></p>
            <label for="field" class="font-weight-bold">Người Đặt Hoa:<a style="color:red">*</a></label> 
            <p><input type="text" name="fullname_customer" style="width: 50%;" placeholder="Họ và Tên" value="<?php echo $fullname_customer; ?>"><input type="number" name="phone_customer" style="width: 50%;"placeholder="Số Điện Thoại"  value="<?php echo "0".$phone_customer; ?>"></p>
            <label for="field" class="font-weight-bold">Người Nhận Hoa:<a style="color:red">*</a></label> 
            <p><input type="text" name="fullname_receiver" style="width:50%" placeholder="Họ và Tên" value="<?php echo $fullname_receiver; ?>"><input type="number" name="phone_receiver" style="width:50%" placeholder="Số Điện Thoại" value="<?php echo "0".$phone_receiver; ?>"></p>
            <label for="field" class="font-weight-bold">Địa Chỉ Giao Hàng:<a style="color:red">*</a></label> 
            <p><input type="text" name="address_receiver" placeholder="Địa chỉ" style="width:20%" value="<?php echo $address_receiver; ?>"><input type="text" name="street_receiver"  placeholder="Tên Đường" style="width:20%" value="<?php echo $street_receiver; ?>"><input type="text" name="ward_receiver" placeholder="Phường/Xã" style="width:20%" value="<?php echo $ward_receiver; ?>"><input type="text" name="district_receiver" placeholder="Quận/Huyện" style="width:20%" value="<?php echo $district_receiver; ?>"><input type="text" name="city_receiver" placeholder="Tỉnh/Thành Phố" style="width:20%" value="<?php echo $city_receiver; ?>"></p>

            <div>
                <select class="form-select form-select-sm mb-3" id="city" name="city_receiver" aria-label=".form-select-sm" style="width:20%; height: 30px;">
                  <option value="" selected>Chọn Tỉnh/Thành</option>           
                </select>
                          
                <select class="form-select form-select-sm mb-3" id="district" name="district_receiver" aria-label=".form-select-sm" style="width:19.5%; height: 30px;">
                  <option value="" selected>Chọn Quận/Huyện</option>
                </select>

                <select class="form-select" id="ward" aria-label=".form-select-sm" style="width:19.5%; height: 30px;" name="ward_receiver">
                  <option value="" selected>Chọn Phường/Xã</option>
                </select>
                <input type="text" name="address_receiver" placeholder="Địa chỉ" style="width:19.5%"><input type="text" name="street_receiver"  placeholder="Tên Đường" style="width:20%">
             </div>  

            <label for="field" class="font-weight-bold">Mô Tả Thông Tin Sản Phẩm: <a style="color:red">*</a></label>
            <p><textarea rows="5" cols="50" name="details" class="form-control" placeholder="Nhập chi tiết sản phẩm bán ra"><?php echo $details; ?></textarea></p>



            <label for="field" class="font-weight-bold">Giá Tiền (chưa VAT): <a style="color:red">*</a></label>
            <p><input type="number" name="total_price" id="total_price" class="form-control" placeholder="VNĐ" value="<?php echo $total_price; ?>" oninput="tinhThanhTien()"></p>
            <label for="field" class="font-weight-bold">Phí Vận Chuyển: <a style="color:red">*</a></label>
            <p><input type="number" name="shipping_price" id="shipping_price" class="form-control" placeholder="VNĐ" value="<?php echo $shipping_price; ?>" oninput="tinhThanhTien()"></p>
            <label for="field" class="font-weight-bold">Tổng Tiền: <a style="color:red">*</a></label>
            <p><input type="text" name="all_price" id="all_price" class="form-control" placeholder="VNĐ" value="<?php echo $all_price; ?>" readonly></p>
            <label for="field" class="font-weight-bold">Hình Thức Thanh Toán: <a style="color:red">*</a></label>
            <p>
              <select name="pay_method" class="form-control">
                <?php 
                  $sql_namemethod = "SELECT * FROM `payment_method` WHERE status=1 and id ='$pay_method' ";
                  $run_namemethod= $con->query($sql_namemethod);
                  $row_namemethod = mysqli_fetch_array($run_namemethod);
                  $namemethod = $row_namemethod['name_method'];
                ?>
                <option value="<?php echo $pay_method; ?>"><?php echo $namemethod; ?></option>
                <?php 
                  $sql_paymethod = "SELECT * FROM `payment_method` WHERE status=1 AND id<>'$pay_method'";
                  $run_paymethod = $con->query($sql_paymethod);

                  while ($row_paymethod = mysqli_fetch_array($run_paymethod)) {
                    $id_method = $row_paymethod['id'];
                    $name_method = $row_paymethod['name_method'];
                    ?>
                    <option value="<?php echo $id_method; ?>"><?php echo $name_method; ?></option>
                    <?php 
                  }
                ?>
              </select>

            </p>
            <label for="field" class="font-weight-bold">Trạng Thái Thanh Toán: <a style="color:red">*</a></label>
            <p>
              <select name="pay_status" class="form-control">
                <?php 
                  $sql_namestatus = "SELECT * FROM `payment_status` WHERE status=1 and id ='$pay_status' ";
                  $run_namestatus= $con->query($sql_namestatus);
                  $row_namestatus = mysqli_fetch_array($run_namestatus);
                  $namstatus = $row_namestatus['name_status'];
                ?>
                <option value="<?php echo $pay_status; ?>"><?php echo $namstatus; ?></option>
                <?php 
                  $sql_paystatus = "SELECT * FROM `payment_status` WHERE status=1 AND id <>'$pay_status'";
                  $run_paystatus = $con->query($sql_paystatus);
                  while ($row_paystatus = mysqli_fetch_array($run_paystatus)) {
                    $id_status = $row_paystatus['id'];
                    $name_status = $row_paystatus['name_status'];
                    ?>
                    <option value="<?php echo $id_status; ?>" ><?php echo $name_status; ?></option>
                    <?php 
                  }
                ?>
              </select>

            </p>
            <div class="clearfix mt-4">
              <button type="submit" name="submit" value="6" class="btn btn-primary float-mid text-uppercase shadow-sm">Quay Lại</button>
              <button type="submit" name="submit" value="5" class="btn btn-primary float-right text-uppercase shadow-sm">XÁC NHẬN</button>
            </div>
          </form> 
        </div>
      </div>
    </div>
  </body>
</html>
<script>
  function validateForm() {

    let date_ship = document.forms["myForm"]["date_ship"].value;
    let fullname_customer = document.forms["myForm"]["fullname_customer"].value;
    let phone_customer = document.forms["myForm"]["phone_customer"].value;
    let fullname_receiver = document.forms["myForm"]["fullname_receiver"].value;
    let phone_receiver = document.forms["myForm"]["phone_receiver"].value;
    let address_receiver = document.forms["myForm"]["address_receiver"].value;
    let street_receiver = document.forms["myForm"]["date_use"].value;
    let ward_receiver = document.forms["myForm"]["ward_receiver"].value;
    let district_receiver = document.forms["myForm"]["district_receiver"].value;
    let city_receiver = document.forms["myForm"]["city_receiver"].value;
    let total_price = document.forms["myForm"]["total_price"].value;
    let shipping_price = document.forms["myForm"]["shipping_price"].value;
    let all_price = document.forms["myForm"]["all_price"].value;
    let pay_method = document.forms["myForm"]["pay_method"].value;
    let pay_status = document.forms["myForm"]["pay_status"].value;
    let details = document.forms["myForm"]["details"].value;

    if (date_ship.trim() === "" && fullname_customer.trim()===""&& phone_customer.trim()===""&& fullname_receiver.trim()===""&& phone_receiver.trim()===""&& address_receiver.trim()===""&& street_receiver.trim()===""&& ward_receiver.trim()===""&& district_receiver.trim()===""&& city_receiver.trim()===""&& total_price.trim()===""&& pay_method.trim()===""&& pay_status.trim()===""&& details.trim()==="") {
      alert("Vui Lòng Điền Đầy Đủ Thông Tin!");
      return false;
    }
    if(date_ship.trim()===""){
      alert("Vui lòng điền THỜI GIAN GIAO HÀNG!");
      return false;
   }
    if(fullname_customer.trim()==="" || phone_customer.trim()===""){
      alert("Vui lòng điền thông tin NGƯỜI ĐẶT HOA!");
      return false;
   }
       if(fullname_receiver.trim()==="" || phone_receiver.trim()===""){
      alert("Vui lòng điền thông tin NGƯỜI NHẬN HÀNG!");
      return false;
   }
  if(address_receiver.trim()==="" || street_receiver.trim()===""|| ward_receiver.trim()===""|| district_receiver.trim()===""|| city_receiver.trim()===""){
      alert("Vui lòng điền thông tin ĐỊA CHỈ NHẬN HÀNG");
      return false;
   }
   if(total_price.trim()===""){
      alert("Vui lòng điền GIÁ TIỀN!");
      return false;
   }
   if(pay_method.trim()===""){
      alert("Vui lòng điền HÌNH THỨC THANH TOÁN!");
      return false;
   }
   if(pay_status.trim()===""){
      alert("Vui lòng điền TRẠNG THÁI THANH TOÁN!");
      return false;
   }
   if(details.trim()===""){
      alert("Vui lòng điền CHI TIẾT SẢN PHẨM!");
      return false;
   }
  return true;
  }
  function click_back() {
    window.location.href = "../chitiet.php?id=<?php echo $id_bill; ?>";
    }
        function tinhThanhTien() {
            var total_price = parseFloat(document.getElementById("total_price").value);
            var shipping_price = parseInt(document.getElementById("shipping_price").value);
            var all_price = total_price + shipping_price;
            document.getElementById("all_price").value = all_price;
        }
</script>
  <script  src="./script.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
  <script src="selectvietnam.js"></script>

  <?php 
      //Lấy Thông Tin Đã Sửa
      $date_ship = $_POST['date_ship'];
      $date_shipping = date_format(date_create($date_ship),"Y-m-d");
      $time_shipping = date_format(date_create($date_ship),"H:i");
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
      $shipping_price = $_POST['shipping_price']; 
      $all_price = $_POST['all_price']; 
      $pay_method = $_POST['pay_method']; 
      $pay_status = $_POST['pay_status']; 
      $status_ship = $_POST['status_ship']; 
      $details = $_POST['details']; 
      
      $id_bill_xn = $_POST['id_bill'];
      $submit_xn = $_POST['submit'];

      if( $submit_xn ==5){
        $sql_bill_edit = "UPDATE `billing` SET `fullname_customer` = '$fullname_customer' ,`phone_customer` = '$phone_customer' ,`fullname_receiver` = '$fullname_receiver' ,`phone_receiver` = '$phone_receiver' ,`address` = '$address_receiver', `street` = '$street_receiver', `ward` = '$ward_receiver', `district` = '$district_receiver', `city` = '$city_receiver', `details` = '$details', `total_price` = '$total_price', `shipping_price` = '$shipping_price', `all_price` = '$all_price', `time_shipping` = '$time_shipping', `date_shipping` = '$date_shipping', `pay_method` = '$pay_method', `pay_status` = '$pay_status' WHERE `billing`.`id` = $id_bill_xn;";
        $run_bill_edit = $con->query($sql_bill_edit);
        ?><meta http-equiv="refresh" content="0"><?php
      }
      if($submit_xn ==6){
        echo '<meta http-equiv="refresh" content="0;url=chitiet.php/?id='.$id_bill_xn.'">';
      }

  ?>
</body>
</html>
