<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'clave')->passwordInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            
            <?= $form->field($model, 'tipo')->dropDownList([ 'Superadmin' => 'Superadmin', 'Administrador' => 'Administrador', 'Personal' => 'Personal', 'Operador' => 'Operador', ], ['prompt' => '']) ?>
           
            <?= $form->field($model, 'dispositivo_id')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\Dispositivos::find()->orderBy('nombre')->asArray()->andWhere(['cuenta_id'=>Yii::$app->user->identity->cuenta_id, 'tipo_dispositivo'=>0])->all(), 'id', 'nombre'
                    ),
                'options' => ['placeholder' => Yii::t('app', 'Seleccione')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

            <?= $form->field($model, 'estado_id')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\Estados::find()->orderBy('id')->asArray()->all(), 'id', 'nombre'
                    ),
                'options' => ['placeholder' => Yii::t('app', 'Seleccione estado')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
            
        </div>
    </div>
    
    

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
