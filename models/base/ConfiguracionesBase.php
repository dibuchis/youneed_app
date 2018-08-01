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
            [['porcentaje_cancelacion_cliente'], 'number'],
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
];
}
}