<?php

namespace app\models\base;

use Yii;
use app\models\Eventos;

/**
 * This is the model class for table "alertas".
*
    * @property integer $id
    * @property string $nombre
    * @property string $color
    * @property string $icono
    *
            * @property Eventos[] $eventos
    */
class AlertasBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'alertas';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['nombre'], 'string', 'max' => 200],
            [['color'], 'string', 'max' => 7],
            [['icono'], 'string', 'max' => 45],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'nombre' => Yii::t('app', 'Nombre'),
    'color' => Yii::t('app', 'Color'),
    'icono' => Yii::t('app', 'Icono'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getEventos()
    {
    return $this->hasMany(Eventos::className(), ['alerta_id' => 'id']);
    }
}