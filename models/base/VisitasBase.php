<?php

namespace app\models\base;

use Yii;
use app\models\Dispositivos;

/**
 * This is the model class for table "visitas".
*
    * @property integer $id
    * @property integer $dispositivo_id
    * @property double $lat
    * @property double $lng
    * @property string $fecha_creacion
    * @property string $fecha_inicio
    * @property string $fecha_final
    * @property integer $cumplimiento
    *
            * @property Dispositivos $dispositivo
    */
class VisitasBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'visitas';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['dispositivo_id', 'cumplimiento'], 'integer'],
            [['lat', 'lng'], 'number'],
            [['fecha_creacion', 'fecha_inicio', 'fecha_final'], 'safe'],
            [['dispositivo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dispositivos::className(), 'targetAttribute' => ['dispositivo_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'dispositivo_id' => 'Dispositivo ID',
    'lat' => 'Lat',
    'lng' => 'Lng',
    'fecha_creacion' => 'Fecha Creacion',
    'fecha_inicio' => 'Fecha Inicio',
    'fecha_final' => 'Fecha Final',
    'cumplimiento' => 'Cumplimiento',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getDispositivo()
    {
    return $this->hasOne(Dispositivos::className(), ['id' => 'dispositivo_id']);
    }
}