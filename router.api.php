<?php

require_once 'libs/Router.php';
require_once 'app/controllers/api.tablaPrendas.controller.php';
require_once 'app/controllers/api.detallesPrenda.controller.php';

$router = new Router();

//          -------- SECCIÓN TABLA DE PRENDAS -----------

// Para obtener todas las prendas y ordenar asc o desc
$router->addRoute('prendas','GET', 'ApiTablaPrendasController', 'get');

// Para obtener una prenda por id
$router->addRoute('prendas/:ID','GET','ApiTablaPrendasController','get');

// Para filtrar prendas menores a un costo en específico
$router->addRoute('prendas/filtro/costos','GET','ApiTablaPrendasController','filter');

// Para eliminar una prenda dado un id
$router->addRoute('prendas/:ID','DELETE','ApiTablaPrendasController','delete');

// Para agregar una prenda
$router->addRoute('prendas','POST','ApiTablaPrendasController','add');

// Para editar una prenda dado un id
$router->addRoute('prendas/:ID','PUT','ApiTablaPrendasController','update');





//          -------- SECCIÓN TABLA DETALLES DE LAS PRENDAS -----------


// Para obtener todos los detalles de las prendas y ordenar asc o desc
$router->addRoute('detalles','GET', 'ApiDetallesPrendaController', 'get');

// Para obtener el detalle de una prenda en específico
$router->addRoute('detalles/:ID','GET', 'ApiDetallesPrendaController', 'get');

// Para filtrar la cantidad de stock disponible de las prendas en específico
$router->addRoute('detalles/filtro/stocks','GET','ApiDetallesPrendaController','filter');

// Para eliminar el detalle de una prenda 
$router->addRoute('detalles/:ID','DELETE','ApiDetallesPrendaController','delete');

// Para agregar el detalle de una prenda
$router->addRoute('detalles','POST','ApiDetallesPrendaController','add');

// Para editar el detalle de una prenda dado un id
$router->addRoute('detalles/:ID','PUT','ApiDetallesPrendaController','update');

$router->route($_REQUEST['resource'], $_SERVER['REQUEST_METHOD']);
