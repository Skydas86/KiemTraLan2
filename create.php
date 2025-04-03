<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra nếu có file ảnh được tải lên
    if (isset($_FILES["Hinh"]) && $_FILES["Hinh"]["error"] == 0) {
        $target_dir = "img/"; // Thư mục lưu ảnh
        $target_file = $target_dir . basename($_FILES["Hinh"]["name"]);
        move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file); // Lưu file ảnh vào thư mục
        
        $hinhPath = $target_file; // Đường dẫn ảnh để lưu vào DB
    } else {
        $hinhPath = ""; // Nếu không có ảnh, lưu chuỗi rỗng
    }

    // Thực hiện INSERT vào database
    $stmt = $conn->prepare("INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$_POST["MaSV"], $_POST["HoTen"], $_POST["GioiTinh"], $_POST["NgaySinh"], $hinhPath, $_POST["MaNganh"]]);
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sinh Viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 25px;
            width: 420px;
            box-sizing: border-box;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 15px;
        }

        label {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"], input[type="date"], select, input[type="file"] {
            width: calc(100% - 20px);
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
            display: block;
            margin-top: 5px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Thêm Sinh Viên</h2>
    <form method="POST" enctype="multipart/form-data"> <!-- Thêm enctype để hỗ trợ upload file -->
        <div class="form-group">
            <label for="MaSV">Mã SV:</label>
            <input type="text" name="MaSV" id="MaSV" required>
        </div>
        <div class="form-group">
            <label for="HoTen">Họ tên:</label>
            <input type="text" name="HoTen" id="HoTen" required>
        </div>
        <div class="form-group">
            <label for="GioiTinh">Giới tính:</label>
            <select name="GioiTinh" id="GioiTinh">
                <option value="Nam">Nam</option>
                <option value="Nữ">Nữ</option>
            </select>
        </div>
        <div class="form-group">
            <label for="NgaySinh">Ngày sinh:</label>
            <input type="date" name="NgaySinh" id="NgaySinh" required>
        </div>
        <div class="form-group">
            <label for="Hinh">Hình ảnh:</label>
            <input type="file" name="Hinh" id="Hinh" accept="image/*">
        </div>
        <div class="form-group">
            <label for="MaNganh">Ngành học:</label>
            <input type="text" name="MaNganh" id="MaNganh" required>
        </div>
        <input type="submit" value="Thêm">
    </form>
</div>

</body>
</html>
