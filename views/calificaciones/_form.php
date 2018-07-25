<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Calificaciones */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="calificaciones-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'calificacion')->textInput() ?>

    <?= $form->field($model, 'atencion_id')->textInput() ?>

    <?= $form->field($model, 'fecha_calificacion')->textInput() ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
