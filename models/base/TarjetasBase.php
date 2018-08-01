<?php

namespace app\models\base;

use Yii;
use app\models\Pedidos;
use app\models\Usuarios;

/**
 * This is the model class for table "tarjetas".
*
    * @property integer $id
    * @property string $numero
    * @property string $token_tarjeta
    * @property string $cvv
    * @property string $fecha_creacion
    * @property integer $predeterminada
    * @property integer $marca
    * @property integer $usuario_id
    *
            * @property Pedidos[] $pedidos
            * @property Usuarios $usuario
    */
class TarjetasBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'tarjetas';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['fecha_creacion'], 'safe'],
            [['predeterminada', 'marca', 'usuario_id'], 'integer'],
            [['usuario_id'], 'required'],
            [['numero', 'cvv'], 'string', 'max' => 45],
            [['token_tarjeta'], 'string', 'max' => 450],
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
    'numero' => 'Numero',
    'token_tarjeta' => 'Token Tarjeta',
    'cvv' => 'Cvv',
    'fecha_creacion' => 'Fecha Creacion',
    'predeterminada' => 'Predeterminada',
    'marca' => 'Marca',
    'usuario_id' => 'Usuario ID',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPedidos()
    {
    return $this->hasMany(Pedidos::className(), ['tarjeta_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuario()
    {
    return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }
}