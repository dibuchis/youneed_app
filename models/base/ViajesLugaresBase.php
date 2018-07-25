<?php

namespace app\models\base;

use Yii;
use app\models\Lugares;
use app\models\Viajes;

/**
 * This is the model class for table "viajes_lugares".
*
    * @property integer $id
    * @property integer $viaje_id
    * @property integer $lugar_id
    * @property string $fecha_ingreso
    * @property string $fecha_salida
    *
            * @property Lugares $lugar
            * @property Viajes $viaje
    */
class ViajesLugaresBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'viajes_lugares';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['viaje_id', 'lugar_id'], 'integer'],
            [['fecha_ingreso', 'fecha_salida'], 'safe'],
            [['lugar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lugares::className(), 'targetAttribute' => ['lugar_id' => 'id']],
            [['viaje_id'], 'exist', 'skipOnError' => true, 'targetClass' => Viajes::className(), 'targetAttribute' => ['viaje_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'viaje_id' => Yii::t('app', 'Viaje ID'),
    'lugar_id' => Yii::t('app', 'Lugar ID'),
    'fecha_ingreso' => Yii::t('app', 'Fecha Ingreso'),
    'fecha_salida' => Yii::t('app', 'Fecha Salida'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getLugar()
    {
    return $this->hasOne(Lugares::className(), ['id' => 'lugar_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getViaje()
    {
    return $this->hasOne(Viajes::className(), ['id' => 'viaje_id']);
    }
}