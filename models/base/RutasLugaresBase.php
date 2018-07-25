<?php

namespace app\models\base;

use Yii;
use app\models\Lugares;
use app\models\Rutas;

/**
 * This is the model class for table "rutas_lugares".
*
    * @property integer $idrutas_lugares
    * @property integer $ruta_id
    * @property integer $lugar_id
    *
            * @property Lugares $lugar
            * @property Rutas $ruta
    */
class RutasLugaresBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'rutas_lugares';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['ruta_id', 'lugar_id'], 'required'],
            [['ruta_id', 'lugar_id'], 'integer'],
            [['lugar_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lugares::className(), 'targetAttribute' => ['lugar_id' => 'id']],
            [['ruta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rutas::className(), 'targetAttribute' => ['ruta_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'idrutas_lugares' => Yii::t('app', 'Idrutas Lugares'),
    'ruta_id' => Yii::t('app', 'Ruta ID'),
    'lugar_id' => Yii::t('app', 'Lugar ID'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getLugar()
    {
    return $this->hasOne(Lugares::className(), ['id' => 'lugar_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getRuta()
    {
    return $this->hasOne(Rutas::className(), ['id' => 'ruta_id']);
    }
}