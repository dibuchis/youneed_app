<?php

namespace app\models\base;

use Yii;
use app\models\Carreteras;
use app\models\CatalogosIncidencias;
use app\models\Conductores;
use app\models\CorreosHistorial;
use app\models\Cuentas;
use app\models\Estados;
use app\models\Dispositivos;
use app\models\Eventos;
use app\models\Grupos;
use app\models\Lugares;
use app\models\Mantenimientos;
use app\models\Rutas;
use app\models\Suscripciones;
use app\models\Usuarios;
use app\models\Viajes;

/**
 * This is the model class for table "cuentas".
*
    * @property integer $id
    * @property integer $cuenta_id
    * @property string $nombre_comercial
    * @property string $nombres
    * @property string $apellidos
    * @property string $identificacion
    * @property string $direccion
    * @property string $telefonos
    * @property string $pagina_web
    * @property string $skype
    * @property string $observaciones
    * @property string $tipo
    * @property integer $numero_dispositivos
    * @property string $fecha_creacion
    * @property string $fecha_actualizacion
    * @property integer $estado_id
    *
            * @property Carreteras[] $carreteras
            * @property CatalogosIncidencias[] $catalogosIncidencias
            * @property Conductores[] $conductores
            * @property CorreosHistorial[] $correosHistorials
            * @property Cuentas $cuenta
            * @property Cuentas[] $cuentas
            * @property Estados $estado
            * @property Dispositivos[] $dispositivos
            * @property Eventos[] $eventos
            * @property Grupos[] $grupos
            * @property Lugares[] $lugares
            * @property Mantenimientos[] $mantenimientos
            * @property Rutas[] $rutas
            * @property Suscripciones[] $suscripciones
            * @property Usuarios[] $usuarios
            * @property Viajes[] $viajes
    */
class CuentasBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'cuentas';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['cuenta_id', 'numero_dispositivos', 'estado_id'], 'integer'],
            [['telefonos', 'observaciones', 'tipo'], 'string'],
            [['fecha_creacion', 'fecha_actualizacion'], 'safe'],
            [['nombre_comercial'], 'string', 'max' => 150],
            [['nombres', 'apellidos'], 'string', 'max' => 100],
            [['identificacion', 'pagina_web', 'skype'], 'string', 'max' => 45],
            [['direccion'], 'string', 'max' => 450],
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
    'nombre_comercial' => Yii::t('app', 'Nombre Comercial'),
    'nombres' => Yii::t('app', 'Nombres'),
    'apellidos' => Yii::t('app', 'Apellidos'),
    'identificacion' => Yii::t('app', 'Identificacion'),
    'direccion' => Yii::t('app', 'Direccion'),
    'telefonos' => Yii::t('app', 'Telefonos'),
    'pagina_web' => Yii::t('app', 'Pagina Web'),
    'skype' => Yii::t('app', 'Skype'),
    'observaciones' => Yii::t('app', 'Observaciones'),
    'tipo' => Yii::t('app', 'Tipo'),
    'numero_dispositivos' => Yii::t('app', 'Numero Dispositivos'),
    'fecha_creacion' => Yii::t('app', 'Fecha Creacion'),
    'fecha_actualizacion' => Yii::t('app', 'Fecha Actualizacion'),
    'estado_id' => Yii::t('app', 'Estado ID'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCarreteras()
    {
    return $this->hasMany(Carreteras::className(), ['cuenta_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCatalogosIncidencias()
    {
    return $this->hasMany(CatalogosIncidencias::className(), ['cuenta_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getConductores()
    {
    return $this->hasMany(Conductores::className(), ['cuenta_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCorreosHistorials()
    {
    return $this->hasMany(CorreosHistorial::className(), ['cuenta_id' => 'id']);
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
    public function getCuentas()
    {
    return $this->hasMany(Cuentas::className(), ['cuenta_id' => 'id']);
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
    public function getDispositivos()
    {
    return $this->hasMany(Dispositivos::className(), ['cuenta_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getEventos()
    {
    return $this->hasMany(Eventos::className(), ['cuenta_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getGrupos()
    {
    return $this->hasMany(Grupos::className(), ['cuenta_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getLugares()
    {
    return $this->hasMany(Lugares::className(), ['cuenta_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMantenimientos()
    {
    return $this->hasMany(Mantenimientos::className(), ['cuenta_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRutas()
    {
    return $this->hasMany(Rutas::className(), ['cuenta_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getSuscripciones()
    {
    return $this->hasMany(Suscripciones::className(), ['cuenta_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuarios()
    {
    return $this->hasMany(Usuarios::className(), ['cuenta_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getViajes()
    {
    return $this->hasMany(Viajes::className(), ['cuenta_id' => 'id']);
    }
}