<?php

	//echo 666666666666;

	require("database.php");

	$id = $_POST['id'];

		$sql = "UPDATE `medicines` SET `status` = '1' WHERE `id` = $id ";

		mysqli_query($conn,$sql);

		echo "1";

	

//

exit;
?>

