<?php

namespace app\models\base;

use Yii;
use app\models\Carreteras;
use app\models\Cuentas;
use app\models\Lugares;
use app\models\Usuarios;

/**
 * This is the model class for table "estados".
*
    * @property integer $id
    * @property string $nombre
    *
            * @property Carreteras[] $carreteras
            * @property Cuentas[] $cuentas
            * @property Lugares[] $lugares
            * @property Usuarios[] $usuarios
    */
class EstadosBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'estados';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 45],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'nombre' => Yii::t('app', 'Nombre'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCarreteras()
    {
    return $this->hasMany(Carreteras::className(), ['estado_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCuentas()
    {
    return $this->hasMany(Cuentas::className(), ['estado_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getLugares()
    {
    return $this->hasMany(Lugares::className(), ['estado_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuarios()
    {
    return $this->hasMany(Usuarios::className(), ['estado_id' => 'id']);
    }
}