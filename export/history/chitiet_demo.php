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
        #qrcode-container {
            text-align: center;
        }
  </style>

  <title>CHI TIẾT ĐƠN HÀNG- LILLY FLOWER</title>
  

</head>
<body>
<!-- partial:index.partial.html -->
<html>
  <head>
    <title>CHI TIẾT ĐƠN HÀNG</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
  </head>

  <body>
     
    <div class="container my-4">
      
      <center><p class="h2" id="bienhan">BIÊN NHẬN</p></center>
      <div class="card my-4 shadow">
        <div class="card-body">
          <?php 
            $id_bill = $_GET['id']; 
            $sql_pre = "SELECT * FROM billing WHERE status =1 AND id = '$id_bill'";
            $run_pre = $con->query($sql_pre);
            $row_pre = mysqli_fetch_array($run_pre);
            //$date_use = $row_pre['date_use']; 
              $date_ship = $row_pre['date_shipping'];
              $time_ship = $row_pre['time_shipping'];
              $day_ship = date("H:i - d/m/Y", strtotime("$date_ship $time_ship"));
              $fullname_customer = $row_pre['fullname_customer']; 
              $phone_customer = $row_pre['phone_customer']; 
              $fullname_receiver = $row_pre['fullname_receiver']; 
              $phone_receiver = $row_pre['phone_receiver']; 
              $address_receiver = $row_pre['address']; 
              $street_receiver = $row_pre['street']; 
              $ward_receiver = $row_pre['ward']; 
              $district_receiver = $row_pre['district']; 
              $city_receiver = $row_pre['city']; 
              $total_price = $row_pre['total_price']; 
              $shipping_price = $row_pre['shipping_price'];
              if($row_pre['all_price']==0){
                $all_price = $row_pre['total_price']; 
              }else{
                $all_price = $row_pre['all_price']; 
              }
              $pay_method = $row_pre['pay_method']; 
              $pay_status = $row_pre['pay_status']; 
              $status_ship = $row_pre['status_ship']; 
              $details = $row_pre['details']; 
          ?>
          <center>
          <form action="" method="post" id="myForm">
            
            <br/>
            <label for="field" class="font-weight-bold">Ngày Nhận Đơn:</label> <input type="hidden" name="date_use" value="<?php echo $date_use; ?>">
            <?php $day = date_format(date_create($date_use),"d/m/Y "); ?><?php echo $day; ?>
            <br/>
            <!-- Tên + SDT người đặt hoa -->
            <label for="field" class="font-weight-bold">Tên Người Đặt Hoa: </label><input type="hidden" name="fullname_customer" value="<?php echo $fullname_customer; ?>"><?php echo $fullname_customer;?> <br/> <label for="field" class="font-weight-bold">Số Điện Thoại: </label><input type="hidden" name="phone_customer" value="<?php echo $phone_customer; ?>"><?php echo "0".$phone_customer; ?>
            <br/><br/>
            <!-- Ngày Giao Đơn -->
            <label for="field" class="font-weight-bold">Ngày Giao Đơn:</label> <input type="hidden" name="date_ship" value="<?php echo $date_ship; ?>">
            <?php $day_ship; ?><?php echo $day_ship; ?>

            <br/>
              <!-- Tên + SDT người nhận hoa -->
            <label for="field" class="font-weight-bold">Tên Người Nhận Hoa: </label><input type="hidden" name="fullname_receiver" value="<?php echo $fullname_receiver; ?>"><?php echo $fullname_receiver; ?><br/>  <label for="field" class="font-weight-bold">Số Điện Thoại: </label><input type="hidden" name="phone_receiver" value="<?php echo $phone_receiver; ?>"><?php echo "0".$phone_receiver; ?>

            
            <br/>
            <!-- Địa chỉ giao hàng -->
            <br/>
            <label for="field" class="font-weight-bold">Địa Chỉ Giao Hàng: </label><br/>
            <input type="hidden" name="address_receiver" value="<?php echo $address_receiver; ?>">
            <input type="hidden" name="street_receiver" value="<?php echo $street_receiver; ?>">
            <input type="hidden" name="ward_receiver" value="<?php echo $ward_receiver; ?>">
            <input type="hidden" name="district_receiver" value="<?php echo $district_receiver; ?>">
            <input type="hidden" name="city_receiver" value="<?php echo $city_receiver; ?>">

            <?php echo $address_receiver.', Đường '.$street_receiver.', '.$ward_receiver.', <br/>'.$district_receiver.', '.$city_receiver; ?> 
            <br/><br/>
            <!-- Chi Tiết Đơn Hàng -->
            <label for="field" class="font-weight-bold">Chi Tiết Đơn Hàng: </label><input type="hidden" name="details" value="<?php echo $details; ?>"><?php echo $details;?> 
            <br/><br/>
            <!-- Thành tiền chưa VAT-->
            <label for="field" class="font-weight-bold">Giá Tiền (chưa VAT)(1): </label><input type="hidden" name="total_price" value="<?php echo $total_price; ?>"><?php echo ' '.number_format($total_price, 0, '', ',').' VNĐ';?> 
            <br/>
            <label for="field" class="font-weight-bold">Phí Vận Chuyển(2): </label><input type="hidden" name="shipping_price" value="<?php echo $shipping_price; ?>"><?php echo ' '.number_format($shipping_price, 0, '', ',').' VNĐ';?> 
            <br/>
            <label for="field" class="font-weight-bold">Tổng Đơn (chưa VAT)(1+2): </label><input type="hidden" name="all_price" value="<?php echo $all_price; ?>"><?php echo ' '.number_format($all_price, 0, '', ',').' VNĐ';?> 
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
            <br/><br/>
            <center>Mã Đơn Hàng: </center>
            <br/>
            <div id="qrcode-container">
              <div id="qrcode"></div> 
            </div>
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
        var qrcode = "Địa chỉ: 593 Trần Hưng Đạo, Quận 1, HCM";

        var printDocument = printWindow.document;
        printDocument.open();
        printDocument.write('<html><head>' + styles + '<center><img src="https://banhang.lillyflower.com.vn/admin/img/logo.png" width=200px"><h2 style="font-size:28px">Biên Nhận</h2></center></head><body>');

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
        printDocument.body.innerHTML += '<center>'+formContent+'</center>';
        printDocument.body.innerHTML += '<br>';
        printDocument.body.innerHTML += '<div style="font-size: 10px;"><center>' + footer + '</center></div>';
        printDocument.body.innerHTML += '<div style="font-size: 10px;"><center>' + sodienthoai + '</center></div>';
        printDocument.body.innerHTML += '<div style="font-size: 10px;"><center>' + website + '</center></div>';
        printDocument.body.innerHTML += '<div style="font-size: 10px;"><center>' + address + '</center></div>';
        printDocument.write('</body></html>');
        printDocument.close();
        printWindow.print();
        printWindow.close();
    }

    function click_edit() {
    window.location.href = "../edit.php?id=<?php echo $id_bill; ?>";
    }
</script>


    <script>
        // Tạo một đối tượng QRCode
        var qrcode = new QRCode(document.getElementById("qrcode"), {
            text: "<?php echo $id_bill; ?>", // Nội dung của QR code
            width: 60, // Chiều rộng của QR code
            height: 60// Chiều cao của QR code
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>

  <script  src="./script.js"></script>

</body>
</html>
