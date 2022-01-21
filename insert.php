<?php

//これを書けばエラー内容が表示される。
ini_set('display_errors',"On");

require_once('funcs.php');

//1. POSTデータ取得
$myoji = $_POST['myoji'];
$namae = $_POST['namae'];
$postcode = $_POST['postcode'];
$address = $_POST['address'];
// $image = $_POST['image'];



//2.DB接続

try {
  //ID:'root', Password: 'root'
  $pdo = new PDO('mysql:dbname=gs_kadaidb;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

// $pdo = db_conn();

//3.データ登録SQLの用意

//SQL文を用意
$stmt = $pdo->prepare("INSERT INTO gs_bm_table(id, myoji, namae, postcode, address ,image)
                      VALUES(NULL, :myoji, :namae, :postcode, :address,:image)");

// バインド変数を用意

$image = file_get_contents($_FILES['image']['tmp_name']); //画像

$stmt->bindValue(':myoji', $myoji, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':namae', $namae, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':postcode', $postcode, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':address', $address, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':image', $image, PDO::PARAM_STR);

// 実行
$status = $stmt->execute();

// データ登録処理後
if($status==false){
    //SQL実行時にエラーがある場合（エラーオブジェクト取得して表示）
    $error = $stmt->errorInfo();
    exit("ErrorMessage:".$error[2]);
  }else{
    //index.phpへリダイレクト
    header('Location: index.php');
  }

?>