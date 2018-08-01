<?php

namespace app\models\base;

use Yii;
use app\models\Pedidos;
use app\models\Usuarios;

/**
 * This is the model class for table "calificaciones".
*
    * @property integer $id
    * @property integer $usuario_id
    * @property string $observaciones
    * @property integer $tipo
    * @property integer $puntualidad
    * @property integer $calidad_trabajo_realizado
    * @property integer $trato_cliente
    * @property integer $presentacion
    * @property integer $pedido_id
    *
            * @property Pedidos $pedido
            * @property Usuarios $usuario
    */
class CalificacionesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'calificaciones';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['usuario_id', 'tipo', 'puntualidad', 'calidad_trabajo_realizado', 'trato_cliente', 'presentacion', 'pedido_id'], 'integer'],
            [['observaciones'], 'string'],
            [['pedido_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pedidos::className(), 'targetAttribute' => ['pedido_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'usuario_id' => 'Usuario ID',
    'observaciones' => 'Observaciones',
    'tipo' => 'Tipo',
    'puntualidad' => 'Puntualidad',
    'calidad_trabajo_realizado' => 'Calidad Trabajo Realizado',
    'trato_cliente' => 'Trato Cliente',
    'presentacion' => 'Presentacion',
    'pedido_id' => 'Pedido ID',
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
    public function getUsuario()
    {
    return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }
}