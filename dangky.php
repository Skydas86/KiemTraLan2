<?php
include "db.php";

session_start();
$maSV = "0123456789"; // Sinh viên mặc định (có thể thay bằng session nếu có đăng nhập)

if (!isset($_GET["MaHP"])) {
    die("Không có học phần nào được chọn!");
}

$maHP = $_GET["MaHP"];

// Kiểm tra nếu sinh viên đã có trong bảng DangKy
$stmt = $conn->prepare("SELECT MaDK FROM DangKy WHERE MaSV = ?");
$stmt->execute([$maSV]);
$maDK = $stmt->fetchColumn();

if (!$maDK) {
    // Nếu chưa có, tạo một bản ghi mới trong bảng DangKy
    $stmt = $conn->prepare("INSERT INTO DangKy (NgayDK, MaSV) VALUES (NOW(), ?)");
    $stmt->execute([$maSV]);
    $maDK = $conn->lastInsertId();
}

// Kiểm tra sinh viên đã đăng ký học phần này chưa
$stmt = $conn->prepare("SELECT * FROM ChiTietDangKy WHERE MaDK = ? AND MaHP = ?");
$stmt->execute([$maDK, $maHP]);

if ($stmt->rowCount() > 0) {
    die("Bạn đã đăng ký học phần này rồi!");
}

// Thêm vào bảng ChiTietDangKy
$stmt = $conn->prepare("INSERT INTO ChiTietDangKy (MaDK, MaHP) VALUES (?, ?)");
$stmt->execute([$maDK, $maHP]);

echo "Đăng ký thành công! <a href='hocphan_dadangky.php'>Xem học phần đã đăng ký</a>";
?>
