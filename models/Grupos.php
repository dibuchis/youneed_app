<?php

namespace app\models;

class Grupos extends \app\models\base\GruposBase
{
    public function rules()
    {
        return array_merge(parent::rules(),
        [
            [['nombre'], 'required'],
        ]);
    }
}