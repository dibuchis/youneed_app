<?php

namespace app\models\base;

use Yii;
use app\models\Notificaciones;

/**
 * This is the model class for table "tipos_notificaciones".
*
    * @property integer $id
    * @property integer $categoria
    * @property string $descripcion
    * @property string $mensaje
    *
            * @property Notificaciones[] $notificaciones
    */
class TiposNotificacionesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'tipos_notificaciones';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['categoria'], 'integer'],
            [['descripcion', 'mensaje'], 'required'],
            [['descripcion', 'mensaje'], 'string', 'max' => 200],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'categoria' => 'Categoria',
    'descripcion' => 'Descripcion',
    'mensaje' => 'Mensaje',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getNotificaciones()
    {
    return $this->hasMany(Notificaciones::className(), ['tipo_notificacion_id' => 'id']);
    }
}