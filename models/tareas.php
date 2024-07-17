<?php

namespace Model;

class Tareas extends ActiveRecord
{
  protected static $tabla = 'tareas';
  protected static $columnasDB = ['id', 'name', 'state',  'projectId'];

  public $id;
  public $name;
  public $state;
  public $projectId;

  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->name = $args['name'] ?? '';
    $this->state = $args['state'] ?? 0;
    $this->projectId = $args['projectId'] ?? '';
  }
}
