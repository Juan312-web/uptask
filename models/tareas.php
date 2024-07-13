<?php

namespace Model;

class Tareas extends ActiveRecord
{
  protected static $tabla = 'tareas';
  protected static $columnasDB = ['id', 'name', 'projectId'];

  public $id;
  public $name;
  public $projectId;

  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->name = $args['name'] ?? '';
    $this->projectId = $args['projectId'] ?? '';
  }
}
