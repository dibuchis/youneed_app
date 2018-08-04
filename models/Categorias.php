<?php

namespace app\models;

class Categorias extends \app\models\base\CategoriasBase
{
	public $imagen_upload;
	
	public function rules()
    {
        return array_merge(parent::rules(),
        [
            [['imagen', 'nombre', 'descripcion'], 'required'],
        ]);
    }

    public function attributeLabels()
	{
	return [
	    'id' => 'ID',
	    'nombre' => 'Nombre',
	    'slug' => 'Slug',
	    'descripcion' => 'Descripción',
	    'imagen' => 'Imagen',
	    'fecha_creacion' => 'Fecha Creación',
	];
	}
}