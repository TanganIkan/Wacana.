<?php
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "majalah";

$conn = new mysqli($servername, $username, $password, $db_name);

if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}




$query = "select * from articles";
$result = mysqli_query($conn, $query);
$datas = [];
while($row = mysqli_fetch_assoc($result)){
  $datas[] = $row;
}




?>


