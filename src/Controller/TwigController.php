<?php

namespace App\src\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigController
{
    public $twig;
    protected $loader;

    public function __construct()
    {
        $this->loader = new FilesystemLoader("../templates");

        $this->twig = new Environment($this->loader);
    }

    public function index()
    {
        echo $this->twig->render('base.html.twig', [
            'data' => 'Bienvenue sur le controller Racine!'
        ]);
    }
}
