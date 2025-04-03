<?php
include "db.php";

$stmt = $conn->prepare("DELETE FROM SinhVien WHERE MaSV = ?");
$stmt->execute([$_GET["MaSV"]]);

header("Location: index.php");
?>
