<?php

/**
 * Created by PhpStorm.
 * User: Carlos Canela
 * Date: 24/12/2018
 * Time: 11:17 AM
 */
class Database
{
    private $db_usr;
    private $db_pass;
    private $db_name;
    private $db_host;
    /**
     * @var PDO
     */
    public $pdo;

    /**
     * Database constructor.
     * No recibe parametros, ingresar informacion de BD directo en el constructor de Database.php
     */
    public function __construct()
    {
        $this->db_usr = 'USUARIO_DB';
        $this->db_pass = 'PASS_USR';
        $this->db_name = 'NOMBRE_ESQU';
        $this->db_host = 'DIRECCION_HOST';
    }

    /**
     * Por cada conexion, crear una nueva instancia de "Database" y usar el metodo conectar() que devuelve un objeto PDO.
     * Se recomienda invocar el metodo close() para permitir el garbage collector de PHP cerrar la conexion a la BD que ya no se utiliza
     * @return PDO
     */
    public function conectar()
    {
        $this->pdo = new PDO(
            'mysql:host=' . $this->db_host . ';dbname=' . $this->db_name,
            $this->db_usr,
            $this->db_pass);
        return $this->pdo;
    }

    /**
     * Elimina la referencia al objeto PDO, permitiendo a PHP eventualmente cerrar la conexion a BD
     */
    public function close(){
        $this->pdo=null;
    }
}