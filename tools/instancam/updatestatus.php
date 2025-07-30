<?php
// Kết nối đến cơ sở dữ liệu (thay đổi thông tin kết nối của bạn)
$servername = "localhost";
$username = "lillyflower_banhang";
$password = "123456@IT";
$dbname = "lillyflower_banhang";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Get the ID and newStatus from POST data
$id = $_POST['id'];
//$newStatus = $_POST['newStatus'];

// Validate input
if (empty($id)) {
    $responseData = array('success' => false, 'message' => 'ID and newStatus are required.');
} else {
    // Update the status_ship in the database
    $sql = "UPDATE billing SET status_ship = 5 WHERE id = '$id'";
    if ($conn->query($sql) === TRUE) {
        // Successful update
        $responseData = array('success' => true, 'message' => 'Status updated successfully.');
    } else {
        // Error in the update
        $responseData = array('success' => false, 'message' => 'Error updating status_ship: ' . $conn->error);
    }
}

// Close the database connection
$conn->close();

// Chuyển hướng sau khi đảm bảo không có đầu ra HTTP nào khác đã được gửi
header("Location: ../index.php?idbill=$id");
?>
