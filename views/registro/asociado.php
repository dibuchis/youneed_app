<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Servicios;
use app\models\Planes;
use app\models\TiposDocumentos;
use yii\helpers\Url;
use kartik\widgets\DepDrop;
use dosamigos\fileupload\FileUpload;
use borales\extensions\phoneInput\PhoneInput;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => true,
    'enableAjaxValidation' => true,
    'options'=>['enctype'=>'multipart/form-data'] // important
]); ?>

	<div class="container">
		<?php echo $form->errorSummary( $model, ['class' => 'alert alert-danger'] ); ?>
	    <div class="stepwizard">
	        <div class="stepwizard-row setup-panel">
	            <div class="stepwizard-step col-xs-3"> 
	                <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
	                <p><small>Información personal</small></p>
	            </div>
	            <div class="stepwizard-step col-xs-3"> 
	                <a href="#step-2" type="button" class="btn btn-default btn-circle" >2</a>
	                <p><small>Servicios a brindar</small></p>
	            </div>
	            <div class="stepwizard-step col-xs-3"> 
	                <a href="#step-3" type="button" class="btn btn-default btn-circle" >3</a>
	                <p><small>Documentos</small></p>
	            </div>
	            <div class="stepwizard-step col-xs-3"> 
	                <a href="#step-4" type="button" class="btn btn-default btn-circle" >5</a>
	                <p><small>Información para pagos y planes</small></p>
	            </div>
	        </div>
	    </div>
	    
	    <form role="form">
	        <div class="panel panel-primary setup-content" id="step-1">
	            <div class="panel-heading">
	                 <h3 class="panel-title">Información personal</h3>
	            </div>
	            <div class="panel-body">
	                
	            	<div class="row">
						<div class="col-md-4">
							<?php echo $form->field($model, 'imagen')->textarea(['style' => 'display:none;']); ?>
						    <?php echo Html::img($model->imagen , ['style'=> 'height:200px;', 'id'=>'vista_previa_imagen']); ?>
						    <?= Html::img( Url::to('@web/images/ajax-loader.gif'), ['class'=> 'loader']);?>
						    <?= FileUpload::widget([
						        'model' => $model,
						        'attribute' => 'imagen_upload',
						        'url' => ['ajax/subirfotografia', 'id' => $model->id],
						        'options' => ['accept' => 'image/*'],
						        'clientOptions' => [
						            'maxFileSize' => 2000000,
						            'dataType' => 'json'
						        ],
						        'clientEvents' => [
						            'fileuploaddone' => 'function(e, data) {
						                                    $("#usuarios-imagen").val( data.result[0].base64 );
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
						    <div class="alert alert-info">
						    	Subir una imagen con una foto tamaño carnet, el rostro debe ser visible
						    </div>
						</div>
						<div class="col-md-8">
							<div class="row">
								<div class="col-md-6">

									<div class="row">
										<div class="col-md-6">
											<?= $form->field($model, 'tipo_identificacion')->dropDownList( [1=>'Cédula', 2=>'RUC', 3=>'RISE', 4=>'Pasaporte'], ['prompt' => 'Seleccione']) ?>  
										</div>
										<div class="col-md-6">
											<?= $form->field($model, 'identificacion')->textInput(['maxlength' => true]) ?>
										</div>
									</div>
									
								    <?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>

								    <?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>

								</div>
								<div class="col-md-6">
									<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

								    <?php 
							            echo $form->field($model, 'numero_celular')->widget(PhoneInput::className(), [
							                'jsOptions' => [
							                    // 'preferredCountries' => ['EC'],
							                    'onlyCountries' => ['EC'],
							                    'nationalMode' => false,
							                ]
							            ]);
							        ?>


								    <?= $form->field($model, 'pais_id')->widget(\kartik\widgets\Select2::classname(), [
						                'data' => \yii\helpers\ArrayHelper::map(\app\models\Paises::find()->orderBy('nombre')->asArray()->all(), 'id', 
						                        function($model, $defaultValue) {
						                            return $model['nombre'];
						                        }
						                    ),
						                'options' => ['placeholder' => Yii::t('app', 'Seleccione una empresa'), 'id'=>'cat1-id'],
						                'pluginOptions' => [
						                    'allowClear' => true
						                ],
						            ]); ?>

						            <?php 
						                echo $form->field($model, 'ciudad_id')->widget(DepDrop::classname(), [
						                    'type'=>DepDrop::TYPE_SELECT2,
						                    'data'=>[],
						                    'options'=>['id'=>'subcat11-id', 'placeholder'=>'Seleccione', 'options'=> [] ],
						                    'select2Options'=>['pluginOptions'=>['multiple' => false,'allowClear'=>true]],
						                    'pluginOptions'=>[
						                        'depends'=>['cat1-id'],
						                        'url'=>Url::to(['/ajax/ciudades']),
						                    ]
						                ]);
						            ?>

								 

								</div>	
							</div>
						</div>
					</div>

	                <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
	            </div>
	        </div>
	        
	        <div class="panel panel-primary setup-content" id="step-2">
	            <div class="panel-heading">
	                 <h3 class="panel-title">Servicios a brindar</h3>
	            </div>
	            <div class="panel-body">
	                <div class="col-md-12">

			            <?php 
			                $lista_categorias = \yii\helpers\ArrayHelper::map(\app\models\Categorias::find()->orderBy('nombre')->asArray()->all(), 'id', 
				                    function($model, $defaultValue) {
				                        return $model['nombre'];
				                    }
			                );

			                //echo $form->field($model, 'categorias')->dropDownList($lista_categorias, ['id'=>'cat-id', 'prompt' => 'Seleccione', 'multiple'=>'multiple']);
			                
			                echo $form->field($model, 'categorias')->widget(\kartik\widgets\Select2::classname(), [
				                'data' => $lista_categorias,
				                'options' => ['id'=>'cat-id', 'placeholder' => 'Seleccione categorías'],
				                'pluginOptions' => [
				                    'allowClear' => true, 
				                    'multiple' => true,
				                ],
				            ]);

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

				    </div>
				    
				    	<div class="col-md-6">
				    		<?= $form->field($model, 'dias_trabajo')->dropDownList([ 1 => 'Lunes a Viernes', 2 => 'Fines de semana', 3 => 'Cualquier día' ], ['prompt' => 'Seleccione']) ?>
				    	</div>
				    	<div class="col-md-6">
				    		<?= $form->field($model, 'horarios_trabajo')->dropDownList([ 1 => '7am a 12 am', 2 => '12am a 7pm', 3 => '7pm a 7 am', 4 => '24 horas' ], ['prompt' => 'Seleccione']) ?>
				    	</div>
				    
	                <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
	            </div>
	        </div>
	        
	        <div class="panel panel-primary setup-content" id="step-3">
	            <div class="panel-heading">
	                 <h3 class="panel-title">Documentos</h3>
	            </div>
	            <div class="panel-body">
	                <?php $array_documentos = 	[ 
	                								[ 'atributo_upload' => 'fotografia_cedula_upload', 'atributo_modelo' => 'fotografia_cedula' ],
	                								[ 'atributo_upload' => 'ruc_upload', 'atributo_modelo' => 'ruc' ],
	                								[ 'atributo_upload' => 'visa_trabajo_upload', 'atributo_modelo' => 'visa_trabajo' ],
	                								[ 'atributo_upload' => 'rise_upload', 'atributo_modelo' => 'rise' ],
	                								[ 'atributo_upload' => 'referencias_personales_upload', 'atributo_modelo' => 'referencias_personales' ],
	                								//[ 'atributo_upload' => 'titulo_academico_upload', 'atributo_modelo' => 'titulo_academico' ],
	                							];

	                ?>

	                <?php foreach ($array_documentos as $documento) { ?>

		            	<?php echo $form->field($model, $documento['atributo_modelo'])->textarea(['style' => 'display:none;']); ?>
					    <a style="display: none;" target="_blank" id="vista_<?php echo $documento['atributo_modelo']; ?>" class="btn-primary btn" href="">Ver documento subido</a>
					    <?= Html::img( Url::to('@web/images/ajax-loader.gif'), ['class'=> 'loader loader_'.$documento['atributo_modelo']] );?>
					    <?= FileUpload::widget([
					        'model' => $model,
					        'attribute' => $documento['atributo_upload'],
					        'url' => ['ajax/subirdocumento', 'atributo_upload' => $documento['atributo_upload'], 'atributo_modelo' => $documento['atributo_modelo'] ],
					        'options' => ['accept' => 'image/*,application/pdf'],
					        'clientOptions' => [
					            'maxFileSize' => 2000000,
					            'dataType' => 'json'
					        ],
					        'clientEvents' => [
					            'fileuploaddone' => 'function(e, data) {
					                                    $("#usuarios-'.$documento['atributo_modelo'].'").val( data.result[0]["url"] );
					                                    $("#vista_'.$documento['atributo_modelo'].'").attr("href", data.result[0]["url"]);
					                                    $("#vista_'.$documento['atributo_modelo'].'").show();
					                                    $(".loader_'.$documento['atributo_modelo'].'").hide();
					                                }',
					            'fileuploadfail' => 'function(e, data) {

					                                }',
					            'fileuploadstart' => 'function(e, data) {
					            	$(".loader_'.$documento['atributo_modelo'].'").show();
					                                }',
					        ],
					    ]); ?>
					    <div class="alert alert-info">
					    	Subir una imagen o un archivo PDF no mayor a 2MB
					    </div>
						<hr>

					<?php } ?>

	                <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
	            </div>
	        </div>
	        <div class="panel panel-primary setup-content" id="step-4">
	    		<div class="panel-heading">
	                 <h3 class="panel-title">Información para pagos</h3>
	            </div>
	            <div class="panel-body">
	            	<div class="alert alert-success">
	            		Los datos proporcionados servirán para realizar los pagos por los servicios realizados
	            	</div>
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

		        	<section id="plans">
	        
				            <div class="row">
				            	<?php 
				            		$planes = Planes::find()->all();
				            	?>
				                <!-- item -->
				                <div class="col-md-6 text-center">
				                    <div class="panel panel-success panel-pricing">
				                        <div class="panel-heading">
				                            <i class="fa fa-desktop"></i>
				                            <h3><?php echo $planes[0]->nombre; ?> - $<?php echo $planes[0]->sin_descuento; ?> USD</h3>
				                        </div>
				                        <div class="panel-body text-center">
				                            <p>
				                            	<strong><?php echo $planes[0]->pvp; ?> USD / anual</strong>
				                            	<br>
				                            	<small>(<?php echo $planes[0]->descuento_1; ?> % de descuento)</small>
				                            </p>
				                        </div>
				                        <?php echo $planes[0]->descripcion; ?>
				                        <div class="panel-footer">
				                            <a plan-id="<?php echo $planes[0]->id; ?>" plan-nombre="<?php echo $planes[0]->nombre; ?>" class="btn btn-lg btn-block btn-success seleccion_plan" href="javascript:;">Seleccionar</a>
				                        </div>
				                    </div>
				                </div>
				                <!-- /item -->

				                <!-- item -->
				                <div class="col-md-6 text-center">
				                    <div class="panel panel-success panel-pricing">
				                        <div class="panel-heading">
				                            <i class="fa fa-desktop"></i>
				                            <h3><?php echo $planes[1]->nombre; ?> - $<?php echo $planes[1]->sin_descuento; ?> USD</h3>
				                        </div>
				                        <div class="panel-body text-center">
				                            <p>
				                            	<strong><?php echo $planes[1]->pvp; ?> USD / anual</strong>
				                            	<br>
				                            	<small>(<?php echo $planes[1]->descuento_1; ?> % de descuento)</small>
				                            </p>
				                        </div>
				                        <?php echo $planes[1]->descripcion; ?>
				                        <div class="panel-footer">
				                            <a plan-id="<?php echo $planes[1]->id; ?>" plan-nombre="<?php echo $planes[1]->nombre; ?>" class="btn btn-lg btn-block btn-success seleccion_plan" href="javascript:;">Seleccionar</a>
				                        </div>
				                    </div>
				                </div>
				                <!-- /item -->

				            </div>

				            <div class="alert alert-success plan_seleccionado" style="display: none;">
				            	Plan seleccionado:
				            </div>

				            <?= $form->field($model, 'plan_id')->hiddenInput()->label(false); ?>
				        
				        	<div style="height: 200px!important; overflow-y: scroll;" >
				        		<?php echo $terminos; ?>
				        		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				        		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				        		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				        		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				        		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				        		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				        		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				        		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				        		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				        		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				        		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				        		Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				        	</div>

				        	<?= $form->field($model, 'terminos_condiciones')->checkbox(['checked' => true]); ?>

				    </section>
				     <?= Html::submitButton($model->isNewRecord ? 'Registrarse' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary btn-lg center-block' : 'btn btn-primary']) ?>
				</div>
	        </div>
	    </form>
	</div>
<?php ActiveForm::end(); ?>
