<?php

namespace app\models\base;

use Yii;
use app\models\AttributeAliases;
use app\models\DeviceGeofence;
use app\models\Groups;
use app\models\Dispositivos;
use app\models\Events;
use app\models\Positions;
use app\models\UserDevice;

/**
 * This is the model class for table "devices".
*
    * @property integer $id
    * @property string $name
    * @property string $uniqueid
    * @property string $lastupdate
    * @property integer $positionid
    * @property integer $groupid
    * @property string $attributes
    * @property string $phone
    * @property string $model
    * @property string $contact
    * @property string $category
    *
            * @property AttributeAliases[] $attributeAliases
            * @property DeviceGeofence[] $deviceGeofences
            * @property Groups $group
            * @property Dispositivos[] $dispositivos
            * @property Events[] $events
            * @property Positions[] $positions
            * @property UserDevice[] $userDevices
    */
class DevicesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'devices';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['name', 'uniqueid'], 'required'],
            [['lastupdate'], 'safe'],
            [['positionid', 'groupid'], 'integer'],
            [['name', 'uniqueid', 'phone', 'model', 'category'], 'string', 'max' => 128],
            [['attributes'], 'string', 'max' => 4000],
            [['contact'], 'string', 'max' => 512],
            [['uniqueid'], 'unique'],
            [['groupid'], 'exist', 'skipOnError' => true, 'targetClass' => Groups::className(), 'targetAttribute' => ['groupid' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'name' => Yii::t('app', 'Name'),
    'uniqueid' => Yii::t('app', 'Uniqueid'),
    'lastupdate' => Yii::t('app', 'Lastupdate'),
    'positionid' => Yii::t('app', 'Positionid'),
    'groupid' => Yii::t('app', 'Groupid'),
    'attributes' => Yii::t('app', 'Attributes'),
    'phone' => Yii::t('app', 'Phone'),
    'model' => Yii::t('app', 'Model'),
    'contact' => Yii::t('app', 'Contact'),
    'category' => Yii::t('app', 'Category'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getAttributeAliases()
    {
    return $this->hasMany(AttributeAliases::className(), ['deviceid' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getDeviceGeofences()
    {
    return $this->hasMany(DeviceGeofence::className(), ['deviceid' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getGroup()
    {
    return $this->hasOne(Groups::className(), ['id' => 'groupid']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getDispositivos()
    {
    return $this->hasMany(Dispositivos::className(), ['device_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getEvents()
    {
    return $this->hasMany(Events::className(), ['deviceid' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPositions()
    {
    return $this->hasMany(Positions::className(), ['deviceid' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUserDevices()
    {
    return $this->hasMany(UserDevice::className(), ['deviceid' => 'id']);
    }
}