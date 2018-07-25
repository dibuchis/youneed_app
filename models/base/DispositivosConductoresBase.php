<?php

namespace app\models\base;

use Yii;
use app\models\Conductores;
use app\models\Dispositivos;

/**
 * This is the model class for table "dispositivos_conductores".
*
    * @property integer $id
    * @property integer $dispositivo_id
    * @property integer $conductor_id
    *
            * @property Conductores $conductor
            * @property Dispositivos $dispositivo
    */
class DispositivosConductoresBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'dispositivos_conductores';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['dispositivo_id', 'conductor_id'], 'required'],
            [['dispositivo_id', 'conductor_id'], 'integer'],
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
    'id' => Yii::t('app', 'ID'),
    'dispositivo_id' => Yii::t('app', 'Dispositivo ID'),
    'conductor_id' => Yii::t('app', 'Conductor ID'),
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