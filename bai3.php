<?php
require "connect.php";
$stmt= $conn->query("
    SELECT c.category_name, COUNT(p.product_id) AS total_products
    FROM categories c
    JOIN products p ON c.category_id = p.category_id
    GROUP BY c.category_name
    HAVING COUNT(p.product_id) > 5  
");
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bai 3 - Tim loai hang co tren 5 san pham</title>

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
    <h3>Các loại hàng có trên 5 sản phẩm:</h3>
    <table >
        <thead>
            <tr>
                <th>Tên loại hàng</th>
                <th>Số lượng sản phẩm</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($result)):?>
            <?php foreach($result as $row):?>
                <tr>
                    <td><?php echo htmlspecialchars($row['category_name'])?></td>
                    <td><?php echo htmlspecialchars($row['total_products'])?></td>
                </tr>
            <?php endforeach;?>
        <?php else: ?>
            <tr>
                <td colspan="2">Khong co du lieu</td>
            </tr>
        <?php endif; ?>
    </tbody>
    </table>   
</body>
</html>



