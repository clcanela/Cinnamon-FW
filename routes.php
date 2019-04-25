<?php
/**
 * Created by PhpStorm.
 * User: Carlos Canela
 * Date: 24/05/2017
 * Time: 05:37 PM
 */

Router::addRoute("post","Ejemplo");
Router::addRoute("post/{pid}/edit/{cmd}","Ejemplo","comodinDoble");
Router::addRoute("post/{pid}/edit","Ejemplo", "comodin");
Router::addRoute("post/aitre/edit","Ejemplo", "aitre");
Router::addRoute("una/ruta/muy/larga/exagerada/final","Ejemplo", "main");
Router::addRoute("no/tan/larga","Ejemplo", "main");
Router::addRoute("corta","Ejemplo", "main");
Router::addRoute("ejemplo/modelo","Ejemplo","modelo_ejemplo");
