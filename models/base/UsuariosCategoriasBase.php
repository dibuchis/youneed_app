<?php

namespace app\models\base;

use Yii;
use app\models\Categorias;
use app\models\Usuarios;

/**
 * This is the model class for table "usuarios_categorias".
*
    * @property integer $id
    * @property integer $usuario_id
    * @property integer $categoria_id
    *
            * @property Categorias $categoria
            * @property Usuarios $usuario
    */
class UsuariosCategoriasBase extends \yii\db\ActiveRecord
{
/**
* @inheritdoc
*/
public static function tableName()
{
return 'usuarios_categorias';
}

/**
* @inheritdoc
*/
public function rules()
{
        return [
            [['usuario_id', 'categoria_id'], 'required'],
            [['usuario_id', 'categoria_id'], 'integer'],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::className(), 'targetAttribute' => ['categoria_id' => 'id']],
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
    'categoria_id' => 'Categoria ID',
];
}

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getCategoria()
    {
    return $this->hasOne(Categorias::className(), ['id' => 'categoria_id']);
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getUsuario()
    {
    return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id']);
    }
}