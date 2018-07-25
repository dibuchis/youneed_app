<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Turnos */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Turnos';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="turnos-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            
            <?= $form->field($model, 'dispositivo_id')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\Dispositivos::find()->orderBy('alias')->asArray()->all(), 'id', function($model, $defaultValue) {
                            return $model['alias'].' - '.$model['placa'];
                        }
                    ),
                'options' => ['placeholder' => Yii::t('app', 'Seleccione dispositivo')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>

            <?= $form->field($model, 'conductor_id')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\Conductores::find()->orderBy('nombres')->asArray()->all(), 'id', function($model, $defaultValue) {
                            return $model['identificacion'].' - '.$model['nombres'].' '.$model['apellidos'];
                        }
                    ),
                'options' => ['placeholder' => Yii::t('app', 'Seleccione dispositivo')],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]); ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'fecha_inicio')->widget(\kartik\widgets\DateTimePicker::classname(),[
                'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd hh:ii'
                    ]
            ]); ?>

            <?= $form->field($model, 'fecha_final')->widget(\kartik\widgets\DateTimePicker::classname(),[
                'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd hh:ii'
                    ]
            ]); ?>

        </div>
    </div>
    <?= $form->field($model, 'observaciones')->textarea(['rows' => 6]) ?>
    

   

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
    <?php if( !$model->isNewRecord ){ 
        echo Html::beginForm(['/turnos/delete/?id='.$model->id], 'post');
        echo Html::submitButton('Eliminar turno',['class' => 'btn btn-danger']);
        echo Html::endForm();
    } ?>

</div>
