<?php
include "db.php";

$stmt = $conn->prepare("SELECT sv.*, nh.TenNganh FROM SinhVien sv JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh WHERE sv.MaSV = ?");
$stmt->execute([$_GET["MaSV"]]);
$sinhvien = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin Sinh viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .info-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 400px;
            box-sizing: border-box;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #555;
            margin: 10px 0;
        }

        .student-image {
            text-align: center;
            margin: 20px 0;
        }

        .student-image img {
            width: 150px;
            border-radius: 50%;
            border: 2px solid #ddd;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
            text-decoration: none;
            color: #4CAF50;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="info-container">
    <h2>Thông tin Sinh viên</h2>
    <p><strong>Mã SV:</strong> <?= $sinhvien['MaSV'] ?></p>
    <p><strong>Họ tên:</strong> <?= $sinhvien['HoTen'] ?></p>
    <p><strong>Giới tính:</strong> <?= $sinhvien['GioiTinh'] ?></p>
    <p><strong>Ngày sinh:</strong> <?= $sinhvien['NgaySinh'] ?></p>
    <p><strong>Ngành học:</strong> <?= $sinhvien['TenNganh'] ?></p>
    <div class="student-image">
        <img src="<?= $sinhvien['Hinh'] ?>" alt="Hình ảnh sinh viên">
    </div>
    <a href="index.php" class="back-link">Quay lại</a>
</div>

</body>
</html>
