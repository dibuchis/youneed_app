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
<span id="test"></span>
<?php $form = ActiveForm::begin([
    'enableClientValidation' => true,
    'enableAjaxValidation' => true,
    'options'=>['enctype'=>'multipart/form-data'] // important
]); ?>

	<!-- <script>
	Swal.fire({
        type:"info",
        text:"Antes de continuar asegúrate de disponer en tu teléfono o PC una imagen actualizada de tu perfil o logo si es una empresa, imagen de tu Cédula o RUC o RISE o Pasaporte con permiso de Trabajo, dependiendo del tipo de documento que necesites ingresar"
    });
	</script> -->

	<div class="container" id="form-registro-asociado">
		<div class="stepwizard">
	        <div class="stepwizard-row setup-panel">
	            <div class="stepwizard-step col-xs-3"> 
	                <a href="#step-1" id="btn-step-1" type="button" data-step="1" class="btn btn-success btn-circle btn-step">1</a>
	                <p><small>Información personal</small></p>
	            </div>
	            <div class="stepwizard-step col-xs-3"> 
	                <a href="#step-2" id="btn-step-2" type="button" data-step="2" class="btn btn-default btn-circle btn-step" >2</a>
	                <p><small>Servicios</small></p>
	            </div>
	            <div class="stepwizard-step col-xs-3"> 
	                <a href="#step-3" id="btn-step-3" type="button" data-step="3" class="btn btn-default btn-circle btn-step" >3</a>
	                <p><small>Información para pagos</small></p>
	            </div>
	            <div class="stepwizard-step col-xs-3"> 
	                <a href="#step-4" id="btn-step-4" type="button" data-step="4" class="btn btn-default btn-circle btn-step" >4</a>
	                <p><small>Planes</small></p>
	            </div>
	        </div>
	    </div>
	    
	    <form role="form">
	        <div class="panel panel-primary setup-content panel-default" id="step-1">
	            <div class="panel-heading">
	                 <h3 class="panel-title">Queremos conocerte mejor</h3>
	            </div>
	            <div class="panel-body">
	                
	            	<div class="row">
						<div class="col-md-10 col-md-offset-2">
							<h4>Datos Personales:</h4>
						</div>
						<div class="col-md-3 col-md-offset-2 foto-container">
							<?php echo $form->field($model, 'imagen')->textarea(['style' => 'display:none;']); ?>
						    <?php echo Html::img($model->imagen , ['style'=> 'height:200px;', 'id'=>'vista_previa_imagen']); ?>
							<label for="usuarios-imagen_upload" id="img-upload-plus"><i class="glyphicon glyphicon-plus"></i></label>
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
						    <div class="alert alert-info" style="max-width: 200px;">
						    	Subir una imagen con una foto tamaño carnet, el rostro debe ser visible.
						    </div>
						</div>
						<div class="col-md-5 col-md-pushed-2">
							<div class="row mt-2">
								<div class="col-md-6">
									<?= $form->field($model, 'nombres')->textInput(['maxlength' => true]) ?>
								</div>
								<div class="col-md-6">
									<?= $form->field($model, 'apellidos')->textInput(['maxlength' => true]) ?>
								</div>
								<div class="col-md-12"></div>

								<div class="col-md-6">
									<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
								</div>
								
								<div class="col-md-6">
								    <?php 
							            echo $form->field($model, 'numero_celular')->widget(PhoneInput::className(), [
											'jsOptions' => [
												// 'preferredCountries' => ['EC'],
							                    'onlyCountries' => ['EC'],
							                    'nationalMode' => false,
												]
												]);
												?>
								</div>
								<div class="col-md-12"></div>

								<div class="col-md-6">
									<?= $form->field($model, 'clave')->passwordInput() ?>
								</div>
								<div class="col-md-6">
								<div class="form-group field-usuarios-clave required has-success">
								<label class="control-label" >Confirmar Clave</label>
									<input type="password" id="confirmar_clave" class="form-control" required>
								<div class="help-block"></div>
								</div>
								</div>
								<div class="col-md-12"></div>

								<div class="col-md-6">
								    <?= $form->field($model, 'pais_id')->widget(\kartik\widgets\Select2::classname(), [
										'data' => \yii\helpers\ArrayHelper::map(\app\models\Paises::find()->orderBy('nombre')->asArray()->all(), 'id', 
										function($model, $defaultValue) {
											return $model['nombre'];
						                        }
						                    ),
						                'options' => ['placeholder' => Yii::t('app', 'Seleccione un país'), 'id'=>'cat1-id'],
						                'pluginOptions' => [
											'allowClear' => true
						                ],
						            ]); ?>
								</div>

								<div class="col-md-6">
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
					<hr/>
					<div class="row">
						<div class="col-md-10 col-md-offset-2">
							<h4>Documentos:</h4>
						</div>
							
						<div class="col-md-2 col-md-offset-2">
							<?= $form->field($model, 'tipo_identificacion')->dropDownList( [1=>'Cédula', 2=>'RUC', 3=>'RISE', 4=>'Pasaporte'], ['prompt' => 'Seleccione']) ?>  
						</div>
						<div class="col-md-3 col-md-pushed-5">
							<?= $form->field($model, 'identificacion')->textInput(['maxlength' => true]) ?>
						</div>
						<!-- DOCUMENTOS -->
						<div class="col-md-8 col-md-offset-2">
								<!-- <hr> -->
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
								<div class="document-input-asociado <?php echo ($documento["atributo_upload"] == "fotografia_cedula_upload" ? "" : "hidden"); ?>" id="<?php echo "form_" . $documento['atributo_upload']; ?>">
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
								<hr>	
								</div>
		
							<?php } ?>
							<div class="alert alert-info">
								El tamaño los archivos no debe ser mayor a 2MB
							</div>
						</div>
						<!-- FIN DOCUMENTOS -->
					</div>

					<div class="row">
						<div class="col-md-8 col-md-offset-2 col-md-pushed-2">
							<button class="btn btn-primary nextBtn pull-right ml-15" type="button">Siguiente</button>
							<button class="btn btn-warning saveBtn pull-right ml-15" onclick="saveForm()" type="button">Guardar</button>
						</div>
					</div>
	            </div>
	        </div>
	        
	        <div class="panel panel-primary setup-content" id="step-2">
	            <div class="panel-heading">
	                 <h3 class="panel-title">¿Qué servicios quieres brindar?</h3>
	            </div>
	            <div class="panel-body">
					<div class="col-md-10 col-md-offset-1 col-md-pushed-1">
						<div class="alert alert-success help-panel">
							Selecciona una o más categorías de acuerdo a tu experiencia y conocimientos” “Recuerda que algunos servicios requieren presentar certificados que validen tu experiencia y conocimientos.
						</div>
					</div>
					<div class="col-md-10 col-md-offset-1 col-md-pushed-1">
						<h4>Escoger Categoría:</h4>
					</div>
	                <div class="col-md-10 col-md-offset-1 col-md-pushed-1 loader-wrapper">
			            <?php 
			                $lista_categorias = \yii\helpers\ArrayHelper::map(\app\models\Categorias::find()->orderBy('nombre')->asArray()->all(), 'id', 
				                    function($model, $defaultValue) {
				                        return $model;
				                    }
							);

							echo '<div class="owl-carousel owl-carousel-cat owl-theme" id="owl-categorias">';
								foreach($lista_categorias as $val){
									// echo $val["id"] . " | " . $val["nombre"] . "<br>";
									echo "<div class='cat-item' data-id='" . $val["id"]. "'><img src='" . $val["imagen"] . "'><span>" . $val["nombre"] . "</span></div>";
								}	
							echo '</div>';


							// var_dump($lista_categorias);
							// echo "</pre>";


			                echo Html::hiddenInput('input-type-1', 'Additional value 1', ['id'=>'input-type-1']);
			                echo Html::hiddenInput('input-type-2', 'Additional value 2', ['id'=>'input-type-2']);
							
							$lista_servicios = \yii\helpers\ArrayHelper::map(\app\models\Servicios::find()->orderBy('nombre')->asArray()->all(), 'id', 
							function($model, $defaultValue) {
										return $model;
									}
							);

							// echo "<pre>";
							// var_dump($lista_servicios);
							// echo "</pre>";
							?>
							</div>

								<div class="col-md-10 col-md-offset-1 col-md-pushed-1" id="seccion-servicios">
									<hr>
									<h4>Escoger Servicio:</h4>
								</div>
							<div class="col-md-10 col-md-offset-1 col-md-pushed-1 loader-wrapper" >
							<?php

							echo '<div id="servicios-wrapper">';
								echo '<div class="owl-carousel owl-carousel-serv owl-theme" id="owl-servicios">';
									// }foreach($lista_servicios as $val){
										// echo $val["id"] . " | " . $val["nombre"] . "<br>";
										// echo "<div class='serv-item' data-id='" . $val["id"]. "'><img src='" . $val["imagen"] . "'><span>" . $val["nombre"] . "</span></div>";
									// }	
								echo '</div>';
							echo '</div>';
							
							echo '<hr>';
							echo '<h4>Servicios Agregados:</h4>';
							
							echo "<div class='servicios-agregados' id='servicios-agregados'> </div>";
							echo '<hr>';
							// $items_categorias = \yii\helpers\ArrayHelper::map(\app\models\Categorias::find()->orderBy('nombre')->asArray()->all(), 'id', 
							// 		function($model, $defaultValue) {
							// 			return $model["nombre"];
							// 		}
							// );

							// $items_servicios = \yii\helpers\ArrayHelper::map(\app\models\Servicios::find()->orderBy('nombre')->asArray()->all(), 'id', 
							// 		function($model, $defaultValue) {
							// 			return $model["nombre"];
							// 		}
							// );

							// echo $form->field($model, 'categorias')->dropDownList($items_categorias, ['id'=>'cat-id', 'prompt' => 'Seleccione', 'multiple'=>'multiple']);
							// echo $form->field($model, 'servicios')->dropDownList($items_servicios, ['id'=>'subcat-id', 'prompt' => 'Seleccione', 'multiple'=>'multiple']);
							
							echo $form->field($model, 'categorias')->hiddenInput(['maxlength' => true])->label(false);;
							echo $form->field($model, 'servicios')->hiddenInput(['maxlength' => true])->label(false);;
							
			                // echo $form->field($model, 'categorias')->widget(\kartik\widgets\Select2::classname(), [
				            //     'data' => $lista_categorias2,
				            //     'options' => ['id'=>'cat-id', 'placeholder' => 'Seleccione categorías'],
				            //     'pluginOptions' => [
				            //         'allowClear' => true, 
				            //         'multiple' => true,
				            //     ],
				            // ]);

			                // echo $form->field($model, 'servicios')->widget(DepDrop::classname(), [
			                //     'type'=>DepDrop::TYPE_SELECT2,
			                //     'data'=>[],
			                //     'options'=>['id'=>'subcat1-id', 'placeholder'=>'Seleccione', 'options'=> []],
			                //     'select2Options'=>['pluginOptions'=>['multiple' => true,'allowClear'=>true]],
			                //     'pluginOptions'=>[
			                //         'depends'=>['cat-id'],
			                //         'url'=>Url::to(['/ajax/listadoservicios']),
			                //         'params'=>['input-type-1', 'input-type-2'],
			                //     ]
			                // ]);
			            ?>

				    </div>
					<div class="row">		
						<div class="col-md-10 col-md-offset-1 col-md-pushed-1">		
							<div class="col-md-6">
								<?= $form->field($model, 'dias_trabajo')->dropDownList([ 1 => 'Lunes a Viernes', 2 => 'Fines de semana', 3 => 'Cualquier día' ], ['prompt' => 'Seleccione']) ?>
							</div>
							<div class="col-md-6">
								<?= $form->field($model, 'horarios_trabajo')->dropDownList([ 1 => '7am a 12 am', 2 => '12am a 7pm', 3 => '7pm a 7 am', 4 => '24 horas' ], ['prompt' => 'Seleccione']) ?>
							</div>
						
							<button class="btn btn-primary nextBtn pull-right ml-15" type="button">Siguiente</button>
							<button class="btn btn-primary backBtn pull-right ml-15" type="button">Anterior</button> 
							<button class="btn btn-warning saveBtn pull-right ml-15" onclick="saveForm()" type="button">Guardar</button>
						</div>
	            	</div>
	            </div>
	        </div>
	        
	        <div class="panel panel-primary setup-content" id="step-3">
	            <div class="panel-heading">
	                 <h3 class="panel-title">¿Dónde recibirás tu pago?</h3>
	            </div>
	            <div class="panel-body">
					<div class="row">		
						<div class="col-md-8 col-md-offset-2 col-md-pushed-2">
							<div class="alert alert-success help-panel">
								<!-- Los datos proporcionados servirán para realizar los pagos por sus servicios realizados -->
								Registra los datos de tu cuenta bancaria, donde se te depositará los valores que corresponden a la ejecución de tus servicios. Rápido y seguro.
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
						</div>
					</div>
					<div class="row">		
						<div class="col-md-8 col-md-offset-2 col-md-pushed-2">
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
				    	</div>
				    </div>
					<div class="row">		
						<div class="col-md-8 col-md-offset-2 col-md-pushed-2">
						<button class="btn btn-primary nextBtn pull-right ml-15" type="button">Siguiente</button>
						<button class="btn btn-primary backBtn pull-right ml-15" type="button">Anterior</button> 
						<button class="btn btn-warning saveBtn pull-right ml-15" onclick="saveForm()" type="button">Guardar</button>
						</div>
				    </div>
	            </div>
	        </div>
	        <div class="panel panel-primary setup-content" id="step-4">
	    		<div class="panel-heading">
	                 <h3 class="panel-title">Escoge tu plan GRATIS para empezar a dar tus servicios</h3>
	            </div>
	            <div class="panel-body">
	            	

		        	<section id="plans">
	        
				            <div class="row">
				            	<?php 
				            		$planes = Planes::find()->all();
				            	?>
				                <!-- item -->
				                <div class="col-md-4 col-md-offset-2 text-center">
				                    <div class="panel panel-success panel-pricing" id="free-plan-panel">
				                        <div class="panel-heading-plan">
				                            <i class="fa fa-desktop"></i>
				                            <h3><span class="plan-name"><?php echo $planes[0]->nombre; ?></span><br/> $<?php echo $planes[0]->pvp; ?> USD</h3>
				                        </div>
				                        <div class="panel-body text-center real-price-panel">
				                            <p>
				                            	<strong>Precio sin descuento: <span class="real-price"><?php echo $planes[0]->sin_descuento; ?> USD </span> / anual</strong>
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
				                <div class="col-md-4 col-md-pushed-2 text-center">
				                    <div class="panel panel-success panel-pricing" id="normal-plan-panel">
				                        <div class="panel-heading-plan">
				                            <i class="fa fa-desktop"></i>
				                            <h3><span class="plan-name"><?php echo $planes[1]->nombre; ?></span><br/> $<?php echo $planes[1]->pvp; ?> / ANUAL </h3>
				                        </div>
				                        <div class="panel-body text-center real-price-panel">
				                            <p>
				                            	<strong>Precio sin descuento: <span class="real-price"><?php echo $planes[1]->sin_descuento; ?> USD </span> / anual</strong>
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
							<div class="col-md-8 col-md-offset-2 col-md-pushed-2">
								<div class="alert alert-success plan_seleccionado" style="display: none;">
									Plan seleccionado:
								</div>

				            <?= $form->field($model, 'plan_id')->hiddenInput()->label(false); ?>
				        
							<p>Antes de registrarse lea los <a href="terminos-y-condiciones" target="_blank">Términos y condiciones</a> para aceptar su plan.</p>
				        	<!-- <div style="height: 200px!important; overflow-y: scroll;" > -->
								<!-- <?php //echo $terminos; ?> -->
				        		<!-- </div> -->

				        	<?= $form->field($model, 'terminos_condiciones')->checkbox(['checked' => true]); ?>

				            </div>
					</section>
					
					<div class="col-md-8 col-md-offset-2 col-md-pushed-2">
				     <?= Html::submitButton($model->isNewRecord ? 'Registrarse' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-primary btn-lg center-block' : 'btn btn-primary']) ?>
					 <?php echo $form->errorSummary( $model, ['class' => 'registro-error-sumary clearfix alert alert-danger'] ); ?>
					</div>
				</div>
	        </div>
	    </form>
	</div>
<?php ActiveForm::end(); ?>
