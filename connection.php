<?php

try{
    $conn=new PDO("mysql:host=localhost;dbname=lequangduc_web17316;charset:utf8","root","");
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "Lỗi kết nối".$e->getMessage();

}