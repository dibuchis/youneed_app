<?php

namespace app\models\base;

use Yii;
use app\models\Cuentas;
use app\models\Dispositivos;
use app\models\MantenimientosConceptos;

/**
 * This is the model class for table "mantenimientos".
*
    * @property integer $id
    * @property integer $cuenta_id
    * @property integer $dispositivo_id
    * @property string $tipo
    * @property string $nombre
    * @property double $kilometros
    * @property string $tiempo
    * @property string $siguiente_revision
    * @property string $email_alerta
    * @property string $descripcion
    *
            * @property Cuentas $cuenta
            * @property Dispositivos $dispositivo
            * @property MantenimientosConceptos[] $mantenimientosConceptos
    */
class MantenimientosBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'mantenimientos';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['cuenta_id', 'dispositivo_id'], 'integer'],
            [['tipo', 'tiempo', 'descripcion'], 'string'],
            [['kilometros'], 'number'],
            [['siguiente_revision'], 'safe'],
            [['nombre'], 'string', 'max' => 45],
            [['email_alerta'], 'string', 'max' => 250],
            [['cuenta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cuentas::className(), 'targetAttribute' => ['cuenta_id' => 'id']],
            [['dispositivo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dispositivos::className(), 'targetAttribute' => ['dispositivo_id' => 'id']],
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
    'dispositivo_id' => Yii::t('app', 'Dispositivo ID'),
    'tipo' => Yii::t('app', 'Tipo'),
    'nombre' => Yii::t('app', 'Nombre'),
    'kilometros' => Yii::t('app', 'Kilometros'),
    'tiempo' => Yii::t('app', 'Tiempo'),
    'siguiente_revision' => Yii::t('app', 'Siguiente Revision'),
    'email_alerta' => Yii::t('app', 'Email Alerta'),
    'descripcion' => Yii::t('app', 'Descripcion'),
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
    public function getDispositivo()
    {
    return $this->hasOne(Dispositivos::className(), ['id' => 'dispositivo_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMantenimientosConceptos()
    {
    return $this->hasMany(MantenimientosConceptos::className(), ['mantenimiento_id' => 'id']);
    }
}