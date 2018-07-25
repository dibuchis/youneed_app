<?php

namespace app\models\base;

use Yii;
use app\models\Dispositivos;

/**
 * This is the model class for table "categorias".
*
    * @property integer $id
    * @property string $nombre
    * @property string $icono
    *
            * @property Dispositivos[] $dispositivos
    */
class CategoriasBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'categorias';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['nombre'], 'string', 'max' => 200],
            [['icono'], 'string', 'max' => 45],
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
    'icono' => Yii::t('app', 'Icono'),
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getDispositivos()
    {
    return $this->hasMany(Dispositivos::className(), ['categoria_id' => 'id']);
    }
}