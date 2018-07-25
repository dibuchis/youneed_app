<?php

namespace app\models\base;

use Yii;
use app\models\Cuentas;

/**
 * This is the model class for table "suscripciones".
*
    * @property integer $id
    * @property integer $cuenta_id
    * @property string $fecha_inicio
    * @property string $fecha_final
    * @property string $fecha_creacion
    *
            * @property Cuentas $cuenta
    */
class SuscripcionesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'suscripciones';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['cuenta_id', 'fecha_inicio', 'fecha_final'], 'required'],
            [['cuenta_id'], 'integer'],
            [['fecha_inicio', 'fecha_final', 'fecha_creacion'], 'safe'],
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
    'fecha_inicio' => Yii::t('app', 'Fecha Inicio'),
    'fecha_final' => Yii::t('app', 'Fecha Final'),
    'fecha_creacion' => Yii::t('app', 'Fecha Creacion'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCuenta()
    {
    return $this->hasOne(Cuentas::className(), ['id' => 'cuenta_id']);
    }
}