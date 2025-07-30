 <?php
$servername = "localhost";
$username = "anovacorp_traiheo";
$password = "anovafarm@315";
$dbname = "anovacorp_traiheo";

// Create connection

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?> 