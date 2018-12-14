<?php

namespace app\models\base;

use Yii;
use app\models\Paises;
use app\models\Pedidos;
use app\models\Usuarios;

/**
 * This is the model class for table "ciudades".
*
    * @property integer $id
    * @property integer $pais_id
    * @property string $nombre
    *
            * @property Paises $pais
            * @property Pedidos[] $pedidos
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
            [['pais_id'], 'required'],
            [['pais_id'], 'integer'],
            [['nombre'], 'string', 'max' => 650],
            [['pais_id'], 'exist', 'skipOnError' => true, 'targetClass' => Paises::className(), 'targetAttribute' => ['pais_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'pais_id' => 'Pais ID',
    'nombre' => 'Nombre',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPais()
    {
    return $this->hasOne(Paises::className(), ['id' => 'pais_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPedidos()
    {
    return $this->hasMany(Pedidos::className(), ['ciudad_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuarios()
    {
    return $this->hasMany(Usuarios::className(), ['ciudad_id' => 'id']);
    }
}