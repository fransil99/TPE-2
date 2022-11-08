<?php
require_once './libs/Router.php';
require_once './app/controllers/bikes-api.controller.php';

// crea el router
$router = new Router();

// defina la tabla de ruteo
$router->addRoute('bikes', 'GET', 'BikesApiController', 'getBikes');
$router->addRoute('bikes/:ID', 'GET', 'BikesApiController', 'getBike');
$router->addRoute('bikes/:ID', 'DELETE', 'BikesApiController', 'deleteBike');
$router->addRoute('bikes', 'POST', 'BikesApiController', 'insertBike');


// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
