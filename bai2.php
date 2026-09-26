<?php
require "connect.php";
$stmt = $conn->query("
    SELECT o.order_date, SUM(od.quantity * od.price) AS total_revenue
    FROM orders o
    JOIN order_details od ON od.order_id = od.order_id
    GROUP BY o.order_date
");

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bai 2 - Tong doanh thu tung ngay</title>
    <style>
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body> 
    <table>
        <thead>
            <tr>
                <th>Ngày lập</th>
                <th>Tổng doanh thu</th>
            </tr>   
        </thead>
    <tbody>
        <?php if (!empty($result)): ?>
            <?php foreach ($result as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                    <td><?php echo number_format($row['total_revenue']); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="2">Không có dữ liệu doanh thu</td>
            </tr>
        <?php endif; ?>
    </tbody>

    </table>
</body>
</html>
