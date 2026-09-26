<?php
REQUIRE "connect.php";
$stmt = $conn->query("
    SELECT c.customer_id, c.name, SUM(od.quantity *od.price) AS total_spent
    FROM customers c
    JOIN orders o ON c.customer_id = o.customer_id
    JOIN order_details od ON od.order_id = o.order_id
    GROUP BY c.customer_id, c.name
    HAVING total_spent >= 1000000
");
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bai4 - Danh sach khach hang va tong tien da mua hang</title>
    <style>
        th, td{
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th{
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h3>Danh sách khách hàng đã mua hàng trên 1tr</h3>
    <table>
        <thead>
            <tr>
                <th>Mã KH</th>
                <th>Tên khách hàng</th>
                <th>Tổng tiền đã mua</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($result)):?>
                <?php foreach($result as $row):?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['customer_id'])?></td>
                        <td><?php echo htmlspecialchars($row['name'])?></td>
                        <td><?php echo number_format($row['total_spent'])?></td>
                    </tr>
                <?php endforeach;?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Không có dữ liệu</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

