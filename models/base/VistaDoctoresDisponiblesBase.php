<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "vista_doctores_disponibles".
*
    * @property integer $id
    * @property string $nombres
    * @property string $apellidos
    * @property string $identificacion
    * @property string $registro_medico
    * @property string $numero_celular
    * @property string $email
    * @property integer $traccar_id
*/
class VistaDoctoresDisponiblesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'vista_doctores_disponibles';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['id', 'traccar_id'], 'integer'],
            [['nombres', 'apellidos', 'email'], 'string', 'max' => 200],
            [['identificacion'], 'string', 'max' => 80],
            [['registro_medico'], 'string', 'max' => 100],
            [['numero_celular'], 'string', 'max' => 45],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'nombres' => 'Nombres',
    'apellidos' => 'Apellidos',
    'identificacion' => 'Identificacion',
    'registro_medico' => 'Registro Medico',
    'numero_celular' => 'Numero Celular',
    'email' => 'Email',
    'traccar_id' => 'Traccar ID',
];
}
}