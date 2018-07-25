<?php

namespace app\models\base;

use Yii;
use app\models\Conductores;
use app\models\Dispositivos;

/**
 * This is the model class for table "turnos".
*
    * @property integer $id
    * @property integer $dispositivo_id
    * @property integer $conductor_id
    * @property string $fecha_inicio
    * @property string $fecha_final
    * @property string $observaciones
    *
            * @property Conductores $conductor
            * @property Dispositivos $dispositivo
    */
class TurnosBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'turnos';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['dispositivo_id', 'conductor_id', 'fecha_inicio', 'fecha_final'], 'required'],
            [['dispositivo_id', 'conductor_id'], 'integer'],
            [['fecha_inicio', 'fecha_final'], 'safe'],
            [['observaciones'], 'string'],
            [['conductor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Conductores::className(), 'targetAttribute' => ['conductor_id' => 'id']],
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
    'conductor_id' => 'Conductor ID',
    'fecha_inicio' => 'Fecha Inicio',
    'fecha_final' => 'Fecha Final',
    'observaciones' => 'Observaciones',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getConductor()
    {
    return $this->hasOne(Conductores::className(), ['id' => 'conductor_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getDispositivo()
    {
    return $this->hasOne(Dispositivos::className(), ['id' => 'dispositivo_id']);
    }
}