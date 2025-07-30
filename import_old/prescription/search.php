<?php

include "../../header.php"; 
// Lấy dữ liệu từ client
$query = $_POST['query'];

// Tạo truy vấn SQL để tìm kiếm các bản ghi gần giống với nội dung nhập vào
$sql = "SELECT * FROM medicines WHERE code_med LIKE '%$query%'";

// Thực thi truy vấn và lấy dữ liệu từ database
$result = mysqli_query($con, $sql);

// Tạo một mảng JSON chứa kết quả tìm kiếm
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Trả về kết quả tìm kiếm dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
