<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Servicios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="servicios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'incluye')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'no_incluye')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tarifa_base')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tarifa_dinamica')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'aplica_iva')->textInput() ?>

    <?= $form->field($model, 'obligatorio_certificado')->textInput() ?>

    <?= $form->field($model, 'imagen')->textarea(['rows' => 6]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
