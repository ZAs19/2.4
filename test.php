<?php
    require_once 'functions.php';
    if(empty($_COOKIE['guest_name']) && !isAuthorized()):
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
    <title>Test</title>
    </head>
<body>
    <?php
    if(!empty($_GET)) {
        if(array_key_exists('testnumber', $_GET)):
            $number = (int)$_GET['testnumber'];
            $string = file_get_contents(__DIR__ . '/Tests/test' . $number . '.json');
            if (!$string)
                header('HTTP/1.1 404 Not Found', $http_response_code = 404);
            else
                $data = json_decode($string, true);
        endif;
    } else header('Location: ./list.php', $http_response_code = 301);
    if(!empty($_GET)):
        if(array_key_exists('testnumber', $_GET)):
            $i = 0; ?>
            <form action='test.php?testnumber=<?php echo $_GET['testnumber']?>' method='POST'>
                <?php foreach($data['test'] as $question => $answers): ?>
                    <fieldset>
                        <legend><?php echo "$question<br>";?></legend>
                        <?php
                        $n = 1;
                        foreach($answers as $value): ?>
                            <label>
                                <input type='radio'
                                name='<?php echo $i; ?>'
                                value='<?php echo "a$n"?>'><?php echo " $value";?>
                            </label>
                            <?php $n++;
                        endforeach;
                        $i++; ?>
                    </fieldset>
                <?php endforeach;?>
                <input type='submit' value='Отправить'>
            </form>
        <?php endif;
    endif;
    if(!empty($_POST)):
        $userAnswers = $_POST;
        $correct = $data['correct'];
        $len = count($correct);
        if(count($userAnswers) < $len) { // Проверка на полноту ответов
            echo 'Пожалуйста, ответьте на все вопросы';
        } else {
            if(isAuthorized())
                $name = $_SESSION['user']['name'];
            else $name = $_COOKIE['guest_name'];
            $right = 0;
            for($i = 0; $i < $len; $i++)
                if($correct[$i] == $userAnswers[$i])
                    $right++;
            echo "Ваш результат $right из $len<br>";?>
            <?php $result = (int)($right / $len * 100);
            $font_file =  __DIR__ . '\font\BadScript-Regular.ttf';
            $certificate = imagecreatetruecolor (470, 664);
            $textColor = imagecolorallocate($certificate, 0, 0, 0);
            $imBox = imagecreatefrompng('blank\blank.png');
            imagecopy($certificate, $imBox, 0, 0, 0, 0, 470, 664);
            imagettftext($certificate, 16, 0, 110, 290, $textColor, $font_file, $name);
            imagettftext($certificate, 15, 0, 140, 320, $textColor, $font_file, 'Вы прошли тест ');
            imagettftext($certificate, 10, 0, 180, 350, $textColor, $font_file, 'С результатом ' . $result . '% верных ответов');
            imagepng($certificate, "./Certificates/$name.png");
            imagedestroy($certificate);?>
            <a href='./Certificates/<?php echo $name ?>.png' target='blank'>Загрузить сертификат</a><hr>
            <a href='./list.php'>Выбрать другой тест</a><br>
            <?php if(isAuthorized()): ?>
                <a href='./admin.php'>Загрузить больше тестов</a><br>
            <?php endif; ?>
            <a href='./logout.php'>Выход</a>
        <?php }
    endif; ?>
</body>
</html>
