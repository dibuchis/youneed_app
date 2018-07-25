<?php

namespace app\models\base;

use Yii;
use app\models\Cuentas;
use app\models\Estados;
use app\models\Lugares;
use app\models\RutasCarreteras;

/**
 * This is the model class for table "carreteras".
*
    * @property integer $id
    * @property integer $cuenta_id
    * @property string $nombre
    * @property string $poligono
    * @property string $wkt
    * @property integer $estado_id
    *
            * @property Cuentas $cuenta
            * @property Estados $estado
            * @property Lugares[] $lugares
            * @property RutasCarreteras[] $rutasCarreteras
    */
class CarreterasBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'carreteras';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['cuenta_id', 'estado_id'], 'integer'],
            [['poligono', 'wkt'], 'string'],
            [['nombre'], 'string', 'max' => 300],
            [['cuenta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cuentas::className(), 'targetAttribute' => ['cuenta_id' => 'id']],
            [['estado_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado_id' => 'id']],
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
    'poligono' => Yii::t('app', 'Poligono'),
    'wkt' => Yii::t('app', 'Wkt'),
    'estado_id' => Yii::t('app', 'Estado ID'),
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
    public function getEstado()
    {
    return $this->hasOne(Estados::className(), ['id' => 'estado_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getLugares()
    {
    return $this->hasMany(Lugares::className(), ['carretera_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRutasCarreteras()
    {
    return $this->hasMany(RutasCarreteras::className(), ['carretera_id' => 'id']);
    }
}