<?php

namespace Controllers;

use Model\Tareas;

class TaskController
{
  public static function index()
  {

    $tarea = new Tareas();
    $tarea->sincronizar($_POST);
    $tarea->projectId = intval($_POST['projectId']);

    $res = $tarea->guardar();

    $respuesta = [
      "res" => $res
    ];

    echo json_encode($respuesta);
  }
}
