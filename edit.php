<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu ảnh hiện tại
    $stmt = $conn->prepare("SELECT Hinh FROM SinhVien WHERE MaSV = ?");
    $stmt->execute([$_POST["MaSV"]]);
    $sinhvien = $stmt->fetch();

    // Kiểm tra nếu có file ảnh mới được tải lên
    if (isset($_FILES["Hinh"]) && $_FILES["Hinh"]["error"] == 0) {
        $target_dir = "img/"; // Thư mục lưu ảnh
        $target_file = $target_dir . basename($_FILES["Hinh"]["name"]);
        move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file); // Lưu ảnh vào thư mục

        $hinhPath = $target_file; // Đường dẫn ảnh mới
    } else {
        $hinhPath = $sinhvien["Hinh"]; // Nếu không upload ảnh mới, giữ nguyên ảnh cũ
    }

    // Cập nhật thông tin sinh viên
    $stmt = $conn->prepare("UPDATE SinhVien SET HoTen = ?, GioiTinh = ?, NgaySinh = ?, Hinh = ?, MaNganh = ? WHERE MaSV = ?");
    $stmt->execute([$_POST["HoTen"], $_POST["GioiTinh"], $_POST["NgaySinh"], $hinhPath, $_POST["MaNganh"], $_POST["MaSV"]]);
    header("Location: index.php");
}

// Lấy thông tin sinh viên cần chỉnh sửa
$stmt = $conn->prepare("SELECT * FROM SinhVien WHERE MaSV = ?");
$stmt->execute([$_GET["MaSV"]]);
$sinhvien = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật Thông tin Sinh viên</title>
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

        .form-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 400px;
            box-sizing: border-box;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        label {
            font-size: 16px;
            margin: 10px 0 5px;
            display: block;
            text-align: left;
        }

        input[type="text"], input[type="date"], select, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 20px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
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

        .preview {
            margin-top: 10px;
            text-align: center;
        }

        .preview img {
            max-width: 100%;
            max-height: 150px;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Cập nhật Thông tin Sinh viên</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="MaSV" value="<?= $sinhvien['MaSV'] ?>">

        <label for="HoTen">Họ tên:</label>
        <input type="text" name="HoTen" id="HoTen" value="<?= $sinhvien['HoTen'] ?>" required>

        <label for="GioiTinh">Giới tính:</label>
        <select name="GioiTinh" id="GioiTinh">
            <option value="Nam" <?= $sinhvien['GioiTinh'] == "Nam" ? "selected" : "" ?>>Nam</option>
            <option value="Nữ" <?= $sinhvien['GioiTinh'] == "Nữ" ? "selected" : "" ?>>Nữ</option>
        </select>

        <label for="NgaySinh">Ngày sinh:</label>
        <input type="date" name="NgaySinh" id="NgaySinh" value="<?= $sinhvien['NgaySinh'] ?>" required>

        <label for="Hinh">Hình ảnh:</label>
        <input type="file" name="Hinh" id="Hinh" accept="image/*">
        <div class="preview">
            <p>Ảnh hiện tại:</p>
            <?php if (!empty($sinhvien['Hinh'])): ?>
                <img src="<?= $sinhvien['Hinh'] ?>" alt="Hình ảnh sinh viên">
            <?php else: ?>
                <p>Chưa có ảnh</p>
            <?php endif; ?>
        </div>

        <label for="MaNganh">Ngành học:</label>
        <input type="text" name="MaNganh" id="MaNganh" value="<?= $sinhvien['MaNganh'] ?>" required>

        <input type="submit" value="Cập nhật">
    </form>
    <a href="index.php" class="back-link">Quay lại</a>
</div>

</body>
</html>
