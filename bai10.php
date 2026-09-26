<?php
require "connect.php";
$stmt = $conn->query("
    SELECT c.customer_id, c.name, c.email, 
           SUM(od.quantity * od.price) AS total_spent
    FROM customers c
    JOIN orders o ON c.customer_id = o.customer_id
    JOIN order_details od ON o.order_id = od.order_id
    GROUP BY c.customer_id, c.name, c.email
    ORDER BY total_spent DESC
    LIMIT 5
");
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 10 - 5 khách hàng chi tiêu nhiều nhất</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h3>Bài 10: Danh sách 5 khách hàng chi tiêu nhiều nhất</h3>
    <table>
        <thead>
            <tr>
                <th>Hạng</th>
                <th>Mã KH</th>
                <th>Tên khách hàng</th>
                <th>Email</th>
                <th>Tổng chi tiêu</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($result)): ?>
                <?php $rank = 1; foreach ($result as $row): ?>
                    <tr>
                        <td><strong>#<?php echo $rank++; ?></strong></td>
                        <td><?php echo htmlspecialchars($row['customer_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><strong><?php echo number_format($row['total_spent'], 0, ',', '.'); ?> đ</strong></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Không có dữ liệu</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>