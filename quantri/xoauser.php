<?php
include("ketnoi.php");
session_start();

if ($_SESSION['username'] == "pvkhanh" && $_SESSION['mk'] == "admin12345") {
    $id_user = $_GET['id_user'];

    $sql = "DELETE FROM users WHERE id_user = '$id_user'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        echo "<script>alert('Xoá thành viên thành công!');</script>";
        echo "<script>window.location.href = 'quantri.php?page_layout=danhsachuser';</script>";
    } else {
        echo "<script>alert('Lỗi khi xoá thành viên.');</script>";
    }
} else {
    header('location:index.php');
}
?>
