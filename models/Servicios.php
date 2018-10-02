<?php

namespace app\models;

class Servicios extends \app\models\base\ServiciosBase
{

	public $categorias, $imagen_upload;

	public function rules()
    {
        return array_merge(parent::rules(),
        [
            [['imagen', 'nombre', 'incluye', 'no_incluye', 'categorias'], 'required'],
        ]);
    }

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
	    'mostrar_app' => '¿Mostrar en APP?',
	    'proveedor_aplica_iva' => 'Aplica Iva',
		'proveedor_subtotal' => 'Subtotal',
		'proveedor_iva' => 'Iva',
		'proveedor_total' => 'Total',
	];
	}
}