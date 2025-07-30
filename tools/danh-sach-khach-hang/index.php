<html>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
		<meta charset="UTF-8">
		<title>Danh Sách Khách Hàng</title>
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

//$masogiasuc = $_GET['masogiasuc'];
//GET Medicines
	/*$id_farm = $row_staff['id_farm'];
	if($levelid!=1){
		$sql = "SELECT * FROM custormer WHERE `id_farm` LIKE '$id_farm' ORDER BY id_farm ASC";
	}else {
		$sql = "SELECT * FROM custormer ORDER BY date_create ASC";
	}*/
	$sql = "SELECT * FROM customer";
	$run = mysqli_query($con,$sql);

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
	
	<!--<form action="" method="GET">
		<p><b>Lựa Chọn Bệnh:</b> 
		<select name="id_sick" style=" height: 25px; width: 15%;">
					<?php if(isset($_GET['id_sick'])){?>
	                 <option value=''><?php echo $row_name_sick['name_sick'] ?></option>
	                 <?}else{?>
	                 	<option value=''>Chọn bệnh</option>
	                 <?php }?>
	                 <?php 
	                 include "database.php";
	                 $sql_sick="SELECT * FROM sicks";
	                 $run_sick = $conn->query($sql_sick);
	                 while ($row_sick = mysqli_fetch_array($run_sick)){ ?>
	                      <option name="id_sick" value='<?php echo $row_sick["id"] ?>'><?php echo $row_sick["name_sick"] ?></option>
	                 <?php } ?>
	             
	     </select>
     </p>
     <button class="btn btn-success">Lọc</button>
     <?php if(isset($_GET['alert'])){echo "<p style='color:green; text-align:center'>ĐÃ THÊM THÀNH CÔNG</p>";}else{echo "";}?>
     <?php $id_s = $_GET['id_sick']; ?>
     <br/><br/>
    <p style="text-align: right; font-size:18px" >
    	<?php if(isset($id_s)){?><a class="buttons" href="/admin/tools/insert-medicine/?id_sick=<?php echo $id_s?> " style="text-decoration: none; color: green"><b>Thêm Thuốc</b></a> <?php }else{?><a class="buttons" href="/admin/tools/insert-medicine/" style="text-decoration: none; color: green;text-align: right"><b>Thêm Thuốc</b></a> <?php }?>| <a class="buttons" href="/admin/tools/insert-sick/" style="text-decoration: none; color: green"><b>Thêm Bệnh</b></a>

    </p>
	</form>-->
	<div class="container my-4" style="max-width: 100%;">
		<center><p class="h3">DANH SÁCH KHÁCH HÀNG</p></center>
		<p style="text-align: right;color: red">Cập nhật ngày: <?php echo $show_date; ?></p>
      <div class="card my-4 shadow" style="overflow-x:auto;">
        <div class="card-body">
          <form action="" method="post">
            <table border="1" style="width:100%;">
							<tr class="table table-bordered">
								<th >STT</th>
								<th >Mã KH</th>
								<th >Tên KH</th>
								<th >Số Điện Thoại</th>
								<th >Tình Trạng</th>
								<th >Công Cụ</th>
							</tr>

							<?php $a= '0'; foreach($run as $row){ $a++;
								//GET FARM
								$farm_id = $row['id_farm'];
								$sql_farm_name = "SELECT * FROM farm WHERE code_farm ='$farm_id'";
								$run_farm_name = mysqli_query($con,$sql_farm_name);
								$row_farm_name = mysqli_fetch_array($run_farm_name);
								$farm_name = $row_farm_name['name'];

								//GET FullName
								$fullname = $row['fullname'];
								//GET ID Staff
								$id_staff = $row['id'];
								//GET STATUS
								$status_user = $row['status'];
								if($status_user==1){
									$status = "<a style='color:green'>Hoạt Động</a>";
								}else {
									$status = "<a style='color:red'>Đã Khoá</a>";
								}
								//GET DATE CREATE
								$date = $row_username["date_created"];
								$day = date_format(date_create($date),"d/m/Y ");
								$time = date_format(date_create($date),"H:i:s ");
								?>
							<tr>
								<td><?php echo $a ?></td>
								<td><?php echo $row['code']; ?></td>
								<td><?php echo $fullname; ?></td>
								<td><?php echo $row['phone'];?></td>
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
