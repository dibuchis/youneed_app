<?php

namespace app\models;

class Servicios extends \app\models\base\ServiciosBase
{
    public function attributeLabels()
	{
	return [
	    'id' => 'ID',
	    'nombre' => 'Nombre',
	    'slug' => 'Slug',
	    'incluye' => 'Incluye',
	    'no_incluye' => 'No Incluye',
	    'tarifa_base' => 'Tarifa Base',
	    'tarifa_dinamica' => 'Tarifa Dinámica',
	    'aplica_iva' => 'Aplica Iva',
	    'obligatorio_certificado' => '¿Obligatorio Certificado?',
	    'imagen' => 'Imagen',
	];
	}
}