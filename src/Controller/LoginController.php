<?php

namespace App\src\Controller;

use App\src\Controller\TwigController;
use App\src\Entity\User;

class LoginController extends TwigController
{
    public function index()
    {
        echo $this->twig->render("login/index.html.twig", [
            'data' => ''
        ]);
    }
}
