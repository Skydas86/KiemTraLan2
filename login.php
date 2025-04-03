<?php
session_start();
include "db.php";

// Kiểm tra nếu người dùng đã đăng nhập, chuyển hướng đến trang chính
if (isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Truy vấn kiểm tra thông tin sinh viên
    $stmt = $conn->prepare("SELECT * FROM SinhVien WHERE MaSV = ? AND Password = ?");
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch();

    // Nếu thông tin đăng nhập hợp lệ
    if ($user) {
        $_SESSION["user"] = $user["MaSV"];  // Lưu mã sinh viên vào session
        $_SESSION["name"] = $user["HoTen"]; // Lưu tên sinh viên vào session
        header("Location: index.php"); // Điều hướng về trang chủ
        exit;
    } else {
        $error = "Sai mã sinh viên hoặc mật khẩu!"; // Hiển thị lỗi nếu sai thông tin
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 300px;
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .input-group label {
            display: block;
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .input-group input:focus {
            outline: none;
            border-color: #007BFF;
        }

        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        p.error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Đăng Nhập</h2>
    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST">
        <div class="input-group">
            <label for="username">Mã sinh viên:</label>
            <input type="text" name="username" required id="username">
        </div>
        <div class="input-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" required id="password">
        </div>
        <button type="submit">Đăng nhập</button>
    </form>
</div>

</body>
</html>
