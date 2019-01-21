<?php
    require_once 'functions.php';
    if(!isAuthorized()):
        http_response_code(403);
        die("Доступ запрещен. Пожалуйста, авторизуйтесь или выполните вход, как гость <a href='./index.php'>this page</a>");
    endif;
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <form action='admin.php' method='POST' enctype='multipart/form-data'>
        <div>Пожалуйста, загрузите .json файл с тестом:</div>
        <input type='file' name='test'>
        <div><input type='submit' value='Загрузить'></div>
    </form>
    <?php
    if(!empty($_FILES)) {
        if(array_key_exists('test', $_FILES)) {
            if($_FILES['test']['type'] != 'application/json') {
                echo 'Извините, нужен файл с расширением JSON';
                exit;
            } else {
                $name = $_FILES['test']['name'];
                $dest = "./Tests/$name";
                move_uploaded_file($_FILES['test']['tmp_name'], $dest);
                header('Location: ./list.php');?>
            <?php }
        }
    } ?>
    <a href='./list.php'>Перейти к списку тестов</a><br>
    <a href='./logout.php'>Выход</a>
</body>
</html>
