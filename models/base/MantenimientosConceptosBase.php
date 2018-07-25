<?php

namespace app\models\base;

use Yii;
use app\models\Conceptos;
use app\models\Mantenimientos;

/**
 * This is the model class for table "mantenimientos_conceptos".
*
    * @property integer $id
    * @property integer $mantenimiento_id
    * @property integer $concepto_id
    *
            * @property Conceptos $concepto
            * @property Mantenimientos $mantenimiento
    */
class MantenimientosConceptosBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'mantenimientos_conceptos';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['mantenimiento_id', 'concepto_id'], 'required'],
            [['mantenimiento_id', 'concepto_id'], 'integer'],
            [['concepto_id'], 'exist', 'skipOnError' => true, 'targetClass' => Conceptos::className(), 'targetAttribute' => ['concepto_id' => 'id']],
            [['mantenimiento_id'], 'exist', 'skipOnError' => true, 'targetClass' => Mantenimientos::className(), 'targetAttribute' => ['mantenimiento_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'mantenimiento_id' => Yii::t('app', 'Mantenimiento ID'),
    'concepto_id' => Yii::t('app', 'Concepto ID'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getConcepto()
    {
    return $this->hasOne(Conceptos::className(), ['id' => 'concepto_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMantenimiento()
    {
    return $this->hasOne(Mantenimientos::className(), ['id' => 'mantenimiento_id']);
    }
}