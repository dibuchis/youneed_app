<?php

namespace app\models;

class Provincias extends \app\models\base\ProvinciasBase
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