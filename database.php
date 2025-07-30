 <?php
$servername = "localhost";
$username = "vintraso66ea_banhanglilly";
$password = "NTVntv@999";
$dbname = "vintraso66ea_banhanglilly";

// Create connection

$conn = new mysqli($servername, $username, $password, $dbname);
mysqli_set_charset($conn, 'UTF8');

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?> 