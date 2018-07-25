<?php

namespace app\models\base;

use Yii;
use app\models\Cuentas;

/**
 * This is the model class for table "correos_historial".
*
    * @property integer $id
    * @property integer $cuenta_id
    * @property string $para
    * @property string $de
    * @property string $contenido
    * @property string $fecha_envio
    *
            * @property Cuentas $cuenta
    */
class CorreosHistorialBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'correos_historial';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['cuenta_id'], 'integer'],
            [['contenido'], 'string'],
            [['fecha_envio'], 'safe'],
            [['para', 'de'], 'string', 'max' => 250],
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
    'para' => Yii::t('app', 'Para'),
    'de' => Yii::t('app', 'De'),
    'contenido' => Yii::t('app', 'Contenido'),
    'fecha_envio' => Yii::t('app', 'Fecha Envio'),
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