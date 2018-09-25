<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Servicios;
use kartik\widgets\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="container">
	<?php $form = ActiveForm::begin(); ?>
	<div class="row">
		<h1>Información personal</h1>
		<div class="col-md-6">

			<div class="row">
				<div class="col-md-4">
					<?= $form->field($model, 'tipo_identificacion')->dropDownList( [1=>'Cédula', 2=>'RUC', 3=>'RISE', 4=>'Pasaporte'], ['prompt' => 'Seleccione']) ?>  
				</div>
				<div class="col-md-8">
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
	<div class="row">
		<div class="col-md-12">
			<?= $form->field($model, 'categoria_id')->widget(\kartik\widgets\Select2::classname(), [
	            'data' => \yii\helpers\ArrayHelper::map(\app\models\Categorias::find()->orderBy('nombre')->asArray()->all(), 'id', 
	                    function($model, $defaultValue) {
	                        return $model['nombre'];
	                    }
	                ),
	            'options' => ['placeholder' => Yii::t('app', 'Seleccione una empresa'), 'id'=>'cat-id'],
	            'pluginOptions' => [
	                'allowClear' => true
	            ],
	        ]); ?>
	    </div>
	    <div class="col-md-12">

            <?php 
                // $lista_empresas = \yii\helpers\ArrayHelper::map(\app\models\Empresas::find()->orderBy('nombre_comercial')->asArray()->all(), 'id', 
                //         function($model, $defaultValue) {
                //             return $model['ruc'].'-'.$model['nombre_comercial'];
                //         }
                // );
                // echo $form->field($model, 'empresa_id')->dropDownList($lista_empresas, ['id'=>'cat-id']);
                // echo Html::hiddenInput('input-type-1', 'Additional value 1', ['id'=>'input-type-1']);
                // echo Html::hiddenInput('input-type-2', 'Additional value 2', ['id'=>'input-type-2']);

                // echo $form->field($model, 'servicios')->widget(DepDrop::classname(), [
                //     'type'=>DepDrop::TYPE_SELECT2,
                //     'data'=>$array_adicionales,
                //     'options'=>['id'=>'subcat1-id', 'placeholder'=>'Seleccione', 'options'=> $array_filtros],
                //     'select2Options'=>['pluginOptions'=>['multiple' => true,'allowClear'=>true]],
                //     'pluginOptions'=>[
                //         'depends'=>['cat-id'],
                //         'url'=>Url::to(['/ajax/adicionalesempresa']),
                //         'params'=>['input-type-1', 'input-type-2'],
                //     ]
                // ]);
            ?>

	    </div>
	</div>
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
</div>
