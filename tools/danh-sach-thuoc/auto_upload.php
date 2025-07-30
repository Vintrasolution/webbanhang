<?php
use Phppot\DataSource;

require_once 'DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();
            
            $sql_resetmedecine = "DELETE FROM `dataload_erp`";
            $sql_idresetmedecine = "ALTER TABLE `dataload_erp` AUTO_INCREMENT = 1";
            $run_resetmedecine = $conn->query($sql_resetmedecine);
            $run_idresetmedicine= $conn->query($sql_idresetmedecine);
    
        //$dir = "*.csv";
        foreach (glob("upload/done/*.csv") as $filename) {
            echo "$filename size " . filesize($filename) . "\n";
            }
        
        $file = fopen($filename, "r");
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            
            $ORGANIZATIONNAME = "";
            if (isset($column[0])) {
                $ORGANIZATIONNAME = substr(mysqli_real_escape_string($conn, $column[0]),0,3);
            }
            $ITEMNUMBER = "";
            if (isset($column[1])) {
                $ITEMNUMBER = mysqli_real_escape_string($conn, $column[1]);
            }
            $ITEMDESCRIPTION = "";
            if (isset($column[2])) {
                $ITEMDESCRIPTION = mysqli_real_escape_string($conn, $column[2]);
            }
            $UOM = "";
            if (isset($column[3])) {
                $UOM = mysqli_real_escape_string($conn, $column[3]);
            }
            $ONHAND = "";
            if (isset($column[4])) {
                $ONHAND = mysqli_real_escape_string($conn, $column[4]);
            }
            
            /*$suckhoelancuoi = "";
            if (isset($column[15])) {

                $date_convert_suckhoecuoi = $column[15];
                $date_sk = date_format(date_create("$date_convert_suckhoecuoi "),"Y-m-d");
                if($date_convert_suckhoecuoi == ""){
                    $suckhoelancuoi = mysqli_real_escape_string($conn, "0000-00-00");
                }else{
                $suckhoelancuoi = mysqli_real_escape_string($conn, $date_sk);}
            }*/

            $sqlInsert = "INSERT into `dataload_erp` (ORGANIZATIONNAME,ITEMNUMBER,ITEMDESCRIPTION,UOM,ONHAND)
                values (?,?,?,?,?)";


              
            $paramType = "sssss";
            $paramArray = array(
                $ORGANIZATIONNAME,
                $ITEMNUMBER,
                $ITEMDESCRIPTION,
                $UOM,
                $ONHAND
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