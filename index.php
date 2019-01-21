<?php
    require_once 'functions.php';

    $errors = [];
    $file = __DIR__ . '/Users/{login}.json';
    if(!empty($_POST['login']) && !empty($_POST['password'])) {
        if(file_exists($file)) {
            if(login($_POST['login'], $_POST['password'])) {
                header('Location: ./list.php');
                die;
            } else $errors[] = 'Неверный логин или пароль';
        } else $errors[] = 'Пользователь не найден, выполните вход как гость';
    } elseif(!empty($_POST['login']) && empty($_POST['password'])) {
        $guestName = $_POST['login'];
        setcookie('guest_name', $guestName);
        header('Location: ./list.php');
    } else $errors[] = 'Представьтесь или зайдите как администратор';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    </head>
<body>
    <h1>Авторизация</h1>
    <?php if(!empty($errors)): ?>
        <ul>
        <?php foreach($errors as $error): ?>
            <li><?php echo $error; ?></li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <form method='POST'>
        <div>
            <label>Login:</label>
            <input type='text' placeholder='Логин или Имя' name='login'>
        </div>
        <div>
            <label>Password:</label>
            <input type='text' placeholder='Пароль' name='password'>
        </div>
        <small>* для входа в качестве гостя укажите только Имя</small>
        <div>
            <input type='submit' value='Вход'>
        </div>
    </form>
</body>
</html>
