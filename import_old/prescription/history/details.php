<?php

    //echo 666666666666;
    require('../../../db.php');
    $id = $_POST['id'];
    $sql = "SELECT * FROM `prescription_log` WHERE `id_prescription` = $id ORDER BY `id` ASC";
    $run = $con->query($sql);
            foreach($run as $row){
            $id_user_process = $row['id_user_process'];
            $level = $row['level'];
            $sql_user ="SELECT * FROM user WHERE id_staff='$id_user_process'";
            $run_user = $con->query($sql_user);
            $row_user = mysqli_fetch_array($run_user);
            $id_staff = $row_user['id_staff'];
            $sql_staff = "SELECT * FROM staff WHERE id = '$id_staff'";
            $run_staff = $con->query($sql_staff);
            $row_staff = mysqli_fetch_array($run_staff);
            $fullname = $row_staff['fullname'];
            $time = $row['data_created'];
            $datecheck = date_format(date_create("$time"),"d/m/Y");
            $hourcheck = date_format(date_create("$time"),"H:i:s");
            echo "\n";
            if($level==1){
                echo "Thời gian giao:   ".$hourcheck." - ".$datecheck."\n";
                echo "NV giao:   ".$fullname."\n";
            }else{
                echo "Thời gian nhận:   ".$hourcheck." - ".$datecheck."\n";
                echo "NV nhận:   ".$fullname."\n";
            }
        }

exit;

?>
