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
    * @property string $tarifa_base
    * @property string $tarifa_dinamica
    * @property integer $aplica_iva
    * @property integer $obligatorio_certificado
    * @property string $imagen
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
            [['tarifa_base', 'tarifa_dinamica'], 'number'],
            [['aplica_iva', 'obligatorio_certificado'], 'integer'],
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
    'tarifa_base' => 'Tarifa Base',
    'tarifa_dinamica' => 'Tarifa Dinamica',
    'aplica_iva' => 'Aplica Iva',
    'obligatorio_certificado' => 'Obligatorio Certificado',
    'imagen' => 'Imagen',
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