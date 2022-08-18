<?php
require_once "connection.php";
if(isset($_GET['id'])){
    $id=$_GET['id'];

    $sql="delete  from nhanvien where id_nv=$id";
    $stmt=$conn->prepare($sql);
    $stmt->execute();
    setcookie("success","Xóa thành công ",time()+1);
    header("location:index.php");
}
header("location:index.php");
exit;