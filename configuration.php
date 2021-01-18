<?php
try{
    $pdo=new PDO('mysql:host=localhost;post=3306;dbname=sport','fred','zap');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOExeption $e){
        echo 'connection faied:'.$e->getMessage();
}