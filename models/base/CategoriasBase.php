<?php

namespace app\models\base;

use Yii;
use app\models\CategoriasServicios;
use app\models\Usuarios;

/**
 * This is the model class for table "categorias".
*
    * @property integer $id
    * @property string $nombre
    * @property string $slug
    * @property string $descripcion
    * @property string $imagen
    * @property string $fecha_creacion
    *
            * @property CategoriasServicios[] $categoriasServicios
            * @property Usuarios[] $usuarios
    */
class CategoriasBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'categorias';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['descripcion', 'imagen'], 'string'],
            [['fecha_creacion'], 'safe'],
            [['nombre'], 'string', 'max' => 450],
            [['slug'], 'string', 'max' => 2000],
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
    'slug' => 'Slug',
    'descripcion' => 'Descripcion',
    'imagen' => 'Imagen',
    'fecha_creacion' => 'Fecha Creacion',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCategoriasServicios()
    {
    return $this->hasMany(CategoriasServicios::className(), ['categoria_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuarios()
    {
    return $this->hasMany(Usuarios::className(), ['categoria_id' => 'id']);
    }
}