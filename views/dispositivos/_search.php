<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DispositivosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dispositivos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cuenta_id') ?>

    <?= $form->field($model, 'grupo_id') ?>

    <?= $form->field($model, 'categoria_id') ?>

    <?= $form->field($model, 'nombre') ?>

    <?php // echo $form->field($model, 'alias') ?>

    <?php // echo $form->field($model, 'placa') ?>

    <?php // echo $form->field($model, 'imei') ?>

    <?php // echo $form->field($model, 'traccar_id') ?>

    <?php // echo $form->field($model, 'tipo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
