<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dispositivos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dispositivos-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'grupo_id')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\Grupos::find()->orderBy('nombre')->asArray()->all(), 'id', 'nombre'
                    ),
                'options' => ['placeholder' => Yii::t('app', 'Seleccione')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
            <?= $form->field($model, 'categoria_id')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\Categorias::find()->orderBy('nombre')->asArray()->all(), 'id', 'nombre'
                    ),
                'options' => ['placeholder' => Yii::t('app', 'Seleccione')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'alias')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'placa')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            
            <?= $form->field($model, 'imei')->textInput(['maxlength' => true]) ?>  
            <?= $form->field($model, 'tipo')->dropDownList([ 'Roja' => 'Roja', 'Naranja' => 'Naranja', 'Verde' => 'Verde', ], ['prompt' => '']) ?>

        </div>
    </div>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
