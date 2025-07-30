<?php 
	include "../header.php";

?>
<style type="text/css">
    th {
      padding-left: 10px;
      padding-right: 10px;
      padding-top: 8px;
      padding-bottom: 8px;
      #white-space: nowrap;
      font-size: 14px;
      color: white;
      background-color: #7B77FC;
      text-align: center;
    }
    td {
      padding-left: 10px;
      padding-right: 10px;
      padding-top: 10px;
      padding-bottom: 10px;
      #white-space: nowrap;
      font-size: 13px;
      word-break: nowrap;
      text-align: center;

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
        /* Đặt các quy tắc rớt dòng cho các thiết bị có màn hình rộng tối đa 480px */
      table {
        /* CSS để bảng tự động thay đổi kích thước hoặc cuộn ngang theo nhu cầu */
        width: 100%;
        overflow-x: auto;
      }
      td {
        /* Đặt các thuộc tính cho các ô trong bảng */
        white-space: nowrap; /* Ngăn chặn ngắt dòng */
        overflow: hidden; /* Ẩn nội dung dư thừa */
        text-overflow: ellipsis; /* Hiển thị dấu chấm ở cuối khi nội dung bị ẩn */
      }
    }

    .pagination a:hover:not(.active) {background-color: #ddd;}
  </style>
   <script src="jquery-3.2.1.min.js"></script>
  <header>
    <center><h2>BÁO CÁO LILLY FLOWER</h2></center>
  </header>
  <body>
    <main>
    <?php

      include "bieudodoanhso.php";
      echo "<br/>";
      include "thongtintrangthaidonhang.php";
      echo "<br/>";
      include "baocaotaichinh.php";
      echo "<br/>";
      include "baocaotaichinhnhap.php";
      echo "<br/>";
      $final_total = $totalRevenue-$totalRevenuen;
      if($final_total>0){
      echo "<strong style='font-size:25px'>TỔNG DOANH THU THỰC TẾ THÁNG "."$selectedMonth"."/"."$selectedYear"." :</strong>"."<span style='font-size:35px; color:green'>".number_format($final_total, 0, '', ',')."</span>";
      }else if($final_total<0){
        echo "<strong style='font-size:25px'>TỔNG DOANH THU THỰC TẾ THÁNG "."$selectedMonth"."/"."$selectedYear"." : </strong>"."<span style='font-size:35px; color:red'>".number_format($final_total, 0, '', ',')."</span>";
      }else{
        echo "<strong style='font-size:25px'>TỔNG DOANH THU THỰC TẾ THÁNG "."$selectedMonth"."/"."$selectedYear"." : </strong>"."<span style='font-size:35px; color:yellow'>".number_format($final_total, 0, '', ',')."</span>";
      }
      include "../footer.php";
    ?>
  </main>
</body>

