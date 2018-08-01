<?php

namespace app\models\base;

use Yii;
use app\models\Pedidos;
use app\models\Servicios;

/**
 * This is the model class for table "items".
*
    * @property integer $id
    * @property integer $pedido_id
    * @property integer $servicio_id
    * @property integer $cantidad
    * @property string $costo_unitario
    * @property string $costo_total
    *
            * @property Pedidos $pedido
            * @property Servicios $servicio
    */
class ItemsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'items';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['pedido_id'], 'required'],
            [['pedido_id', 'servicio_id', 'cantidad'], 'integer'],
            [['costo_unitario', 'costo_total'], 'string', 'max' => 45],
            [['pedido_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pedidos::className(), 'targetAttribute' => ['pedido_id' => 'id']],
            [['servicio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servicios::className(), 'targetAttribute' => ['servicio_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'pedido_id' => 'Pedido ID',
    'servicio_id' => 'Servicio ID',
    'cantidad' => 'Cantidad',
    'costo_unitario' => 'Costo Unitario',
    'costo_total' => 'Costo Total',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPedido()
    {
    return $this->hasOne(Pedidos::className(), ['id' => 'pedido_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getServicio()
    {
    return $this->hasOne(Servicios::className(), ['id' => 'servicio_id']);
    }
}