<?php

namespace app\models;
use Yii;
use yii\base\Model;
use borales\extensions\phoneInput\PhoneInputValidator;

class Usuarios extends \app\models\base\UsuariosBase implements \yii\web\IdentityInterface
{

    public $servicios, $imagen_upload;
    public $fotografia_asociado_upload;
    public $fotografia_cedula_upload;
    public $ruc_upload;
    public $visa_trabajo_upload;
    public $rise_upload;
    public $referencias_personales_upload;
    public $titulo_academico_upload;

    public function rules()
    {
        return array_merge(parent::rules(),
        [
            [['nombres', 'apellidos', 'email', 'numero_celular', 'clave', 'estado'], 'required', 'on' => 'Webapp'],
            [['imagen', 'tipo_identificacion', 'identificacion', 'nombres', 'apellidos', 'numero_celular', 'email', 'clave', 'categoria_id', 'servicios', 'dias_trabajo', 'horarios_trabajo', 'banco_id', 'nombre_beneficiario', 'tipo_cuenta', 'numero_cuenta', 'plan_id', 'fotografia_cedula', 'referencias_personales'], 'required', 'on' => 'Asociado'],
            [['nombres', 'apellidos', 'numero_celular', 'email', 'clave'], 'required', 'on' => 'Cliente'],
            ['email', 'unique'],
            ['email', 'email'],
            ['numero_celular', 'unique'],
            ['identificacion', 'unique'],
            [['numero_celular'], PhoneInputValidator::className(), 'region' => ['EC']],
        ]);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->numero_celular = preg_replace('/\s+/', '', $this->numero_celular);
            $this->numero_celular = str_replace(' ', '', $this->numero_celular);
            return true;
        } else {
            return false;
        }
    }

    public function attributeLabels()
	{
		return [
		    'id' => 'ID',
		    'tipo_identificacion' => 'Tipo Identificación',
		    'identificacion' => 'Identificación',
		    'imagen' => 'Fotografía',
		    'nombres' => 'Nombres',
		    'apellidos' => 'Apellidos',
		    'email' => 'Email',
		    'numero_celular' => 'Número Celular',
		    'telefono_domicilio' => 'Teléfono del Domicilio',
		    'clave' => 'Clave',
		    'tipo' => 'Tipo',
		    'estado' => 'Estado',
		    'token_push' => 'Token Push',
		    'habilitar_rastreo' => 'Habilitar Rastreo',
		    'token' => 'Token',
		    'canton_id' => 'Ciudad',
		    'categoria_id' => 'Actividad Principal',
            'servicios' => 'Servicios a prestar',
		    'fecha_creacion' => 'Fecha Creación',
		    'fecha_activacion' => 'Fecha Activación',
		    'fecha_desactivacion' => 'Fecha Desactivación',
		    'causas_desactivacion' => 'Causas Desactivación',
		    'plan_id' => 'Plan',
		    'fecha_cambio_plan' => 'Fecha Cambio de Plan',
		    'banco_id' => 'Banco',
		    'tipo_cuenta' => 'Tipo de Cuenta',
		    'numero_cuenta' => 'Número de Cuenta',
		    'preferencias_deposito' => 'Preferencia para Depósito',
		    'observaciones' => 'Observaciones',
		    'dias_trabajo' => 'Días de Trabajo',
		    'horarios_trabajo' => 'Horarios de Trabajo',
		    'estado_validacion_documentos' => 'Estado Validación Documentos',
		    'traccar_id' => 'Traccar ID',
            'banco_id' => 'Institución Bancaria',
            'nombre_beneficiario' => 'Nombre del Beneficiario',
            'fotografia_asociado' => 'Fotografía del asociado',
            'fotografia_cedula' => 'Fotografía de cédula de identidad',
            'ruc' => 'Fotografía del Registro Único de Contribuyentes',
            'visa_trabajo' => 'Fotografía del Pasaporte con Visa de Trabajo',
            'rise' => 'Fotografía del RISE Régimen Impositivo Simplificado Ecuatoriano',
            'referencias_personales' => 'Carta de Referencias Personales',
            'titulo_academico' => 'Título Académico o Certificado que Acredite sus Conocimientos',
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