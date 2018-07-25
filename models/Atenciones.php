<?php

namespace app\models;

class Atenciones extends \app\models\base\AtencionesBase
{

	public function rules()
    {
        return array_merge(parent::rules(),
        [
            [['sintomas', 'diagnostico', 'cie10', 'descripcion_cie10', 'medicamentos', 'observaciones'], 'required', 'on' => 'registro_formulario'],
        ]);
    }

    public function attributeLabels()
	{
		return [
		    'id' => 'ID',
		    'paciente_id' => 'Paciente',
		    'doctor_id' => 'Doctor',
		    'latitude' => 'Latitude',
		    'longitude' => 'Longitude',
		    'atencion_id' => 'Atencion ID',
		    'turno_id' => 'Turno ID',
		    'fecha_creacion' => 'Fecha Creación',
		    'fecha_pago'=>'Fecha de pago',
		    'estado' => 'Estado',
		    'sintomas' => 'Sintomas',
		    'diagnostico' => 'Diagnostico',
		    'cie10' => 'Cie10',
		    'descripcion_cie10' => 'Descripcion Cie10',
		    'medicamentos' => 'Medicamentos',
		    'observacioens' => 'Observacioens',
		    'imagen' => 'Imagen',
		    'fecha_llenado_formulario' => 'Fecha Llenado Formulario',
		    'tiempo_atencion' => 'Tiempo de Atención',
		    'latitude_inicial_doctor' => 'Latitude Inicial Doctor',
		    'longitude_inicial_doctor' => 'Longitude Inicial Doctor',
		];
	}
}