<?php

//これを書けばエラー内容が表示される。
ini_set('display_errors',"On");

require_once 'funcs.php';

// try {
//     $pdo = new PDO('mysql:dbname=gs_kadaidb;charset=utf8;host=localhost','root','root');
//   } catch (PDOException $e) {
//     exit('DBConnectError'.$e->getMessage());
//   }

$pdo = db_conn();


$sql = 'SELECT * FROM image WHERE id = :id LIMIT 1';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', (int)$_GET['id'], PDO::PARAM_INT);
$stmt->execute();
$image = $stmt->fetch();

header('myoji: ' . $image['namae']);
echo $image['image'];
exit();
?>