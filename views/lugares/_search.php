<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LugaresSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lugares-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cuenta_id') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'tipo') ?>

    <?= $form->field($model, 'poligono') ?>

    <?php // echo $form->field($model, 'wkt') ?>

    <?php // echo $form->field($model, 'estado_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
