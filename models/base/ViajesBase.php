<?php

namespace app\models\base;

use Yii;
use app\models\Conductores;
use app\models\Cuentas;
use app\models\Dispositivos;
use app\models\Rutas;
use app\models\ViajesLugares;

/**
 * This is the model class for table "viajes".
*
    * @property integer $id
    * @property integer $cuenta_id
    * @property integer $ruta_id
    * @property integer $dispositivo_id
    * @property integer $conductor_id
    * @property string $observaciones
    * @property string $fecha_creacion
    * @property string $fecha_inicio
    * @property string $fecha_llegada
    * @property string $estado
    *
            * @property Conductores $conductor
            * @property Cuentas $cuenta
            * @property Dispositivos $dispositivo
            * @property Rutas $ruta
            * @property ViajesLugares[] $viajesLugares
    */
class ViajesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'viajes';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['cuenta_id', 'ruta_id', 'dispositivo_id', 'conductor_id'], 'integer'],
            [['observaciones', 'estado'], 'string'],
            [['fecha_creacion', 'fecha_inicio', 'fecha_llegada'], 'safe'],
            [['conductor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Conductores::className(), 'targetAttribute' => ['conductor_id' => 'id']],
            [['cuenta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cuentas::className(), 'targetAttribute' => ['cuenta_id' => 'id']],
            [['dispositivo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dispositivos::className(), 'targetAttribute' => ['dispositivo_id' => 'id']],
            [['ruta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rutas::className(), 'targetAttribute' => ['ruta_id' => 'id']],
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
    'ruta_id' => Yii::t('app', 'Ruta ID'),
    'dispositivo_id' => Yii::t('app', 'Dispositivo ID'),
    'conductor_id' => Yii::t('app', 'Conductor ID'),
    'observaciones' => Yii::t('app', 'Observaciones'),
    'fecha_creacion' => Yii::t('app', 'Fecha Creacion'),
    'fecha_inicio' => Yii::t('app', 'Fecha Inicio'),
    'fecha_llegada' => Yii::t('app', 'Fecha Llegada'),
    'estado' => Yii::t('app', 'Estado'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getConductor()
    {
    return $this->hasOne(Conductores::className(), ['id' => 'conductor_id']);
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
    public function getDispositivo()
    {
    return $this->hasOne(Dispositivos::className(), ['id' => 'dispositivo_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRuta()
    {
    return $this->hasOne(Rutas::className(), ['id' => 'ruta_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getViajesLugares()
    {
    return $this->hasMany(ViajesLugares::className(), ['viaje_id' => 'id']);
    }
}