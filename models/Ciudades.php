<?php

namespace app\models;

class Ciudades extends \app\models\base\CiudadesBase
{
	public function rules()
    {
        return array_merge(parent::rules(),
        [
            [['nombre'], 'required'],
        ]);
    }
    
    public function attributeLabels()
	{
	return [
	    'id' => 'ID',
	    'pais_id' => 'País',
	    'nombre' => 'Nombre',
	];
	}
}