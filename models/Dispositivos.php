<?php

namespace app\models;
use Yii;
use yii\base\Model;
class Dispositivos extends \app\models\base\DispositivosBase
{
    public function rules()
    {
        return array_merge(parent::rules(),
        [
            [['nombre', 'alias', 'imei', 'placa'], 'required'],
            [['imei', 'alias'], 'unique'],
        ]);
    }

    public function attributeLabels()
	{
	return [
	    'id' => Yii::t('app', 'ID'),
	    'cuenta_id' => Yii::t('app', 'Cuenta ID'),
	    'grupo_id' => Yii::t('app', 'Grupo/Flota'),
	    'categoria_id' => Yii::t('app', 'Categoría'),
	    'nombre' => Yii::t('app', 'Nombre'),
	    'alias' => Yii::t('app', 'Alias'),
	    'placa' => Yii::t('app', 'Placa'),
	    'imei' => Yii::t('app', 'Imei'),
	    'traccar_id' => Yii::t('app', 'Traccar ID'),
	    'tipo' => Yii::t('app', 'Tipo'),
	];
	}
}