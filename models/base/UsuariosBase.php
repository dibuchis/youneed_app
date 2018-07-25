<?php

namespace app\models\base;

use Yii;
use app\models\Atenciones;
use app\models\Eventos;
use app\models\Alianzas;
use app\models\Ciudades;
use app\models\Cuentas;
use app\models\Dispositivos;
use app\models\Estados;
use app\models\Usuarios;

/**
 * This is the model class for table "usuarios".
*
    * @property integer $id
    * @property integer $cuenta_id
    * @property string $nombres
    * @property string $apellidos
    * @property string $email
    * @property string $clave
    * @property string $tipo
    * @property string $fecha_creacion
    * @property integer $estado_id
    * @property integer $dispositivo_id
    * @property string $codigo_familiar
    * @property string $numero_celular
    * @property string $fecha_nacimiento
    * @property string $token_push
    * @property string $identificacion
    * @property string $registro_medico
    * @property integer $alianza_id
    * @property integer $habilitar_rastreo
    * @property integer $estado_doctor
    * @property integer $ciudad_id
    * @property string $token
    * @property integer $usuario_id
    * @property integer $tipo_usuario
    * @property string $imagen
    *
            * @property Atenciones[] $atenciones
            * @property Atenciones[] $atenciones0
            * @property Eventos[] $eventos
            * @property Alianzas $alianza
            * @property Ciudades $ciudad
            * @property Cuentas $cuenta
            * @property Dispositivos $dispositivo
            * @property Estados $estado
            * @property Usuarios $usuario
            * @property Usuarios[] $usuarios
    */
class UsuariosBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'usuarios';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['cuenta_id', 'estado_id', 'dispositivo_id', 'alianza_id', 'habilitar_rastreo', 'estado_doctor', 'ciudad_id', 'usuario_id', 'tipo_usuario'], 'integer'],
            [['tipo', 'token_push', 'token', 'imagen'], 'string'],
            [['fecha_creacion', 'fecha_nacimiento'], 'safe'],
            [['nombres', 'apellidos', 'email', 'clave'], 'string', 'max' => 200],
            [['codigo_familiar'], 'string', 'max' => 10],
            [['numero_celular'], 'string', 'max' => 45],
            [['identificacion'], 'string', 'max' => 80],
            [['registro_medico'], 'string', 'max' => 100],
            [['alianza_id'], 'exist', 'skipOnError' => true, 'targetClass' => Alianzas::className(), 'targetAttribute' => ['alianza_id' => 'id']],
            [['ciudad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ciudades::className(), 'targetAttribute' => ['ciudad_id' => 'id']],
            [['cuenta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cuentas::className(), 'targetAttribute' => ['cuenta_id' => 'id']],
            [['dispositivo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Dispositivos::className(), 'targetAttribute' => ['dispositivo_id' => 'id']],
            [['estado_id'], 'exist', 'skipOnError' => true, 'targetClass' => Estados::className(), 'targetAttribute' => ['estado_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
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
    'nombres' => 'Nombres',
    'apellidos' => 'Apellidos',
    'email' => 'Email',
    'clave' => 'Clave',
    'tipo' => 'Tipo',
    'fecha_creacion' => 'Fecha Creacion',
    'estado_id' => 'Estado ID',
    'dispositivo_id' => 'Dispositivo ID',
    'codigo_familiar' => 'Codigo Familiar',
    'numero_celular' => 'Numero Celular',
    'fecha_nacimiento' => 'Fecha Nacimiento',
    'token_push' => 'Token Push',
    'identificacion' => 'Identificacion',
    'registro_medico' => 'Registro Medico',
    'alianza_id' => 'Alianza ID',
    'habilitar_rastreo' => 'Habilitar Rastreo',
    'estado_doctor' => 'Estado Doctor',
    'ciudad_id' => 'Ciudad ID',
    'token' => 'Token',
    'usuario_id' => 'Usuario ID',
    'tipo_usuario' => 'Tipo Usuario',
    'imagen' => 'Imagen',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getAtenciones()
    {
    return $this->hasMany(Atenciones::className(), ['paciente_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getAtenciones0()
    {
    return $this->hasMany(Atenciones::className(), ['doctor_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getEventos()
    {
    return $this->hasMany(Eventos::className(), ['usuario_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getAlianza()
    {
    return $this->hasOne(Alianzas::className(), ['id' => 'alianza_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCiudad()
    {
    return $this->hasOne(Ciudades::className(), ['id' => 'ciudad_id']);
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
    public function getEstado()
    {
    return $this->hasOne(Estados::className(), ['id' => 'estado_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuario()
    {
    return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuarios()
    {
    return $this->hasMany(Usuarios::className(), ['usuario_id' => 'id']);
    }
}