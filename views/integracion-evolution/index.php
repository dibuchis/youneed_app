<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Traccar;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Atenciones */
/* @var $form yii\widgets\ActiveForm */
?>

<script type="text/javascript">
var lat = "<?php echo $atencion->latitude; ?>";
var lon = "<?php echo $atencion->longitude; ?>";
var metros_redonda_movil = "<?php echo Yii::$app->params['metros_redonda_movil']; ?>";
var api_utim = "<?php echo Yii::$app->params['api_utim']; ?>";
var base_url = $("#base_url").val();
var markers_data = [];

$(document).ready(function(){
	map_atencion = new GMaps({
	    div: '#mapPacientes',
	    lat: lat,
	    lng: lon,
	    mapTypeControlOptions: {
	      mapTypeIds : ["hybrid", "roadmap", "satellite", "terrain", "osm"]
	    },
	    zoom: 14,
	    minZoom: 7,
	    maxZoom: 19
	});

	var iconPaciente = base_url + 'images/iconos/paciente.png';

	map_atencion.addMarker({
	  lat: lat,
	  lng: lon,
	  title: 'Ubicación Paciente',
	  icon: iconPaciente
	});

	circulo = new google.maps.Circle({
	      center: new google.maps.LatLng( lat, lon ),
	      radius: eval(metros_redonda_movil),
	      strokeColor: "#FF0000",
	      strokeOpacity: 0.8,
	      strokeWeight: 2,
	      fillColor: "#FF0000",
	      fillOpacity: 0.35,
	      map: map_atencion.map
	  });

	$.ajax({
	    url: api_utim+"doctorsavailable?lat="+lat+"&lon="+lon+"&meters="+metros_redonda_movil,
	    dataType: "json",
	    type: "GET",
	    dataType: 'json',
	    beforeSend: function () {
            $("#loading_doctores").show();
        },
	    success: function(data){
	    	if( data.status == 1 ){
	    		$.each(data.data.doctores, function(){
		    		var iconDoctor = base_url + 'images/iconos/medico.png';
		    		markers_data.push({
	    		        id: this.id,
	    		        lat: this.lat,
	    		        lng: this.lon,
	    		        icon: iconDoctor,
	    		        infoWindow: {
	    		          content: "<img src='"+base_url+"images/ajax-loader.gif'>",
	    		          closeclick:function(){
	    		            this.setContent( "<img src='"+base_url+"images/ajax-loader.gif'>" );
	    		          }
	    		        },
	    		        click: function(e) {
	    		          	$.ajax({
	    		                type: "get",
	    		                url: base_url+"ajax/getdatamarker/?id="+e.id,
	    		                dataType: 'json',
	    		                success: function(data){
	    		                	if( data.status == 1 ){
	    		                		var html = '<strong>Nombres:</strong> Dr(a).'+data.doctor.nombres+' '+data.doctor.apellidos+' <br>'+'<strong>Número celular:</strong> '+data.doctor.numero_celular+' <br>';
	    		                		html += '<a href="javascript:;" doctor-id="'+e.id+'" class="asignar_doctor_atencion btn btn-success btn-xs btn-block">Asignar</a>'
	    		                		e.infoWindow.setContent( html );
	    		                		$(".asignar_doctor_atencion").click(function(){
	    		                			$("#usuarios-doctor_id").val( $(this).attr("doctor-id") );
	    		                			$(".informacion_doctor_atencion").html( "Dr(a). "+data.doctor.nombres+" "+data.doctor.apellidos );
	    		                			$("#usuarios-latitude_inicial_doctor").val( data.doctor.lat );
	    		                			$("#usuarios-longitude_inicial_doctor").val( data.doctor.lon );
	    		                			$(this).html( "Doctor asignado" );
	    		                		});
	    		                	}
	    		                	// e.infoWindow.setContent( 'hola' );
	    		                },
	    		                async: true,
	    		                cache: false
	    		            });
	    		        }
	    		    });
		    	});
	    		map_atencion.addMarkers(markers_data);
	    	}
	    	$("#loading_doctores").hide();
	    }
	});

	// map_atencion.setMapTypeId("osm");
});

</script>
<div class="container-crud atenciones-form" style="margin-top: 20px;">

	<div class="row">
		<div class="col-md-2">
			
			<?php $form = ActiveForm::begin(); ?>

			<div class="row">
			    <?= $form->field($model, 'tiempo_atencion')->dropDownList([ 5 => '5 min', 10 => '10 min', 15 => '15 min', 20 => '20 min', 25 => '25 min', 30 => '30 min', 45 => '45 min', 60 => '60 min', ], ['prompt' => 'Seleccione']) ?>
			    <label>Doctor:</label>
			    <div class="informacion_doctor_atencion">Seleccione un doctor del mapa para asignarlo a la atención</div>
				<?= $form->field($model, 'doctor_id')->hiddenInput([])->label(false) ?>
				<?= $form->field($model, 'latitude_inicial_doctor')->hiddenInput([])->label(false) ?>
				<?= $form->field($model, 'longitude_inicial_doctor')->hiddenInput([])->label(false) ?>
			</div>
		  
			<?php if (!Yii::$app->request->isAjax){ ?>
			  	<div class="form-group">
			        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Asignar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary btn-block btn-lg']) ?>
			    </div>
			<?php } ?>

		    <?php ActiveForm::end(); ?>	
		
		</div>
		<div class="col-md-10">
			<div id="loading_doctores" style="position: absolute; z-index: 1000; display: none;" class="alert alert-success" role="alert"><?= Html::img( Url::to('@web/images/ajax-loader.gif'), ['class'=> '']);?> Buscando doctores disponibles, espere por favor ...</div>
			<div id="mapPacientes" class="mapPacientes">
			</div>
		</div>
	</div>
    
</div>
<style type="text/css">
	.mapPacientes{
		width: 100%;
		height: 500px;
	}
</style>