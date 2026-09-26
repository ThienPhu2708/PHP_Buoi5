<?php
require "connect.php";
$stmt = $conn->query("
    SELECT p.product_id, p.name AS product_name, p.price, c.category_name, 
    COUNT(od.order_id) AS order_count
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.category_id
    LEFT JOIN order_details od ON p.product_id = od.product_id
    GROUP BY p.product_id, p.name, p.price, c.category_name
    ORDER BY order_count DESC, p.product_id ASC
");
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 12 - Tất cả sản phẩm và số lần được đặt hàng</title>
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
    <h3>Bài 12: Danh sách tất cả sản phẩm và số lần được đặt hàng</h3>
    <table>
        <thead>
            <tr>
                <th>Mã SP</th>
                <th>Tên sản phẩm</th>
                <th>Loại hàng</th>
                <th>Đơn giá</th>
                <th>Số lần được đặt hàng</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($result)): ?>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['product_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                        <td><?php echo number_format($row['price'], 0, ',', '.'); ?> đ</td>
                        <td><strong><?php echo htmlspecialchars($row['order_count']); ?></strong> lần</td>
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