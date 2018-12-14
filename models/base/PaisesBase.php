<?php

namespace app\models\base;

use Yii;
use app\models\Ciudades;
use app\models\Usuarios;

/**
 * This is the model class for table "paises".
*
    * @property integer $id
    * @property string $nombre
    *
            * @property Ciudades[] $ciudades
            * @property Usuarios[] $usuarios
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
    public function getCiudades()
    {
    return $this->hasMany(Ciudades::className(), ['pais_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuarios()
    {
    return $this->hasMany(Usuarios::className(), ['pais_id' => 'id']);
    }
}