<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Servicios;
use yii\helpers\Url;
use kartik\widgets\DepDrop;
use dosamigos\fileupload\FileUpload;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="container">
	<?php $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'enableAjaxValidation' => true,
        'options'=>['enctype'=>'multipart/form-data'] // important
    ]); ?>
	<h3>Información personal</h3>
	<div class="row">
		<div class="col-md-4">
			<?php echo $form->field($model, 'imagen')->textarea(['style' => 'display:none;']); ?>
		    <?php echo Html::img($model->imagen , ['style'=> 'height:200px;', 'id'=>'vista_previa_imagen']); ?>
		    <?= Html::img( Url::to('@web/images/ajax-loader.gif'), ['class'=> 'loader']);?>
		    <?= FileUpload::widget([
		        'model' => $model,
		        'attribute' => 'imagen_upload',
		        'url' => ['ajax/subirfotografia', 'id' => $model->id],
		        'options' => ['accept' => 'image/*'],
		        'clientOptions' => [
		            'maxFileSize' => 2000000,
		            'dataType' => 'json'
		        ],
		        'clientEvents' => [
		            'fileuploaddone' => 'function(e, data) {
		                                    $("#usuarios-imagen").val( data.result[0].base64 );
		                                    $("#vista_previa_imagen").attr("src", data.result[0].base64);
		                                    $(".loader").hide();
		                                }',
		            'fileuploadfail' => 'function(e, data) {

		                                }',
		            'fileuploadstart' => 'function(e, data) {
		            	$(".loader").show();
		                                }',
		        ],
		    ]); ?>
		</div>
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-6">

					<div class="row">
						<div class="col-md-6">
							<?= $form->field($model, 'tipo_identificacion')->dropDownList( [1=>'Cédula', 2=>'RUC', 3=>'RISE', 4=>'Pasaporte'], ['prompt' => 'Seleccione']) ?>  
						</div>
						<div class="col-md-6">
							<?= $form->field($model, 'identificacion')->textInput(['maxlength' => true]) ?>
						</div>
					</div>
					
				    <?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>

				    <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>

				</div>
				<div class="col-md-6">
					<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

				    <?= $form->field($model, 'numero_celular')->textInput(['maxlength' => true]) ?>

				    <?= $form->field($model, 'ciudad_id')->widget(\kartik\widgets\Select2::classname(), [
				        'data' => \yii\helpers\ArrayHelper::map(\app\models\Ciudades::find()->orderBy('nombre')->asArray()->all(), 'id', 
				                function($model, $defaultValue) {
				                    return $model['nombre'];
				                }
				            ),
				        'options' => ['placeholder' => 'Seleccione'],
				        'pluginOptions' => [
				            'allowClear' => true, 
				            'multiple' => false,
				        ],
				    ]); ?>

				</div>	
			</div>
		</div>
	</div>
	<h3>Información de servicios</h3>
	<div class="row">
	    <div class="col-md-12">

            <?php 
                $lista_categorias = \yii\helpers\ArrayHelper::map(\app\models\Categorias::find()->orderBy('nombre')->asArray()->all(), 'id', 
	                    function($model, $defaultValue) {
	                        return $model['nombre'];
	                    }
                );
                echo $form->field($model, 'categoria_id')->dropDownList($lista_categorias, ['id'=>'cat-id', 'prompt' => 'Seleccione']);
                echo Html::hiddenInput('input-type-1', 'Additional value 1', ['id'=>'input-type-1']);
                echo Html::hiddenInput('input-type-2', 'Additional value 2', ['id'=>'input-type-2']);

                echo $form->field($model, 'servicios')->widget(DepDrop::classname(), [
                    'type'=>DepDrop::TYPE_SELECT2,
                    'data'=>[],
                    'options'=>['id'=>'subcat1-id', 'placeholder'=>'Seleccione', 'options'=> []],
                    'select2Options'=>['pluginOptions'=>['multiple' => true,'allowClear'=>true]],
                    'pluginOptions'=>[
                        'depends'=>['cat-id'],
                        'url'=>Url::to(['/ajax/listadoservicios']),
                        'params'=>['input-type-1', 'input-type-2'],
                    ]
                ]);
            ?>

	    </div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<?= $form->field($model, 'dias_trabajo')->dropDownList([1=>'Lunes a viernes', 2=>'Fines de semana', 3=>'Cualquier día'], ['prompt' => 'Seleccione']) ?>
		</div>
		<div class="col-md-6">
			<?= $form->field($model, 'horarios_trabajo')->dropDownList([1=>'7am a 12am', 2=>'12am a 7pm', 3=>'7pm a 7am', 4=>'24 horas'], ['prompt' => 'Seleccione']) ?>
		</div>
	</div>
	<h3>Información para pagos</h3>

	<?= $form->field($model, 'banco_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\models\Bancos::find()->orderBy('nombre')->asArray()->all(), 'id', 
                function($model, $defaultValue) {
                    return $model['nombre'];
                }
            ),
        'options' => ['placeholder' => 'Seleccione'],
        'pluginOptions' => [
            'allowClear' => true, 
            'multiple' => false,
        ],
    ]); ?>

    <div class="row">
    	<div class="col-md-4">
    		<?= $form->field($model, 'nombre_beneficiario')->textInput(['maxlength' => true]) ?>
    	</div>
    	<div class="col-md-4">
    		<?= $form->field($model, 'tipo_cuenta')->dropDownList([ 'Corriente' => 'Corriente', 'Ahorros' => 'Ahorros', ], ['prompt' => '']) ?>
    	</div>
    	<div class="col-md-4">
    		<?= $form->field($model, 'numero_cuenta')->textInput(['maxlength' => true]) ?>
    	</div>
    </div>
    <hr>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Registrarse' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary btn-lg center-block' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
</div>
