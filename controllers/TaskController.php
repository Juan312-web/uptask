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

  public static function findTask()
  {
    $id = $_GET['id'];
    $task = Tareas::where('id', $id);
    $taskState = $task->state;

    $newState = ($taskState === "0") ? "1" : "0";
    $task->state = $newState;
    $task->guardar();

    echo json_encode($task);
  }

  public static function deleteTask()
  {
    $id = $_GET['id'];

    if ($id) {
      $task = Tareas::find($id);
      $respuesta = $task->eliminar();
    }

    echo json_encode($respuesta);
  }

  public static function updateTask()
  {
    $taskId = intval($_POST["id"]);
    $taskName = $_POST["name"];

    $task = Tareas::where('id', $taskId);

    $task->id = $taskId;
    $task->name = $taskName;

    $res = $task->guardar();

    echo json_encode($res);
  }
}
