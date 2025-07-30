<html>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous" />
		<meta charset="UTF-8">
<style type="text/css">

th, td {
  text-align: left;
  padding: 8px 8px 8px 8px;
}

tr:nth-child(even){background-color: #f2f2f2}
 table {
        /* CSS để bảng tự động thay đổi kích thước hoặc cuộn ngang theo nhu cầu */
        width: 100%;
        overflow-x: auto;
      }
th {
	background-color: #7B77FC;
	color: white;
	font-size: 14px;
}
td{
	font-size: 13px;
}
tr:nth-child(even){background-color: #f2f2f2}
    .pagination {
      display: inline-block;
    }

    .pagination a {
      color: black;
      float: left;
      padding: 5px 8px;
      text-decoration: none;
      transition: background-color .3s;
      border: 1px solid #ddd;
      margin: 0 2px;
      text-decoration: none;
    }

    .pagination a.active {
      background-color: #4CAF50;
      color: white;
      border: 1px solid #4CAF50;
      text-decoration: none;
    }
</style>
              
<meta charset="utf-8">
  
  <?php 
        include "../../header.php"; 
        include "../../level_user.php";
  ?>
 <script src="jquery-3.2.1.min.js"></script>
<?php 
include 'database.php';
//Phân Trang
                  $query = "SELECT COUNT(*) as total_records FROM warehouse";
                  $result = mysqli_query($con, $query);
                  $row = mysqli_fetch_assoc($result);
                  $totalRecords = $row['total_records'];
                  $recordsPerPage = 100;
                  $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                  if($_GET['page']==""){
                    $startIndex = 0;
                  }else{
                    $startIndex = ($currentPage - 1) * $recordsPerPage;
                  }
//$masogiasuc = $_GET['masogiasuc'];
//GET Medicines
	$id_farm = $row_staff['id_farm'];
	if($levelid !=1){
		$sql = "SELECT * FROM warehouse WHERE `id_farm` LIKE '$id_farm' ORDER BY id_farm ASC LIMIT $startIndex, $recordsPerPage";
	}else{
		$sql = "SELECT * FROM warehouse WHERE `id_farm` NOT LIKE '081' AND `id_medicine` NOT LIKE '0' ORDER BY id_farm ASC LIMIT $startIndex, $recordsPerPage";
	}
	
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
		<center><p class="h3">DANH SÁCH THUỐC</p></center>
		<p style="text-align: right;color: red">Cập nhật ngày: <?php echo $show_date; ?></p>
      <div class="card my-4 shadow" style="overflow-x:auto;">
        <div class="card-body">
          <form action="" method="post">
            <table border="1" style="width:100%;">
							<tr class="table table-bordered">
								<th >STT</th>
								<th style="white-space: nowrap; " >Trại</th>
								<th >Mã Thuốc</th>
								<th >Tên Thuốc</th>
								<th >Đơn Vị</th>
								<th >Tồn Kho</th>
								<!--<th >Công Cụ</th>-->
							</tr>

							<?php $a= '0'; foreach($run as $row){ $a++;
								//GET SICKS
								$farm_id = $row['id_farm'];
								$sql_farm_name = "SELECT * FROM farm WHERE code_farm ='$farm_id'";
								$run_farm_name = mysqli_query($con,$sql_farm_name);
								$row_farm_name = mysqli_fetch_array($run_farm_name);
								$farm_name = $row_farm_name['name'];
								//GET Farm
								$id_medicine = $row['id_medicine'];
								$sqlme = "SELECT * FROM `medicines` WHERE `code_med`='$id_medicine'";
								$runme = mysqli_query($con,$sqlme);
								$rowme = mysqli_fetch_array($runme);
								$name_med = $rowme['name'];
								$unit_med = $rowme['unit'];

								//GET AMOUNT
								$sql_amout = "SELECT * FROM `warehouse` WHERE `id_medicine`='$id_medicine' AND `id_farm`='$farm_id'";
								$run_amount = mysqli_query($con,$sql_amout);
								$row_amount = mysqli_fetch_array($run_amount);
								$amount_med = $row_amount['amount'];
								?>
							<tr>
								<td><?php echo $a ?></td>
								<td style="white-space: nowrap; "><?php echo $farm_name; ?></td>
								<td><?php echo $id_medicine; ?></td>
								<td><?php echo $name_med;?></td>
								<td><?php echo $unit_med;?></td>
								<td><?php echo $amount_med;?></td>
								<!--<td> 
					<a href='edit-medicines.php?id=<?php echo $row['id'] ?>' style="color:blue;text-decoration: none">SỬA</a> 
					 | 
					<span style="color:blue;"	 onClick="myFunction('<?php echo $row['id'] ?>')">XÓA</span>

				</td>-->
			</tr>
	<?}?> 
	
</table>
</form>
<?php 
            
            $totalPages = ceil($totalRecords / $recordsPerPage);
            $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
            $startIndex = ($currentPage - 1) * $recordsPerPage;
            $visiblePages = 5; // Number of page links to display
            $halfVisible = floor($visiblePages / 2); // Number of page links on each side of the current page

            $startPage = max(1, $currentPage - $halfVisible);
            $endPage = min($startPage + $visiblePages - 1, $totalPages);

            if ($endPage - $startPage + 1 < $visiblePages) {
                $startPage = max(1, $endPage - $visiblePages + 1);
            }
            
            echo "<div class='pagination justify-content-center'>";
            
            if ($startPage > 1) {
                echo "<a style='text-decoration:none' href='?page=1'>1</a> ";
                if ($startPage > 2) {
                    echo "<a style='text-decoration:none'>... </a>";
                }
            }

            for ($i = $startPage; $i <= $endPage; $i++) {
                if ($i == $currentPage) {
                    echo "<a style='text-decoration:none;background-color:#ddd'><strong >$i</strong></a>";
                } else {
                    echo "<a style='text-decoration:none' href='?page=$i'>$i</a> ";
                }
            }

            if ($endPage < $totalPages) {
                if ($endPage < $totalPages - 1) {
                    echo "<a style='text-decoration:none'>... </a>";
                }
                echo "<a  style='text-decoration:none'href='?page=$totalPages'>$totalPages</a> ";
            }
            
            echo "</div>";
            
          ?>
</div>
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
