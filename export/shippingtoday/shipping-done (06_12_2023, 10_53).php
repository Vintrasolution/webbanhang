<?php

	//echo 666666666666;

	require("../../database.php");

	$id = $_POST['id'];

		$sql = "UPDATE `user` SET `status` = '0' WHERE `id_staff` = $id ";

		mysqli_query($conn,$sql);

		$sql_staff = "UPDATE `staff` SET `status` = '0' WHERE `id` = $id ";

		mysqli_query($conn,$sql_staff);

		echo "1";

	

//

exit;
?>

