<?php

/**
 * Created by PhpStorm.
 * User: Carlos Canela
 * Date: 09/06/2017
 * Time: 01:50 PM
 */
class Cfn
{
    /**
     * Carga el phtml de una vista localizado en la carpeta 'views'
     * @param string $view Nombre de la vista
     * @throws Exception
     */
    public static function loadView($view,$scope_vars=array()){
        extract($scope_vars,EXTR_PREFIX_SAME,"fwk_");
        if(!file_exists("views/$view.phtml")){
            throw new Exception("Vista no encontrada [$view]");
        }
        include_once "views/$view.phtml";
    }

    /**
     * Devuelve la ruta relativa hacia la carpeta resources, junto con la ruta del asset solicitado (incluyendo el nombre
     * del directorio que contiene todos los recursos
     * @param string $resource Ruta del recurso (no incluir la carpeta "resources")
     * @return string ruta relativa
     */
    public static function resourceURL($resource){
        global $url;
        $fpath="";
        $ds=(substr($_SERVER['REQUEST_URI'],-1)=="/")?sizeof($url):sizeof($url)-1;
        for($d=1;$d<=$ds;$d++){
            $fpath.="../";
        }
        return $fpath."resources/".$resource;
    }

    public static function siteRoot(){ //todo: no esta devolviendo la raiz si la url no tiene diagonal al final
        global $url;
        $fpath="";
        $ds=(substr($_SERVER['REQUEST_URI'],-1)=="/")?sizeof($url):sizeof($url)-1;
        for($d=1;$d<=$ds;$d++){
            $fpath.="../";
        }
        return $fpath;
    }

    /**
     * Carga para su uso una libreria externa. Esta libreria debe almacenarse en la capreta lib
     * Para cargarla basta tener una carpeta con el nombre de la libreria
     * Por default se busca un archivo php que tenga el mismo nombre de la libreria, aunque tambien es posible
     * usar el segundo parametro para indicar el nombre del archivo a cargar
     * @param string $mainClass Nombre de la libreria (case sensitive)
     * @param string $file Ruta del archivo a cargar si es que se especifica. Puede ser tambien una ruta interna al directorio de la clase
     * @throws Exception
     */
    public static function loadLibrary($mainClass,$file=''){
        //revisamos existe el directorio con el nombre de la libreria
        if(!file_exists("libs/$mainClass")){
            throw new Exception("Carpeta de Librería $mainClass no encontrada");
        }
        //buscamos si en el directorio existe un php con el nombre de la clase
        if(file_exists("libs/$mainClass/$mainClass.php")){
            require_once "libs/$mainClass/$mainClass.php";
        }else{
            //no se encontro archivo de clase, buscamos el que nos mandan en file
            if(empty($file)){
                throw new Exception('No se encontró una clase default en la carpeta '.$mainClass);
            }
            if(file_exists("libs/$mainClass/".$file)){
                require_once "libs/$mainClass/".$file;
            }else{
                throw new Exception("No se encontró el archivo especificado en el directorio de la libreria $mainClass");
            }
        }
    }
}