<?php

namespace App;

class Autoloader
{
    static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    static function autoload($class)
    {
        //var_dump($class);
        //Permet de retirer le namspace de la chaine de caractére
        $class = str_replace(__NAMESPACE__ . '\\', '', $class);
        //Permet de replacer l'antislache par un slache
        $class = str_replace('\\', '/', $class);
        //Créer le Path du fichier
        $file = __DIR__ . '/' . $class . '.php';
        //Vérifie si le fichier existe
        if (file_exists($file)) {
            //var_dump($file);
            include $file;
        } else {
            header("Location:/");
        }
    }
}
