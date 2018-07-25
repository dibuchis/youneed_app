<?php

namespace app\models;
use Yii;
use yii\base\Model;

class Lugares extends \app\models\base\LugaresBase
{
    public function rules()
    {
        return array_merge(parent::rules(),
        [
            [['nombre', 'tipo'], 'required'],
        ]);
    }
}