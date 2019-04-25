<?php
/**
 * Created by PhpStorm.
 * User: Carlos Canela
 * Date: 14/09/2017
 * Time: 12:29 PM
 */

class Modelo
{
    private $mensaje;
    public function __construct()
    {
        print $this->mensaje;
    }

    /**
     * @return mixed
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * @param mixed $mensaje
     */
    public function setMensaje($mensaje)
    {
        $this->mensaje = $mensaje;
    }

}