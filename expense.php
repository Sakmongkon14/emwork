<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expenses_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$type = $_POST['type'];
$item_name = $_POST['item_name'];
$amount = $_POST['amount'];
$expense_date = $_POST['expense_date'];

$stmt = $conn->prepare("INSERT INTO expenses (type, item_name, amount, expense_date) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssds", $type, $item_name, $amount, $expense_date);

$stmt->execute();

echo "บันทึกข้อมูลสำเร็จ";


$stmt->close();
$conn->close();
?>
<br>

<a href="home.html">บันทึกรายการรายรับ/รายจ่าย</a> <br>
<a href="show_data.php">รายการรายรับ/รายจ่าย</a>

