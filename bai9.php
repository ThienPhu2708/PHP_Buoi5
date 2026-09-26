<?php
require "connect.php";
$stmt = $conn->query("
    SELECT p.product_id, p.name AS product_name, c.category_name, p.price, 
           SUM(od.quantity) AS total_sold
    FROM products p
    JOIN categories c ON p.category_id = c.category_id
    JOIN order_details od ON p.product_id = od.product_id
    GROUP BY p.product_id, p.name, c.category_name, p.price
    ORDER BY total_sold DESC
    LIMIT 3
");
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 9 - Top 3 sản phẩm bán chạy nhất</title>
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
    <h3>Bài 9: Top 3 sản phẩm bán chạy nhất</h3>
    <table>
        <thead>
            <tr>
                <th>Hạng</th>
                <th>Mã SP</th>
                <th>Tên sản phẩm</th>
                <th>Loại hàng</th>
                <th>Đơn giá</th>
                <th>Số lượng bán ra</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($result)): ?>
                <?php $rank = 1; foreach ($result as $row): ?>
                    <tr>
                        <td><strong>#<?php echo $rank++; ?></strong></td>
                        <td><?php echo htmlspecialchars($row['product_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                        <td><?php echo number_format($row['price'], 0, ',', '.'); ?> đ</td>
                        <td><strong><?php echo number_format($row['total_sold']); ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Không có dữ liệu</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>