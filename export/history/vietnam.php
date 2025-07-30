<?php
// Đọc nội dung từ tệp JSON
$jsonData = file_get_contents('diagioihanhchinhvn.json');

// Giải mã JSON thành một mảng đa cấp
$data = json_decode($jsonData, true);

// Hàm để tìm thông tin dựa trên ID
function findInfoById($data, $cityId, $districtId, $wardId) {
    foreach ($data as $city) {
        if ($city['Id'] == $cityId) {
            foreach ($city['Districts'] as $district) {
                if ($district['Id'] == $districtId) {
                    foreach ($district['Wards'] as $ward) {
                        if ($ward['Id'] == $wardId) {
                            return $ward;
                        }
                    }
                }
            }
        }
    }
    return null;
}

// Thay đổi ID theo thông tin bạn muốn hiển thị
$cityId = '79'; // ID của thành phố
$districtId = '001'; // ID của quận
$wardId = '00001'; // ID của phường

// Tìm thông tin dựa trên ID
$wardInfo = findInfoById($data, $cityId, $districtId, $wardId);

if ($wardInfo !== null) {
    $wardName = $wardInfo['Name']; // Tên phường
    $wardLevel = $wardInfo['Level']; // Cấp phường

    // Tìm tên thành phố và quận tương ứng
    $cityName = '';
    $districtName = '';

    foreach ($data as $city) {
        if ($city['Id'] == $cityId) {
            $cityName = $city['Name']; // Tên thành phố
            foreach ($city['Districts'] as $district) {
                if ($district['Id'] == $districtId) {
                    $districtName = $district['Name']; // Tên quận
                    break;
                }
            }
            break;
        }
    }

    // In ra thông tin
    echo "Tên thành phố: $cityName<br>";
    echo "Tên quận: $districtName<br>";
    echo "Tên phường: $wardName<br>";
    echo "Cấp phường: $wardLevel<br>";
} else {
    echo "Không tìm thấy thông tin với ID cung cấp.";
}
?>
