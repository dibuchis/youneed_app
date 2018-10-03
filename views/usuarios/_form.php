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

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#infogeneral">Información general</a></li>
      <?php if( $model->tipo == 'Asociado' ){ ?>
          <li><a data-toggle="tab" href="#infoservicios">Información de servicios</a></li>
          <li><a data-toggle="tab" href="#infopagos">Información para pagos</a></li>
      <?php } ?>
    </ul>

    <div class="tab-content">
      <div id="infogeneral" class="tab-pane fade in active">
        <?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'numero_celular')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'clave')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'estado')->dropDownList(Yii::$app->params['estados_genericos'], ['prompt' => 'Seleccione']) ?>
      
        <pre>
        <?php print_r( $model ); ?>
        </pre>

        <?php if( $model->tipo == 'Asociado' ){ ?>
            <?= $form->field($model, 'estado_validacion_documentos')->dropDownList(Yii::$app->params['estados_genericos'], ['prompt' => 'Seleccione']) ?>
        <?php } ?>

      </div>

      <div id="infoservicios" class="tab-pane fade">
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

        <?= $form->field($model, 'causas_desactivacion')->widget(\yii\redactor\widgets\Redactor::className()) ?>

        <?= $form->field($model, 'plan_id')->widget(\kartik\widgets\Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(\app\models\Planes::find()->orderBy('nombre')->asArray()->all(), 'id', function($model, $defaultValue) {
                        return $model['nombre'];
                    }
                ),
            'options' => ['placeholder' => Yii::t('app', 'Seleccione')],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

        <?= $form->field($model, 'dias_trabajo')->dropDownList([1=>'Lunes a viernes', 2=>'Fines de semana', 3=>'Cualquier día'], ['prompt' => 'Seleccione']) ?>

        <?= $form->field($model, 'horarios_trabajo')->dropDownList([1=>'7am a 12am', 2=>'12am a 7pm', 3=>'7pm a 7am', 4=>'24 horas'], ['prompt' => 'Seleccione']) ?>


      </div>

      <div id="infopagos" class="tab-pane fade">
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

        <?= $form->field($model, 'observaciones')->widget(\yii\redactor\widgets\Redactor::className()) ?>
        
        
      </div>

      <div id="infodocumentos" class="tab-pane fade">
        <h3>Menu 2</h3>
        <p>Some content in menu 2.</p>
      </div>
    </div>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
