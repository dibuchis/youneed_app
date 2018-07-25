<?php

namespace app\models\base;

use Yii;
use app\models\Cuentas;
use app\models\Eventos;

/**
 * This is the model class for table "catalogos_incidencias".
*
    * @property integer $id
    * @property integer $cuenta_id
    * @property string $nombres
    *
            * @property Cuentas $cuenta
            * @property Eventos[] $eventos
    */
class CatalogosIncidenciasBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'catalogos_incidencias';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['id'], 'required'],
            [['id', 'cuenta_id'], 'integer'],
            [['nombres'], 'string'],
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
    public function getEventos()
    {
    return $this->hasMany(Eventos::className(), ['catalogo_incidencia_id' => 'id']);
    }
}