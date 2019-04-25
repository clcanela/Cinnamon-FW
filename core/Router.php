<?php

/**
 * Created by PhpStorm.
 * User: Carlos Canela
 * Date: 24/05/2017
 * Time: 10:18 AM
 */
class Router
{
    /**
     * @var static $responseType indica el tipo de respuesta de esta peticion
     */
    public static $responseType;
    private static $routes;

    //revisa la url y establece el tipo de respuesta, el controlador y el metodo a buscar
    public static function init($url = array())
    {
        try {
            //si no hay routes definidas, iniciamos como arreglo vacio
            if (!is_array(self::$routes)) {
                self::$routes = array();
            }
            self::$responseType = 'html';
            //la url podria venir vacia
            if (!empty($url)) {
                //buscamos formato y establecemos response type
                self::setResponseType($url);
                //llamamos controlador-metodo-vista
            } else {
                //url vacia, mandamos a index
                array_push($url, "index");
            }
            self::callCV($url);
        } catch (Exception $ex) {
            ErrorController::main($ex);
        }
    }

    public static function addRoute($path, $controller, $method = "main")
    {
        if (!is_array(self::$routes)) {
            self::$routes = array();
        }
        $route = new stdClass();
        $route->path = $path;
        $route->controller = $controller;
        $route->method = $method;
        array_push(self::$routes, $route);
    }

    private static function callCV($url)
    {

        //revisamos primero si se encuentra definido en las rutas
        $rutes_match = array();
        $params = array();
        foreach (self::$routes as $rts) {
            if (self::compareRoute($url, $rts)) {
                //revisamos full match de ruta
                array_push($rutes_match, $rts);
            }
        }
        if (!empty($rutes_match)) {
            //tenemos routas candidatas en $rutes_match
            $route = null;
            foreach ($rutes_match as $rt) {
                if (implode("/", $url) == $rt->path) {
                    $route = $rt;
                    break;
                }
            }
            if (empty($route)) {
                $route = $rutes_match[0];
            }
            $_controller = $route->controller;
            $_method = $route->method;
            //obtenemos parametros en url (por comodin)
            foreach (explode("/", $route->path) as $inx => $part) {
                if (preg_match("/(\{)(.+)(\})/", $part, $ret)) {
                    $params[$ret[2]] = $url[$inx];
                }
            }
        } else {
            //no hizo match ninguna ruta, sacamos directo de URL
            //la clase del controlador existe, despachamos metodo si existe
            $_controller = $url[0];
            $_method = (isset($url[1])) ? $url[1] : 'main';
        }
        //obtenemos controlador, metodo, parametros
        if (!class_exists($_controller)) {
            throw new Exception("La URL ingresada (".$_controller.") no se encuentra en el sistema",404);//todo: enviar error statushttp
        }
        if (!is_callable($_controller . "::" . $_method)) {
            throw new Exception("Metodo no reconocido en el controlador", 501);
        }
        //revisamos el tipo de reponse para imprimir return o solo ejecutar (phtml)
        switch (self::$responseType) {
            case 'html':
                print call_user_func_array($_controller . "::" . $_method, array($params));
                break;
            case 'json':
                print json_encode(call_user_func_array($_controller . "::" . $_method, array($params)));
                break;
            default:
                //todo: considerar si para XML armamos aqui el objeto o se recibe ya un simpleXML y solo se manda imprimir
                call_user_func_array($_controller . "::" . $_method, array($params));
                break;
        }
    }

    private static function setResponseType(&$url)
    {
        if (preg_match('/((\.json)|(\.csv)|(\.xml))/i', $url[sizeof($url) - 1], $ext)) {
            switch (strtolower($ext[0])) {
                case '.json':
                    header('Content-type: application/json');
                    self::$responseType = 'json';
                    break;
                case '.csv':
                    header('Content-type: text/csv');
                    header("Content-Disposition:attachment;'");
                    self::$responseType = 'csv';
                    break;
                case '.xml':
                    header('Content-type: application/xml');
                    self::$responseType = 'xml';
                    break;
            }
        }
        //limpiamos extension de la URL
        if (preg_match("/(.+)(\." . self::$responseType . ")/i", $url[sizeof($url) - 1], $part)) {
            $url[sizeof($url) - 1] = $part[1];
        }
    }

    /**
     * Compara, tramo por tramo, la url contra la ruta definida
     * @param $url
     * @param $route
     * @param int $pos
     */
    private static function compareRoute($url, $route)
    {
        $comp = implode("/", $url);//armamos url textual
        $rt_regx = preg_replace(array("(\/)", "(\{[^\}\/]+\})"), array("\\/", "[^\}\/]+"), $route->path);
        if (preg_match("/(" . $rt_regx . ")$/i", $comp)) {
            return true;
        } else {
            return false;
        }
    }
}