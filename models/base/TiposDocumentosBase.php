<?php

namespace app\models\base;

use Yii;
use app\models\Documentos;

/**
 * This is the model class for table "tipos_documentos".
*
    * @property integer $id
    * @property string $nombre
    *
            * @property Documentos[] $documentos
    */
class TiposDocumentosBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'tipos_documentos';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['nombre'], 'string', 'max' => 450],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'nombre' => 'Nombre',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getDocumentos()
    {
    return $this->hasMany(Documentos::className(), ['tipo_documento_id' => 'id']);
    }
}