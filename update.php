<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expenses_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$type = $_POST['type'];
$item_name = $_POST['item_name'];
$amount = $_POST['amount'];
$expense_date = $_POST['expense_date'];

$stmt = $conn->prepare("UPDATE expenses SET type = ?, item_name = ?, amount = ?, expense_date = ? WHERE id = ?");
$stmt->bind_param("ssdsi", $type, $item_name, $amount, $expense_date, $id);

$stmt->execute();

echo "ปรับปรุงข้อมูลสำเร็จ";

$stmt->close();
$conn->close();
?>
