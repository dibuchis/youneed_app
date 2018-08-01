<?php

namespace app\models\base;

use Yii;
use app\models\Servicios;
use app\models\Categorias;

/**
 * This is the model class for table "categorias_servicios".
*
    * @property integer $id
    * @property integer $categoria_id
    * @property integer $servicio_id
    *
            * @property Servicios $servicio
            * @property Categorias $categoria
    */
class CategoriasServiciosBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'categorias_servicios';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['categoria_id', 'servicio_id'], 'required'],
            [['categoria_id', 'servicio_id'], 'integer'],
            [['servicio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servicios::className(), 'targetAttribute' => ['servicio_id' => 'id']],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::className(), 'targetAttribute' => ['categoria_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'categoria_id' => 'Categoria ID',
    'servicio_id' => 'Servicio ID',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getServicio()
    {
    return $this->hasOne(Servicios::className(), ['id' => 'servicio_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCategoria()
    {
    return $this->hasOne(Categorias::className(), ['id' => 'categoria_id']);
    }
}