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
    public $categorias;
    public $terminos_condiciones;

    public function rules()
    {
        return array_merge(parent::rules(),
        [
            [['nombres', 'apellidos', 'email', 'numero_celular', 'clave', 'estado'], 'required', 'on' => 'Webapp'],
            [['imagen', 'tipo_identificacion', 'identificacion', 'nombres', 'apellidos', 'numero_celular', 'email', 'clave', 'servicios', 'dias_trabajo', 'horarios_trabajo', 'banco_id', 'nombre_beneficiario', 'tipo_cuenta', 'numero_cuenta', 'plan_id', 'fotografia_cedula', 'referencias_personales', 'categorias', 'pais_id', 'ciudad_id'], 'required', 'on' => 'Asociado'],
            [['nombres', 'apellidos', 'numero_celular', 'email', 'clave'], 'required', 'on' => 'Cliente'],
            ['email', 'unique'],
            ['email', 'email'],
            ['numero_celular', 'unique'],
            ['identificacion', 'unique'],
            [['numero_celular'], PhoneInputValidator::className(), 'region' => ['EC']],
            [['identificacion'], 'checkIdentification'],
            ['terminos_condiciones', 'required', 'on' => ['Asociado'], 'requiredValue' => 1, 'message' => 'Es necesario que acepte los términos y condiciones'],
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

    public function checkIdentification()
    {
        if( $this->tipo_identificacion != 4 ){
            $numero = $this -> identificacion;
            $suma = 0;
            $residuo = 0;
            $pri = false;
            $pub = false;
            $nat = false;
            $numeroProvincias = 24;
            $modulo = 11;

            /* Verifico que el campo no contenga letras */
            if(!(substr($numero, 0, 2) > 0 && substr($numero, 0, 2) <= $numeroProvincias))
                $this->addError('identificacion','Número de identificación Incorrecto');

            /* Aqui almacenamos los digitos de la cedula en variables. */
            $d1 = substr($numero, 0,1);
            $d2 = substr($numero, 1,1);
            $d3 = substr($numero, 2,1);
            $d4 = substr($numero, 3,1);
            $d5 = substr($numero, 4,1);
            $d6 = substr($numero, 5,1);
            $d7 = substr($numero, 6,1);
            $d8 = substr($numero, 7,1);
            $d9 = substr($numero, 8,1);
            $d10 = substr($numero, 9,1);

            /* El tercer digito es: */
            /* 9 para sociedades privadas y extranjeros */
            /* 6 para sociedades publicas */
            /* menor que 6 (0,1,2,3,4,5) para personas naturales */

            if($d3==7 || $d3==8)
            {
                $this->addError('identificacion','Número de identificación Incorrecto');
            }

            /* Solo para personas naturales (modulo 10) */
            if ($d3 < 6){
                $nat = true;
                $p1 = $d1 * 2; if ($p1 >= 10) $p1 -= 9;
                $p2 = $d2 * 1; if ($p2 >= 10) $p2 -= 9;
                $p3 = $d3 * 2; if ($p3 >= 10) $p3 -= 9;
                $p4 = $d4 * 1; if ($p4 >= 10) $p4 -= 9;
                $p5 = $d5 * 2; if ($p5 >= 10) $p5 -= 9;
                $p6 = $d6 * 1; if ($p6 >= 10) $p6 -= 9;
                $p7 = $d7 * 2; if ($p7 >= 10) $p7 -= 9;
                $p8 = $d8 * 1; if ($p8 >= 10) $p8 -= 9;
                $p9 = $d9 * 2; if ($p9 >= 10) $p9 -= 9;
                $modulo = 10;
            }

            /* Solo para sociedades publicas (modulo 11) */
            /* Aqui el digito verficador esta en la posicion 9, en las otras 2 en la pos. 10 */
            else if($d3 == 6)
            {
                $pub = true;
                $p1 = $d1 * 3;
                $p2 = $d2 * 2;
                $p3 = $d3 * 7;
                $p4 = $d4 * 6;
                $p5 = $d5 * 5;
                $p6 = $d6 * 4;
                $p7 = $d7 * 3;
                $p8 = $d8 * 2;
                $p9 = 0;
            }

            /* Solo para entidades privadas (modulo 11) */
            else if($d3 == 9)
            {
                $pri = true;
                $p1 = $d1 * 4;
                $p2 = $d2 * 3;
                $p3 = $d3 * 2;
                $p4 = $d4 * 7;
                $p5 = $d5 * 6;
                $p6 = $d6 * 5;
                $p7 = $d7 * 4;
                $p8 = $d8 * 3;
                $p9 = $d9 * 2;
            }

            $suma = $p1 + $p2 + $p3 + $p4 + $p5 + $p6 + $p7 + $p8 + $p9;
            $residuo = $suma % $modulo;

            /* Si residuo=0, dig.ver.=0, caso contrario 10 - residuo*/
            $digitoVerificador = ($residuo==0)? 0 : ($modulo - $residuo);

            /* ahora comparamos el elemento de la posicion 10 con el dig. ver.*/
            if($pub==true)
            {
                if($digitoVerificador != $d9)
                {
                    $this->addError('identificacion','Número de identificación Incorrecto');
                }
                /* El ruc de las empresas del sector publico terminan con 0001*/
                if( substr($numero, 9, 4) < 1 )
                {
                    $this->addError('identificacion','Número de identificación Incorrecto');
                }
            }
            else if($pri == true)
            {
                if($digitoVerificador != $d10)
                {
                    $this->addError('identificacion','Número de identificación Incorrecto');
                }
                if( substr($numero, 10, 3) < 1 ){
                    $this->addError('identificacion','Número de identificación Incorrecto');
                }
            }
            else if($nat == true)
            {
                if ($digitoVerificador != $d10)
                {
                    $this->addError('identificacion','Número de identificación Incorrecto');
                }
                if (strlen($numero) > 10 && substr($numero, 10, 3) < 1 )
                {
                    $this->addError('identificacion','Número de identificación Incorrecto');
                }
            }
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
            'pais_id' => 'País',
            'ciudad_id' => 'Ciudad',
            'terminos_condiciones' => 'Aceptar términos y condiciones',
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