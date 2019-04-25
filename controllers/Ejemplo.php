<?php

/**
 * Created by PhpStorm.
 * User: Carlos Canela
 * Date: 24/05/2017
 * Time: 01:00 PM
 */
class Ejemplo
{
    public static function main()
    {
        Cfn::loadView("ejemplo");
    }

    /**
     * Ejemplo que recibe dos parametros nombrados via la URL y devuelve un objeto que sera convertido a JSON por la aplicacion
     * @param $vars
     * @return array
     */
    public static function comodinDoble($vars)
    {
        $respuesta=new stdClass();
        $respuesta->parametro1=$vars['pid'];
        $respuesta->parametro2=$vars['cmd'];
        $respuesta->parametro3="Esto se hizo desde Ejemplo::comodinDoble";
        return $respuesta;
    }

    public static function aitre($vars)
    {
        print "SOY AITRE";
        print_r($vars);
    }

    public static function comodin($vars)
    {
        print "Metodo Comodin. PDI=" . $vars['pid'];
        print "<br/> CMD=" . $vars['cmd'];
    }

    public static function vista()
    {
        $objeto = new stdClass();
        $objeto->param1 = 'parametro uno';
        $objeto->param2 = 'parametro dos';
        $mis_variables = array(
            'titulo' => "Controlador Ejemplo",
            'var2' => "Me definieron en el controller",
            'objeto' => $objeto);
        Cfn::loadView("ejemplo", $mis_variables);
    }

    /**
     * Ejemplo de uso de un modelo localizado en la carpeta "models"
     */
    public static function modelo_ejemplo(){
        $modelo= new Modelo();
        $modelo->setMensaje("mensaje ejemplo");
        print $modelo->getMensaje();
    }
}