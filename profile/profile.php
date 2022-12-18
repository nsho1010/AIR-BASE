<?php

session_start();

include('../functions/check_session_id.php');
include('../functions/connect_to_db.php');

if ($_SESSION['user_type'] == 1) {
    check_session_id();
} else {
    header("Location:../login/loginTop.php");
    exit();
}

$id = $_SESSION['id'];

// var_dump($_SESSION['name']);
// exit();

// //値があったら
// if (isset($result['name'])) {
//     header("Location:./profile.php");
// } else {
//     header("Location:./profile_input.php");
// }


// DB接続
$pdo = connect_to_db();
// $sql = 'SELECT * FROM pailot_info WHERE user_id=:id';
$sql = 'SELECT * FROM users INNER JOIN pailot_info ON users.id = pailot_info.user_id INNER JOIN pailot_skill ON pailot_info.user_id = pailot_skill.user_id where users.id=:id ;';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);

try {
    $status = $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

$result = $stmt->fetch(PDO::FETCH_ASSOC);



// echo '<pre>';
// var_dump($result);
// echo '</pre>';
// exit();


?>



<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/top.css">
    <title>AIR BASE</title>
</head>

<body>
    <header>
        <p> LOGO</p>
        <h1>AIR BASE</h1>
        <div class="header-nav">
            <!-- <a href="#"><img src="" alt=""></a> -->
            <p>ユーザー名</p>
        </div>
    </header>

    <ul>
        <a href="">
            <li>案件検索</li>
        </a>
        <a href="">
            <li>パイロット検索</li>
        </a>
        <a href="">
            <li>気に入った案件</li>
        </a>
        <a href="">
            <li>受注管理</li>
        </a>
        <a href="./profile.php">
            <li>プロフィール</li>
        </a>
    </ul>

    <p>パイロットプロフィール</p>

    <img src='{$result["my_image"]}' height='150px'>
    <p><?= $result['kana'] ?></p>
    <p><?= $result['name'] ?></p>
    <p><?= $result['age'] ?></p>
    <p><?= $result['word'] ?></p>
    <p><?= $result['gender'] ?></p>
    <p><?= $result['work_area'] ?></p>
    <p><?= $result['status'] ?></p>
    <p><?= $result['achievement'] ?></p>
    <p><?= $result['pr'] ?></p>
</body>

</html>