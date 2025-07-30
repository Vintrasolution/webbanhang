<?php
// Lấy số điện thoại từ yêu cầu Ajax
$codeCustomer = $_POST['code'];

include "../database.php";
$sql = "SELECT * FROM customer WHERE code LIKE '%$codeCustomer%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Trả về dữ liệu dưới dạng JSON
    $row = $result->fetch_assoc();

    // Thêm số 0 ở đầu nếu số điện thoại không có
    $formattedPhone = $row['phone'];
    if (!startsWithZero($formattedPhone)) {
        $formattedPhone = '0' . $formattedPhone;
    }
    echo json_encode(['success' => true, 'data' => [
        'fullname' => $row['fullname'], 
        'phone' => $formattedPhone
    ]]);
} else {
    echo json_encode(['success' => false]);
}

$conn->close();
// Hàm kiểm tra xem chuỗi có bắt đầu bằng số 0 không
function startsWithZero($str) {
    return substr($str, 0, 1) === '0';
}
?>
