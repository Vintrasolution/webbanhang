<?php

session_start();
include_once('db.php');
 //kiem tra cookie xem da tôn tai chua
//neu chua thi minh ha dang nhap;
if(empty($_SESSION['username'])){
if(isset($cookie_name)){
if(isset($_COOKIE[$cookie_name])){
parse_str($_COOKIE[$cookie_name]);
$sql2="SELECT * FROM `login` WHERE username_login='$username' and password_login='".md5($password)."'";
$result2=mysql_query($sql2,$dbconect);
if($result2){
header('location:index.php');
exit;
}
}
}
}
else{
header('location:index.php');//chuyển qua trang đăng nhập thành công
exit;
}   
if(isset($_POST['submit'])){
$username=$_POST['username'];
$password=md5($_POST['password']);
$a_check=((isset($_POST['remember'])!=0)?1:"");
if($username=="" || $password==""){
echo "vui long dien day du thong tin";
exit;
}
else{
$sql="SELECT * FROM `login` WHERE username_login='$username' and password_login='".md5($password)."'";
echo $sql;
$result=mysql_query($sql,$dbconect);
if(!$result){
echo "loi cau truy van".mysql_error();
exit;
}
$row=mysql_fetch_array($result);
$f_user=$row['username'];
$f_pass=$row['password'];
if($f_user==$username && $f_pass==$password){
$_SESSION['username']=$f_user;
$_SESSION['password']=$f_pass;
if($a_check==1){
setcookie ($cookie_name, 'usr='.$f_user.'&hash='.$f_pass, time() + $cookie_time);
}
header('location:index.php');//chuyền qua trang đăng nhập thành công
exit;
}
}
}
?>
