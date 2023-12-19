<?php

namespace App\src\Controller;

use App\src\Controller\TwigController;

class ContactController extends TwigController
{

    public function index()
    {
        if (isset($_POST['btnContact'])) {
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $email = htmlspecialchars($_POST['email']);
                $name = htmlspecialchars($_POST['name']);
                $msg = htmlspecialchars($_POST['msg']);
                $headers = "MIME-Version: 1.0\r\n";
                $headers = "From:$email" . PHP_EOL;
                $headers .= 'Content-type: text/html; charset=utf-8' . PHP_EOL;
                mail("contact@webarki.fr", $name, $msg, $headers);
                $success = "Votre message a été envoyer avec succes";
            } else {
                $error = "Veuillez entrer une adresse email valide";
            }
        }
        echo $this->twig->render('contact/index.html.twig', [
            'data' => 'Bienvenue sur le controller Contact!',
            'session' => $_SESSION,
            'message' => (isset($success)) ? $success : "",
            'error' => (isset($error)) ? $error : ""
        ]);
    }

    public function test(int $params)
    {
        if (isset($params)) {
            // var_dump($params);
        }
        echo $this->twig->render('contact/index.html.twig', [
            'data' => 'Bienvenue sur le controller Contact! ' . $params,
            'session' => $_SESSION
        ]);
    }
}
