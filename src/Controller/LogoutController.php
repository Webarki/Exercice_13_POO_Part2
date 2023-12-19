<?php

namespace App\src\Controller;

use App\src\Controller\TwigController;

class LogoutController
{
    public function index()
    {
        session_start();
        //Permet de vider les variables de session
        session_unset();
        //Detruit la session
        session_destroy();
        header('Location:/');
    }
}
