<?php

namespace app\models\base;

use Yii;
use app\models\Alertas;
use app\models\CatalogosIncidencias;
use app\models\Cuentas;
use app\models\Positions;
use app\models\Usuarios;

/**
 * This is the model class for table "eventos".
*
    * @property integer $id
    * @property integer $cuenta_id
    * @property integer $position_id
    * @property integer $usuario_id
    * @property integer $catalogo_incidencia_id
    * @property integer $alerta_id
    * @property string $novedad
    * @property string $fecha_creacion
    * @property string $fecha_atencion
    * @property string $fecha_finalizacion
    *
            * @property Alertas $alerta
            * @property CatalogosIncidencias $catalogoIncidencia
            * @property Cuentas $cuenta
            * @property Positions $position
            * @property Usuarios $usuario
    */
class EventosBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'eventos';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['cuenta_id', 'position_id', 'usuario_id', 'catalogo_incidencia_id', 'alerta_id'], 'integer'],
            [['novedad'], 'string'],
            [['fecha_creacion', 'fecha_atencion', 'fecha_finalizacion'], 'safe'],
            [['alerta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Alertas::className(), 'targetAttribute' => ['alerta_id' => 'id']],
            [['catalogo_incidencia_id'], 'exist', 'skipOnError' => true, 'targetClass' => CatalogosIncidencias::className(), 'targetAttribute' => ['catalogo_incidencia_id' => 'id']],
            [['cuenta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cuentas::className(), 'targetAttribute' => ['cuenta_id' => 'id']],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => Positions::className(), 'targetAttribute' => ['position_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
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
    'position_id' => Yii::t('app', 'Position ID'),
    'usuario_id' => Yii::t('app', 'Usuario ID'),
    'catalogo_incidencia_id' => Yii::t('app', 'Catalogo Incidencia ID'),
    'alerta_id' => Yii::t('app', 'Alerta ID'),
    'novedad' => Yii::t('app', 'Novedad'),
    'fecha_creacion' => Yii::t('app', 'Fecha Creacion'),
    'fecha_atencion' => Yii::t('app', 'Fecha Atencion'),
    'fecha_finalizacion' => Yii::t('app', 'Fecha Finalizacion'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getAlerta()
    {
    return $this->hasOne(Alertas::className(), ['id' => 'alerta_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCatalogoIncidencia()
    {
    return $this->hasOne(CatalogosIncidencias::className(), ['id' => 'catalogo_incidencia_id']);
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
    public function getPosition()
    {
    return $this->hasOne(Positions::className(), ['id' => 'position_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuario()
    {
    return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }
}