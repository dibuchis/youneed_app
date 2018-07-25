<?php

namespace app\models;
use Yii;

class Conductores extends \app\models\base\ConductoresBase
{
	public $dispositivos;

	public function rules()
    {
        return array_merge(parent::rules(),
        [
            [['identificacion', 'nombres', 'apellidos', 'telefonos', 'dispositivos'], 'required'],
            [['identificacion'], 'unique'],
        ]);
    }

    public function attributeLabels()
	{
		return [
		    'id' => Yii::t('app', 'ID'),
		    'cuenta_id' => Yii::t('app', 'Cuenta ID'),
		    'nombres' => Yii::t('app', 'Nombres'),
		    'apellidos' => Yii::t('app', 'Apellidos'),
		    'identificacion' => Yii::t('app', 'Identificación'),
		    'telefonos' => Yii::t('app', 'Teléfonos'),
		    'observaciones' => Yii::t('app', 'Observaciones'),
		];
	}
}