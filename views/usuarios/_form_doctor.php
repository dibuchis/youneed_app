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
            <?= $form->field($model, 'identificacion')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?php if( $model->tipo == 'Doctor' ){ ?>
                <?= $form->field($model, 'registro_medico')->textInput(['maxlength' => true]) ?>
            <?php } ?>
            <?= $form->field($model, 'numero_celular')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'estado_id')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\Estados::find()->orderBy('id')->asArray()->all(), 'id', 'nombre'
                    ),
                'options' => ['placeholder' => Yii::t('app', 'Seleccione estado')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

            <?php if( !is_null( $model->imagen ) ){ ?>
                <img width="180px" src="<?php echo $model->imagen; ?>">
            <?php } ?>
        </div>
    </div>
    
    

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
