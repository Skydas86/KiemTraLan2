<?php
include "db.php";

session_start();
$maSV = "0123456789"; // Sinh viên mặc định

// Truy vấn thông tin sinh viên
$sql_sinhvien = "SELECT HoTen, GioiTinh, NgaySinh FROM DangKy dk JOIN SinhVien sv ON dk.MaSV = sv.MaSV WHERE dk.MaSV = ?";
$stmt_sinhvien = $conn->prepare($sql_sinhvien);
$stmt_sinhvien->execute([$maSV]);
$sinhvien = $stmt_sinhvien->fetch();

// Truy vấn học phần đã đăng ký
$sql = "SELECT ctdk.MaHP, hp.TenHP, hp.SoTinChi 
        FROM ChiTietDangKy ctdk 
        JOIN DangKy dk ON ctdk.MaDK = dk.MaDK 
        JOIN HocPhan hp ON ctdk.MaHP = hp.MaHP 
        WHERE dk.MaSV = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$maSV]);
$hocphans = $stmt->fetchAll();

// Tính tổng số tín chỉ đã đăng ký
$totalCredits = 0;
foreach ($hocphans as $hp) {
    $totalCredits += $hp['SoTinChi'];
}

// Tính số học phần đã đăng ký
$totalCourses = count($hocphans);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Học Phần Đã Đăng Ký</title>
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

        .info-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            width: 80%;
            text-align: center;
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

        .total-container {
            margin-top: 20px;
            font-size: 16px;
            text-align: center;
            font-weight: bold;
        }

        .student-info {
            margin-bottom: 20px;
        }

    </style>
</head>
<body>

    <h2>Học Phần Đã Đăng Ký</h2>

    <div class="table-container">
        <a href="hocphan.php" class="btn-back">Quay lại danh sách học phần</a>

        <table>
            <tr>
                <th>Mã HP</th>
                <th>Tên học phần</th>
                <th>Số tín chỉ</th>
                <th>Hủy đăng ký</th>
            </tr>
            <?php foreach ($hocphans as $hp) : ?>
                <tr>
                    <td><?= htmlspecialchars($hp['MaHP']) ?></td>
                    <td><?= htmlspecialchars($hp['TenHP']) ?></td>
                    <td><?= htmlspecialchars($hp['SoTinChi']) ?></td>
                    <td><a href="huydangky.php?MaHP=<?= urlencode($hp['MaHP']) ?>">Hủy</a></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="total-container">
            Tổng số học phần đã đăng ký: <?= $totalCourses ?><br>
            Tổng số tín chỉ đã đăng ký: <?= $totalCredits ?>
        </div>
    </div>

</body>
</html>
