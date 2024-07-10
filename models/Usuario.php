<?php

namespace Model;

class Usuario extends ActiveRecord
{
  protected static $tabla = 'usuarios';
  protected static $columnasDB = ['id', 'name', 'email', 'password', 'token', 'confirm'];

  public $id;
  public $name;
  public $email;
  public $password;
  public $token;
  public $confirm;


  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->name = $args['name'] ?? '';
    $this->email = $args['email'] ?? '';
    $this->password = $args['password'] ?? '';
    $this->token = $args['token'] ?? '';
    $this->confirm = $args['confirm'] ?? 0;
  }

  public function validatePasswordVerify($res)
  {
    $verify = password_verify($this->password, $res->password);
    return $verify;
  }

  public function validateLogin()
  {
    if (!$this->email) {
      self::$alertas['error'][] = "el correo es obligatorio";
    }

    if (!$this->password || strlen($this->password) < 6) {
      self::$alertas['error'][] = "la contraseña debe tener minimo 6 caracteres";
    }

    return self::$alertas;
  }

  public function validateUser()
  {

    if (!$this->name) {
      self::$alertas['error'][] = "el nombre es obligatorio";
    }

    if (!$this->email) {
      self::$alertas['error'][] = "el correo es obligatorio";
    }

    if (!$this->password || strlen($this->password) < 6) {
      self::$alertas['error'][] = "la contraseña debe tener minimo 6 caracteres";
    } elseif ($this->password != $_POST['repeat-password']) {
      self::$alertas['error'][] = "las contraseñas no coinciden";
    }

    return self::$alertas;
  }

  public function validateUpdateUser()
  {

    if (!$this->name) {
      self::$alertas['error'][] = "el nombre es obligatorio";
    }


    if ($_POST['password']) {
      if (!$this->password || strlen($this->password) < 6) {
        self::$alertas['error'][] = "la contraseña debe tener minimo 6 caracteres";
      } elseif ($this->password != $_POST['repeat-password']) {
        self::$alertas['error'][] = "las contraseñas no coinciden";
      }
    }

    return self::$alertas;
  }
  public function validateNewUser()
  {
    $resultado = Usuario::where('email', $this->email);

    if ($resultado) {
      self::$alertas['error'][] = "Usuario ya existente";
    }

    return self::$alertas;
  }


  public function hashPassword()
  {
    $this->password = password_hash($this->password, PASSWORD_DEFAULT);
  }

  public function createToken()
  {
    $this->token = uniqid();
  }

  public function validatePassword()
  {
    if (!$this->password || strlen($this->password) < 6) {
      self::$alertas['error'][] = "la contraseña debe tener minimo 6 caracteres";
    } elseif ($this->password != $_POST['repeat-password']) {
      self::$alertas['error'][] = "las contraseñas no coinciden";
    }

    return self::$alertas;
  }
}
