<?php

namespace app\models;

class Planes extends \app\models\base\PlanesBase
{

	public function rules()
    {
        return array_merge(parent::rules(),
        [
            [['nombre', 'descripcion', 'pvp', 'descuento_1', 'sin_descuento' ], 'required'],
        ]);
    }

	public function attributeLabels()
	{
	return [
	    'id' => 'ID',
	    'nombre' => 'Nombre',
	    'descripcion' => 'Descripción',
	    'pvp' => 'PVP',
	    'descuento_1' => 'Descuento aplicado',
	    'descuento_2' => 'Descuento 2',
	    'fecha_creacion' => 'Fecha Creación',
	];
	}
}