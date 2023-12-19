<?php

namespace App\src\Controller;

use App\src\Entity\User;

class UserController extends TwigController
{
    public function index()
    {
        if ($_SESSION['role'] == "admin") {
            $user = new User();
            $users = $user->getUserList();
            echo $this->twig->render('user/index.html.twig', [
                'data' => 'Bienvenue sur le controller User!',
                'users' => $users,
                'session' => $_SESSION
            ]);
        } else {
            header("Location: /public/home");
        }
    }
}
