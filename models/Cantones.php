<?php

namespace app\models;

class Cantones extends \app\models\base\CantonesBase
{
    public function attributeLabels()
	{
	return [
	    'id' => 'ID',
	    'provincia_id' => 'Provincia',
	    'nombre' => 'Nombre',
	];
	}
}