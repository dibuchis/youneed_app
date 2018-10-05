<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Servicios;
use app\models\CategoriasServicios;
use app\models\UsuariosServicios;
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
      <?php if( $model->es_asociado == 1 ){ ?>
          <li><a data-toggle="tab" href="#infoservicios">Información de servicios</a></li>
          <li><a data-toggle="tab" href="#infopagos">Información para pagos</a></li>
      <?php } ?>
    </ul>

    <div class="tab-content">
      <div id="infogeneral" class="tab-pane fade in active">

        <?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'telefono_domicilio')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'numero_celular')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'canton_id')->widget(\kartik\widgets\Select2::classname(), [
            'data' => \yii\helpers\ArrayHelper::map(\app\models\Cantones::find()->orderBy('nombre')->asArray()->all(), 'id', function($model, $defaultValue) {
                        return $model['nombre'];
                    }
                ),
            'options' => ['placeholder' => Yii::t('app', 'Seleccione')],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

        <?= $form->field($model, 'clave')->passwordInput(['maxlength' => true]) ?>


        <?= $form->field($model, 'estado')->dropDownList(Yii::$app->params['estados_genericos'], ['prompt' => 'Seleccione']) ?>

        <?= $form->field($model, 'causas_desactivacion')->textInput(['maxlength' => true]) ?>
      
        <div class="row">
            <div class="col-md-4">
                <?= $form->field($model, 'fecha_creacion')->textInput(['maxlength' => true, 'readonly'=>'readonly']) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'fecha_activacion')->textInput(['maxlength' => true, 'readonly'=>'readonly']) ?>
            </div>
            <div class="col-md-4">
                <?= $form->field($model, 'fecha_desactivacion')->textInput(['maxlength' => true, 'readonly'=>'readonly']) ?>
            </div>
        </div>

        <?php if( $model->es_asociado == 1 ){ ?>
            <?= $form->field($model, 'estado_validacion_documentos')->dropDownList(Yii::$app->params['parametros_globales']['estados_condiciones'], ['prompt' => 'Seleccione']) ?>
        <?php } ?>

      </div>

      <div id="infoservicios" class="tab-pane fade">

        <?php 
            $data_adicionales = CategoriasServicios::find()->andWhere( ['categoria_id'=>$model->categoria_id] )->all();
            $array_adicionales = [];
            foreach ($data_adicionales as $adis) {
                $array_adicionales [$adis->servicio_id] = $adis->servicio->nombre;
            }
            $array_filtros = array();
            if ($model->id > 0) {
                $productos = UsuariosServicios::find()->where(' usuario_id = '.$model->id)->all();
                foreach ($productos as $p) {
                    $array_filtros[ $p->servicio_id ] = [ 'selected' => true ];
                }
            }
        ?>

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
                'data'=>$array_adicionales,
                'options'=>['id'=>'subcat1-id', 'placeholder'=>'Seleccione', 'options'=>$array_filtros],
                'select2Options'=>['pluginOptions'=>['multiple' => true,'allowClear'=>true]],
                'pluginOptions'=>[
                    'depends'=>['cat-id'],
                    'url'=>Url::to(['/ajax/listadoservicios']),
                    'params'=>['input-type-1', 'input-type-2'],
                ]
            ]);
        ?>

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
