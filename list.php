<?php
    require_once 'functions.php';
    if(empty($_COOKIE['guest_name']) && !isAuthorized()) {
        http_response_code(403);
        die("Доступ запрещен. Пожалуйста, авторизуйтесь или выполните вход, как гость <a href='./index.php'>this page</a>");
    }
    if(isset($_POST['del_file'])) {
        $file = './Tests/'.$_POST['del_file'];
        $result = unlink($file);
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>List of Tests</title>
    </head>
<body>
    <ul>
        <?php
        $dir = './Tests/';
        $skip = array('.','..');
        $files = scandir($dir);
        foreach($files as $key => $file):
            if(!in_array($file, $skip)):
                $k = $key - 1;
                $link = 'test.php?testnumber='.$k;
                $number = substr($file,4,1);
                echo "<li><a href='$link'>Тест #$number</a></li>";
                if(isAuthorized()): ?>
                    <form method='POST'>
                        <input type='hidden' name='del_file' value='<?php echo $file; ?>'>
                        <input type='submit' value='Удалить'>
                    </form>
                <?php endif;
            endif;
        endforeach; ?>
    </ul><hr>
    <ul>
        <?php if(isAuthorized()) { ?>
            <li><a href='./admin.php'>Загрузить больше тестов</a></li>
        <?php } ?>
            <li><a href='./logout.php'>Выход</a></li>
</body>
</html>
