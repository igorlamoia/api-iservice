<?php

session_start();
// require('Core/Core.php');
ini_set('display_errors',1);ini_set('display_startup_erros',1);error_reporting(E_ALL);

date_default_timezone_set("America/Sao_Paulo");
    setlocale(LC_ALL, 'pt_BR');

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: *");

    if (isset($_SERVER['HTTP_ORIGIN'])) {

        //header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Credentials: true');
        header("Access-Control-Allow-Methods: *");
    }

    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: *");
        if (isset($_SERVER['HTTP_ACCESS_CONWTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
    }


require 'config.php';
require 'routers.php';
require 'vendor/autoload.php';


$core = new Core\Core();
$core->run();
