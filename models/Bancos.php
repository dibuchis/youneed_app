<?php

namespace app\models;

class Bancos extends \app\models\base\BancosBase
{
    public function attributeLabels()
	{
	return [
	    'id' => 'ID',
	    'nombre' => 'Nombre',
	];
	}
}