<html>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
<style>
table {
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td {
  text-align: left;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2}
</style>
              
<meta charset="utf-8">
  <title>Danh Sách Thuốc Chữa Trị | Anova Agri</title>
  <?php 
        include "../../header.php"; 
        include "../../level_user.php";
  ?>
 <script src="jquery-3.2.1.min.js"></script>
<?php 
include 'database.php';

//$masogiasuc = $_GET['masogiasuc'];
//GET Medicines
if(isset($_GET['id_sick'])){
	$sick_id = $_GET['id_sick'];
	$sql = "SELECT * FROM medicines WHERE `status`='0' AND `id_sicks`= '$sick_id' ORDER BY id_sicks DESC ";
	$sql_name_sick="SELECT * FROM sicks WHERE `id`='$sick_id'";
	$run_name_sick = $conn->query($sql_name_sick);
	$run = mysqli_query($conn,$sql);
	$row_name_sick = mysqli_fetch_array($run_name_sick);
}
else{
	$sql = "SELECT * FROM medicines WHERE `status`='0' ORDER BY id_sicks DESC ";
	$run = mysqli_query($conn,$sql);
}


/*date_default_timezone_set("Asia/Bangkok");
$datecheck = date_format(date_create(),"Y-m-d H:i:s");
$day = date_format(date_create($date),"d-m-Y ");
$time = date_format(date_create($date),"H:i:s ");*/

?>
<center>
	<b><span style="font-size: 23px">DANH SÁCH THUỐC CHỮA TRỊ</span> </b><br/><br/>
	<p style="text-align: right;color: red">Cập nhật ngày: 30-07-2021</p>
	<form action="" method="GET">
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
	</form>
	
<div style="overflow-x:auto;">
<table class="table-responsive" border="2" style="font-size:16px">
	<tr class="table table-bordered">
		<td width="5%"><Strong>STT</Strong></td>
		<td width="20%"><Strong>Tên Bệnh</Strong></td>
		<td width="20%"><Strong>Tên Thuốc</Strong></td>
		<td width="15%"><Strong>Liều Lượng</Strong></td>
		<td width="32%"><Strong>HDSD</Strong></td>
		<td width="8%"><Strong>Công Cụ</Strong></td>
	</tr>
	<?php foreach($run as $row){
		//GET SICKS
		$id_sicks = $row['id_sicks'];
		$sqlsick = "SELECT * FROM `sicks` WHERE `id`='$id_sicks'";
		$runsick = mysqli_query($conn,$sqlsick);
		$rowsick = mysqli_fetch_array($runsick);
		//GET MEDICINES
		/*$id_medicine = $row['id_medicines'];
		$sqlme = "SELECT * FROM `medicines` WHERE `id`='$id_medicine'";
		$runme = mysqli_query($conn,$sqlme);
		$rowme = mysqli_fetch_array($runme);

		//GET WORKER
		$id_worker = $row['id_worker'];
		$sqlworker = "SELECT * FROM `worker` WHERE `id`='$id_worker'";
		$runworker = mysqli_query($conn,$sqlworker);
		$rowworker = mysqli_fetch_array($runworker);*/

		//GET TIME TODAY?>
			<tr>
				<td><?php echo $row['id'] ?></td>
				<td><?php echo $rowsick['name_sick'] ?></td>
				<td><?php echo $row['name_medicine']?></td>
				<td><?php echo $row['dosage']?></td>
				<td><?php echo $row['user_guide']?></td>
				<td> 
					<a href='edit-medicines.php?id=<?php echo $row['id'] ?>' style="color:blue;text-decoration: none">SỬA</a> 
					 | 
					<span style="color:blue;"	 onClick="myFunction('<?php echo $row['id'] ?>')">XÓA</span>

				</td>
			</tr>
	<?}?> 
	
</table>
</div>
<br/><br/>
<script>
	//Loại bỏ Mã Số Gia Súc không Gieo
              function myFunction(id) {
                var r = confirm("Bạn có chắc chưa?");
                if (r == true) {
                   $.ajax({
                        url : "disablestatus.php",
                        type : "post",
                        dataType:"text",
                        data : {id : id},
                        success : function (result){
                          //alert (result);
                          if (result==1){
                            alert ("Loại Bỏ Thành Công");
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
