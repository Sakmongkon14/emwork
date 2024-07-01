<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "expenses_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM expenses WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $expense = $result->fetch_assoc();
} else if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $type = $_POST['type'];
    $item_name = $_POST['item_name'];
    $amount = $_POST['amount'];
    $expense_date = $_POST['expense_date'];

    $stmt = $conn->prepare("UPDATE expenses SET type = ?, item_name = ?, amount = ?, expense_date = ? WHERE id = ?");
    $stmt->bind_param("ssdsi", $type, $item_name, $amount, $expense_date, $id);

    if ($stmt->execute()) {
        echo "ปรับปรุงข้อมูลสำเร็จ";
    } else {
        echo "เกิดข้อผิดพลาดในการปรับปรุงข้อมูล: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

    echo "<br><a href='show_data.php'>กลับไปยังหน้ารายการ</a>";
    exit;
} else {
    echo "ไม่มี ID ที่จะทำการแก้ไข";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>แก้ไขรายการรายรับ/รายจ่าย</title>
</head>
<body>
    <h2>แก้ไขรายการรายรับ/รายจ่าย</h2>
    <form action="edit.php" method="post">
        <input type="hidden" name="id" value="<?php echo $expense['id']; ?>">

        <label for="type">ประเภท:</label><br>
        <select name="type" id="type">
            <option value="income" <?php echo $expense['type'] == 'income' ? 'selected' : ''; ?>>รายรับ</option>
            <option value="expense" <?php echo $expense['type'] == 'expense' ? 'selected' : ''; ?>>รายจ่าย</option>
        </select><br><br>

        <label for="item_name">ชื่อรายการใช้จ่าย:</label><br>
        <input type="text" id="item_name" name="item_name" value="<?php echo $expense['item_name']; ?>" required><br><br>

        <label for="amount">จำนวนเงิน:</label><br>
        <input type="number" step="0.01" id="amount" name="amount" value="<?php echo $expense['amount']; ?>" required><br><br>

        <label for="expense_date">วันที่ใช้จ่าย:</label><br>
        <input type="date" id="expense_date" name="expense_date" value="<?php echo $expense['expense_date']; ?>" required><br><br>

        <input type="submit" value="บันทึก">
    </form>
</body>
</html>
