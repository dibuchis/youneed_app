<?php

namespace app\models;

class TiposDocumentos extends \app\models\base\TiposDocumentosBase
{
    public function rules()
    {
        return array_merge(parent::rules(),
        [
            [['nombre'], 'required'],
        ]);
    }
}