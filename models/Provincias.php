<?php

namespace app\models;

class Provincias extends \app\models\base\ProvinciasBase
{
    public function attributeLabels()
	{
	return [
	    'id' => 'ID',
	    'pais_id' => 'País',
	    'nombre' => 'Nombre',
	];
	}
}