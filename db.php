<?php
$con = mysqli_connect("localhost","vintraso66ea_banhanglilly","NTVntv@999","vintraso66ea_banhanglilly");
mysqli_set_charset($con, 'UTF8');
$cookie_name = 'siteAuth';
$cookie_time = (3600 * 24); // 1 day
if (mysqli_connect_errno())
  {
  echo "Không thể kết nối đến MySQL: " . mysqli_connect_error();
  }
?>
