<?php
require_once "connection.php";
if (isset($_POST['submit'])) {
    $id = $_POST['idnv'];
    $image = $_POST['image']; //lấy ra ảnh cũ
    $hoten = $_POST['hoten'];
    $diachi = $_POST['diachi'];
    $luong = $_POST['luong'];
    $thuong = $_POST['thuong'];
    $lylich = $_POST['lylich'];
    $danhmuc = $_POST['danhmuc'];
    


    $file = $_FILES['image'];
    //lấy tên file
    if ($file['size'] > 0) {
        $image = $file['name'];
        //Lấy phần mở rộng của file
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        if ($ext != 'jpg' && $ext != 'png') {
            $errors['anh'] = "Bạn cần nhập đúng ảnh";
        } elseif ($file['size'] > 2 * 1024 * 1024) {
            $errors['anh'] = "Ảnh không được vượt quá 2MB";
        }
    }
    $sql = "UPDATE nhanvien set hoten='$hoten',image='$image',diachi='$diachi',luong='$luong',thuong='$thuong',lylich='$lylich',id_phong='$danhmuc' where id_nv=$id";
    if ($file['size'] > 0) {
        move_uploaded_file($file['tmp_name'], 'image/' . $image);
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    setcookie("success", "Thêm dữ liệu thành công", time() + 1);
    header("location: index.php");
    exit;
}
$stmt = $conn->prepare("Select * From phongban");
$stmt->execute();
$phongban = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Lay du lieu
$id = $_GET['id'];
//SQL select
$sql = "SELECT * FROM nhanvien where id_nv=$id";
//chuan bi
$stmt = $conn->prepare($sql);
//thực thi
$stmt->execute();
$thongtin = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="idnv" id="" value="<?= $thongtin['id_nv'] ?>">
        hoten:
        <input type="text" name="hoten" id="" value="<?= $thongtin['hoten'] ?>">
        <br>
        <!-- Hiển thị ảnh cũ -->
        <img src="image/<?= $thongtin['image'] ?>" alt="" width="140px">
        <br>

        <!-- lưu lại ảnh cũ khi không update-->
        <input type="hidden" name="image" id="" value="<?= $thongtin['image'] ?>">

        <!-- lấy ảnh mới -->
        Image: 
        <input type="file" name="image" id="">
        <br>
        diachi:
        <input type="text" name="diachi" id="" value="<?= $thongtin['diachi'] ?>">
        <br>
        luong:
        <input type="number" name="luong" id="" value="<?= $thongtin['luong'] ?>">

        <br>
        thuong
        <input type="number" name="thuong" id="" value="<?= $thongtin['thuong'] ?>">

        <br>
        lylich
        <input type="text" name="lylich" id="" value="<?= $thongtin['lylich'] ?>">
        <br>
        ip_Phong
        <select name="danhmuc" id="">
            <?php foreach ($phongban as $pb) : ?>
                <option value="<?= $pb['id_phong'] ?>" >
                    <?= $pb['tenphong'] ?>
                </option>
            <?php endforeach ?>
        </select>
        <br>
        <button type="submit" name="submit">add</button>
    </form>
</body>

</html>