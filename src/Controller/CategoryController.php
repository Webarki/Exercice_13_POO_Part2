<?php

namespace App\src\Controller;

use App\src\Entity\Article;
use App\src\Controller\TwigController;
use App\src\Entity\Category;

class CategoryController extends TwigController
{
    public function index()
    {
        if ($_SESSION["role"] == "admin") {
            $category = new Category();
            $categories = $category->findAll();
            echo $this->twig->render("category/index.html.twig", [
                'session' => $_SESSION,
                'categories' => $categories,
                'data' => 'Bienvenue sur le controller Category'
            ]);
        } else {
            header("Location: /public/home");
        }
    }

    public function create()
    {
        if ($_SESSION["role"] == "admin") {
            if (isset($_POST["btnCreate"])) {
                $category = new Category();
                $category->setTitle(htmlspecialchars($_POST["title"]));
                $category->setDescription(htmlspecialchars($_POST["description"]));
                $category->createCategory();
                header("Location: /public/category");
            }
            echo $this->twig->render("category/form.html.twig", [
                'session' => $_SESSION,
                'data' => 'Bienvenue sur le controller Category'
            ]);
        } else {
            header("Location: /public/home");
        }
    }

    public function modify(int $params)
    {
        if ($_SESSION["role"] == "admin") {
            $category = new Category();
            $categorie = $category->find($params);
            if (isset($_POST["btnUpdate"])) {
                $category->setTitle(htmlspecialchars($_POST["title"]));
                $category->setDescription(htmlspecialchars($_POST["description"]));
                $category->setCategory($params);
                header("Location: /public/category");
            }
            echo $this->twig->render("category/form.html.twig", [
                'session' => $_SESSION,
                'data' => 'Bienvenue sur le controller Category',
                'categorie' => $categorie
            ]);
        } else {
            header("Location: /public/home");
        }
    }

    public function remove(int $params)
    {
        if ($_SESSION["role"] == "admin") {
            $category = new Category();
            $category->removeCategory($params);
            header("Location: /public/category");
        } else {
            header("Location: /public/login");
        }
    }
}
