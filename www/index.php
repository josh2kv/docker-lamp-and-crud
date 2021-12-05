<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>Document</title>
</head>

<body>

    <h1>회원 목록</h1>

    <a href="form.html"><button class="btn">신규입력</button></a>
    <form name='search_key' method="post" action="index.php">
        <label for="name">이름을 검색하세요.</label>
        <input type="text" name="search_key" />
        <input class="btn" type="submit" value="검색">
    </form>

    <?php
    require_once("db_con.php");
    $pdo = db_connect();

    // 삭제 처리
    if(isset($_GET['action']) && $_GET['action'] == 'delete' && $_GET['id'] > 0){
        try{
            $pdo->beginTransaction();
            $id = $_GET['id'];
            $sql = "DELETE FROM members WHERE id = :id";
            $stmh = $pdo->prepare($sql);
            $stmh->bindValue(':id', $id, PDO::PARAM_INT);
            $stmh->execute();
            $pdo->commit();
            print "<p>데이터를 ".$stmh->rowCount()."건 삭제하였습니다.</p>";
        } catch(PDOException $Exception) {
            $pdo->rollBack();
            print "<p>오류: ".$Exception->getMessage()."</p>";
        }
    }

    // 입력 처리
    if(isset($_POST['action']) && $_POST['action'] == 'insert'){
        try {
            // 트랜잭션 시작
            $pdo->beginTransaction();
            $sql = "INSERT INTO members (last_name, first_name, age) VALUES (:last_name, :first_name, :age)";
            $stmh = $pdo->prepare($sql);
            // 데이터형을 문자열로 표시
            $stmh->bindValue(':first_name', $_POST['first_name'], PDO::PARAM_STR);
            $stmh->bindValue(':last_name', $_POST['last_name'], PDO::PARAM_STR);
            // 데이터형을 정수로 표시
            $stmh->bindValue(':age', $_POST['age'], PDO::PARAM_INT);
            $stmh->execute();
            // 각종 처리(트랜잭션) 완료 후 변경을 확정
            $pdo->commit();
            print "<p>데이터를 ".$stmh->rowCount()."건 입력하였습니다.</p>";
            
        } catch(PDOException $Exception){
            // 에러발생한 경우 원래 상태로 롤백
            $pdo->rollBack();
            print "<p>오류: ".$Exception->getMessage()."</p>";
        }
    }
    // 수정 처리
    if(isset($_POST['action']) && $_POST['action'] == 'update'){
        $id = $_SESSION['id'];
        try {
            $pdo->beginTransaction();
            $sql = "UPDATE members SET last_name = :last_name, first_name = :first_name, age = :age WHERE id = :id";
            $stmh = $pdo->prepare($sql);
            $stmh->bindValue(':last_name', $_POST['last_name'], PDO::PARAM_STR);
            $stmh->bindValue(':first_name', $_POST['first_name'], PDO::PARAM_STR);
            $stmh->bindValue(':age', $_POST['age'], PDO::PARAM_INT);
            $stmh->bindValue(':id', $id, PDO::PARAM_INT);
            $stmh->execute();
            $pdo->commit();
            print "<p>데이터를 ".$stmh->rowCount()."건 수정하였습니다.</p>";
        } catch(PDOException $Exception) {
            $pdo->rollBack();
            print "<p>오류: ".$Exception->getMessage()."</p>";
        }

        unset($_SESSION['id']);
    }

    // 검색 및 모든 데이터 표시
    try {
        if(isset($_POST['search_key']) && $_POST['search_key'] != ""){
            $search_key = '%'.$_POST['search_key'].'%';
            $sql = "SELECT * FROM members WHERE last_name LIKE :last_name OR first_name LIKE :first_name";
            $stmh = $pdo->prepare($sql);
            $stmh->bindValue(':last_name', $search_key, PDO::PARAM_STR);
            $stmh->bindValue(':first_name', $search_key, PDO::PARAM_STR);
            $stmh->execute();
            } else {
                $sql = "SELECT * FROM members";
                $stmh = $pdo->query($sql);
        }
        $count = $stmh->rowCount();
        print "<p>검색 결과는 ".$count."건입니다.</p>";
    } catch(PDOException $Exception) {
        print "<p>오류: ".$Exception->getMessage()."</p>";
    }

    if($count < 1){
        print "검색결과가 없습니다.<br>";
    } else {
        ?>
    <table class="styled-table">
        <thead>
            <tr>
                <th>INDEX</th>
                <th>LAST NAME</th>
                <th>FIRST NAME</th>
                <th>AGE</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            while($row = $stmh->fetch(PDO::FETCH_ASSOC)){
            ?>
            <tr>
                <td><?=htmlspecialchars($row['id'])?></td>
                <td><?=htmlspecialchars($row['last_name'])?></td>
                <td><?=htmlspecialchars($row['first_name'])?></td>
                <td><?=htmlspecialchars($row['age'])?></td>
                <td><a href=updateform.php?id=<?=htmlspecialchars($row['id'])?>>수정</a></td>
                <td><a href=index.php?action=delete&id=<?=htmlspecialchars($row['id'])?>>삭제</a></td>

            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    <?php
    }
    ?>
</body>

</html>