<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Planes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="planes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'sin_descuento')->widget(\yii\widgets\MaskedInput::className(), [
                'clientOptions' => [
                        'alias' =>  'decimal',
                        'groupSeparator' => '',
                        'digits' => 2, 
                        'autoGroup' => true
                    ],
            ])->textInput(['value' => $model->sin_descuento]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'descuento_1')->widget(\yii\widgets\MaskedInput::className(), [
                'clientOptions' => [
                        'alias' =>  'decimal',
                        'groupSeparator' => '',
                        'digits' => 2, 
                        'autoGroup' => true
                    ],
            ])->textInput(['value' => $model->descuento_1]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'pvp')->widget(\yii\widgets\MaskedInput::className(), [
                'clientOptions' => [
                        'alias' =>  'decimal',
                        'groupSeparator' => '',
                        'digits' => 2, 
                        'autoGroup' => true
                    ],
            ])->textInput(['value' => $model->pvp, 'readonly'=>'readonly']) ?>
        </div>
    </div>

	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
