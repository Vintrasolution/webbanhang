<?php
use Phppot\DataSource;

require_once 'DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();
            
            $sql_resetmedecine = "DELETE FROM `medicines`";
            $sql_idresetmedecine = "ALTER TABLE `medicines` AUTO_INCREMENT = 1";
            $run_resetmedecine = $conn->query($sql_resetmedecine);
            $run_idresetmedicine= $conn->query($sql_idresetmedecine);
    
        //$dir = "*.csv";
        foreach (glob("upload/*.csv") as $filename) {
            echo "$filename size " . filesize($filename) . "\n";
            }
        
        $file = fopen($filename, "r");
        
        while (($column = fgetcsv($file, 10000, ";")) !== FALSE) {
            
            $code_med = "";
            if (isset($column[0])) {
                $code_med = mysqli_real_escape_string($conn, $column[0]);
            }
            $name = "";
            if (isset($column[1])) {
                $name = mysqli_real_escape_string($conn, $column[1]);
            }
            $unit = "";
            if (isset($column[2])) {
                $unit = mysqli_real_escape_string($conn, $column[2]);
            }

            $sqlInsert = "INSERT into `medicines` (code_med,name,unit,status)
                values (?,?,?,?)";

            $paramType = "ssss";
            $paramArray = array(
                $code_med,
                $name,
                $unit,
                1
            );
            $insertId = $db->insert($sqlInsert, $paramType, $paramArray);
            
            if (! empty($insertId)) {
                $type = "success";
                $message = "Đăng tải dữ liệu thành công!";
            } else {
                $type = "error";
                $message = "Có vấn đề trong quá trình đăng tải dữ liệu!";
            }
        }
?>