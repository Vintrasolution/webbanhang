<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include "../../header.php"; ?>
  <title>Tạo Nhập Hàng | Lilly Flower</title>
  

</head>
<body>
<!-- partial:index.partial.html -->
<html>
  <head>
    <title>Tạo Nhập Hàng - Lilly FLower</title>
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

      <center><p class="h2">Thông Tin Nhập Hàng</p></center>
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
          ?> 
          
          <!-- Thông tin trại --> 
          <form onsubmit="return validateForm()" action="" method="post" name="myForm">
            <!-- Tạo Ngày Nhập Hàng -->
            <label for="field" class="font-weight-bold">Nhà Cung Cấp: <a style="color:red">*</a></label>
            <p>
              <?php 
                $sql_supplier = "SELECT * FROM `supplier` WHERE status=1";
                $run_supplier = $con->query($sql_supplier);
              ?>
              <select class="js-example-basic-multiple form-control js-example-placeholder-multiple" id="field" name="id_supplier" >
                  <option></option>
                  <?php while ($row_supplier = mysqli_fetch_array($run_supplier)){ 
                    $id = $row_supplier['id'];
                    $supplier_name = $row_supplier['supplier_name'];
                  ?>
                    <option value='<?php echo $id; ?>'><?php echo $supplier_name; ?></option>
                  <?php } ?>
                </select>
            </p>
            <label for="field" class="font-weight-bold">Thời Gian Nhập Hàng:<a style="color:red">*</a></label> 
            <p><input type="datetime-local" name="date_import" class="form-control"></p>

            <label for="field" class="font-weight-bold">Loại Hàng Hoá: <a style="color:red">*</a></label>
            <p><textarea rows="5" cols="50" name="details" class="form-control" placeholder="Nhập chi tiết hàng hoá nhập vào"></textarea></p>

            <label for="field" class="font-weight-bold">Đơn Giá: <a style="color:red">*</a></label>
            <p><input type="number" name="price_unit" id="price_unit" class="form-control" placeholder="VNĐ" oninput="tinhThanhTien()"></p>
            <label for="field" class="font-weight-bold">Số Lượng: <a style="color:red">*</a></label>
            <p><input type="number" name="quantity" id="quantity" class="form-control" placeholder="VNĐ" oninput="tinhThanhTien()"></p>
            <label for="field" class="font-weight-bold">Thành Tiền: <a style="color:red">*</a></label>
            <p><input type="text" name="price_total" id="price_total" class="form-control" readonly></p>
            <label for="field" class="font-weight-bold">Hình Thức Thanh Toán: <a style="color:red">*</a></label>
            <p>
              <select name="pay_method" class="form-control">
                <option value="">--Lựa Chọn--</option>
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
            <!--<label for="field" class="font-weight-bold">Trạng Thái Thanh Toán: <a style="color:red">*</a></label>
            <p>
              <select name="pay_status" class="form-control">
                <option value="">--Lựa Chọn--</option>
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

            </p>-->
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
  $(document).ready(function() {
                        $('.js-example-basic-multiple').select2();
                    
                    $(".js-example-placeholder-multiple").select2({
                        placeholder: "Lựa Chọn Nhà Cung Cấp..."
                    });
                    });
  function validateForm() {

    let id_supplier = document.forms["myForm"]["id_supplier"].value;
    let date_import = document.forms["myForm"]["date_import"].value;
    let details = document.forms["myForm"]["details"].value;
    let price_unit = document.forms["myForm"]["price_unit"].value;
    let quantity = document.forms["myForm"]["quantity"].value;
    let price_total = document.forms["myForm"]["price_total"].value;
    let pay_method = document.forms["myForm"]["pay_method"].value;

    if (id_supplier.trim() === "" && date_import.trim()===""&& details.trim()===""&& price_unit.trim()===""&& quantity.trim()===""&& price_total.trim()===""&& pay_method.trim()===""&& ward_receiver.trim()===""&& district_receiver.trim()===""&& city_receiver.trim()===""&& total_price.trim()===""&& pay_method.trim()===""&& pay_status.trim()===""&& details.trim()==="") {
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
  function tinhThanhTien() {
            var price_unit = parseFloat(document.getElementById("price_unit").value);
            var quantity = parseInt(document.getElementById("quantity").value);
            var price_total = price_unit * quantity;
            document.getElementById("price_total").value = price_total;
        }
</script>
  <script  src="./script.js"></script>
</body>
</html>
