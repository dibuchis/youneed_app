<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\fileupload\FileUpload;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Alianzas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alianzas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'imagen')->textarea(['style' => 'display:none;']); ?>
    <?php echo Html::img($model->imagen , ['style'=> 'height:200px;', 'id'=>'vista_previa_imagen']); ?>
    <?= Html::img( Url::to('@web/images/ajax-loader.gif'), ['class'=> 'loader']);?>
    <?= FileUpload::widget([
        'model' => $model,
        'attribute' => 'imagen_upload',
        'url' => ['ajax/subirimagenalianza', 'id' => $model->id],
        'options' => ['accept' => 'image/*'],
        'clientOptions' => [
            'maxFileSize' => 2000000,
            'dataType' => 'json'
        ],
        'clientEvents' => [
            'fileuploaddone' => 'function(e, data) {
                                    $("#alianzas-imagen").val( data.result[0].base64 );
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

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
