<?php
require_once('funcs.php');

$pdo = db_conn();

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    // 画像を取得

    $sql = 'SELECT * FROM image ORDER BY id DESC';
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $image = $stmt->fetchAll();

} else {
    // 画像を保存
    if (!empty($_FILES['myoji'])) {
        $myoji = $_FILES['myoji'];
        $namae = $_FILES['namae'];
        $postcode = $_FILES['postcode'];
        $address = $_FILES['address'];
        $image = file_get_contents($_FILES['image']);
        
        $sql = 'INSERT INTO gs_bm_table(NULL, myoji, namae, postcode, address, image)
                VALUES (NULL, :myoji, :namae, :postcode, :address, :image)';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':myoji', $name, PDO::PARAM_STR);
        $stmt->bindValue(':namae', $type, PDO::PARAM_STR);
        $stmt->bindValue(':postcode', $content, PDO::PARAM_STR);
        $stmt->bindValue(':address', $size, PDO::PARAM_INT);
        $stmt->bindValue(':image', $size, PDO::PARAM_INT);
        $stmt->execute();
    }
    header('Location:index.php');
    exit();
}
?>



<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <!-- BootstrapのCSS読み込み -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</head>

<body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> 

<!-- ここからbody -->

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 border-right">
            <ul class="list-unstyled">
            <?php for($i = 0; $i < count($image); $i++): ?>
                    <li class="media mt-5">
                        <a href="#lightbox" data-toggle="modal" data-slide-to="<?= $i; ?>">
                        <img src="img.php?id=<?= $image[$i]['id']; ?>" width="100" height="auto" class="mr-3">
                        </a>
                        <div class="media-body">
                        <h5><?= $image[$i]['myoji']; ?> (<?= number_format($image[$i]['namae']); ?> )</h5>
                            <a href="#"><i class="far fa-trash-alt"></i> 削除</a>
                        </div>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>

        <!-- フォーム -->
        <div class="col-md-4 pt-4 pl-4">
            <form method="post" enctype="multipart/form-data" action="insert.php">
                <div class="form-group">
                <fieldset>
                <label>名字：<input type="text" name="myoji"></label><br>
                <label>名前：<input type="text" name="namae"></label><br>
                <label>郵便：<input type="text" name="postcode"></label><br>
                <label>住所：<input type="text" name="address"></label><br>
                <label>画像を選択</label>
                    <input type="file" name="image" required>
                </div>
                <button type="submit" class="btn btn-primary">保存</button>
            </form>
        </div>
    </div>
</div>

<div class="modal carousel slide" id="lightbox" tabindex="-1" role="dialog" data-ride="carousel" style="position:fixed;">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <ol class="carousel-indicators">
        <?php for ($i = 0; $i < count($image); $i++): ?>
                <li data-target="#lightbox" data-slide-to="<?= $i; ?>" <?php if ($i == 0) echo 'class="active"'; ?>></li>
            <?php endfor; ?>
        </ol>

        <div class="carousel-inner">
        <?php for ($i = 0; $i < count($image); $i++): ?>
                <div class="carousel-item <?php if ($i == 0) echo 'active'; ?>">
                <img src="img.php?id=<?= $image[$i]['id']; ?>" class="d-block w-100">
                </div>
            <?php endfor; ?>
        </div>

        <a class="carousel-control-prev" href="#lightbox" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#lightbox" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
      </div>
    </div>
  </div>
</div>






</body>
</html>