<?php
	include "database.php";
	include "auth.php";
	$user = $_SESSION["username"];

		$sql = "SELECT * FROM user WHERE `username`='$user' ";

		$run_sql = mysqli_query($conn,$sql);

		$row = mysqli_fetch_array($run_sql);

?>