<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include "../header.php"; ?>
  <title>Tạo Đơn Hàng - Lilly Flower</title>
  

</head>
<body>
<!-- partial:index.partial.html -->
<html>
  <head>
    <title>Tạo Đơn Hàng - Lilly FLower</title>
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
            
            $id_trai = $row_staff['id_farm'];
            $sql_farmp = "SELECT * FROM farm WHERE status =1 AND code_farm = '$id_trai'";
            $run_farm = $con->query($sql_farmp);
            $row_farm = mysqli_fetch_array($run_farm); 

          ?> 
          
          <!-- Thông tin trại --> 
          <form onsubmit="return validateForm()" action="preview.php" method="post" name="myForm">
            <!-- Ngày sử dụng toa thuốc -->
            <label for="field" class="font-weight-bold">Ngày Nhận Đơn:</label> 
            <p><input name="date_use" class="form-control" value="<?php echo date("d/m/Y"); ?>" disabled></p>
            <label for="field" class="font-weight-bold">Thời Gian Giao Hàng:<a style="color:red">*</a></label> 
            <p><input type="datetime-local" name="date_ship" class="form-control"></p>
            <label for="field" class="font-weight-bold">Người Đặt Hoa:<a style="color:red">*</a></label> 
            <p><input type="text" name="fullname_customer" style="width: 50%;" placeholder="Họ và Tên"><input type="number" name="phone_customer" style="width: 50%;"placeholder="Số Điện Thoại"></p>
            <label for="field" class="font-weight-bold">Người Nhận Hoa:<a style="color:red">*</a></label> 
            <p><input type="text" name="fullname_receiver" style="width:50%" placeholder="Họ và Tên"><input type="number" name="phone_receiver" style="width:50%" placeholder="Số Điện Thoại"></p>
            <label for="field" class="font-weight-bold">Địa Chỉ Giao Hàng:<a style="color:red">*</a></label> 
            <p><input type="text" name="address_receiver" placeholder="Địa chỉ" style="width:20%"><input type="text" name="street_receiver"  placeholder="Tên Đường" style="width:20%"><input type="text" name="ward_receiver" placeholder="Phường/Xã" style="width:20%"><input type="text" name="district_receiver" placeholder="Quận/Huyện" style="width:20%"><input type="text" name="city_receiver" placeholder="Tỉnh/Thành Phố" style="width:20%"></p>

            <label for="field" class="font-weight-bold">Mô Tả Thông Tin Sản Phẩm: <a style="color:red">*</a></label>
            <p><textarea rows="5" cols="50" name="details" class="form-control" placeholder="Nhập chi tiết sản phẩm bán ra"></textarea></p>



            <label for="field" class="font-weight-bold">Giá Tiền (chưa VAT): <a style="color:red">*</a></label>
            <p><input type="number" name="total_price" class="form-control" placeholder="VNĐ"></p>
            <label for="field" class="font-weight-bold">Hình Thức Thanh Toán: <a style="color:red">*</a></label>
            <p>
              <select name="pay_method" class="form-control">
                <?php 
                  $sql_paymethod = "SELECT * FROM `payment_method` WHERE status=1";
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
                  $sql_paystatus = "SELECT * FROM `payment_status` WHERE status=1";
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
              <button type="submit" name="submit" class="btn btn-primary float-right text-uppercase shadow-sm">TIẾP THEO</button>
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
    let pay_method = document.forms["myForm"]["pay_method"].value;
    let pay_status = document.forms["myForm"]["pay_status"].value;
    let details = document.forms["myForm"]["details"].value;

    if (date_ship === "" && fullname_customer===""&& phone_customer===""&& fullname_receiver===""&& phone_receiver===""&& address_receiver===""&& street_receiver===""&& ward_receiver===""&& district_receiver===""&& city_receiver===""&& total_price===""&& pay_method===""&& pay_status===""&& details==="") {
      alert("Vui Lòng Điền Đầy Đủ Thông Tin!");
      return false;
    }
    if(date_ship===""){
      alert("Vui lòng điền THỜI GIAN GIAO HÀNG!");
      return false;
   }
    if(fullname_customer==="" || phone_customer===""){
      alert("Vui lòng điền thông tin NGƯỜI ĐẶT HOA!");
      return false;
   }
       if(fullname_receiver==="" || phone_receiver===""){
      alert("Vui lòng điền thông tin NGƯỜI NHẬN HÀNG!");
      return false;
   }
  if(address_receiver==="" || street_receiver===""|| ward_receiver===""|| district_receiver===""|| city_receiver===""){
      alert("Vui lòng điền thông tin ĐỊA CHỈ NHẬN HÀNG");
      return false;
   }
   if(total_price===""){
      alert("Vui lòng điền GIÁ TIỀN!");
      return false;
   }
   if(pay_method===""){
      alert("Vui lòng điền HÌNH THỨC THANH TOÁN!");
      return false;
   }
   if(pay_status===""){
      alert("Vui lòng điền TRẠNG THÁI THANH TOÁN!");
      return false;
   }
   if(details===""){
      alert("Vui lòng điền CHI TIẾT SẢN PHẨM!");
      return false;
   }
  return true;
  }
</script>
  <script  src="./script.js"></script>
</body>
</html>
