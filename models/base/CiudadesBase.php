<?php

namespace app\models\base;

use Yii;
use app\models\Cantones;
use app\models\Pedidos;
use app\models\Usuarios;

/**
 * This is the model class for table "ciudades".
*
    * @property integer $id
    * @property integer $canton_id
    * @property string $nombre
    *
            * @property Cantones $canton
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
            [['canton_id'], 'required'],
            [['canton_id'], 'integer'],
            [['nombre'], 'string', 'max' => 650],
            [['canton_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cantones::className(), 'targetAttribute' => ['canton_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'canton_id' => 'Canton ID',
    'nombre' => 'Nombre',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCanton()
    {
    return $this->hasOne(Cantones::className(), ['id' => 'canton_id']);
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