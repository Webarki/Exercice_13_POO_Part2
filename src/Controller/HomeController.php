<?php

namespace App\src\Controller;

use App\src\Controller\TwigController;
use App\src\Entity\User;
use App\src\Entity\Article;

class HomeController extends TwigController
{

    public function index()
    {
        $getArticles = new Article();
        $articles = $getArticles->getArticleListStateTrue();
        echo $this->twig->render('home/index.html.twig', [
            'data' => '',
            'session' => $_SESSION,
            'articles' => $articles
        ]);
    }
}
