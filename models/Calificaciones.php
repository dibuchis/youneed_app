<?php

namespace app\models;

class Calificaciones extends \app\models\base\CalificacionesBase
{
    public function attributeLabels()
	{
	return [
	    'id' => 'ID',
	    'usuario_id' => 'Cliente/Paciente',
	    'observaciones' => 'Observaciones',
	    'tipo' => 'Tipo',
	    'puntualidad' => 'Puntualidad',
	    'calidad_trabajo_realizado' => 'Calidad del Trabajo Realizado',
	    'trato_cliente' => 'Trato al Cliente',
	    'presentacion' => 'Presentación',
	    'pedido_id' => 'Pedido',
	];
	}
}