<?php
    require_once 'functions.php';
    if(isAuthorized())
        logout();
    elseif($_COOKIE['guest_name']) setcookie('guest_name', '', time() - 10);
    header('Location: ./index.php');
?>
