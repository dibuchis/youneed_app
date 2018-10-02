<?php

namespace app\models\base;

use Yii;
use app\models\CategoriasServicios;
use app\models\Items;
use app\models\UsuariosServicios;

/**
 * This is the model class for table "servicios".
*
    * @property integer $id
    * @property string $nombre
    * @property string $slug
    * @property string $incluye
    * @property string $no_incluye
    * @property integer $aplica_iva
    * @property string $subtotal
    * @property string $iva
    * @property string $total
    * @property integer $obligatorio_certificado
    * @property string $imagen
    * @property integer $mostrar_app
    * @property integer $proveedor_aplica_iva
    * @property string $proveedor_subtotal
    * @property string $proveedor_iva
    * @property string $proveedor_total
    *
            * @property CategoriasServicios[] $categoriasServicios
            * @property Items[] $items
            * @property UsuariosServicios[] $usuariosServicios
    */
class ServiciosBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'servicios';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['incluye', 'no_incluye', 'imagen'], 'string'],
            [['aplica_iva', 'obligatorio_certificado', 'mostrar_app', 'proveedor_aplica_iva'], 'integer'],
            [['subtotal', 'iva', 'total', 'proveedor_subtotal', 'proveedor_iva', 'proveedor_total'], 'number'],
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
    'incluye' => 'Incluye',
    'no_incluye' => 'No Incluye',
    'aplica_iva' => 'Aplica Iva',
    'subtotal' => 'Subtotal',
    'iva' => 'Iva',
    'total' => 'Total',
    'obligatorio_certificado' => 'Obligatorio Certificado',
    'imagen' => 'Imagen',
    'mostrar_app' => 'Mostrar App',
    'proveedor_aplica_iva' => 'Proveedor Aplica Iva',
    'proveedor_subtotal' => 'Proveedor Subtotal',
    'proveedor_iva' => 'Proveedor Iva',
    'proveedor_total' => 'Proveedor Total',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCategoriasServicios()
    {
    return $this->hasMany(CategoriasServicios::className(), ['servicio_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getItems()
    {
    return $this->hasMany(Items::className(), ['servicio_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuariosServicios()
    {
    return $this->hasMany(UsuariosServicios::className(), ['servicio_id' => 'id']);
    }
}