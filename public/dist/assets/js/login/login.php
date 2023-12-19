<?php

use \App\Autoloader;

require_once "../../../../../Autoloader.php";
Autoloader::register();

if (isset($_POST['login']) && !empty($_POST['login'])) {
    $login = htmlspecialchars($_POST['login']);
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = htmlspecialchars($_POST['password']);
    }
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        $user = new App\src\Entity\User();
        $user->email = $login;
        if ($user->getUserMail()) {
            $getUser = $user->getUserMail();
            $token = $user->generateCSRFToken();
            $user->id = $getUser->id;
            $user->token = $token;
            $user->setTokenUser();
            if (is_object($user)) {
                if (password_verify($password, $getUser->pass)) {
                    session_start();
                    $_SESSION['email'] = $getUser->email;
                    $_SESSION['id'] = $getUser->id;
                    $_SESSION['role'] = $getUser->role;
                    $_SESSION['token'] = $token;
                    $response['url'] = 'home';
                    $response['type'] = 'Success';
                    echo json_encode($response);
                } else {
                    $response['type'] = 'ERROR';
                    $response['data'] = 'Vérifier vos identifiants';
                    echo json_encode($response);
                }
            } else {
                $response['type'] = 'ERROR';
                $response['data'] = 'Aucun utilisateur n\'existe';
                echo json_encode($response);
            }
        } else {
            $response['type'] = 'ERROR';
            $response['data'] = 'Aucun utilisateur n\'existe';
            echo json_encode($response);
        }
    } else {
        $response['type'] = "ERROR";
        $response['data'] = 'Une erreur c\'est produite';
        echo json_encode($response);
    }
}
