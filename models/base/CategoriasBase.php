<?php

namespace app\models\base;

use Yii;
use app\models\CategoriasServicios;
use app\models\UsuariosCategorias;

/**
 * This is the model class for table "categorias".
*
    * @property integer $id
    * @property string $nombre
    * @property string $slug
    * @property string $descripcion
    * @property string $imagen
    * @property string $fecha_creacion
    * @property integer $aplica_iva
    * @property string $subtotal
    * @property string $iva
    * @property string $total
    *
            * @property CategoriasServicios[] $categoriasServicios
            * @property UsuariosCategorias[] $usuariosCategorias
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
            [['aplica_iva'], 'integer'],
            [['subtotal', 'iva', 'total'], 'number'],
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
    'aplica_iva' => 'Aplica Iva',
    'subtotal' => 'Subtotal',
    'iva' => 'Iva',
    'total' => 'Total',
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
    public function getUsuariosCategorias()
    {
    return $this->hasMany(UsuariosCategorias::className(), ['categoria_id' => 'id']);
    }
}