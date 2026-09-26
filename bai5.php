<?php
require "connect.php";
$stmt = $conn->query("
    SELECT c.category_name, p.name AS product_name, p.price
    FROM products p
    JOIN categories c ON p.category_id = c.category_id
    WHERE p.price = (
        SELECT MAX(p2.price)
        FROM products p2
        WHERE p2.category_id = p.category_id
    )
    ORDER BY c.category_name
");
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 5 - Sản phẩm có giá cao nhất trong từng loại hàng</title>
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
    <h3>Bài 5: Sản phẩm có giá cao nhất trong từng loại hàng</h3>
    <table>
        <thead>
            <tr>
                <th>Tên loại hàng</th>
                <th>Tên sản phẩm đắt nhất</th>
                <th>Giá bán</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($result)): ?>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td><?php echo number_format($row['price'], 0, ',', '.'); ?> đ</td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Không có dữ liệu</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>