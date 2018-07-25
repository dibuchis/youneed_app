<?php

namespace app\models\base;

use Yii;
use app\models\Devices;
use app\models\GroupGeofence;
use app\models\Groups;
use app\models\UserGroup;

/**
 * This is the model class for table "groups".
*
    * @property integer $id
    * @property string $name
    * @property integer $groupid
    * @property string $attributes
    *
            * @property Devices[] $devices
            * @property GroupGeofence[] $groupGeofences
            * @property Groups $group
            * @property Groups[] $groups
            * @property UserGroup[] $userGroups
    */
class GroupsBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'groups';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['name'], 'required'],
            [['groupid'], 'integer'],
            [['name'], 'string', 'max' => 128],
            [['attributes'], 'string', 'max' => 4000],
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
    'groupid' => Yii::t('app', 'Groupid'),
    'attributes' => Yii::t('app', 'Attributes'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getDevices()
    {
    return $this->hasMany(Devices::className(), ['groupid' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getGroupGeofences()
    {
    return $this->hasMany(GroupGeofence::className(), ['groupid' => 'id']);
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
    public function getGroups()
    {
    return $this->hasMany(Groups::className(), ['groupid' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUserGroups()
    {
    return $this->hasMany(UserGroup::className(), ['groupid' => 'id']);
    }
}