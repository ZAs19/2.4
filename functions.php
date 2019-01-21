<?php
    session_start();

    function getUsers() {
        $jsonUsers = file_get_contents(__DIR__ . '/Users/{login}.json');
        $users = json_decode($jsonUsers, true);
        if (empty($users)) {
            return [];
        }
        return $users;
    }

    function findUser($login) {
        $users = getUsers();
        foreach($users as $user) {
            if($login === $user['login'])
                return $user;
        }
        return null;
    }

    function login($login, $password) {
        $user = findUser($login);
        if($user && $user['password'] === $password) {
            $_SESSION['user'] = $user;
            return true;
        }
        return false;
    }

    function isAuthorized() {
        return !empty($_SESSION['user']);
    }

    function getAuthorizedUser() {
        return $_SESSION['user'];
    }

    function logout() {
        session_destroy();
    }
?>
