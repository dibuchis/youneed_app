<?php

namespace app\models\base;

use Yii;
use app\models\Atenciones;

/**
 * This is the model class for table "calificaciones".
*
    * @property integer $id
    * @property integer $calificacion
    * @property integer $atencion_id
    * @property string $fecha_calificacion
    * @property string $observacion
    *
            * @property Atenciones $atencion
    */
class CalificacionesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'calificaciones';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['calificacion', 'atencion_id'], 'integer'],
            [['atencion_id'], 'required'],
            [['fecha_calificacion'], 'safe'],
            [['observacion'], 'string', 'max' => 2000],
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
    'calificacion' => 'Calificacion',
    'atencion_id' => 'Atencion ID',
    'fecha_calificacion' => 'Fecha Calificacion',
    'observacion' => 'Observacion',
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