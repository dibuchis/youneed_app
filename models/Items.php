<?php

namespace app\models;
use Yii;
use app\models\Util;

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

	public function rules()
    {
        return array_merge(parent::rules(),
        [
            [['pedido_id', 'servicio_id', 'cantidad', 'costo_unitario', 'asociado_id'], 'required'],
        ]);
    }

	// public function afterSave($insert, $changedAttributes)
	// {
	// 	parent::afterSave($insert, $changedAttributes);
	// 	// if ( !$this->isNewRecord )
	//     	Util::calcularPedido( $this->pedido_id );
	//     	die();
	// }

}