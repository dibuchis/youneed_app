<?php

namespace app\models;
use Yii;
use yii\base\Model;

class Visitas extends \app\models\base\VisitasBase
{
    public function attributeLabels()
	{
	return [
	    'id' => 'ID',
	    'dispositivo_id' => 'Dispositivo ID',
	    'lat' => 'Lat',
	    'lng' => 'Lng',
	    'fecha_creacion' => 'Fecha Creación',
	    'fecha_inicio' => 'Fecha Inicio',
	    'fecha_final' => 'Fecha Final',
	    'cumplimiento' => 'Cumplimiento',
	];
	}
}