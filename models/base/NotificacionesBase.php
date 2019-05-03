<?php

namespace app\models\base;

use Yii;
use app\models\TiposNotificaciones;
use app\models\Usuarios;

/**
 * This is the model class for table "notificaciones".
*
    * @property integer $id
    * @property integer $usuario_id
    * @property integer $tipo_notificacion_id
    * @property string $fecha_notificacion
    *
            * @property TiposNotificaciones $tipoNotificacion
            * @property Usuarios $usuario
    */
class NotificacionesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'notificaciones';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['usuario_id', 'tipo_notificacion_id'], 'required'],
            [['usuario_id', 'tipo_notificacion_id'], 'integer'],
            [['fecha_notificacion'], 'safe'],
            [['tipo_notificacion_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposNotificaciones::className(), 'targetAttribute' => ['tipo_notificacion_id' => 'id']],
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
    'tipo_notificacion_id' => 'Tipo Notificacion ID',
    'fecha_notificacion' => 'Fecha Notificacion',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTipoNotificacion()
    {
    return $this->hasOne(TiposNotificaciones::className(), ['id' => 'tipo_notificacion_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuario()
    {
    return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }
}