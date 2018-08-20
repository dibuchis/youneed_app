<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "configuraciones".
*
    * @property integer $id
    * @property string $politicas_condiciones
    * @property string $porcentaje_cancelacion_cliente
    * @property string $beneficios_ser_asociado
    * @property string $promociones_asociados
    * @property string $ayuda
    * @property string $comision_pasarela
    * @property string $comision_servicios_bancarios
    * @property string $comision_youneed
    * @property string $porcentaje_iva
    * @property string $porcentaje_retencion
*/
class ConfiguracionesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'configuraciones';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['politicas_condiciones', 'beneficios_ser_asociado', 'promociones_asociados', 'ayuda'], 'string'],
            [['porcentaje_cancelacion_cliente', 'comision_pasarela', 'comision_servicios_bancarios', 'comision_youneed', 'porcentaje_iva', 'porcentaje_retencion'], 'number'],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'politicas_condiciones' => 'Politicas Condiciones',
    'porcentaje_cancelacion_cliente' => 'Porcentaje Cancelacion Cliente',
    'beneficios_ser_asociado' => 'Beneficios Ser Asociado',
    'promociones_asociados' => 'Promociones Asociados',
    'ayuda' => 'Ayuda',
    'comision_pasarela' => 'Comision Pasarela',
    'comision_servicios_bancarios' => 'Comision Servicios Bancarios',
    'comision_youneed' => 'Comision Youneed',
    'porcentaje_iva' => 'Porcentaje Iva',
    'porcentaje_retencion' => 'Porcentaje Retencion',
];
}
}