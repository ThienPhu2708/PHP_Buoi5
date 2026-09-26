<?php
require "connect.php";
$stmt = $conn->query("
    SELECT c.category_id, c.category_name, 
           SUM(od.quantity) AS total_quantity,
           SUM(od.quantity * od.price) AS total_revenue
    FROM categories c
    JOIN products p ON c.category_id = p.category_id
    JOIN order_details od ON p.product_id = od.product_id
    GROUP BY c.category_id, c.category_name
    ORDER BY total_revenue DESC
    LIMIT 1
");
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 11 - Loại hàng có doanh thu cao nhất</title>
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
    <h3>Bài 11: Loại hàng có doanh thu cao nhất</h3>
    <table>
        <thead>
            <tr>
                <th>Mã loại</th>
                <th>Tên loại hàng</th>
                <th>Số lượng SP đã bán</th>
                <th>Tổng doanh thu</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($result)): ?>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['category_id']); ?></td>
                        <td><strong><?php echo htmlspecialchars($row['category_name']); ?></strong></td>
                        <td><?php echo number_format($row['total_quantity']); ?> sản phẩm</td>
                        <td><strong><?php echo number_format($row['total_revenue'], 0, ',', '.'); ?> đ</strong></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">Không có dữ liệu</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>