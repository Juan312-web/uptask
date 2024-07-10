<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
  public static function index(Router $router)
  {
    session_start();

    $alertas = [];
    $usuario = new Usuario();

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
      $usuario->sincronizar($_POST);
      $alertas = $usuario->validateLogin();

      if (empty($alertas)) {
        $respuesta = $usuario->where("email", $usuario->email);

        if (!$respuesta) {
          Usuario::setAlerta("error", "Usuario no encontrado");
          $alertas = Usuario::getAlertas();
        }

        if (!$usuario->validatePasswordVerify($respuesta) || !$respuesta->confirm) {
          Usuario::setAlerta("error", "correo o contraseña incorrectos o cuenta no confirmada");
          $alertas = Usuario::getAlertas();
        }


        if (empty($alertas)) {
          $_SESSION['login'] = true;
          $_SESSION['name'] = $respuesta->name;
          $_SESSION['id'] = $respuesta->id;

          header("location: /dashboard");
        }
      }
    }

    $router->render('auth/login', ["alertas" => $alertas, "usuario" => $usuario]);
  }

  public static function logout()
  {
    session_start();

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
      unset($_SESSION['login']);
      header("location: /");
    }
  }

  public static function createAccount(Router $router)
  {
    session_start();



    $usuario = new Usuario();
    $alertas = [];

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
      $usuario->sincronizar($_POST);

      $alertas = $usuario->validateUser();

      if (empty($alertas)) {
        // hash Password
        $usuario->hashPassword();
        $usuario->createToken();

        $alertas = $usuario->validateNewUser();

        if (empty($alertas)) {

          // ? Enviar Email
          $email = new Email($usuario->email, $usuario->name, $usuario->token);
          $email->sendConfirmation();

          $usuario->guardar();
          Usuario::setAlerta("exito", "Revisa tu correo, hemos enviado un mensaje de confirmación");
          $alertas = Usuario::getAlertas();
        }
      }
    }

    $router->render('auth/create', [
      "usuario" => $usuario,
      "alertas" => $alertas
    ]);
  }

  public static function forgotPassword(Router $router)
  {
    session_start();

    $alertas = [];
    $usuario = new Usuario();

    if ($_SERVER['REQUEST_METHOD'] === "POST") {

      $email = $_POST['email'];
      $usuario = $usuario->where("email", $email);

      if (!$usuario) {
        Usuario::setAlerta("error", "Usuario no encontrado");
        $alertas = Usuario::getAlertas();
      }

      if (empty($alertas)) {
        // ? Crear Token
        $usuario->createToken();
        $usuario->guardar();


        // ? Enviar Email de validación
        $email = new Email($usuario->email, $usuario->name, $usuario->token);
        $email->sendInstructions();

        // ? Set alertas
        Usuario::setAlerta("exito", "Hemos enviado un correo con las instrucciones");
        $alertas = Usuario::getAlertas();
      }
    }

    $router->render('auth/forgot', ["alertas" => $alertas]);
  }

  public static function recoveryPassword(Router $router)
  {
    session_start();


    $alertas = [];
    $usuario = new Usuario();

    $token = $_GET['token'];
    $usuario = Usuario::where("token", $token);

    if (!$usuario) {
      header('location: /not-found');
    }

    if ($_SERVER['REQUEST_METHOD'] === "POST") {

      $usuarioPOST = new Usuario();
      $usuarioPOST->sincronizar($_POST);

      $alertas = $usuarioPOST->validatePassword();

      if (empty($alertas)) {

        $usuario->token = null;
        $usuario->password = $token;
        $usuario->hashPassword();

        $usuario->guardar();
        header("location: /confirmaciones");
      }
    }

    $router->render("auth/recovery", ["alertas" => $alertas]);
  }

  public static function message(Router $router)
  {
    echo "Desde message";
  }

  public static function confirm(Router $router)
  {

    session_start();


    $token = $_GET['token'];

    $usuario = Usuario::where("token", $token);

    if (!$usuario) {
      header('location: /not-found');
    }

    $usuario->token = null;
    $usuario->confirm = '1';

    $usuario->guardar();

    $router->render('auth/confirm', []);
  }
}
