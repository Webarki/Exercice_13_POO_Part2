<?php

//Obtien le repertoire courant
define('ROOT',  dirname(__DIR__) . '/');

use App\Autoloader;
use App\src\Kernel;

include "../vendor/autoload.php";
include ROOT . "Autoloader.php";

Autoloader::register();

$app = new Kernel();

$app->start();
