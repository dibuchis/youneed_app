<?php

namespace app\models\base;

use Yii;
use app\models\Categorias;
use app\models\Cuentas;
use app\models\Grupos;
use app\models\DispositivosConductores;
use app\models\Mantenimientos;
use app\models\Turnos;
use app\models\Usuarios;
use app\models\Viajes;
use app\models\Visitas;

/**
 * This is the model class for table "dispositivos".
*
    * @property integer $id
    * @property integer $cuenta_id
    * @property integer $grupo_id
    * @property integer $categoria_id
    * @property string $nombre
    * @property string $alias
    * @property string $placa
    * @property string $imei
    * @property integer $traccar_id
    * @property string $tipo
    * @property integer $en_ruta
    * @property integer $tipo_dispositivo
    * @property string $utim_app_tipo
    *
            * @property Categorias $categoria
            * @property Cuentas $cuenta
            * @property Grupos $grupo
            * @property DispositivosConductores[] $dispositivosConductores
            * @property Mantenimientos[] $mantenimientos
            * @property Turnos[] $turnos
            * @property Usuarios[] $usuarios
            * @property Viajes[] $viajes
            * @property Visitas[] $visitas
    */
class DispositivosBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'dispositivos';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['cuenta_id', 'grupo_id', 'categoria_id', 'traccar_id', 'en_ruta', 'tipo_dispositivo'], 'integer'],
            [['tipo'], 'required'],
            [['tipo', 'utim_app_tipo'], 'string'],
            [['nombre'], 'string', 'max' => 200],
            [['alias', 'placa'], 'string', 'max' => 60],
            [['imei'], 'string', 'max' => 128],
            [['imei'], 'unique'],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::className(), 'targetAttribute' => ['categoria_id' => 'id']],
            [['cuenta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cuentas::className(), 'targetAttribute' => ['cuenta_id' => 'id']],
            [['grupo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Grupos::className(), 'targetAttribute' => ['grupo_id' => 'id']],
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
    'grupo_id' => 'Grupo ID',
    'categoria_id' => 'Categoria ID',
    'nombre' => 'Nombre',
    'alias' => 'Alias',
    'placa' => 'Placa',
    'imei' => 'Imei',
    'traccar_id' => 'Traccar ID',
    'tipo' => 'Tipo',
    'en_ruta' => 'En Ruta',
    'tipo_dispositivo' => 'Tipo Dispositivo',
    'utim_app_tipo' => 'Utim App Tipo',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCategoria()
    {
    return $this->hasOne(Categorias::className(), ['id' => 'categoria_id']);
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
    public function getGrupo()
    {
    return $this->hasOne(Grupos::className(), ['id' => 'grupo_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getDispositivosConductores()
    {
    return $this->hasMany(DispositivosConductores::className(), ['dispositivo_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMantenimientos()
    {
    return $this->hasMany(Mantenimientos::className(), ['dispositivo_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTurnos()
    {
    return $this->hasMany(Turnos::className(), ['dispositivo_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuarios()
    {
    return $this->hasMany(Usuarios::className(), ['dispositivo_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getViajes()
    {
    return $this->hasMany(Viajes::className(), ['dispositivo_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getVisitas()
    {
    return $this->hasMany(Visitas::className(), ['dispositivo_id' => 'id']);
    }
}