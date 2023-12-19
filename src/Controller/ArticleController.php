<?php

namespace App\src\Controller;

use App\src\Entity\Article;
use App\src\Controller\TwigController;

class ArticleController extends TwigController
{
    public function index()
    {
        if ($_SESSION["role"] == "admin") {
            $article = new Article;
            $articles = $article->getArticles();
            echo $this->twig->render("article/index.html.twig", [
                'articles' => $articles,
                'data' => 'Bienvenue sur le controller Article',
                'session' => $_SESSION
            ]);
        } else {
            header("Location: /public/home");
        }
    }

    public function create()
    {
        if ($_SESSION["role"] == "admin") {
            $article = new Article();
            if (isset($_POST["btnCreate"])) {
                $formError = [];
                $article = new Article();
                if (isset($_POST["title"]) && !empty($_POST["title"])) {
                    $article->title = htmlspecialchars($_POST["title"]);
                } else {
                    $formError["title"] = "Veuillez entrer un titre";
                }
                if (isset($_POST["content"]) && !empty($_POST["content"])) {
                    $article->content = htmlspecialchars($_POST["content"]);
                } else {
                    $formError["content"] = "Veuillez entrer un contenu";
                }
                $id = $article->lastId()["id"] + 1;
                // Recupere mon image puis la redirige afin de la stocker dans mon dossier avatar
                if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
                    // var_dump($_FILES);
                    // Initalisation d'une variable qui stockera la taille du poid autoriser pour l'avatar 2mo
                    $tailleMax = 1000000; //octet = 1MO
                    // Déclaration d'une variable qui stockera les extension autoriser pour l'avatar
                    $extensionValid = array('png', 'jpg', 'jpeg');
                    // Condition qui s'effectue si le poid de mon image est inferieur ou egal a ma limite autoriser
                    if ($_FILES['file']['size'] <= $tailleMax) {
                        // Declaration d'une variable qui sotkera l'extension de mon image tout en la mettant en miniscule et on ignore le caractere . puis on recupere le nom de l'extension apres le caractere ignorer
                        $extensionUpload = strtolower(substr(strrchr($_FILES['file']['name'], '.'), 1));
                        // Condition qui verifie si l'extesion récuperer est egal a notre tableau d'extension
                        if (in_array($extensionUpload, $extensionValid)) {
                            // J'initialise une variable qui stocke le chemin que je definie ou sera stoker mon avatar
                            $way = str_replace(' ', '', 'album/article_' . $id . '.' . $extensionUpload);
                            // var_dump($way);
                            //Déclaration d'une variable qui stokera la valeur de retour du Deplacement d'un fichier téléchargé renvoi TRUE ou FALSE
                            $result =  move_uploaded_file($_FILES['file']['tmp_name'], ROOT . "/" . $way);
                            if ($result) {
                                $article->img = htmlspecialchars('../../' . $way);
                            } else {
                                $formError['file'] = 'Désoler une erreur c\'est produite , veuillez charger une autre image';
                            }
                        } else {
                            $formError['file'] = 'Votre format de photo ne correspond pas il doit être au format jpg, jpeg, gif ou png';
                        }
                    } else {
                        $formError['file'] = 'Votre photo ne doit pas depasser 1 MO';
                    }
                } else {
                    $formError['file'] = 'Veuillez selectionner une image';
                }
                if (isset($_POST["state"]) && !empty($_POST["state"])) {
                    $article->state = htmlspecialchars($_POST["state"]);
                } else {
                    $article->state = false;
                }
                if (!$formError) {
                    $article->createArticle();
                    header("Location: /public/article");
                }
            }
            echo $this->twig->render("article/form.html.twig", [
                'data' => 'Bienvenue sur le controller Article/create/',
                'session' => $_SESSION,
                'error' => (isset($formError)) ? $formError : "",
                'count' => $article->lastId()
            ]);
        } else {
            header("Location: /public/home");
        }
    }

    public function view(int $params)
    {
        if ($_SESSION) {
            $getArticle = new Article;
            $getArticle->id = $params;
            $article = $getArticle->getArticleById();
            echo $this->twig->render("article/index.html.twig", [
                'article' => $article,
                'data' => 'Bienvenue sur le controller Article/view',
                'session' => $_SESSION
            ]);
        } else {
            header("Location: /public/home");
        }
    }

    public function modify(int $params)
    {
        if ($_SESSION["role"] == "admin") {
            $getArticle = new Article;
            $getArticle->id = $params;
            $article = $getArticle->getArticleById();
            //Verifier que le boutton de mon formulaire est submit ( qu'il existe ! )
            if (isset($_POST["btnUpdate"])) {

                $getArticle->id = $params;
                $getArticle->title = htmlspecialchars($_POST["title"]);
                $getArticle->content = htmlspecialchars($_POST["content"]);

                // Recupere mon image puis la redirige afin de la stocker dans mon dossier album
                if (isset($_FILES['file']) && !empty($_FILES['file']['name'])) {
                    var_dump($_FILES);
                    // Initalisation d'une variable qui stockera la taille du poid autoriser pour l'album
                    $tailleMax = 1000000; //octet = 1MO
                    // Déclaration d'une variable qui stockera les extension autoriser pour l'avatar
                    $extensionValid = array('png', 'jpg', 'jpeg');
                    // Condition qui s'effectue si le poid de mon image est inferieur ou egal a ma limite autoriser
                    if ($_FILES['file']['size'] <= $tailleMax) {
                        // Declaration d'une variable qui sotkera l'extension de mon image tout en la mettant en miniscule et on ignore le caractere . puis on recupere le nom de l'extension apres le caractere ignorer
                        $extensionUpload = strtolower(substr(strrchr($_FILES['file']['name'], '.'), 1));
                        // Condition qui verifie si l'extesion récuperer est egal a notre tableau d'extension
                        if (in_array($extensionUpload, $extensionValid)) {
                            // J'initialise une variable qui stocke le chemin que je definie ou sera stoker mon image
                            $way = str_replace(' ', '', 'album/article_' . $params . '.' . $extensionUpload);
                            var_dump($way);
                            //Déclaration d'une variable qui stokera la valeur de retour du Deplacement d'un fichier téléchargé renvoi TRUE ou FALSE
                            $result =  move_uploaded_file($_FILES['file']['tmp_name'], ROOT . "/" . $way);
                            if ($result) {
                                $getArticle->img = '../../' . $way;
                            } else {
                                $formError['file'] = 'Désoler une erreur c\'est produite , veuillez charger une autre image';
                            }
                        } else {
                            $formError['file'] = 'votre format de photo ne correspond pas il doit être au format jpg, jpeg, gif ou png';
                        }
                    } else {
                        $formError['file'] = 'votre photo ne doit pas depasser 1 mo';
                    }
                } else {
                    $getArticle->img = '../../album/article_1.jpg';
                }
                $getArticle->state = htmlspecialchars($_POST["state"]);
                $getArticle->updatedAt = date('d/m/Y h:m:s');
                $getArticle->updateArticleById();
                header("Location: /public/view/" . $params);
            }
            //Limite l'accés au controller à l'admin
            echo $this->twig->render("article/form.html.twig", [
                'article' => $article,
                'data' => 'Bienvenue sur le controller Article/modify/',
                'session' => $_SESSION
            ]);
        } else {
            header("Location: /public/home");
        }
    }

    public function delete(int $params)
    {
        //Limite l'accés au controller à l'admin
        if ($_SESSION["role"] == "admin") {
            $getArticle = new Article;
            $getArticle->id = $params;
            $article = $getArticle->getArticleById();
            unlink(ROOT . strchr($article->img, "album"));
            $getArticle->deleteArticleById();
            header("Location: /public/article");
        } else {
            header("Location: /public/home");
        }
    }
}
