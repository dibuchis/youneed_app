<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Configuraciones */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="configuraciones-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'politicas_condiciones')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'beneficios_ser_asociado')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'promociones_asociados')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'ayuda')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'porcentaje_cancelacion_cliente')->widget(\yii\widgets\MaskedInput::className(), [
        'clientOptions' => [
                'alias' =>  'decimal',
                'groupSeparator' => '',
                'digits' => 2, 
                'autoGroup' => true
            ],
    ]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
