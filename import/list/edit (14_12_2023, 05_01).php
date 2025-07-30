<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include "../../header.php"; ?>
  <title>Sửa Nhập Hàng | Lilly Flower</title>
  

</head>
<body>
<!-- partial:index.partial.html -->
<html>
  <head>
    <title>Sửa Nhập Hàng - Lilly FLower</title>
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

      <center><p class="h2">Sửa Thông Tin Nhập Hàng</p></center>
      <?php
          $error = $_GET['error'];
            if($error ==1){
              echo "<center><a style ='color:red'>Vui lòng nhập lại TOA THUỐC <br/> Lý do: Dữ liệu trước đó của Anh/Chị đã bị lỗi!</a></center>";
            }
      ?>
      <?php
          $alert = $_GET['alert'];
            if($alert ==1){
              echo "<center><a style ='color:green'>Thông Tin Đã Cập Nhập Thành Công</a></center>";
            }
      ?>
      <div class="card my-4 shadow">
        <div class="card-body">
          <!-- Lấy dữ liệu Trại-->
          <?php 
            // Bắt đầu session
            session_start();
            
            $id_supplier = $_GET['id'];
            $sql_supplier = "SELECT * FROM import_details WHERE status =1 AND id = '$id_supplier'";
            $run_supplier = $con->query($sql_supplier);
            $row_supplier = mysqli_fetch_array($run_supplier); 

            //Thông Tin Bill Trước chỉnh sửa
              $id_supplier = $row_supplier['id_supplier'];
              
              $product_type = $row_supplier['product_type'];
              $quantity = $row_supplier['quantity'];
              $price_unit = $row_supplier['price_unit']; 
              $price_total = $row_supplier['price_total']; 
              $id_pay_method_import = $row_supplier['id_pay_method_import']; 
              $date_import = $row_supplier['date_import']; 
              echo $date_import;
              $dayimport = date_format(date_create($date_import),"Y/m/d");
          ?> 
          
          <!-- Thông tin trại --> 
          <form onsubmit="return validateForm()" action="" method="post" name="myForm">
            <!-- Tạo Ngày Nhập Hàng -->
            <label for="field" class="font-weight-bold">Nhà Cung Cấp: <a style="color:red">*</a></label>
            <p>
              <?php 
                $sql_supplier_name = "SELECT * FROM `supplier` WHERE status=1 and id='$id_supplier'";
                $run_supplier_name = $con->query($sql_supplier_name);
                $row_supplier_name = mysqli_fetch_array($run_supplier_name);
              ?>
              <select class="js-example-basic-multiple form-control js-example-placeholder-multiple" id="field" name="id_supplier" >
                  <option value="<?php echo $id_supplier; ?>"><?php echo $row_supplier_name['supplier_name']; ?></option>
                  <?php 
                    $sql_supplier = "SELECT * FROM `supplier` WHERE status=1";
                    $run_supplier = $con->query($sql_supplier);
                  ?>
                  <?php while ($row_supplier = mysqli_fetch_array($run_supplier)){ 
                    $id = $row_supplier['id'];
                    $supplier_name = $row_supplier['supplier_name'];
                  ?>
                    <option value='<?php echo $id; ?>'><?php echo $supplier_name; ?></option>
                  <?php } ?>
                </select>
            </p>
            <label for="field" class="font-weight-bold">Thời Gian Nhập Hàng:<a style="color:red">*</a></label> 
            <p><input type="date" name="date_import" class="form-control" value="<?php echo $dayimport; ?>"></p>

            <label for="field" class="font-weight-bold">Loại Hàng Hoá: <a style="color:red">*</a></label>
            <p><textarea rows="5" cols="50" name="details" class="form-control" placeholder="Nhập chi tiết hàng hoá nhập vào"></textarea></p>

            <label for="field" class="font-weight-bold">Đơn Giá: <a style="color:red">*</a></label>
            <p><input type="number" name="price_unit" id="price_unit" class="form-control" placeholder="VNĐ" oninput="tinhThanhTien()"></p>
            <label for="field" class="font-weight-bold">Số Lượng: <a style="color:red">*</a></label>
            <p><input type="number" name="quantity" id="quantity" class="form-control" placeholder="Số Lượng" oninput="tinhThanhTien()"></p>
            <label for="field" class="font-weight-bold">Thành Tiền: <a style="color:red">*</a></label>
            <p><input type="text" name="price_total" id="price_total" class="form-control" readonly placeholder="Tổng Tiền"></p>
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
              <button type="submit" name="submit" value="1" class="btn btn-primary float-right text-uppercase shadow-sm">TIẾP THEO</button>
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

    if (id_supplier.trim() === "" && date_import.trim()===""&& details.trim()===""&& price_unit.trim()===""&& quantity.trim()===""&& price_total.trim()===""&& pay_method.trim()==="") {
      alert("Vui Lòng Điền Đầy Đủ Thông Tin!");
      return false;
    }
    if(date_import.trim()===""){
      alert("Vui lòng điền THỜI GIAN NHẬP HÀNG!");
      return false;
   }
    if(id_supplier.trim()===""){
      alert("Vui lòng điền thông tin NHÀ CUNG CẤP!");
      return false;
   }
    if(details.trim()==="" ){
      alert("Vui lòng điền thông tin LOẠI HÀNG HOÁ!");
      return false;
   }
  if(price_unit.trim()===""){
      alert("Vui lòng điền thông tin ĐƠN GIÁ");
      return false;
   }
   if(quantity.trim()===""){
      alert("Vui lòng điền SỐ LƯỢNG HÀNG HOÁ");
      return false;
   }
   if(pay_method.trim()===""){
      alert("Vui lòng điền HÌNH THỨC THANH TOÁN!");
      return false;
   }
  }
  function tinhThanhTien() {
            var price_unit = parseFloat(document.getElementById("price_unit").value);
            var quantity = parseInt(document.getElementById("quantity").value);
            var price_total = price_unit * quantity;
            document.getElementById("price_total").value = price_total;
        }
</script>
  <script  src="./script.js"></script>
  <?php 
    $submit = $_POST['submit'];
    if($submit ==1){
      $id_supplier = $_POST['id_supplier'];
      $details = $_POST['details'];
      $quantity = $_POST['quantity'];
      $price_unit = $_POST['price_unit'];
      $price_total = $_POST['price_total'];
      $pay_method = $_POST['pay_method'];
      $date_import = $_POST['date_import'];

      $sql_import = "INSERT INTO `import_details` (`id`, `id_supplier`, `product_type`, `quantity`, `price_unit`, `price_total`, `id_pay_method_import`, `date_import`, `status`, `date_created`) VALUES (NULL, '$id_supplier', '$details', '$quantity', '$price_unit', '$price_total', '$pay_method', '$date_import', '1', CURRENT_TIMESTAMP);";
      $run_import = $con->query($sql_import);
      echo '<meta http-equiv="refresh" content="0; url=?alert=1">';
    }

  ?>
</body>
</html>
