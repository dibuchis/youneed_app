<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class ReporteHistorico extends Model
{
    public $deviceid;
    public $rango_fechas;
    

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['deviceid', 'rango_fechas'], 'required'],
            
        ];
    }

    public function attributeLabels()
    {
    return [
        'deviceid' => Yii::t('app', 'Dispositivo'),
        'fecha_desde' => Yii::t('app', 'Fecha Desde'),
        'tiempo_desde' => Yii::t('app', ''),
        'fecha_hasta' => Yii::t('app', 'Fecha Hasta'),
        'tiempo_hasta' => Yii::t('app', ''),
        
    ];
    }

}
