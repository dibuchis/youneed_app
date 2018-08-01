<?php

namespace app\models\base;

use Yii;
use app\models\Usuarios;

/**
 * This is the model class for table "planes".
*
    * @property integer $id
    * @property string $nombre
    * @property string $descripcion
    * @property string $pvp
    * @property string $descuento_1
    * @property string $descuento_2
    * @property string $fecha_creacion
    *
            * @property Usuarios[] $usuarios
    */
class PlanesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'planes';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['descripcion'], 'string'],
            [['pvp', 'descuento_1', 'descuento_2'], 'number'],
            [['fecha_creacion'], 'safe'],
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
    'descripcion' => 'Descripcion',
    'pvp' => 'Pvp',
    'descuento_1' => 'Descuento 1',
    'descuento_2' => 'Descuento 2',
    'fecha_creacion' => 'Fecha Creacion',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuarios()
    {
    return $this->hasMany(Usuarios::className(), ['plan_id' => 'id']);
    }
}