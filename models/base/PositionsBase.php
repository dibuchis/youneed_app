<?php

namespace app\models\base;

use Yii;
use app\models\Eventos;
use app\models\Devices;

/**
 * This is the model class for table "positions".
*
    * @property integer $id
    * @property string $protocol
    * @property integer $deviceid
    * @property string $servertime
    * @property string $devicetime
    * @property string $fixtime
    * @property boolean $valid
    * @property double $latitude
    * @property double $longitude
    * @property double $altitude
    * @property double $speed
    * @property double $course
    * @property string $address
    * @property string $attributes
    * @property double $accuracy
    * @property string $network
    *
            * @property Eventos[] $eventos
            * @property Devices $device
    */
class PositionsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'positions';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['deviceid', 'latitude', 'longitude', 'altitude', 'speed', 'course'], 'required'],
            [['deviceid'], 'integer'],
            [['servertime', 'devicetime', 'fixtime'], 'safe'],
            [['valid'], 'boolean'],
            [['latitude', 'longitude', 'altitude', 'speed', 'course', 'accuracy'], 'number'],
            [['protocol'], 'string', 'max' => 128],
            [['address'], 'string', 'max' => 512],
            [['attributes', 'network'], 'string', 'max' => 4000],
            [['deviceid'], 'exist', 'skipOnError' => true, 'targetClass' => Devices::className(), 'targetAttribute' => ['deviceid' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'protocol' => Yii::t('app', 'Protocol'),
    'deviceid' => Yii::t('app', 'Deviceid'),
    'servertime' => Yii::t('app', 'Servertime'),
    'devicetime' => Yii::t('app', 'Devicetime'),
    'fixtime' => Yii::t('app', 'Fixtime'),
    'valid' => Yii::t('app', 'Valid'),
    'latitude' => Yii::t('app', 'Latitude'),
    'longitude' => Yii::t('app', 'Longitude'),
    'altitude' => Yii::t('app', 'Altitude'),
    'speed' => Yii::t('app', 'Speed'),
    'course' => Yii::t('app', 'Course'),
    'address' => Yii::t('app', 'Address'),
    'attributes' => Yii::t('app', 'Attributes'),
    'accuracy' => Yii::t('app', 'Accuracy'),
    'network' => Yii::t('app', 'Network'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getEventos()
    {
    return $this->hasMany(Eventos::className(), ['position_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getDevice()
    {
    return $this->hasOne(Devices::className(), ['id' => 'deviceid']);
    }
}