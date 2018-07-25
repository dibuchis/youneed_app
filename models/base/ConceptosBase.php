<?php

namespace app\models\base;

use Yii;
use app\models\MantenimientosConceptos;

/**
 * This is the model class for table "conceptos".
*
    * @property integer $id
    * @property string $nombre
    *
            * @property MantenimientosConceptos[] $mantenimientosConceptos
    */
class ConceptosBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'conceptos';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['nombre'], 'string', 'max' => 60],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'nombre' => Yii::t('app', 'Nombre'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMantenimientosConceptos()
    {
    return $this->hasMany(MantenimientosConceptos::className(), ['concepto_id' => 'id']);
    }
}