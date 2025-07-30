<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include "../../header.php"; ?>
  <style type="text/css">
    th {
      padding-left: 10px;
      padding-right: 10px;
      padding-top: 8px;
      padding-bottom: 8px;
      font-size: 14px;
      color: white;
      background-color: #7B77FC;
    }
    td {
      padding-left: 10px;
      padding-right: 10px;
      padding-top: 10px;
      padding-bottom: 10px;
      font-size: 13px;
    }
    tr:nth-child(even){background-color: #f2f2f2}
    .pagination {
      display: inline-block;
    }
    table {
        /* CSS để bảng tự động thay đổi kích thước hoặc cuộn ngang theo nhu cầu */
        width: 100%;
        overflow-x: auto;
      }

      /* Định dạng in riêng cho form và các trường input */
        label {
            font-weight: bold;
        }
        label, form{
            text-align: center;
        }
  </style>
  <title>CHI TIẾT ĐƠN NHẬP- LILLY FLOWER</title>
  

</head>
<body>
<!-- partial:index.partial.html -->
<html>
  <head>
    <title>CHI TIẾT ĐƠN NHẬP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
  </head>

  <body>
      
    <div class="container my-4">

      <center><p class="h2" id="bienhan">BIÊN LAI</p></center>
      <div class="card my-4 shadow">
        <div class="card-body">
          <?php 
            $id_bill = $_GET['id']; 

            $sql_pre = "SELECT * FROM import_details WHERE status =1 AND id = '$id_bill'";
            $run_pre = $con->query($sql_pre);
            $row_pre = mysqli_fetch_array($run_pre);
            //$date_use = $row_pre['date_use']; 
              $date_import = $row_pre['date_import'];
              $time_ship = $row_pre['time_shipping'];
              $day_ship = date("d/m/Y", strtotime("$date_import"));
              $id_supplier = $row_pre['id_supplier']; 
              $product_type = $row_pre['product_type']; 
              $price_unit = $row_pre['price_unit']; 
              $quantity = $row_pre['quantity']; 
              $price_total = $row_pre['price_total']; 
              $id_pay_method_import = $row_pre['id_pay_method_import']; 
          ?>
          <center>
          <form action="" method="post" id="myForm">
            
            <br/>
            <label for="field" class="font-weight-bold">Ngày Nhập Hàng:</label> <input type="hidden" name="date_import" value="<?php echo $date_import; ?>">
            <?php $day = date_format(date_create($date_import),"d/m/Y "); ?><?php echo $day; ?>
            <br/>
            <!-- Địa chỉ giao hàng -->
            <?php 
              $sql_supplier = "SELECT * FROM supplier WHERE id='$id_supplier'";
              $run_supplier = $con->query($sql_supplier);
              $row_supplier = mysqli_fetch_array($run_supplier);
              $name_supplier = $row_supplier['supplier_name'];

            ?>
            <label for="field" class="font-weight-bold">Nhà Cung Cấp: </label>
            <?php echo $name_supplier; ?>
            <input type="hidden" name="name_supplier" value="<?php echo $name_supplier; ?>">
            <br/>
            <!-- Chi Tiết Đơn Hàng -->
            <label for="field" class="font-weight-bold">Sản Phẩm: </label><input type="hidden" name="product_type" value="<?php echo $product_type; ?>"><?php echo $product_type;?> 
            <br/><br/>
            <!-- Thành tiền chưa VAT-->
            <label for="field" class="font-weight-bold">Đơn Giá: </label><input type="hidden" name="price_unit" value="<?php echo $price_unit; ?>"><?php echo ' '.number_format($price_unit, 0, '', ',').' VNĐ';?> 
            <br/>
            <label for="field" class="font-weight-bold">Số Lượng: </label><input type="hidden" name="quantity" value="<?php echo $quantity; ?>"><?php echo $quantity;?> 
            <br/>
            <label for="field" class="font-weight-bold">Thành tiền: </label><input type="hidden" name="price_total" value="<?php echo $price_total; ?>"><?php echo ' '.number_format($price_total, 0, '', ',').' VNĐ';?> 
            <br/>
            <!-- Hình thức thanh toán -->
            <?php 
            $sql_paymethod = "SELECT * FROM payment_method_import WHERE id ='$id_pay_method_import' and status =1";
            $run_paymethod = $con->query($sql_paymethod);
            $row_paymethod = mysqli_fetch_array($run_paymethod);
            $name_paymethod = $row_paymethod['name_method'];
            ?>
            <label for="field" class="font-weight-bold">Hình Thức Thanh Toán: </label><input type="hidden" name="id_pay_method_import" value="<?php echo $id_pay_method_import; ?>"><?php echo $name_paymethod;?> 
            <br/>
          </form>
          </center>
          
        
        </div>

      </div>
      <div class="clearfix mt-4">
              <?php if($levelid == 2 || $levelid ==1){  ?>
                  <button class="btn btn-primary float-mid text-uppercase shadow-sm" onclick="printForm()">IN PHIẾU</button>
              <?php } ?>
              <?php if($levelid ==1 || $levelid ==2 ){  ?>
                  <button class="btn btn-primary float-mid text-uppercase shadow-sm" onclick="click_edit()">SỬA ĐƠN</button>

              <?php } ?>

              <button class="btn btn-primary float-right text-uppercase shadow-sm" onclick="window.history.back();">QUAY LẠI</button>
            </div>
    </div>
    <script>
    function printForm() {
        var form = document.getElementById("myForm");
        var printWindow = window.open('', '_blank');
        var formContent = form.outerHTML;
        var styles = document.head.innerHTML;
        var footer = "Mọi thông tin vui lòng liên hệ lillyflower để được hỗ trợ.";
        var sodienthoai = "Số Điện Thoại: 0974 9999 08";
        var website = "Website: www.lillyflower.com.vn";
        var address = "Địa chỉ: 593 Trần Hưng Đạo, Quận 1, HCM";

        var printDocument = printWindow.document;
        printDocument.open();
        printDocument.write('<html><head>' + styles + '<center><img src="https://banhang.lillyflower.com.vn/admin/img/logo.png" width=100px"><h2 style="font-size:28px">Biên Nhận</h2></center></head><body>');

        // Tạo một div để chứa hình ảnh và đặt phong cách để căn giữa
        var centerDiv = document.createElement("div");
        centerDiv.style.textAlign = "center";

        // Tạo một phần tử hình ảnh và đặt thuộc tính src và kích thước
        var imgElement = document.createElement("img");
        imgElement.src = "https://banhang.lillyflower.com.vn/admin/img/logo.png";

        // Đặt kích thước mới cho hình ảnh
        imgElement.style.width = "100px"; // Điều chỉnh kích thước theo nhu cầu của bạn

        // Thêm phần tử hình ảnh vào div ở giữa
        //centerDiv.appendChild(imgElement);
        //printDocument.body.appendChild(centerDiv);

        // Thêm nội dung của biểu mẫu
        printDocument.body.innerHTML += formContent;
        printDocument.body.innerHTML += '<br>';
        printDocument.body.innerHTML += '<div style="font-size: 10px;">' + footer + '</div>';
        printDocument.body.innerHTML += '<div style="font-size: 10px;">' + sodienthoai + '</div>';
        printDocument.body.innerHTML += '<div style="font-size: 10px;">' + website + '</div>';
        printDocument.body.innerHTML += '<div style="font-size: 10px;">' + address + '</div>';
        printDocument.write('</body></html>');
        printDocument.close();
        printWindow.print();
        printWindow.close();
    }

    function click_edit() {
    window.location.href = "../edit.php?id=<?php echo $id_bill; ?>";
    }
</script>



    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>

  <script  src="./script.js"></script>

</body>
</html>
