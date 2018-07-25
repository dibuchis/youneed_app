<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model app\models\Lugares */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="lugares-form">

    <?php $form = ActiveForm::begin([
                'id' => 'formulario-lugares',
                 // 'enableAjaxValidation' => true,
                // 'enableClientValidation' => true,
            ]); ?>
    <div class="row">
        <div class="col-md-4">
             <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'tipo')->dropDownList([ 'Autorizado' => 'Autorizado', 'No Autorizado' => 'No Autorizado', ], ['prompt' => '']) ?>
        </div>
        <div class="col-md-4">
            <?php echo $form->field($model, 'poligono')->textarea()->label(false); ?>
            <?php echo $form->field($model, 'wkt')->textarea()->label(false); ?>            
        </div>
    </div>
    <!-- <input id="pac-input" class="controls" type="text" placeholder="Buscar lugares ..."> -->
    <div id="mapLugares"></div>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
