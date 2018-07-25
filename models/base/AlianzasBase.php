<?php

namespace app\models\base;

use Yii;
use app\models\Usuarios;

/**
 * This is the model class for table "alianzas".
*
    * @property integer $id
    * @property string $nombre
    * @property string $imagen
    *
            * @property Usuarios[] $usuarios
    */
class AlianzasBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'alianzas';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['nombre', 'imagen'], 'required'],
            [['imagen'], 'string'],
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
    'imagen' => 'Imagen',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuarios()
    {
    return $this->hasMany(Usuarios::className(), ['alianza_id' => 'id']);
    }
}