<?php

namespace app\models\base;

use Yii;

/**
 * This is the model class for table "listados_enfermedades".
*
    * @property string $id
    * @property string $descripcion
    * @property string $grp10
*/
class ListadosEnfermedadesBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'listados_enfermedades';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['id'], 'required'],
            [['id'], 'string', 'max' => 10],
            [['descripcion'], 'string', 'max' => 400],
            [['grp10'], 'string', 'max' => 200],
            [['id'], 'unique'],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'descripcion' => 'Descripcion',
    'grp10' => 'Grp10',
];
}
}