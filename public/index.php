<?php
ob_start();
define('PUBLIC_FOLDER', str_replace("public/index.php", "", $_SERVER["SCRIPT_NAME"]));
define('ROOT_FOLDER', str_replace("public/index.php", "", $_SERVER["SCRIPT_FILENAME"]));

//Files
require (ROOT_FOLDER. '/config/core.php');
require (ROOT_FOLDER. '/Router.php');

//Composer autoload
require ROOT_FOLDER . '/vendor/autoload.php';

//Template
require (ROOT_FOLDER. 'Core/Controller.php');

if (!file_exists(ROOT_FOLDER. 'cache'))
    mkdir(ROOT_FOLDER. 'cache', 0775, true);

Router::parse();

ob_end_flush();
