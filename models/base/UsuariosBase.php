<?php

namespace app\models\base;

use Yii;
use app\models\Calificaciones;
use app\models\Documentos;
use app\models\Items;
use app\models\Pedidos;
use app\models\Tarjetas;
use app\models\Bancos;
use app\models\Categorias;
use app\models\Ciudades;
use app\models\Planes;
use app\models\UsuariosServicios;

/**
 * This is the model class for table "usuarios".
*
    * @property integer $id
    * @property integer $tipo_identificacion
    * @property string $identificacion
    * @property string $imagen
    * @property string $nombres
    * @property string $apellidos
    * @property string $email
    * @property string $numero_celular
    * @property string $telefono_domicilio
    * @property string $clave
    * @property integer $estado
    * @property string $token_push
    * @property integer $habilitar_rastreo
    * @property string $token
    * @property integer $ciudad_id
    * @property integer $categoria_id
    * @property string $fecha_creacion
    * @property string $fecha_activacion
    * @property string $fecha_desactivacion
    * @property string $causas_desactivacion
    * @property integer $plan_id
    * @property string $fecha_cambio_plan
    * @property integer $banco_id
    * @property string $nombre_beneficiario
    * @property string $tipo_cuenta
    * @property string $numero_cuenta
    * @property integer $preferencias_deposito
    * @property string $observaciones
    * @property integer $dias_trabajo
    * @property integer $horarios_trabajo
    * @property integer $estado_validacion_documentos
    * @property integer $traccar_id
    * @property string $imei
    * @property integer $es_super
    * @property integer $es_asociado
    * @property integer $es_cliente
    * @property integer $es_operador
    *
            * @property Calificaciones[] $calificaciones
            * @property Documentos[] $documentos
            * @property Items[] $items
            * @property Pedidos[] $pedidos
            * @property Pedidos[] $pedidos0
            * @property Tarjetas[] $tarjetas
            * @property Bancos $banco
            * @property Categorias $categoria
            * @property Ciudades $ciudad
            * @property Planes $plan
            * @property UsuariosServicios[] $usuariosServicios
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
            [['tipo_identificacion', 'estado', 'habilitar_rastreo', 'ciudad_id', 'categoria_id', 'plan_id', 'banco_id', 'preferencias_deposito', 'dias_trabajo', 'horarios_trabajo', 'estado_validacion_documentos', 'traccar_id', 'es_super', 'es_asociado', 'es_cliente', 'es_operador'], 'integer'],
            [['imagen', 'token_push', 'token', 'causas_desactivacion', 'tipo_cuenta', 'observaciones'], 'string'],
            [['fecha_creacion', 'fecha_activacion', 'fecha_desactivacion', 'fecha_cambio_plan'], 'safe'],
            [['identificacion'], 'string', 'max' => 80],
            [['nombres', 'apellidos', 'email', 'clave'], 'string', 'max' => 200],
            [['numero_celular', 'telefono_domicilio'], 'string', 'max' => 45],
            [['nombre_beneficiario'], 'string', 'max' => 850],
            [['numero_cuenta'], 'string', 'max' => 450],
            [['imei'], 'string', 'max' => 150],
            [['banco_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bancos::className(), 'targetAttribute' => ['banco_id' => 'id']],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::className(), 'targetAttribute' => ['categoria_id' => 'id']],
            [['ciudad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ciudades::className(), 'targetAttribute' => ['ciudad_id' => 'id']],
            [['plan_id'], 'exist', 'skipOnError' => true, 'targetClass' => Planes::className(), 'targetAttribute' => ['plan_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'tipo_identificacion' => 'Tipo Identificacion',
    'identificacion' => 'Identificacion',
    'imagen' => 'Imagen',
    'nombres' => 'Nombres',
    'apellidos' => 'Apellidos',
    'email' => 'Email',
    'numero_celular' => 'Numero Celular',
    'telefono_domicilio' => 'Telefono Domicilio',
    'clave' => 'Clave',
    'estado' => 'Estado',
    'token_push' => 'Token Push',
    'habilitar_rastreo' => 'Habilitar Rastreo',
    'token' => 'Token',
    'ciudad_id' => 'Ciudad ID',
    'categoria_id' => 'Categoria ID',
    'fecha_creacion' => 'Fecha Creacion',
    'fecha_activacion' => 'Fecha Activacion',
    'fecha_desactivacion' => 'Fecha Desactivacion',
    'causas_desactivacion' => 'Causas Desactivacion',
    'plan_id' => 'Plan ID',
    'fecha_cambio_plan' => 'Fecha Cambio Plan',
    'banco_id' => 'Banco ID',
    'nombre_beneficiario' => 'Nombre Beneficiario',
    'tipo_cuenta' => 'Tipo Cuenta',
    'numero_cuenta' => 'Numero Cuenta',
    'preferencias_deposito' => 'Preferencias Deposito',
    'observaciones' => 'Observaciones',
    'dias_trabajo' => 'Dias Trabajo',
    'horarios_trabajo' => 'Horarios Trabajo',
    'estado_validacion_documentos' => 'Estado Validacion Documentos',
    'traccar_id' => 'Traccar ID',
    'imei' => 'Imei',
    'es_super' => 'Es Super',
    'es_asociado' => 'Es Asociado',
    'es_cliente' => 'Es Cliente',
    'es_operador' => 'Es Operador',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCalificaciones()
    {
    return $this->hasMany(Calificaciones::className(), ['usuario_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getDocumentos()
    {
    return $this->hasMany(Documentos::className(), ['usuario_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getItems()
    {
    return $this->hasMany(Items::className(), ['asociado_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPedidos()
    {
    return $this->hasMany(Pedidos::className(), ['cliente_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPedidos0()
    {
    return $this->hasMany(Pedidos::className(), ['asociado_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTarjetas()
    {
    return $this->hasMany(Tarjetas::className(), ['usuario_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getBanco()
    {
    return $this->hasOne(Bancos::className(), ['id' => 'banco_id']);
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
    public function getCiudad()
    {
    return $this->hasOne(Ciudades::className(), ['id' => 'ciudad_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getPlan()
    {
    return $this->hasOne(Planes::className(), ['id' => 'plan_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuariosServicios()
    {
    return $this->hasMany(UsuariosServicios::className(), ['usuario_id' => 'id']);
    }
}