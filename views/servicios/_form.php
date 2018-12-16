<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\CategoriasServicios;
use dosamigos\fileupload\FileUpload;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Servicios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="servicios-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-4">
            <?php //echo $form->field($model, 'imagen')->textarea(['style' => 'display:none;']); ?>
            <?php //echo Html::img($model->imagen , ['style'=> 'height:200px;', 'id'=>'vista_previa_imagen']); ?>
            <?php //echo  Html::img( Url::to('@web/images/ajax-loader.gif'), ['class'=> 'loader']);?>
            <?php 
            // echo  FileUpload::widget([
            //     'model' => $model,
            //     'attribute' => 'imagen_upload',
            //     'url' => ['ajax/subirimagenservicios', 'id' => $model->id],
            //     'options' => ['accept' => 'image/*'],
            //     'clientOptions' => [
            //         'maxFileSize' => 2000000,
            //         'dataType' => 'json'
            //     ],
            //     'clientEvents' => [
            //         'fileuploaddone' => 'function(e, data) {
            //                                 $("#servicios-imagen").val( data.result[0].base64 );
            //                                 $("#vista_previa_imagen").attr("src", data.result[0].base64);
            //                                 $(".loader").hide();
            //                             }',
            //         'fileuploadfail' => 'function(e, data) {

            //                             }',
            //         'fileuploadstart' => 'function(e, data) {
            //             $(".loader").show();
            //                             }',
            //     ],
            // ]); 
            ?>

        <div class="row">
            <div class="col-md-6">
                <h1>Asociado</h1>
                
                <?= $form->field($model, 'proveedor_aplica_iva')->dropDownList( Yii::$app->params['parametros_globales']['estados_condiciones'], []) ?>
                <?= $form->field($model, 'proveedor_subtotal')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                                    'alias' =>  'decimal',
                                    'groupSeparator' => '',
                                    'digits' => 2, 
                                    'autoGroup' => true
                                ],
                        ])->textInput(['value' => $model->proveedor_subtotal]) ?>
                <?= $form->field($model, 'proveedor_iva')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                                    'alias' =>  'decimal',
                                    'groupSeparator' => '',
                                    'digits' => 2, 
                                    'autoGroup' => true
                                ],
                        ])->textInput(['value' => $model->proveedor_iva, 'readonly'=>'readonly']) ?>
                <?= $form->field($model, 'proveedor_total')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                                    'alias' =>  'decimal',
                                    'groupSeparator' => '',
                                    'digits' => 2, 
                                    'autoGroup' => true
                                ],
                        ])->textInput(['value' => $model->proveedor_total]) ?>

            </div>
            <div class="col-md-6">
                <h1>PVP</h1>
                <?= $form->field($model, 'aplica_iva')->dropDownList( Yii::$app->params['parametros_globales']['estados_condiciones'], []) ?>
                <?= $form->field($model, 'subtotal')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                                    'alias' =>  'decimal',
                                    'groupSeparator' => '',
                                    'digits' => 2, 
                                    'autoGroup' => true
                                ],
                        ])->textInput(['value' => $model->subtotal]) ?>
                <?= $form->field($model, 'iva')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                                    'alias' =>  'decimal',
                                    'groupSeparator' => '',
                                    'digits' => 2, 
                                    'autoGroup' => true
                                ],
                        ])->textInput(['value' => $model->iva, 'readonly'=>'readonly']) ?>
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
 
        

        <?= $form->field( $model, 'obligatorio_certificado' )->checkbox(); ?>
        <?= $form->field( $model, 'mostrar_app' )->checkbox(); ?>

        </div>
        <div class="col-md-8">
            
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

            <?php 
                $array_filtros = array();
                if ($model->id > 0) {
                    $categorias = CategoriasServicios::find()->where(' servicio_id = '.$model->id)->all();
                    foreach ($categorias as $p) {
                        $array_filtros[ $p->categoria_id ] = [ 'selected' => true ];
                    }
                }
            ?>
            <?= $form->field($model, 'categorias')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\Categorias::find()->orderBy('nombre')->asArray()->all(), 'id', 
                        function($model, $defaultValue) {
                            return $model['nombre'];
                        }
                    ),
                'options' => ['placeholder' => 'Seleccione categorías', 'options'=> $array_filtros],
                'pluginOptions' => [
                    'allowClear' => true, 
                    'multiple' => true,
                ],
            ]); ?>

            
            <?= $form->field($model, 'incluye')->widget(\yii\redactor\widgets\Redactor::className()) ?>
            <?= $form->field($model, 'no_incluye')->widget(\yii\redactor\widgets\Redactor::className()) ?>
            
        </div>
    </div>
  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
