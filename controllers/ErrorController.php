<?php

/**
 * Created by PhpStorm.
 * User: Carlos Canela
 * Date: 24/05/2017
 * Time: 01:00 PM
 */
class ErrorController
{
    public static function main(Exception $ex)
    {
//        Cfn::loadView("ejemplo");
        if(!empty($ex->getCode())){
            //si tenemos codigo de error, lo ponemos como header html
            http_response_code($ex->getCode());
        }
        switch (Router::$responseType){
            case 'json':
                print json_encode(array('error'=>$ex->getMessage()));
                break;
            case 'xml':
                print '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL.'<error>'.PHP_EOL
                    .'<message>'.$ex->getMessage().'</message>'.PHP_EOL
                    .'<code>'.$ex->getCode().'</code>'.PHP_EOL
                    .'</error>';
                break;
            default:
                include "views/error.html";
                break;
        }
    }
}