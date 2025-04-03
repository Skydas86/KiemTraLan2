<?php
include "db.php";

session_start();
$maSV = "0123456789"; // Sinh viên mặc định

if (!isset($_GET["MaHP"])) {
    die("Không có học phần nào được chọn!");
}

$maHP = $_GET["MaHP"];

// Tìm MaDK của sinh viên
$stmt = $conn->prepare("SELECT MaDK FROM DangKy WHERE MaSV = ?");
$stmt->execute([$maSV]);
$maDK = $stmt->fetchColumn();

if ($maDK) {
    // Xóa học phần khỏi ChiTietDangKy
    $stmt = $conn->prepare("DELETE FROM ChiTietDangKy WHERE MaDK = ? AND MaHP = ?");
    $stmt->execute([$maDK, $maHP]);

    echo "Đã hủy học phần! <a href='hocphan_dadangky.php'>Xem danh sách</a>";
} else {
    echo "Không tìm thấy đăng ký của sinh viên!";
}
?>
