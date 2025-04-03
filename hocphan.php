<?php
include "db.php";

$sql = "SELECT * FROM HocPhan";
$stmt = $conn->prepare($sql);
$stmt->execute();
$hocphans = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách Học Phần</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            margin: 0;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .table-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 80%;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .btn-back {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
        }

        .btn-back:hover {
            background-color: #45a049;
        }

        .link-container {
            margin-top: 20px;
            text-align: center;
        }

    </style>
</head>
<body>

    <h2>Danh sách Học Phần</h2>

    <div class="link-container">
        <a href="hocphan_dadangky.php">Xem học phần đã đăng ký</a>
    </div>

    <div class="table-container">
        <table>
            <tr>
                <th>Mã HP</th>
                <th>Tên học phần</th>
                <th>Số tín chỉ</th>
                <th>Đăng ký</th>
            </tr>
            <?php foreach ($hocphans as $hp) : ?>
                <tr>
                    <td><?= htmlspecialchars($hp['MaHP']) ?></td>
                    <td><?= htmlspecialchars($hp['TenHP']) ?></td>
                    <td><?= htmlspecialchars($hp['SoTinChi']) ?></td>
                    <td><a href="dangky.php?MaHP=<?= urlencode($hp['MaHP']) ?>">Đăng ký</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="link-container">
        <a href="index.php" class="btn-back">Quay về trang chủ</a>
    </div>

</body>
</html>
