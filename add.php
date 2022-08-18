<?php 
require_once "connection.php";
if(isset($_POST['submit'])){
    $hoten=$_POST['hoten'];
    $diachi=$_POST['diachi'];
    $luong=$_POST['luong'];
    $thuong=$_POST['thuong'];
    $lylich=$_POST['lylich'];
    $danhmuc=$_POST['danhmuc'];
    $file=$_FILES['anh'];
    //lấy tên file
    $image=$file['name'];
    //validate mảng error
    $errors=[];
    if ($file['size'] > 0) {
        //Lấy phần mở rộng của file
        $ext = pathinfo($image, PATHINFO_EXTENSION);
        if ($ext != 'jpg' && $ext != 'png') {
            $errors['anh'] = "Bạn cần nhập đúng ảnh";
        } elseif ($file['size'] > 2 * 1024 * 1024) {
            $errors['anh'] = "Ảnh không được vượt quá 2MB";
        }
    }
 
    if(empty($hoten)){
        $errors['hoten']="Hãy nhập họ tên";
    }
    if(empty($luong)){
        $errors['luong']="Hãy nhập số lương";
    }
    if(empty($thuong)){
        $errors['thuong']="Hãy nhập số lương";
    }
    if(!$errors){

        $sql="INSERT INTO nhanvien(hoten,image,diachi,luong,thuong,lylich,id_phong) values ('$hoten','$image','$diachi','$luong','$thuong','$lylich','$danhmuc')";
        $stmt=$conn->prepare($sql);
        $stmt->execute();

        if ($file['size'] > 0) {
            move_uploaded_file($file['tmp_name'], 'image/' . $image);
        }
        setcookie("success", "Thêm dữ liệu thành công", time() + 1);
        header("location: index.php");
        exit;
    }

}
$stmt=$conn->prepare("Select * From phongban");
$stmt->execute();
$phongban=$stmt->fetchAll(PDO::FETCH_ASSOC);
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
        hoten:
        <input type="text" name="hoten" id="">
        <span style="color: red;">
            <?=isset($errors['hoten'])? $errors['hoten'] : '' ?>
        </span>
        <br>
        Image: <input type="file" name="anh" id="">
        <span style="color: red;">
            <?= isset($errors['image']) ? $errors['image'] : '' ?>
        </span>
        <br>
        diachi:
        <input type="text" name="diachi" id="">
        <br>
        luong:
        <input type="number" name="luong" id="">
        <span style="color: red;">
            <?=isset($errors['luong'])? $errors['luong'] : '' ?>
        </span>
        <br>
        thuong
        <input type="number" name="thuong" id="">
        <span style="color: red;">
            <?=isset($errors['thuong'])? $errors['thuong'] : '' ?>
        </span>
        <br>
        lylich
        <input type="text" name="lylich" id="">
        <br>
        ip_Phong
        <select name="danhmuc" id="">
            <?php foreach($phongban as $pb) :?>
                <option value="<?=$pb['id_phong']?>">
               <?=$pb['tenphong']?>
        </option>
                <?php endforeach ?>
        </select>
        <br>
        <button type="submit" name="submit">add</button>
    </form>
</body>
</html>