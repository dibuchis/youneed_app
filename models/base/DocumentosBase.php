<?php

namespace app\models\base;

use Yii;
use app\models\TiposDocumentos;
use app\models\Usuarios;

/**
 * This is the model class for table "documentos".
*
    * @property integer $id
    * @property integer $usuario_id
    * @property integer $tipo_documento_id
    * @property string $imagen
    * @property string $tipo_documento
    * @property string $tamanio
    * @property integer $es_obilgatorio
    *
            * @property TiposDocumentos $tipoDocumento
            * @property Usuarios $usuario
    */
class DocumentosBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'documentos';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['usuario_id', 'tipo_documento_id'], 'required'],
            [['usuario_id', 'tipo_documento_id', 'es_obilgatorio'], 'integer'],
            [['imagen', 'tipo_documento'], 'string'],
            [['tamanio'], 'string', 'max' => 45],
            [['tipo_documento_id'], 'exist', 'skipOnError' => true, 'targetClass' => TiposDocumentos::className(), 'targetAttribute' => ['tipo_documento_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
}

/**
* @inheritdoc
*/
public function attributeLabels()
{
return [
    'id' => 'ID',
    'usuario_id' => 'Usuario ID',
    'tipo_documento_id' => 'Tipo Documento ID',
    'imagen' => 'Imagen',
    'tipo_documento' => 'Tipo Documento',
    'tamanio' => 'Tamanio',
    'es_obilgatorio' => 'Es Obilgatorio',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getTipoDocumento()
    {
    return $this->hasOne(TiposDocumentos::className(), ['id' => 'tipo_documento_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuario()
    {
    return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }
}