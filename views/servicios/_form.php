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

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'incluye')->widget(\yii\redactor\widgets\Redactor::className()) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'no_incluye')->widget(\yii\redactor\widgets\Redactor::className()) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'tarifa_base')->widget(\yii\widgets\MaskedInput::className(), [
                'clientOptions' => [
                        'alias' =>  'decimal',
                        'groupSeparator' => '',
                        'digits' => 2, 
                        'autoGroup' => true
                    ],
            ]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'tarifa_dinamica')->widget(\yii\widgets\MaskedInput::className(), [
                'clientOptions' => [
                        'alias' =>  'decimal',
                        'groupSeparator' => '',
                        'digits' => 2, 
                        'autoGroup' => true
                    ],
            ]) ?>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field( $model, 'aplica_iva' )->checkbox(); ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field( $model, 'obligatorio_certificado' )->checkbox(); ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field( $model, 'mostrar_app' )->checkbox(); ?>
                </div>
            </div>
        </div>
    </div>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
