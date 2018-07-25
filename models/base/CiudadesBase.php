<?php

namespace app\models\base;

use Yii;
use app\models\Usuarios;

/**
 * This is the model class for table "ciudades".
*
    * @property integer $id
    * @property string $nombre
    *
            * @property Usuarios[] $usuarios
    */
class CiudadesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'ciudades';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 450],
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
    public function getUsuarios()
    {
    return $this->hasMany(Usuarios::className(), ['ciudad_id' => 'id']);
    }
}