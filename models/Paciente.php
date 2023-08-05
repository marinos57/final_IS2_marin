<?php

namespace Model;

class Especialidad extends ActiveRecord{
    public static $tabla = 'pacientes';
    public static $columnasDB = ['paciente_nombre','paciente_dpi','paciente_telefono', 'paciente_situacion'];
    public static $idTabla = 'paciente_id';