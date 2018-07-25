<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\DispositivosConductores;

/* @var $this yii\web\View */
/* @var $model app\models\Conductores */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="conductores-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'identificacion')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?php 
                $array_filtros = array();
                if ($model->id > 0) {
                    $productos = DispositivosConductores::find()->where(' conductor_id = '.$model->id)->all();
                    foreach ($productos as $p) {
                        $array_filtros[ $p->dispositivo_id ] = [ 'selected' => true ];
                    }
                }
            ?>
            <?= $form->field($model, 'dispositivos')->widget(\kartik\widgets\Select2::classname(), [
                'data' => \yii\helpers\ArrayHelper::map(\app\models\Dispositivos::find()->orderBy('id')->asArray()->andWhere(['tipo_dispositivo'=>0])->all(), 'id', 'nombre'),
                'options' => ['placeholder' => 'Seleccione dispositivos', 'options'=> $array_filtros],
                'pluginOptions' => [
                    'allowClear' => true, 
                    'multiple' => true,
                ],
            ]); ?>

            <?= $form->field($model, 'telefonos')->textarea(['rows' => 1]) ?>
            <?= $form->field($model, 'observaciones')->textarea(['rows' => 3]) ?>        
        </div>
    </div>

  
	<?php if (!Yii::$app->request->isAjax){ ?>
	  	<div class="form-group">
	        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
	    </div>
	<?php } ?>

    <?php ActiveForm::end(); ?>
    
</div>
