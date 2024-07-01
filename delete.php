<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expenses_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM expenses WHERE id = ?");
$stmt->bind_param("i", $id);

$stmt->execute();

echo "ลบข้อมูลสำเร็จ";


$stmt->close();
$conn->close();
?>

<br>

<a href="home.html">บันทึกรายการรายรับ/รายจ่าย</a> <br>
<a href="show_data.php">รายการรายรับ/รายจ่าย</a>
