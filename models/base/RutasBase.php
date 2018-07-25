<?php

namespace app\models\base;

use Yii;
use app\models\Cuentas;
use app\models\RutasCarreteras;
use app\models\RutasLugares;
use app\models\Viajes;

/**
 * This is the model class for table "rutas".
*
    * @property integer $id
    * @property integer $cuenta_id
    * @property string $nombre
    * @property string $tiempo_viaje
    *
            * @property Cuentas $cuenta
            * @property RutasCarreteras[] $rutasCarreteras
            * @property RutasLugares[] $rutasLugares
            * @property Viajes[] $viajes
    */
class RutasBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'rutas';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['cuenta_id'], 'integer'],
            [['tiempo_viaje'], 'safe'],
            [['nombre'], 'string', 'max' => 450],
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
    'nombre' => Yii::t('app', 'Nombre'),
    'tiempo_viaje' => Yii::t('app', 'Tiempo Viaje'),
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
    public function getRutasCarreteras()
    {
    return $this->hasMany(RutasCarreteras::className(), ['ruta_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRutasLugares()
    {
    return $this->hasMany(RutasLugares::className(), ['ruta_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getViajes()
    {
    return $this->hasMany(Viajes::className(), ['ruta_id' => 'id']);
    }
}