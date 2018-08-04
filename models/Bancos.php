<?php

namespace app\models;

class Bancos extends \app\models\base\BancosBase
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
	    'nombre' => 'Nombre',
	];
	}
}