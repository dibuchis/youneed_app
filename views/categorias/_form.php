<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\fileupload\FileUpload;
use yii\helpers\Url;
use kartik\markdown\MarkdownEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Categorias */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categorias-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-5">
            <?php echo $form->field($model, 'imagen')->textarea(['style' => 'display:none;']); ?>
            <?php echo Html::img($model->imagen , ['style'=> 'height:200px;', 'id'=>'vista_previa_imagen']); ?>
            <?= Html::img( Url::to('@web/images/ajax-loader.gif'), ['class'=> 'loader']);?>
            <?= FileUpload::widget([
                'model' => $model,
                'attribute' => 'imagen_upload',
                'url' => ['ajax/subirimagencategorias', 'id' => $model->id],
                'options' => ['accept' => 'image/*'],
                'clientOptions' => [
                    'maxFileSize' => 2000000,
                    'dataType' => 'json'
                ],
                'clientEvents' => [
                    'fileuploaddone' => 'function(e, data) {
                                            $("#categorias-imagen").val( data.result[0].base64 );
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
        <div class="col-md-7">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?> 
            <?= $form->field($model, 'descripcion')->widget(\yii\redactor\widgets\Redactor::className()) ?>

            <div class="row">
                <h1>Visita diagnostico</h1>
                <div class="col-md-3">
                    <?= $form->field($model, 'aplica_iva')->dropDownList( Yii::$app->params['parametros_globales']['estados_condiciones'], []) ?>    
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'subtotal')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                                    'alias' =>  'decimal',
                                    'groupSeparator' => '',
                                    'digits' => 2, 
                                    'autoGroup' => true
                                ],
                        ])->textInput(['value' => $model->subtotal]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'iva')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                                    'alias' =>  'decimal',
                                    'groupSeparator' => '',
                                    'digits' => 2, 
                                    'autoGroup' => true
                                ],
                        ])->textInput(['value' => $model->iva, 'readonly'=>'readonly']) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'total')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                                    'alias' =>  'decimal',
                                    'groupSeparator' => '',
                                    'digits' => 2, 
                                    'autoGroup' => true
                                ],
                        ])->textInput(['value' => $model->total]) ?>
                </div>

            </div>

        </div>
    </div>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
