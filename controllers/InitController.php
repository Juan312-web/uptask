<?php

namespace Controllers;

use MVC\Router;

class InitController
{
  public static function index(Router $router)
  {
    $router->render('/index', []);
  }

  public static function notFound(Router $router)
  {
    $router->render('components/notFound');
  }

  public static function confirmaciones(Router $router)
  {
    $router->render('components/confirmaciones');
  }
}
