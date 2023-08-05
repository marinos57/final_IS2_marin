<?php


namespace Model;


class Especialidad extends ActiveRecord{
    public static $tabla = 'especialidades';
    public static $columnasDB = ['especialidad_nombre','especialidad_situacion'];
    public static $idTabla = 'especialidad_id';

    public $especialidad_id;
    public $especialidad_nombre;
    public $especialidad_situacion;

    public function __construct($args = [] )
    {
        $this->especialidad_id = $args['especialidad_id'] ?? null;
        $this->especialidad_nombre = $args['especialidad_nombre'] ?? '';
        $this->especialidad_situacion = $args['especialidad_situacion'] ?? '';
    }

}