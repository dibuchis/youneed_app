<div style="padding: 5px; color: #FFF;">
<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\ReporteHistorico;
use kartik\daterange\DateRangePicker;
use yii\helpers\Url;
use \yii\web\Response;

$request = Yii::$app->request;

$model = new ReporteHistorico();

$model->load($request->get());

$form = ActiveForm::begin([
  'id' => 'login-form',
  'method' => 'get',
  'validationUrl' => Url::to(),
  // 'layout' => 'horizontal',
  'fieldConfig' => [
      'template' => "{label}\n{input}\n{error}",
      // 'labelOptions' => ['class' => 'col-lg-1 control-label'],
  ],
]); ?>

	<div class="row">
		<h1>Reporte histórico</h1>
		<div class="col-md-12">
			<?= $form->field($model, 'deviceid')->widget(\kartik\widgets\Select2::classname(), [
			    'data' => \yii\helpers\ArrayHelper::map(\app\models\Dispositivos::find()->orderBy('nombre')->asArray()->all(), 'id', 'nombre'
			        ),
			    'options' => ['placeholder' => Yii::t('app', 'Seleccione Dispositivo')],
			    'pluginOptions' => [
			        'allowClear' => true
			    ],
			]); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<?php 
				echo '<label class="control-label">Rango de fechas</label>';
				// echo \kartik\widgets\DatePicker::widget([
				//     'model' => $model,
				//     'attribute' => 'fecha_desde',
				//     'attribute2' => 'fecha_hasta',
				//     'options' => ['placeholder' => 'Desde'],
				//     'options2' => ['placeholder' => 'Hasta'],
				//     'type' => \kartik\widgets\DatePicker::TYPE_RANGE,
				//     'form' => $form,
				//     'pluginOptions' => [
				//         'format' => 'yyyy-mm-dd',
				//         'autoclose' => true,
				//     ]
				// ]);

				echo DateRangePicker::widget([
					'model' => $model,
				    'attribute'=>'rango_fechas',
				    // 'value'=>'2015-10-19 12:00 AM - 2015-11-03 01:00 PM',
				    'convertFormat'=>true,
				    'pluginOptions'=>[
				        'timePicker'=>true,
				        'timePickerIncrement'=>15,
				        'locale'=>['format'=>'Y-m-d H:i']
				    ]            
				]);
			?>
		</div>
	</div>
	

  <?= Html::submitButton('Buscar', ['class' => 'btn btn-success btn-block btn-lg', 'name' => 'buscar-button', 'style'=>'margin-top:20px;']) ?>
<?php ActiveForm::end(); ?>
</div>