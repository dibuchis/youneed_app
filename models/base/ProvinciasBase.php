<?php

namespace app\models\base;

use Yii;
use app\models\Cantones;
use app\models\Paises;

/**
 * This is the model class for table "provincias".
*
    * @property integer $id
    * @property integer $pais_id
    * @property string $nombre
    *
            * @property Cantones[] $cantones
            * @property Paises $pais
    */
class ProvinciasBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'provincias';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['pais_id'], 'required'],
            [['pais_id'], 'integer'],
            [['nombre'], 'string', 'max' => 650],
            [['pais_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paises::className(), 'targetAttribute' => ['pais_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'pais_id' => 'Pais ID',
    'nombre' => 'Nombre',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCantones()
    {
    return $this->hasMany(Cantones::className(), ['provincia_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPais()
    {
    return $this->hasOne(Paises::className(), ['id' => 'pais_id']);
    }
}