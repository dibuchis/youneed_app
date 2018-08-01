<?php

namespace app\models\base;

use Yii;
use app\models\Provincias;
use app\models\Ciudades;

/**
 * This is the model class for table "cantones".
*
    * @property integer $id
    * @property integer $provincia_id
    * @property string $nombre
    *
            * @property Provincias $provincia
            * @property Ciudades[] $ciudades
    */
class CantonesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'cantones';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['provincia_id'], 'required'],
            [['provincia_id'], 'integer'],
            [['nombre'], 'string', 'max' => 450],
            [['provincia_id'], 'exist', 'skipOnError' => true, 'targetClass' => Provincias::className(), 'targetAttribute' => ['provincia_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'provincia_id' => 'Provincia ID',
    'nombre' => 'Nombre',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getProvincia()
    {
    return $this->hasOne(Provincias::className(), ['id' => 'provincia_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCiudades()
    {
    return $this->hasMany(Ciudades::className(), ['canton_id' => 'id']);
    }
}