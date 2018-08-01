<?php

namespace app\models;

class Documentos extends \app\models\base\DocumentosBase
{
    public function attributeLabels()
	{
	return [
	    'id' => 'ID',
	    'usuario_id' => 'Asociado',
	    'tipo_documento_id' => 'Tipo de Documento',
	    'imagen' => 'Imagen',
	    'tamanio' => 'Tamaño',
	    'es_obilgatorio' => '¿Es Obligatorio?',
	];
	}
}