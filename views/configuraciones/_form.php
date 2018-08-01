<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Configuraciones */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="configuraciones-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'politicas_condiciones')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'porcentaje_cancelacion_cliente')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'beneficios_ser_asociado')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'promociones_asociados')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ayuda')->textarea(['rows' => 6]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
