<?php

namespace app\models\base;

use Yii;
use app\models\Cuentas;
use app\models\DispositivosConductores;
use app\models\Viajes;

/**
 * This is the model class for table "conductores".
*
    * @property integer $id
    * @property integer $cuenta_id
    * @property string $nombres
    * @property string $apellidos
    * @property string $identificacion
    * @property string $telefonos
    * @property string $observaciones
    *
            * @property Cuentas $cuenta
            * @property DispositivosConductores[] $dispositivosConductores
            * @property Viajes[] $viajes
    */
class ConductoresBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'conductores';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['cuenta_id'], 'integer'],
            [['telefonos', 'observaciones'], 'string'],
            [['nombres', 'apellidos'], 'string', 'max' => 250],
            [['identificacion'], 'string', 'max' => 45],
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
    'cuenta_id' => Yii::t('app', 'Cuenta ID'),
    'nombres' => Yii::t('app', 'Nombres'),
    'apellidos' => Yii::t('app', 'Apellidos'),
    'identificacion' => Yii::t('app', 'Identificacion'),
    'telefonos' => Yii::t('app', 'Telefonos'),
    'observaciones' => Yii::t('app', 'Observaciones'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCuenta()
    {
    return $this->hasOne(Cuentas::className(), ['id' => 'cuenta_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getDispositivosConductores()
    {
    return $this->hasMany(DispositivosConductores::className(), ['conductor_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getViajes()
    {
    return $this->hasMany(Viajes::className(), ['conductor_id' => 'id']);
    }
}