<?php

namespace app\models\base;

use Yii;
use app\models\Carreteras;
use app\models\Rutas;

/**
 * This is the model class for table "rutas_carreteras".
*
    * @property integer $id
    * @property integer $ruta_id
    * @property integer $carretera_id
    *
            * @property Carreteras $carretera
            * @property Rutas $ruta
    */
class RutasCarreterasBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'rutas_carreteras';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['ruta_id', 'carretera_id'], 'required'],
            [['ruta_id', 'carretera_id'], 'integer'],
            [['carretera_id'], 'exist', 'skipOnError' => true, 'targetClass' => Carreteras::className(), 'targetAttribute' => ['carretera_id' => 'id']],
            [['ruta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rutas::className(), 'targetAttribute' => ['ruta_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => Yii::t('app', 'ID'),
    'ruta_id' => Yii::t('app', 'Ruta ID'),
    'carretera_id' => Yii::t('app', 'Carretera ID'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCarretera()
    {
    return $this->hasOne(Carreteras::className(), ['id' => 'carretera_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRuta()
    {
    return $this->hasOne(Rutas::className(), ['id' => 'ruta_id']);
    }
}