<?php

namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;

use function PHPSTORM_META\map;

class DashboardController
{
  public static function index(Router $router)
  {
    session_start();
    isAuth();
    $proyectosDB = Proyecto::all();

    $proyectos = array_filter($proyectosDB, function ($proyecto) {
      return $proyecto->userId === $_SESSION['id'];
    });



    $router->render('dashboard/index', ["titulo" => "project", "proyectos" => $proyectos]);
  }

  public static function createProject(Router $router)
  {
    session_start();
    isAuth();

    $alertas = [];
    $proyecto = new Proyecto();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $proyecto->sincronizar($_POST);
      $alertas = $proyecto->validateProject();

      if (empty($alertas)) {

        // Generar URL
        $hash = md5(uniqid());
        $proyecto->url = $hash;
        $proyecto->userId = $_SESSION['id'];

        $proyecto->guardar();

        header('location: /project?id=' . $proyecto->url);
      }
    }

    $router->render('dashboard/create-project', ["titulo" => "createProject", "alertas" => $alertas]);
  }

  public static function project(Router $router)
  {
    session_start();
    isAuth();
    $url = $_GET['id'];

    // ? Validar URL
    if (!$url) header('location: /dashboard');

    // ? Confirmar Dueño Proyecto
    $proyecto = Proyecto::where('url', $url);

    if ($proyecto->userId !== $_SESSION['id']) {
      header('location: /dashboard');
    }

    // ? Asignar Nombre de Proyecto
    $nombre = $proyecto->project;

    $router->render('dashboard/project', ["titulo" => $nombre, "projectId" => $proyecto->id]); //  "alertas" => $alertas
  }

  public static function profile(Router $router)
  {
    session_start();
    isAuth();

    $alertas = [];
    $userId = $_SESSION['id'];
    $usuario = new Usuario();

    if ($userId) {
      $respuesta = Usuario::where("id", $userId);
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $usuario->sincronizar($_POST);
      $alertas = $usuario->validateUpdateUser();

      if (empty($alertas)) {


        if ($usuario->password) {
          $usuario->hashPassword();
          $respuesta->password = $usuario->password;
        }

        $respuesta->name = $usuario->name;
        $_SESSION['name'] = $respuesta->name;

        $respuesta->guardar();
        header("location: /profile");
      }
    }

    $router->render('dashboard/profile', ["titulo" => "profile", "usuario" => $respuesta, "alertas" => $alertas]);
  }
}
