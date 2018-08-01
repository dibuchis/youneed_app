<?php

namespace app\models;

class Tarjetas extends \app\models\base\TarjetasBase
{
    public function attributeLabels()
	{
	return [
	    'id' => 'ID',
	    'numero' => 'Número',
	    'token_tarjeta' => 'Token de Tarjeta',
	    'cvv' => 'CVV',
	    'fecha_creacion' => 'Fecha Creación',
	    'predeterminada' => 'Predeterminada',
	    'marca' => 'Marca',
	    'usuario_id' => 'Cliente/Asociado',
	];
	}
}