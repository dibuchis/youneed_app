<?php

namespace app\models;
use Yii;
use yii\base\Model;

class Usuarios extends \app\models\base\UsuariosBase implements \yii\web\IdentityInterface
{

    public $doctor_id;
    public $tiempo_atencion;
    public $latitude_inicial_doctor;
    public $longitude_inicial_doctor;

    public function rules()
    {
        return array_merge(parent::rules(),
        [
            [['nombres', 'apellidos', 'email', 'clave', 'tipo', 'estado_id', 'dispositivo_id'], 'required', 'on' => 'webapp'],
            [['alianza_id', 'identificacion', 'nombres', 'apellidos', 'numero_celular', 'email'], 'required', 'on' => 'paciente'],
            [['registro_medico', 'identificacion', 'nombres', 'apellidos', 'numero_celular', 'email'], 'required', 'on' => 'doctor'],
            [['alianza_id', 'identificacion', 'nombres', 'apellidos', 'numero_celular', 'doctor_id', 'tiempo_atencion'], 'required', 'on' => 'asignacion_doctor'],
            ['email', 'unique'],
            ['email', 'email'],
            [['latitude_inicial_doctor', 'longitude_inicial_doctor'],'number'],
            ['numero_celular', 'unique'],
            ['identificacion', 'unique'],
            ['registro_medico', 'unique'],
        ]);
    }

    public function attributeLabels()
    {
    return [
        'id' => Yii::t('app', 'ID'),
        'alianza_id' => Yii::t('app', 'Alianza'),
        'identificacion' => Yii::t('app', 'Identificación'),
        'numero_celular' => Yii::t('app', 'Número de celular'),
        'cuenta_id' => Yii::t('app', 'Cuenta ID'),
        'nombres' => Yii::t('app', 'Nombres'),
        'apellidos' => Yii::t('app', 'Apellidos'),
        'email' => Yii::t('app', 'Email'),
        'clave' => Yii::t('app', 'Clave'),
        'tipo' => Yii::t('app', 'Tipo'),
        'fecha_creacion' => Yii::t('app', 'Fecha Creacion'),
        'fecha_nacimiento' => Yii::t('app', 'Fecha de Nacimiento'),
        'ciudad_id' => Yii::t('app', 'Ciudad'),
        'estado_id' => Yii::t('app', 'Estado'),
        'dispositivo_id' => Yii::t('app', 'Dispositivo GPS'),
        'tiempo_atencion' => Yii::t('app', 'Tiempo de Atención'),
        'doctor_id' => Yii::t('app', 'Doctor'),
    ];
    }

    public function getAuthKey()
    {
        // return $this->token;
    }

    public function getId()
    {
        return $this->id;
    }

    public function validateAuthKey($token)
    {
        // return $this->token === $token;
    }

    public static function findIdentity($id)
    {
        return self::findOne( $id );
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        // foreach (self::$users as $user) {
        //     if ($user['accessToken'] === $token) {
        //         return new static($user);
        //     }
        // }

        return null;
    }

    public static function findByUsername($username)
    {
        return self::findOne( ['email' => $username] );
    }

    public function validatePassword($password)
    {
        return \Yii::$app->getSecurity()->validatePassword($password, $this->clave);
    }
}