<?php
/**
 * Created by PhpStorm.
 * User: Carlos Canela
 * Date: 23/05/2017
 * Time: 12:52 PM
 */
session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

require_once "core/Bootstrap.php";
include "routes.php";

Router::init($url);
