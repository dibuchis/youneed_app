<?php

namespace app\models;

class Items extends \app\models\base\ItemsBase
{
	public function attributeLabels()
	{
	return [
	    'id' => 'ID',
	    'pedido_id' => 'Pedido',
	    'servicio_id' => 'Servicio',
	    'cantidad' => 'Cantidad',
	    'costo_unitario' => 'Costo Unitario',
	    'costo_total' => 'Costo Total',
	];
	}   
}