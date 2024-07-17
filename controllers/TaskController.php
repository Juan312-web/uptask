<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tareas;

class TaskController
{

  public static function index()
  {

    $projectUrl = explode("=", $_SERVER['HTTP_REFERER'])[1];
    $project = Proyecto::where('url', $projectUrl);
    $projectId = $project->id;

    $query = 'SELECT * FROM tareas WHERE projectId = ' . $projectId;
    $tareas = Tareas::consultarSQL($query);


    $respuesta = [
      "tareas" => $tareas,
    ];

    echo json_encode($respuesta);
  }

  public static function createTask()
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
