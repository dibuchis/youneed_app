<?php

namespace app\models\base;

use Yii;
use app\models\Servicios;
use app\models\Usuarios;

/**
 * This is the model class for table "usuarios_servicios".
*
    * @property integer $id
    * @property integer $usuario_id
    * @property integer $servicio_id
    *
            * @property Servicios $servicio
            * @property Usuarios $usuario
    */
class UsuariosServiciosBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'usuarios_servicios';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['usuario_id', 'servicio_id'], 'required'],
            [['usuario_id', 'servicio_id'], 'integer'],
            [['servicio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servicios::className(), 'targetAttribute' => ['servicio_id' => 'id']],
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
    'servicio_id' => 'Servicio ID',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getServicio()
    {
    return $this->hasOne(Servicios::className(), ['id' => 'servicio_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuario()
    {
    return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }
}