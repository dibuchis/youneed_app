<?php

namespace app\models\base;

use Yii;
use app\models\Usuarios;

/**
 * This is the model class for table "bancos".
*
    * @property integer $id
    * @property string $nombre
    *
            * @property Usuarios[] $usuarios
    */
class BancosBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'bancos';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
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
    return $this->hasMany(Usuarios::className(), ['banco_id' => 'id']);
    }
}