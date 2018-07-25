<?php

namespace app\models\base;

use Yii;
use app\models\Dispositivos;
use app\models\Cuentas;

/**
 * This is the model class for table "grupos".
*
    * @property integer $id
    * @property string $nombre
    * @property integer $cuenta_id
    *
            * @property Dispositivos[] $dispositivos
            * @property Cuentas $cuenta
    */
class GruposBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'grupos';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['cuenta_id'], 'integer'],
            [['nombre'], 'string', 'max' => 200],
            [['cuenta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cuentas::className(), 'targetAttribute' => ['cuenta_id' => 'id']],
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
    'cuenta_id' => Yii::t('app', 'Cuenta ID'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getDispositivos()
    {
    return $this->hasMany(Dispositivos::className(), ['grupo_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCuenta()
    {
    return $this->hasOne(Cuentas::className(), ['id' => 'cuenta_id']);
    }
}