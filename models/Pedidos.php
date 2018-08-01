<?php

namespace app\models;

class Pedidos extends \app\models\base\PedidosBase
{
    public function attributeLabels()
	{
	return [
	    'id' => 'ID',
	    'cliente_id' => 'Cliente',
	    'asociado_id' => 'Asociado',
	    'latitud' => 'Latitud',
	    'longitud' => 'Longitud',
	    'identificacion' => 'Identificación',
	    'razon_social' => 'Razon Social',
	    'nombres' => 'Nombres',
	    'apellidos' => 'Apellidos',
	    'email' => 'Email',
	    'telefono' => 'Teléfono',
	    'fecha_para_servicio' => 'Fecha Para Servicio',
	    'direccion_completa' => 'Dirección Completa',
	    'observaciones_adicionales' => 'Observaciones Adicionales',
	    'ciudad_id' => 'Ciudad',
	    'forma_pago' => 'Forma de Pago',
	    'tarjeta_id' => 'Tarjeta',
	    'codigo_postal' => 'Código Postal',
	    'tipo_atencion' => 'Tipo de Atencion',
	    'tiempo_llegada' => 'Tiempo de Llegada',
	    'fecha_creacion' => 'Fecha Creación',
	    'estado' => 'Estado',
	    'subtotal' => 'Subtotal',
	    'iva' => 'Iva',
	    'iva_0' => 'Iva 0',
	    'total' => 'Total',
	    'fecha_llegada_atencion' => 'Fecha de Llegada a Atencion',
	    'fecha_finalizacion_atencion' => 'Fecha de Finalizacion de Atencion',
	    'valores_transferir_asociado' => 'Valores a Transferir al Asociado',
	    'valores_cancelacion_servicio_cliente' => 'Valores de Cancelacion de Servicio al Cliente',
	    'tiempo_aproximado_llegada' => 'Tiempo Aproximado de Llegada',
	];
	}
}