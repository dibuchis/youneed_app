<?php

namespace app\models;

class Configuraciones extends \app\models\base\ConfiguracionesBase
{
	public function attributeLabels()
	{
	return [
	    'id' => 'ID',
	    'politicas_condiciones' => 'Políticas y Condiciones',
	    'porcentaje_cancelacion_cliente' => 'Porcentaje de Cancelación del Cliente',
	    'beneficios_ser_asociado' => 'Beneficios de ser Asociado',
	    'promociones_asociados' => 'Promociones para Asociados',
	    'ayuda' => 'Ayuda',
	];
	}   
}