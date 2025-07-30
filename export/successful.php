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
  <title>BIÊN NHẬN - LILLY FLOWER</title>
  

</head>
<body>
<!-- partial:index.partial.html -->
<html>
  <head>
    <title>BIÊN NHẬN</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
  </head>

  <body>
      
    <div class="container my-4">
      <?php
            $id_prescription = $_GET['id']; 
      ?>
      <center><p class="h1">BIÊN NHẬN ĐƠN HÀNG</p></center>
      <div class="card my-4 shadow">
        <div class="card-body">
          <form action="" method="post">
            <p>Đơn hàng đã được tạo thành công!</p>
            <p>Trạng Thái Hiện Tại: <a style="color:blue; font-size:18px"><b>Chờ Cắm Hoa</b></a></p> 
            <p>Kiểm tra tiến độ Đơn Hàng: <a href="history/chitiet.php/?id=<?php echo $id_prescription; ?>">XEM NGAY</a></p>
            <div class="clearfix mt-4">
              <button type="submit" name="submit" value="3" class="btn btn-primary float-left text-uppercase shadow-sm" formaction="../export/">THÊM MỚI</button>
              <button type="submit" name="submit" value="3" class="btn btn-primary float-left text-uppercase shadow-sm" formaction="/admin/index.php" style="margin-left: 10px;">TRANG CHỦ</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>

  <script  src="./script.js"></script>

</body>
</html>
