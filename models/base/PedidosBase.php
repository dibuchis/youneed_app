<?php

namespace app\models\base;

use Yii;
use app\models\Calificaciones;
use app\models\Items;
use app\models\Ciudades;
use app\models\Tarjetas;
use app\models\Usuarios;
use app\models\Servicios;

/**
 * This is the model class for table "pedidos".
*
    * @property integer $id
    * @property integer $cliente_id
    * @property integer $asociado_id
    * @property double $latitud
    * @property double $longitud
    * @property string $identificacion
    * @property string $razon_social
    * @property string $nombres
    * @property string $apellidos
    * @property string $email
    * @property string $telefono
    * @property string $fecha_para_servicio
    * @property string $direccion_completa
    * @property string $observaciones_adicionales
    * @property integer $forma_pago
    * @property integer $tarjeta_id
    * @property string $codigo_postal
    * @property integer $tipo_atencion
    * @property integer $tiempo_llegada
    * @property string $fecha_creacion
    * @property integer $estado
    * @property string $subtotal
    * @property string $iva
    * @property string $iva_0
    * @property string $iva_impuesto
    * @property string $total
    * @property string $fecha_llegada_atencion
    * @property string $fecha_finalizacion_atencion
    * @property string $valores_transferir_asociado
    * @property string $valores_cancelacion_servicio_cliente
    * @property integer $tiempo_aproximado_llegada
    * @property integer $ciudad_id
    * @property integer $servicio_id
    *
            * @property Calificaciones[] $calificaciones
            * @property Items[] $items
            * @property Ciudades $ciudad
            * @property Tarjetas $tarjeta
            * @property Usuarios $cliente
            * @property Usuarios $asociado
            * @property Servicios $servicio
    */
class PedidosBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'pedidos';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['cliente_id', 'asociado_id', 'forma_pago', 'tarjeta_id', 'tipo_atencion', 'tiempo_llegada', 'estado', 'tiempo_aproximado_llegada', 'ciudad_id'], 'integer'],
            [['latitud', 'longitud', 'subtotal', 'iva', 'iva_0', 'iva_impuesto', 'total', 'valores_transferir_asociado', 'valores_cancelacion_servicio_cliente'], 'number'],
            [['fecha_para_servicio', 'fecha_creacion', 'fecha_llegada_atencion', 'fecha_finalizacion_atencion'], 'safe'],
            [['direccion_completa', 'observaciones_adicionales'], 'string'],
            [['identificacion'], 'string', 'max' => 80],
            [['razon_social'], 'string', 'max' => 800],
            [['nombres', 'apellidos', 'email'], 'string', 'max' => 200],
            [['telefono', 'codigo_postal'], 'string', 'max' => 45],
            [['ciudad_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ciudades::className(), 'targetAttribute' => ['ciudad_id' => 'id']],
            [['tarjeta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tarjetas::className(), 'targetAttribute' => ['tarjeta_id' => 'id']],
            [['cliente_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['cliente_id' => 'id']],
            [['asociado_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['asociado_id' => 'id']],
            [['servicio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Servicios::className(), 'targetAttribute' => ['servicio_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'cliente_id' => 'Cliente ID',
    'asociado_id' => 'Asociado ID',
    'latitud' => 'Latitud',
    'longitud' => 'Longitud',
    'identificacion' => 'Identificacion',
    'razon_social' => 'Razon Social',
    'nombres' => 'Nombres',
    'apellidos' => 'Apellidos',
    'email' => 'Email',
    'telefono' => 'Telefono',
    'fecha_para_servicio' => 'Fecha Para Servicio',
    'direccion_completa' => 'Direccion Completa',
    'observaciones_adicionales' => 'Observaciones Adicionales',
    'forma_pago' => 'Forma Pago',
    'tarjeta_id' => 'Tarjeta ID',
    'codigo_postal' => 'Codigo Postal',
    'tipo_atencion' => 'Tipo Atencion',
    'tiempo_llegada' => 'Tiempo Llegada',
    'fecha_creacion' => 'Fecha Creacion',
    'estado' => 'Estado',
    'subtotal' => 'Subtotal',
    'iva' => 'Iva',
    'iva_0' => 'Iva 0',
    'iva_impuesto' => 'Iva Impuesto',
    'total' => 'Total',
    'fecha_llegada_atencion' => 'Fecha Llegada Atencion',
    'fecha_finalizacion_atencion' => 'Fecha Finalizacion Atencion',
    'valores_transferir_asociado' => 'Valores Transferir Asociado',
    'valores_cancelacion_servicio_cliente' => 'Valores Cancelacion Servicio Cliente',
    'tiempo_aproximado_llegada' => 'Tiempo Aproximado Llegada',
    'ciudad_id' => 'Ciudad ID',
    'servicio_id' => 'Servicio ID',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCalificaciones()
    {
    return $this->hasMany(Calificaciones::className(), ['pedido_id' => 'id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getItems()
    {
    return $this->hasMany(Items::className(), ['pedido_id' => 'id']);
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
    public function getTarjeta()
    {
    return $this->hasOne(Tarjetas::className(), ['id' => 'tarjeta_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCliente()
    {
    return $this->hasOne(Usuarios::className(), ['id' => 'cliente_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getAsociado()
    {
    return $this->hasOne(Usuarios::className(), ['id' => 'asociado_id']);
    }
}