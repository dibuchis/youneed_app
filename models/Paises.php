<?php

namespace app\models;

class Paises extends \app\models\base\PaisesBase
{
    public function rules()
    {
        return array_merge(parent::rules(),
        [
            [['nombre'], 'required'],
        ]);
    }
}