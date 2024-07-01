<!DOCTYPE html>
<html>
<head>
    <title>รายงานรายรับ/รายจ่าย</title>
</head>
<body>
    <h2>รายงานรายรับ/รายจ่าย</h2>
    <form action="report.php" method="get">
        <label for="month">เลือกเดือน:</label><br>
        <input type="month" id="month" name="month"><br><br>
        <input type="submit" value="ดูรายงาน">
    </form>

    <?php
    if (isset($_GET['month'])) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "expenses_db";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $month = $_GET['month'];

        $stmt = $conn->prepare("SELECT type, SUM(amount) as total_amount FROM expenses WHERE DATE_FORMAT(expense_date, '%Y-%m') = ? GROUP BY type");
        $stmt->bind_param("s", $month);
        $stmt->execute();
        $result = $stmt->get_result();

        $income = 0;
        $expense = 0;

        while ($row = $result->fetch_assoc()) {
            if ($row['type'] == 'income') {
                $income = $row['total_amount'];
            } else {
                $expense = $row['total_amount'];
            }
        }

        $balance = $income - $expense;

        echo "<h3>รายงานประจำเดือน: " . date("F Y", strtotime($month)) . "</h3>";
        echo "รายรับ: " . number_format($income, 2) . " บาท<br>";
        echo "รายจ่าย: " . number_format($expense, 2) . " บาท<br>";
        echo "ยอดคงเหลือ: " . number_format($balance, 2) . " บาท<br>";

        $stmt->close();
        $conn->close();
    }
    ?>
    <br>
    <a href="home.html">บันทึกรายการรายรับ/รายจ่าย</a> <br>
    <a href="show_data.php">รายการรายรับ/รายจ่าย</a>
</body>
</html>
