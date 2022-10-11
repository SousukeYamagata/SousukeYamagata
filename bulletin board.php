<?php
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
$sql = "CREATE TABLE IF NOT EXISTS tbtest"
    . " ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "date DATETIME,"
    . "pass char(16)"
    . ");";
$stmt = $pdo->query($sql);
if (!empty($_POST["name"]) && !empty($_POST["comment"])) {
    if (!empty($_POST["pass"])) {
        $pass    = $_POST["pass"];
        $name    = $_POST["name"];
        $comment = $_POST["comment"];
        $date    = date("Y/m/d/ H:i:s");
        $sql     = $pdo->prepare("INSERT INTO tbtest (id,name, comment, date, pass) VALUES (:id, :name, :comment, :date, :pass)");
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql->bindParam(':date', $date, PDO::PARAM_STR);
        $sql->bindParam(':pass', $pass, PDO::PARAM_STR);
        $sql->execute();
    }
    if (!empty($_POST["edit_num"])) {
        $id      = $_POST["edit_num"];
        $name    = $_POST["name"];
        $comment = $_POST["comment"];
        $date    = date("Y/m/d/ H:i:s");
        $sql     = $pdo->prepare('UPDATE tbtest SET name=:name,comment=:comment,date=:date WHERE id=:id');
        $sql->bindParam(':name', $name, PDO::PARAM_STR);
        $sql->bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql->bindParam(':date', $date, PDO::PARAM_STR);
        $sql->bindParam(':id', $id, PDO::PARAM_INT);
        $sql->execute();
    }
}
if (!empty($_POST["delete"]) && !empty($_POST["D_pass"])) {
    $id   =  $_POST["delete"];
    $sql  =  'DELETE from tbtest where id=:id && pass = :D_pass';
    $stmt =  $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':D_pass', $D_pass, PDO::PARAM_INT);
    $stmt->execute();
}
if (!empty($_POST["edit"])) {
    $edit      = $_POST["edit"];
    $E_pass    = $_POST["E_pass"];
    $sql       = 'SELECT * FROM tbtest WHERE id = :edit && pass = :E_pass';
    $stmt      = $pdo->prepare($sql);
    $stmt->bindParam(':edit', $edit, PDO::PARAM_INT);
    $stmt->bindParam(':E_pass', $E_pass, PDO::PARAM_STR);
    $stmt->execute();
    $results   = $stmt->fetchAll();
    foreach ($results as $row) {
        $edit_name = $row['name'];
        $edit_come = $row['comment'];
    }
} else {
    $edit_num  = "";
    $edit_name = "";
    $edit_come = "";
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>mission_5-01</title>
    <style>
        .form {
            display: block;
        }
    </style>
</head>

<body>
    <form action="" method="post">
        <label class="form">
            <input type="text" name="name" placeholder="名前" value="<?php echo $edit_name; ?>">
        </label>
        <label class="form">
            <input type="text" name="comment" placeholder="コメント" value="<?php echo $edit_come; ?>">
        </label>
        <label class="form">
            <input type="text" name="pass" placeholder="パスワード">
            <input type="hidden" name="edit_num" value="<?php echo $_POST["edit"]; ?>">
            <input type="submit" name="submit">
        </label>
        <div><br></div>
        <label class="form">
            <input type="number" name="delete" placeholder="削除番号">
        </label>
        <label class="form">
            <input type="text" name="D_pass" placeholder="パスワード">
            <input type="submit" value="削除">
        </label>
        <div><br></div>
        <label class="form">
            <input type="text" name="edit" placeholder="編集番号">
            <input type="hidden" name="edit_name">
            <input type="hidden" name="edit_come">
        </label>
        <label class="form">
            <input type="text" name="E_pass" placeholder="パスワード">
            <input type="submit" value="編集">
        </label>
    </form>
</body>

</html>

<?php

$sql     = 'SELECT * FROM tbtest';
$stmt    = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row) {
    echo $row['id'] . ',';
    echo $row['name'] . ',';
    echo $row['comment'] . ',';
    echo $row['date'] . '<br>';
    echo "<hr>";
}
?>
