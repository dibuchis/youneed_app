<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Servicios;
use app\models\CategoriasServicios;
use app\models\UsuariosCategorias;
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
          <li><a data-toggle="tab" href="#infodocumentos">Documentos</a></li>
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
            $categorias = UsuariosCategorias::find()->andwhere( [ 'usuario_id'=>$model->id ] )->all();
            $servicios = UsuariosServicios::find()->andwhere( [ 'usuario_id'=>$model->id ] )->all();
        ?>

        <label>Categorias (varios)</label><br>
        <span>
            <?php foreach ($categorias as $categoria) {
                echo $categoria->categoria->nombre.', ';
            } ?>
        </span>
        <p>&nbsp;</p>
        <label>Servicios (varios)</label><br>
        <span>
            <?php foreach ($servicios as $servicio) {
                echo $servicio->servicio->nombre.', ';
            } ?>
        </span>
        <p>&nbsp;</p>

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
        
        <?php if( !empty($model->fotografia_cedula) ){ ?>
            <?= $form->field($model, 'fotografia_cedula')->hiddenInput(); ?>
            <a target="_blank" class="btn-primary btn" href="<?php echo $model->fotografia_cedula ?>">Ver documento subido</a>
            <hr>
        <?php } ?>

        <?php if( !empty($model->ruc) ){ ?>
            <?= $form->field($model, 'ruc')->hiddenInput(); ?>
            <a target="_blank" class="btn-primary btn" href="<?php echo $model->ruc ?>">Ver documento subido</a>
            <hr>
        <?php } ?>

        <?php if( !empty($model->visa_trabajo) ){ ?>
            <?= $form->field($model, 'visa_trabajo')->hiddenInput(); ?>
            <a target="_blank" class="btn-primary btn" href="<?php echo $model->visa_trabajo ?>">Ver documento subido</a>
            <hr>
        <?php } ?>

        <?php if( !empty($model->rise) ){ ?>
            <?= $form->field($model, 'rise')->hiddenInput(); ?>
            <a target="_blank" class="btn-primary btn" href="<?php echo $model->rise ?>">Ver documento subido</a>
            <hr>
        <?php } ?>

        <?php if( !empty($model->referencias_personales) ){ ?>
            <?= $form->field($model, 'referencias_personales')->hiddenInput(); ?>
            <a target="_blank" class="btn-primary btn" href="<?php echo $model->referencias_personales ?>">Ver documento subido</a>
            <hr>
        <?php } ?>

        <?php if( !empty($model->titulo_academico) ){ ?>
            <?= $form->field($model, 'titulo_academico')->hiddenInput(); ?>
            <a target="_blank" class="btn-primary btn" href="<?php echo $model->titulo_academico ?>">Ver documento subido</a>
            <hr>
        <?php } ?>



      </div>
    </div>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
