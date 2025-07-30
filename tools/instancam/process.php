<?php
include "../../database.php";
// Lấy ID từ request POST
$id = $_POST['id'];

// Truy vấn thông tin từ cơ sở dữ liệu (thay đổi truy vấn của bạn)
$sqll = "SELECT * FROM billing WHERE id = '$id'";
$result = $conn->query($sqll);

// Kiểm tra và xử lý kết quả truy vấn
if ($result->num_rows > 0) {
    // Lấy dữ liệu từ kết quả truy vấn
    $row = $result->fetch_assoc();
    if($row['status_ship']==1){
        $status_shippping = "Chưa Giao Hàng";
    }else if($row['status_ship']==5){
        $status_shippping= "Đã Giao Hàng";
    }
    //Get URL Image
    $get_url = "SELECT * FROM billing_image WHERE id_billing ='$id'";
    $run_get_url = $conn->query($get_url);
    $row_get_url = mysqli_fetch_array($run_get_url);
    $full_url ="https://banhang.lillyflower.com.vn/admin/export/".$row_get_url['url']; 
    // Định dạng dữ liệu theo định dạng bạn muốn
    $responseData = array(
        'success' => true,
        'customerName' => $row['fullname_customer'],
        'phoneNumber' => $row['phone_customer'],
        'deliveryAddress' => $row['address'],
        'deliveryAddress1' => $row['street'],
        'deliveryAddress2' => $row['ward'],
        'deliveryAddress3' => $row['district'],
        'deliveryAddress4' => $row['city'],
        'amountDue' => $row['all_price'],
        'statusShipping' => $status_shippping,
        'idBilling' => $row['id'],
        'idStatusShipping' => $row['status_ship'],
        'Urlimage' => $full_url,


    );

    // Trả về dữ liệu dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($responseData);
} else {
    // ID không tồn tại trong cơ sở dữ liệu
    $responseData = array(
        'success' => false,
        'message' => 'ID không tồn tại',
        //'message' => '$sqll',
    );

    // Trả về dữ liệu dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($responseData);
}

// Đóng kết nối
$conn->close();
?>
