<html>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
		<meta charset="UTF-8">
		<title>Danh Sách Tài Khoản | LillyFlower</title>
<style type="text/css">

th, td {
  text-align: left;
  padding: 8px;
}
th{
	padding-left: 10px;
      padding-top: 10px;
      padding-bottom: 10px;
      padding-right: 10px;
      font-size: 14px;
      color: white;
      background-color: #7B77FC;
      white-space: nowrap;
}
td {
      padding-left: 10px;
      padding-top: 10px;
      padding-bottom: 10px;
      padding-right: 10px;
      font-size: 13px;
      white-space: nowrap; 
      overflow: hidden;
      text-overflow: ellipsis; 
    }
table {
        width: 100%;
        overflow-x: auto;
      }
tr:nth-child(even){background-color: #f2f2f2}
</style>
              
<meta charset="utf-8">
  
  <?php 
        include "../../header.php"; 
        include "../../level_user.php";
  ?>
 <script src="jquery-3.2.1.min.js"></script>
<?php 
	$sql = "SELECT * FROM user";
	$run = mysqli_query($con,$sql);
?>
<center>
	<?php 
		$date_created = $row_name_sick['date_created'];
		$show_date = date_format(date_create($date_created),'d-m-Y');
	?>
	<div class="container my-4" style="max-width: 100%;">
		<center><p class="h3">DANH SÁCH TÀI KHOẢN</p></center>
		<p style="text-align: right;color: red">Cập nhật ngày: <?php echo $show_date; ?></p>
    <p style="text-align: right;"><button class="btn btn-primary float-center text-uppercase shadow-sm" onclick="window.location.href='/admin/tools/create-staff/'">Thêm Tài Khoản</button></p>
      <div class="card my-4 shadow" style="overflow-x:auto;">
        <div class="card-body">

          <form action="" method="post">
            <table border="1" style="width:100%;">
							<tr class="table table-bordered">
								<th >STT</th>
								<th >Họ và Tên</th>
								<th >Tài Khoản</th>
								<th >Phân Quyền</th>
								<th >Tình Trạng</th>
								<th >Công Cụ</th>
							</tr>

							<?php $a= '0'; foreach($run as $row){ $a++;
								$status_user = $row['status'];
								if($status_user==1){
									$status = "<a style='color:green'>Hoạt Động</a>";
								}else {
									$status = "<a style='color:red'>Đã Khoá</a>";
								}
                //Lấy Tên phân quyền
                $id_level = $row['id_level'];
                $sql_quyen = "SELECT * FROM level_user WHERE id = '$id_level'";
                $run_quyen = $con->query($sql_quyen);
                $row_quyen = mysqli_fetch_array($run_quyen);
                $level_name = $row_quyen['level_name'];
								//GET DATE CREATE
								$date = $row_username["date_created"];
								$day = date_format(date_create($date),"d/m/Y ");
								$time = date_format(date_create($date),"H:i:s ");
								?>
							<tr>
								<td><?php echo $a ?></td>
								<td><?php echo $row['fullname']; ?></td>
								<td><?php echo $row['username']; ?></td>
								<td><?php echo $level_name;?></td>
								<td><?php echo $status;?></td>
								<!--<td><?php echo $time." - ".$day;?></td>-->
								<td> 
									<a href='edit-user.php?id=<?php echo $row['id'] ?>' style="color:blue;text-decoration: none">SỬA</a> 
									 |
									<?php if($status_user==1){ ?> 
									<span style="color:blue;"	 onClick="myFunction('<?php echo $row['id'] ?>')">KHOÁ</span>
								<?php } else {?>
									<span style="color:blue;"	 onClick="myFunction_open('<?php echo $row['id'] ?>')">MỞ</span>
								<?php } ?>

								</td>
			</tr>
	<?}?> 
	
</table>
</form>
</div>
</div>
<br/><br/>
<script>
						//Khoá Tài Khoản 
              function myFunction(id) {
                var r = confirm("Bạn đã chắc chắn khoá tài khoản chưa?");
                if (r == true) {
                   $.ajax({
                        url : "disablestatus.php",
                        type : "post",
                        dataType:"text",
                        data : {id : id},
                        success : function (result){
                          //alert (result);
                          if (result==1){
                            alert ("Khoá Tài Khoản Thành Công");
                            location.reload();
                          }
                          //$('#result').html(result);
                        }
                      });
                }
                else{
                  //
                }
              }
              //Mở khoá tài khoản
              function myFunction_open(id) {
                var r = confirm("Bạn đã chắc chắn mở khoá tài khoản chưa?");
                if (r == true) {
                   $.ajax({
                        url : "enablestatus.php",
                        type : "post",
                        dataType:"text",
                        data : {id : id},
                        success : function (result){
                          //alert (result);
                          if (result==1){
                            alert ("Mở Tài Khoản Thành Công");
                            location.reload();
                          }
                          //$('#result').html(result);
                        }
                      });
                }
                else{
                  //
                }
              }
</script>
