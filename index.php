<?php
require_once "connection.php";
$sql = "select * from nhanvien";

$stmt = $conn->prepare($sql);
//thực thi
$stmt->execute();
//lấy dữ liệu
$thongtin = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hiển thị</title>
</head>

<body>
    <div>
        <h2>
            <?= isset($_COOKIE['success']) ? $_COOKIE['success'] : '' ?>
        </h2>
        <table border="1">
            <tr>
                <th>id_nv</th>
                <th>hoten</th>
                <th>hinh</th>
                <th>diachi</th>
                <th>luong</th>
                <th>thuong</th>
                <th>lylich</th>
                <th>id_phong</th>
                <th>
                    <a href="add.php">ADD</a>
                </th>
            </tr>
            <?php foreach ($thongtin as $nv) : ?>
                <tr>
                    <td><?= $nv['id_nv'] ?></td>
                    <td><?= $nv['hoten'] ?></td>
                    <td>
                        <img src="image/<?= $nv['image'] ?>" width="120px" alt="">
                    </td>
                    <td><?= $nv['diachi'] ?></td>
                    <td><?= $nv['luong'] ?></td>
                    <td><?= $nv['thuong'] ?></td>
                    <td><?= $nv['lylich'] ?></td>
                    <td><?= $nv['id_phong'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= $nv['id_nv'] ?>">edit</a>
                        <a onclick="return confirm('Bạn có muốn xóa ?')" href="delete.php?id=<?= $nv['id_nv'] ?>">delete</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</body>

</html>