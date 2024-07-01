<!DOCTYPE html>
<html>
<head>
    <title>รายการรายรับ/รายจ่าย</title>
</head>
<body>
    <h2>รายการรายรับ/รายจ่าย</h2>
    <form action="show_data.php" method="get">
        <label for="month">ค้นหาตามเดือน:</label><br>
        <input type="month" id="month" name="month"><br><br>
        <input type="submit" value="ค้นหา">
    </form>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "expenses_db";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');

    $stmt = $conn->prepare("SELECT * FROM expenses WHERE DATE_FORMAT(expense_date, '%Y-%m') = ?");
    $stmt->bind_param("s", $month);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<table border='1'>";
    echo "<tr><th>ประเภท</th><th>ชื่อรายการ</th><th>จำนวนเงิน</th><th>วันที่ใช้จ่าย</th><th>วันที่บันทึก</th><th>วันที่ปรับปรุงล่าสุด</th><th>แก้ไข</th><th>ลบ</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                
                <td>{$row['type']}</td>
                <td>{$row['item_name']}</td>
                <td>{$row['amount']}</td>
                <td>{$row['expense_date']}</td>
                <td>{$row['created_at']}</td>
                <td>{$row['updated_at']}</td>
                <td><a href='edit.php?id={$row['id']}'>แก้ไข</a></td>
                <td><a href='delete.php?id={$row['id']}'>ลบ</a></td>
              </tr>";
    }
    echo "</table>";

    $stmt->close();
    $conn->close();
    
    ?>
    <br>
    <a href="home.html">บันทึกรายการรายรับ/รายจ่าย</a>
    <br>
    <a href="report.php">แสดงรายงานรายการรายรับรายจ่ายตามเดือน</a>
</body>
</html>
