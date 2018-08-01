<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tipo_identificacion')->textInput() ?>

    <?= $form->field($model, 'identificacion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'imagen')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'numero_celular')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'telefono_domicilio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'clave')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tipo')->dropDownList([ 'Superadmin' => 'Superadmin', 'Operador' => 'Operador', 'Asociado' => 'Asociado', 'Cliente' => 'Cliente', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'estado')->textInput() ?>

    <?= $form->field($model, 'token_push')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'habilitar_rastreo')->textInput() ?>

    <?= $form->field($model, 'token')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'ciudad_id')->textInput() ?>

    <?= $form->field($model, 'categoria_id')->textInput() ?>

    <?= $form->field($model, 'fecha_creacion')->textInput() ?>

    <?= $form->field($model, 'fecha_activacion')->textInput() ?>

    <?= $form->field($model, 'fecha_desactivacion')->textInput() ?>

    <?= $form->field($model, 'causas_desactivacion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'plan_id')->textInput() ?>

    <?= $form->field($model, 'fecha_cambio_plan')->textInput() ?>

    <?= $form->field($model, 'banco_id')->textInput() ?>

    <?= $form->field($model, 'tipo_cuenta')->dropDownList([ 'Corriente' => 'Corriente', 'Ahorros' => 'Ahorros', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'numero_cuenta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'preferencias_deposito')->textInput() ?>

    <?= $form->field($model, 'observaciones')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'dias_trabajo')->textInput() ?>

    <?= $form->field($model, 'horarios_trabajo')->textInput() ?>

    <?= $form->field($model, 'estado_validacion_documentos')->textInput() ?>

    <?= $form->field($model, 'traccar_id')->textInput() ?>

    <?= $form->field($model, 'imei')->textInput(['maxlength' => true]) ?>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
