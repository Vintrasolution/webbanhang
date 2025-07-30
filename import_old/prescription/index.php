<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php include "../../header.php"; ?>
  <title>Nhập Toa Thuốc - Anova Farm</title>
  

</head>
<body>
<!-- partial:index.partial.html -->
<html>
  <head>
    <title>Nhập Toa Thuốc</title>
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

      <center><p class="h3">Nhập Toa Thuốc</p></center>
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
            <label for="field" class="font-weight-bold">Trại</label>
            <p><?php echo $row_farm['name']; ?> </p>
          <form onsubmit="return validateForm()" action="preview.php" method="post" name="myForm">
            <!-- Ngày sử dụng toa thuốc -->
            <label for="field" class="font-weight-bold">Ngày Áp Dụng Toa Thuốc<a style="color:red">*</a></label> 
            <p><input type="date" name="date_use" class="form-control"></p>
            
            <label for="field" class="font-weight-bold">Nhà <a style="color:red">*</a></label>
            <!--Lấy Dữ Chuồng Trại-->
                <?php 
                    $sql_farmplace = "SELECT * FROM farm_place WHERE status =1 AND id_farm =$id_trai ORDER BY id ASC";
                    $run_farmplace = $con->query($sql_farmplace);
                ?>
                <select class="js-example-basic-multiple form-control js-example-placeholder-multiple" id="field" name="farmplace[]" multiple="multiple">
                  <?php while ($row_farmplace = mysqli_fetch_array($run_farmplace)){ ?>
                    <option name="farmplace[]" value='<?php echo $row_farmplace["id"] ?>'><?php echo $row_farmplace["name"] ?></option>
                  <?php } ?>
                </select>
                <br/><br/>
            <div class="form-group dynamic-field">
              <label class="font-weight-bold">Thuốc <a style="color:red">*</a></label>
              <!--Lấy Dữ Liệu Thuốc-->
                <?php 
                    $sql_medicine = "SELECT * FROM medicines WHERE status =1";
                    $run_medicine = $con->query($sql_medicine);
                ?>
                <input name="medicine[]" id="select-medicine" list="medicine-list" placeholder="Nhập Mã Thuốc..." class="form-control medicine-select"/>

                <datalist id="medicine-list">
                    <?php while ($row_medicine = mysqli_fetch_array($run_medicine)){ 
                      $id_med = $row_medicine["code_med"];
                      $unit_med = $row_medicine["unit"];
                      $sql_amount = "SELECT * FROM warehouse WHERE id_medicine='$id_med' AND id_farm='$id_trai' AND amount > 0";
                      $run_amount = mysqli_query($con,$sql_amount);
                      $row_amount = mysqli_fetch_array($run_amount);
                      $id_amount = $row_amount['id'];
                      $amount = $row_amount['amount'];
                      if($id_amount>0){
                  ?>
                    <option name="medicine[]" value='<?php echo $row_medicine["code_med"]." - ".$row_medicine["name"]?>'><?php echo "Số Lượng: ".$row_amount['amount']." ".$unit_med; ?></option>
                  <?php } }?>
                </datalist>
              <div class="result-container"></div>
            </div>
            
            <script>
                    $(document).ready(function(){

                        // Xử lý sự kiện khi bấm nút "Thêm"
                        $("#add-button").click(function() {
                            var $clone = $(".dynamic-field").last().clone();
                            $clone.find("input[type='number']").val(""); // reset giá trị của trường input
                            $clone.find(".result-container").html(""); // reset nội dung hiển thị kết quả
                            $clone.find(".medicine-select").val(""); // reset nội dung hiển thị kết quả
                            $clone.insertAfter(".dynamic-field:last");
                        });
                    // Xử lý sự kiện khi chọn một thuốc
                    $(document).on("change", ".medicine-select", function() {
                      var $this = $(this);
                      var selectedOption = $this.val();
                      var additionalData = {
                        idfarm: '<?php echo $id_trai;?>'
                      };
                      var $resultContainer = $this.parent().find(".result-container");

                      // Gửi Ajax request
                      $.ajax({
                        url: "get-data.php",
                        method: "POST",
                        data: {
                          selectedOption: selectedOption,
                          additionalData: additionalData
                        },
                        success: function(response){
                          $resultContainer.html(response);
                        },
                        error: function(xhr, status, error){
                          console.log(error);
                        }
                      });
                    });
                  });
                    $(document).ready(function() {
                        $('.js-example-basic-multiple').select2();
                    
                    $(".js-example-placeholder-multiple").select2({
                        placeholder: "Lựa Chọn Nhà ..."
                    });
                    });
                  </script>
            <div class="clearfix mt-4">
              <button type="button" id="add-button" class="btn btn-secondary float-left text-uppercase shadow-sm"><i class="fas fa-plus fa-fw"></i> Thêm</button>
              <button type="button" id="remove-button" class="btn btn-secondary float-left text-uppercase ml-1" disabled="disabled"><i class="fas fa-minus fa-fw"></i> Xoá</button>
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

    let date_use = document.forms["myForm"]["date_use"].value;
    let farmplace = document.forms["myForm"]["farmplace[]"].value;
    var medicine = document.getElementsByName('medicine[]');

    if (farmplace === "" && date_use === "") {
      alert("Vui Lòng Điền Đầy Đủ Thông Tin!");
      return false;
    }
    if(date_use===""){
      alert("Vui lòng điền NGÀY ÁP DỤNG!");
      return false;
   }
    if(farmplace===""){
      alert("Vui lòng điền NHÀ!");
      return false;
   }
   
   for (i=0; i<medicine.length; i++)
   {
     if (medicine[i].value === "")
     {
       alert('Vui lòng điền TÊN THUỐC!'); 
       return false;
     } else if (medicine[i].value !== ""){
        var amount = document.getElementsByName('amount[]');
        for (n=0; n<amount.length; n++)
        {
          if (amount[n].value === "")
           {
             alert('Vui lòng điền SỐ LƯỢNG THUỐC!'); 
             return false;
           } 
        }
     }

   }
  return true;
  }
</script>
  <script  src="./script.js"></script>
</body>
</html>
