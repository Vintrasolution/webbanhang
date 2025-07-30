<html>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
		<meta charset="UTF-8">
		<title>Login Event</title>
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
      /* Đặt các thuộc tính cho các ô trong bảng */
        white-space: nowrap; /* Ngăn chặn ngắt dòng */
        overflow: hidden; /* Ẩn nội dung dư thừa */
        text-overflow: ellipsis; /* Hiển thị dấu chấm ở cuối khi nội dung bị ẩn */
    }
table {
        /* CSS để bảng tự động thay đổi kích thước hoặc cuộn ngang theo nhu cầu */
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
include 'database.php';

//GET Medicines
	$id_farm = $row_staff['id_farm'];
	if($levelid==1){
		$sql_eventlog = "SELECT * FROM eventlog ORDER BY time_login DESC";
	}
	$run_eventlog = mysqli_query($con,$sql_eventlog);

/*date_default_timezone_set("Asia/Bangkok");
$datecheck = date_format(date_create(),"Y-m-d H:i:s");
$day = date_format(date_create($date),"d-m-Y ");
$time = date_format(date_create($date),"H:i:s ");*/

?>
<center>
	<?php 
		$date_created = $row_name_sick['date_created'];
		$show_date = date_format(date_create($date_created),'d-m-Y');
	?>
	
	<div class="container my-4" style="max-width: 100%;">
		<center><p class="h3">LOGIN EVENT</p></center>
		<p style="text-align: right;color: red">Cập nhật ngày: <?php echo $show_date; ?></p>
      <div class="card my-4 shadow" style="overflow-x:auto;">
        <div class="card-body">
          <form action="" method="post">
            <table border="1" style="width:100%;">
							<tr class="table table-bordered">
								<th >STT</th>
								<th >Trại</th>
								<th >Họ và Tên</th>
								<th >Tài Khoản</th>
								<th >Thời Gian Login</th>
							</tr>

							<?php $a= '0'; foreach($run_eventlog as $row_eventlog){ $a++;
								$id_user = $row_eventlog['id_user'];
								$sql_get_user = "SELECT * FROM user WHERE id = $id_user";
								$run_get_user = $con->query($sql_get_user);
								$row_get_user = mysqli_fetch_array($run_get_user);
								$id_staff = $row_get_user['id_staff'];

								//GET UserName
								$get_username = $row_get_user['username'];

								//GET FARM
								$sql_staff = "SELECT * FROM staff where id = $id_staff";
								$run_staff = $con->query($sql_staff);
								$row_staff = mysqli_fetch_array($run_staff);
								$farm_id = $row_staff['id_farm'];
								$fullname = $row_staff['fullname'];
								$sql_farm_name = "SELECT * FROM farm WHERE `code_farm` LIKE '$farm_id'";
								$run_farm_name = mysqli_query($con,$sql_farm_name);
								$row_farm_name = mysqli_fetch_array($run_farm_name);
								$farm_name = $row_farm_name['name'];

								//GET DATE CREATE
								$date = $row_eventlog["time_login"];
								$day = date_format(date_create($date),"d/m/Y ");
								$time = date_format(date_create($date),"H:i:s ");
								?>
							<tr>
								<td><?php echo $a ?></td>
								<td><?php echo $farm_name; ?></td>
								<td><?php echo $fullname; ?></td>
								<td><?php echo $get_username;?></td>
								<td><?php echo $time." - ".$day;?></td>
			</tr>
	<?}?> 
	
</table>
</form>
</div>
</div>
<br/><br/>
