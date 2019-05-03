<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\Models\TiposNotificaciones */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipos-notificaciones-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'categoria')->textInput() ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mensaje')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
