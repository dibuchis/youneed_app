<?php

namespace app\models\base;

use Yii;
use app\models\Cuentas;
use app\models\Estados;
use app\models\RutasLugares;
use app\models\ViajesLugares;

/**
 * This is the model class for table "lugares".
*
    * @property integer $id
    * @property integer $cuenta_id
    * @property string $nombre
    * @property string $tipo
    * @property string $poligono
    * @property string $wkt
    * @property integer $estado_id
    *
            * @property Cuentas $cuenta
            * @property Estados $estado
            * @property RutasLugares[] $rutasLugares
            * @property ViajesLugares[] $viajesLugares
    */
class LugaresBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'lugares';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['cuenta_id', 'estado_id'], 'integer'],
            [['tipo', 'poligono', 'wkt'], 'string'],
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
    'id' => 'ID',
    'cuenta_id' => 'Cuenta ID',
    'nombre' => 'Nombre',
    'tipo' => 'Tipo',
    'poligono' => 'Poligono',
    'wkt' => 'Wkt',
    'estado_id' => 'Estado ID',
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
    public function getRutasLugares()
    {
    return $this->hasMany(RutasLugares::className(), ['lugar_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getViajesLugares()
    {
    return $this->hasMany(ViajesLugares::className(), ['lugar_id' => 'id']);
    }
}