<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Atenciones */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="atenciones-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'paciente_id')->textInput() ?>

    <?= $form->field($model, 'doctor_id')->textInput() ?>

    <?= $form->field($model, 'latitude')->textInput() ?>

    <?= $form->field($model, 'longitude')->textInput() ?>

    <?= $form->field($model, 'atencion_id')->textInput() ?>

    <?= $form->field($model, 'turno_id')->textInput() ?>

    <?= $form->field($model, 'fecha_creacion')->textInput() ?>

    <?= $form->field($model, 'estado')->textInput() ?>

    <?= $form->field($model, 'sintomas')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'diagnostico')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cie10')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion_cie10')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'medicamentos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'observacioens')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imagen')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'fecha_llenado_formulario')->textInput() ?>

    <?= $form->field($model, 'tiempo_atencion')->dropDownList([ 5 => '5', 10 => '10', 15 => '15', 20 => '20', 25 => '25', 30 => '30', 45 => '45', 60 => '60', ], ['prompt' => '']) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
