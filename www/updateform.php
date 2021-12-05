<?php
    session_start();
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
    <hr>
    수정화면
    <hr>
    [<a href="index.php">돌아가기</a>]
    <?php
    require_once("db_con.php");
    $pdo = db_connect();
    if(isset($_GET['id']) && $_GET['id'] > 0) {
        $id = $_GET['id'];
        $_SESSION['id'] = $id;
    } else {
        exit('잘못된 파라미터입니다.');
    }
    try {
        $sql = "SELECT * FROM members WHERE id = :id";
        $stmh = $pdo->prepare($sql);
        $stmh->bindValue(':id', $id, PDO::PARAM_INT);
        $stmh->execute();
        $count = $stmh->rowCount();
    } catch(PDOException $Exception) {
        print "<p>오류: ".$Exception->getMessage()."</p>";
    }
    
    if($count < 1) {
        print "<p>수정 데이터가 없습니다</p>";
    } else {
        $row = $stmh->fetch(PDO::FETCH_ASSOC);
        ?>
    <form name="form1" method="post" action="index.php">
        <label>INDEX</label> <?=htmlspecialchars($row['id'])?>

        <label>LAST NAME</label>
        <input type="text" name="last_name" value="<?=htmlspecialchars($row['last_name'])?>" />
        <label>FIRST NAME</label>
        <input type="text" name="first_name" value="<?=htmlspecialchars($row['first_name'])?>" />
        <label>AGE</label>
        <input type="text" name="age" value="<?=htmlspecialchars($row['age'])?>" />
        <input type="hidden" name="action" value="update">
        <input class="btn" type="submit" value="수정" />
    </form>

    <?php
}
?>

</body>

</html>