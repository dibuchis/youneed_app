<?php

namespace app\models;

class Ciudades extends \app\models\base\CiudadesBase
{
    public function attributeLabels()
	{
	return [
	    'id' => 'ID',
	    'canton_id' => 'Cantón',
	    'nombre' => 'Nombre',
	];
	}
}