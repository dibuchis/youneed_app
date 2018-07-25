<?php

namespace app\models\base;

use Yii;
use app\models\Atenciones;

/**
 * This is the model class for table "trazabilidades".
*
    * @property integer $id
    * @property string $fecha_llegada_paciente
    * @property string $fecha_salida_paciente
    * @property integer $atencion_id
    *
            * @property Atenciones $atencion
    */
class TrazabilidadesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'trazabilidades';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['fecha_llegada_paciente', 'fecha_salida_paciente'], 'safe'],
            [['atencion_id'], 'required'],
            [['atencion_id'], 'integer'],
            [['atencion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Atenciones::className(), 'targetAttribute' => ['atencion_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'fecha_llegada_paciente' => 'Fecha Llegada Paciente',
    'fecha_salida_paciente' => 'Fecha Salida Paciente',
    'atencion_id' => 'Atencion ID',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getAtencion()
    {
    return $this->hasOne(Atenciones::className(), ['id' => 'atencion_id']);
    }
}