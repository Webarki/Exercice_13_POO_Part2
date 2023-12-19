<?php
header('Content-Type: application/json');

use App\Autoloader;

include "../../../../../Autoloader.php";
Autoloader::register();

if (isset($_POST['email']) && !empty($_POST['email'])) {
    $login = htmlspecialchars($_POST['email']);
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = htmlspecialchars($_POST['password']);
        $passHash = password_hash($password, PASSWORD_BCRYPT);
    }
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        session_start();
        $user = new App\src\Entity\User();
        $token = $user->generateCSRFToken();
        $user->email = $login;
        $user->pass = $passHash;
        $user->token = $token;
        if ($user->addUser()) {
            $user->email = $login;
            $getUser = $user->getUserMail();
            $_SESSION['email'] = $getUser->email;
            $_SESSION['token'] = $getUser->token;
            $_SESSION['id'] = $getUser->id;
            $_SESSION['role'] = $getUser->role;
            $response['url'] = 'home';
            $response['type'] = 'Success';
            echo json_encode($response);
        } else {
            $response['type'] = "ERROR";
            $response['data'] = 'Une erreur c\'est produite';
            echo json_encode($response);
        }
    } else {
        $response['type'] = "ERROR";
        $response['data'] = 'Une erreur c\'est produite';
        echo json_encode($response);
    }
} else {
    $response['type'] = "ERROR";
    $response['data'] = 'Une erreur c\'est produite';
    echo json_encode($response);
}
