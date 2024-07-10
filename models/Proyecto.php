<?php

namespace Model;

class Proyecto extends ActiveRecord
{
  protected static $tabla = 'proyectos';
  protected static $columnasDB = ['id', 'project', 'url', 'userId'];

  public $id;
  public $project;
  public $url;
  public $userId;

  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->project = $args['project'] ?? '';
    $this->url = $args['url'] ?? '';
    $this->userId = $args['userId'] ?? '';
  }

  public function validateProject()
  {

    if (!$this->project) {
      self::$alertas['error'][] = "El nombre es obligatorio";
    }

    return self::$alertas;
  }
}
