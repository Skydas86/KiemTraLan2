<?php
session_start();
include "db.php";

$limit = 4;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Truy vấn danh sách sinh viên
$sql = "SELECT sv.*, nh.TenNganh FROM SinhVien sv JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh LIMIT $limit OFFSET $offset";
$stmt = $conn->prepare($sql);
$stmt->execute();
$sinhviens = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý Sinh viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

<h1 class="text-center text-primary">Quản lý Sinh viên</h1>

<!-- Thanh điều hướng -->
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Trang chủ</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <?php if (isset($_SESSION["user"])) : ?>
                    <li class="nav-item">
                        <span class="navbar-text me-3">Chào, <strong><?= $_SESSION["name"] ?></strong></span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-danger" href="logout.php">Đăng xuất</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="login.php">Đăng nhập</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Nút đăng ký học phần -->
<div class="text-center mb-4">
    <a class="btn btn-success" href="hocphan.php">📚 Đăng ký học phần</a>
</div>

<!-- Danh sách sinh viên -->
<h2 class="text-center">Danh sách Sinh viên</h2>
<div class="text-end mb-3">
    <a class="btn btn-primary" href="create.php">➕ Thêm Sinh viên</a>
</div>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>Mã SV</th>
            <th>Họ tên</th>
            <th>Giới tính</th>
            <th>Ngày sinh</th>
            <th>Ngành học</th>
            <th>Hình</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($sinhviens as $sv) : ?>
            <tr>
                <td><?= htmlspecialchars($sv['MaSV']) ?></td>
                <td><?= htmlspecialchars($sv['HoTen']) ?></td>
                <td><?= htmlspecialchars($sv['GioiTinh']) ?></td>
                <td><?= htmlspecialchars($sv['NgaySinh']) ?></td>
                <td><?= htmlspecialchars($sv['TenNganh']) ?></td>
                <td><img src="<?= htmlspecialchars($sv['Hinh']) ?>" width="50" class="img-thumbnail"></td>
                <td>
                    <a class="btn btn-info btn-sm" href="detail.php?MaSV=<?= urlencode($sv['MaSV']) ?>">👁️ Xem</a>
                    <a class="btn btn-warning btn-sm" href="edit.php?MaSV=<?= urlencode($sv['MaSV']) ?>">✏️ Sửa</a>
                    <a class="btn btn-danger btn-sm" href="delete.php?MaSV=<?= urlencode($sv['MaSV']) ?>" onclick="return confirm('Xóa sinh viên này?')">🗑️ Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Phân trang -->
<div class="text-center">
    <?php
    $stmt = $conn->prepare("SELECT COUNT(*) FROM SinhVien");
    $stmt->execute();
    $total = $stmt->fetchColumn();
    $totalPages = ceil($total / $limit);

    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<a class='btn btn-outline-primary mx-1' href='index.php?page=$i'>$i</a>";
    }
    ?>
</div>

</body>
</html>
