<?php 
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Usuarios;
?>
<div class="dispositivo-panel" id="dispositivo-<?php echo $model->traccar_id; ?>" traccar_id="<?php echo $model->traccar_id; ?>">
	<div class="dispositivo-nombre">
		<?php 
			echo $model->nombres.' '.$model->apellidos;
		?>	
	</div>
	<div class="dispositivo-info-content">
		<div class="dispositivo-alias"><?php echo $model->identificacion; ?></div>
		<div class="dispositivo-imei"><?php echo $model->imei; ?></div>
		<div class="row">
			<!-- Bateria -->
			<div class="col-md-2">
				<?php echo Html::img( Url::to('@web/images/dispositivos-accesorios/bateria25.png'), ['class'=> 'dispositivos-accesorios bateria-icono-'.$model->traccar_id]) ?>
				<div class="dispositivos-accesorios-info" id="bateria-<?php echo $model->traccar_id ?>">--</div>
			</div>

			<!-- Movimiento -->
			<div class="col-md-2">
				<?php echo Html::img( Url::to('@web/images/dispositivos-accesorios/detenido.png'), ['class'=> 'dispositivos-accesorios movimiento-icono-'.$model->traccar_id]) ?>
				<div class="dispositivos-accesorios-info" id="movimiento-<?php echo $model->traccar_id ?>">Mov</div>
			</div>

			<!-- Velocidad -->
			<div class="col-md-2">
				<?php echo Html::img( Url::to('@web/images/dispositivos-accesorios/velocidad.png'), ['class'=> 'dispositivos-accesorios']) ?>
				<div class="dispositivos-accesorios-info" id="velocidad-<?php echo $model->traccar_id ?>">--</div>
			</div>

			<!-- Temperatura -->
			<div class="col-md-2">
				<?php echo Html::img( Url::to('@web/images/dispositivos-accesorios/tempoff.png'), ['class'=> 'dispositivos-accesorios temperatura-icono-'.$model->traccar_id]) ?>
				<div class="dispositivos-accesorios-info" id="temperatura-<?php echo $model->traccar_id ?>">--</div>
			</div>

			<!-- GPRS -->
			<div class="col-md-2">
				<?php echo Html::img( Url::to('@web/images/dispositivos-accesorios/senaloff.png'), ['class'=> 'dispositivos-accesorios status-icono-'.$model->traccar_id]) ?>
				<div class="dispositivos-accesorios-info" id="status-<?php echo $model->traccar_id ?>">Off</div>
			</div>

			<!-- Ignicion -->
			<div class="col-md-2">
				<?php echo Html::img( Url::to('@web/images/dispositivos-accesorios/apagado.png'), ['class'=> 'dispositivos-accesorios ignicion-icono-'.$model->traccar_id]) ?>
				<div class="dispositivos-accesorios-info" id="ignicion-<?php echo $model->traccar_id ?>">Off</div>
			</div>


		</div>
		<div class="dispositivos-fecha" id="dispositivo-fecha-<?php echo $model->traccar_id ?>">--</div>
		
		<div class="info-direccion direccion-<?php echo $model->traccar_id ?>"></div>
		<button class="btn btn-primary btn-mini btn-block consulta_direccion"><i class="icon icon-search"></i>Consultar dirección</button>
		
	</div>
</div>