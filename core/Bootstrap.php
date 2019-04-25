<?php
/**
 * Created by PhpStorm.
 * User: Carlos Canela
 * Date: 24/05/2017
 * Time: 01:20 PM
 */
require_once "core/Cfn.php";
require_once "core/Router.php";
require_once "core/Database.php";
require_once "controllers/ErrorController.php";
//obtenemos piezas de la url
$url = array();
if (isset($_GET['reqgtwy_'])) {//$_GET['reqgtwy_'] se define en el .htaccess
    $url = filter_var($_GET['reqgtwy_'], FILTER_SANITIZE_URL);
    $url = explode('/', $url);
    $url = array_filter($url);
}

function __autoload($class)
{
    //se busca clase con el nombre de archivo igual (incluyendo minusculas o primera mayuscula)
    //esto se hace para sistemas linux que son case sensitive
    if (file_exists('controllers/' . ucfirst($class) . '.php')) {
        include 'controllers/' . ucfirst($class) . '.php';
    } elseif (file_exists('controllers/' . $class . '.php')) {
        include 'controllers/' . $class . '.php';
    } elseif (file_exists('models/' . ucfirst($class) . '.php')) {
        include 'models/' . ucfirst($class) . '.php';
    } elseif (file_exists('models/' . $class . '.php')) {
        include 'models/' . $class . '.php';
    } else {
        return false;
    }
    // Verificar si la sentencia include declaro la clase
    if (!class_exists($class, false)) {
        trigger_error("No es posible cargar la clase: $class", E_USER_WARNING);
    }
}