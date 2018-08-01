<?php

namespace app\models\base;

use Yii;
use app\models\Provincias;

/**
 * This is the model class for table "paises".
*
    * @property integer $id
    * @property string $nombre
    *
            * @property Provincias[] $provincias
    */
class PaisesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'paises';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['nombre'], 'string', 'max' => 850],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'nombre' => 'Nombre',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getProvincias()
    {
    return $this->hasMany(Provincias::className(), ['pais_id' => 'id']);
    }
}