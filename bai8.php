<?php
require "connect.php";
$stmt = $conn->query("
    SELECT c.category_id, c.category_name, 
           COALESCE(SUM(od.quantity), 0) AS total_quantity, 
           COALESCE(SUM(od.quantity * od.price), 0) AS total_revenue
    FROM categories c
    LEFT JOIN products p ON c.category_id = p.category_id
    LEFT JOIN order_details od ON p.product_id = od.product_id
    GROUP BY c.category_id, c.category_name
    ORDER BY c.category_id ASC
");
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài 8 - Thống kê số lượng và doanh thu từng loại sản phẩm</title>
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
    <h3>Bài 8: Thống kê tổng số lượng đã bán và doanh thu của từng loại sản phẩm</h3>
    <table>
        <thead>
            <tr>
                <th>Mã loại</th>
                <th>Tên loại sản phẩm</th>
                <th>Tổng số lượng đã bán</th>
                <th>Tổng doanh thu</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($result)): ?>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['category_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                        <td><?php echo number_format($row['total_quantity']); ?></td>
                        <td><?php echo number_format($row['total_revenue'], 0, ',', '.'); ?> đ</td>
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