<?php

namespace App\src;

use App\src\Controller\TwigController;

/**
 * Class Noyau Routeur 
 */
class Kernel extends TwigController
{
    public function start()
    {
        if (isset($_COOKIE["PHPSESSID"])) {
            session_start();
        }
        //var_dump($_SERVER);
        $params = [];
        $params = explode("/", $_SERVER["PATH_INFO"]);
        // var_dump($params);
        if (isset($params[1]) && !empty($params[1]) && $params[1] != $params[1] . '/ ') {
            $controller = "\\App\\src\\Controller\\" . ucfirst($params[1]) . "Controller";
            // var_dump($controller);
            $method = (isset($params[2])) ? $params[2] :  "index";
            //var_dump($method);
            if (isset($params[1]) && "/" . $params[1] == $_SERVER["PATH_INFO"]) {
                $data = (isset($params[3])) ? $params[3] :  "";
            } else if (isset($params[2]) && empty($params[3])) {
                $data = (isset($params[3])) ? $params[3] :  "";
            } else if (isset($params[3]) && !empty($params[3]) && intval($params[3]) == $params[3]) {
                $data = (isset($params[3])) ? $params[3] :  "";
            } else {
                header("Location:/public/home");
                // http_response_code(404);
                // echo "La donné n'est pas integer";
            }
            //var_dump($data);
            $controllers = new $controller();
            if (method_exists($controllers, $method)) {
                //J'ouvre mon fichier de destination en precisant le chemin
                $fh = fopen('../tmp/logs.txt', 'a');
                //J'écris dans le fichier
                fwrite($fh, $_SERVER['REMOTE_ADDR'] . ' ' . $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'] . ' ' . date('c') . "\n");
                //Je ferme le fichier 
                fclose($fh);

                (isset($data)) ? $controllers->$method($data) : $controllers->$method();
            } else {
                header("Location:/public/home");
                //http_response_code(404);
                //echo "Aucune methode existe";
            }
        } else {
            header('Location: /public/home');
        }
    }
}
