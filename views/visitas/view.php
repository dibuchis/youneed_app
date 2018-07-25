<?php 
use yii\helpers\Url;
use app\models\Traccar;
$disp = Traccar::getDevice($model->dispositivo->traccar_id);
// $disp = Traccar::getDevice(2);
$ubicacion = Traccar::getPosition($disp[0]['positionId']);
// echo '<pre>';
// print_r($ubicacion);
// echo '</pre>';
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCWmnu8hgRqQzEIU3Sp35ygYoyq_WOIC6Q&libraries=places"></script>
<script src="<?php echo Url::to('@web/js/gmaps.js'); ?>" type="text/javascript"></script>
<style type="text/css">
    .mapa_ruta {
        width: 100%;
        height: 350px;
    }
</style>
<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Visitas */
?>

<div class="visitas-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            // 'dispositivo_id',
            // 'lat',
            // 'lng',
            'fecha_creacion',
            // 'fecha_inicio',
            // 'fecha_final',
            // 'cumplimiento',
        ],
    ]) ?>
    <span class="label label-success info_mapa">Habilite la geolocalización de su dispositivo</span>
    <div class="mapa_ruta" id="mapa_ruta"></div>

</div>
<script type="text/javascript">
    var mapRuta;
    var base_url = $("#base_url").val();
    var latDisp = <?php echo $ubicacion[0]['latitude'] ?>;
    var lngDisp = <?php echo $ubicacion[0]['longitude'] ?>;

     var iconMarker = base_url + '/images/iconos/default.png';
      var tipo = "<?php echo Yii::$app->user->identity->dispositivo->tipo ?>";
      
      if( tipo == "Roja" ){
          iconMarker = base_url + '/images/iconos/roja.png';
      }
      if( tipo == "Naranja" ){
          iconMarker = base_url + '/images/iconos/naranja.png';
      }
      if( tipo == "Verde" ){
          iconMarker = base_url + '/images/iconos/verde.png';
      } 

    mapRuta = new GMaps({
      div: '#mapa_ruta',
      lat: -0.20174155274736552,
      lng: -78.49236593988576,
      mapTypeControlOptions: {
        mapTypeIds : [""]
      },
      zoom: 15,
      minZoom: 8,
      maxZoom: 19,
    });

    mapRuta.addMapType("osm", {
      getTileUrl: function(coord, zoom) {
        return "https://a.tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
      },
      tileSize: new google.maps.Size(256, 256),
      name: "OpenStreetMap",
      minZoom: 8,
      maxZoom: 19
    });
    mapRuta.setMapTypeId("osm");
 
    centrarMapa(latDisp, lngDisp);

    /***********************************************
        Esta función se ejecuta si la llamada a  navigator.geolocation.getCurrentPosition
        tiene éxito. La latitud y la longitud vienen dentro del objeto coords. 
    ***********************************************/

    function centrarMapa(latDisp, lngDisp){
        
        $(".info_mapa").html("espere ...");

        var latCliente = <?php echo $model->lat ?>;
        var lonCliente = <?php echo $model->lng ?>;

        var origin = latDisp+","+lngDisp;
        var destination = latCliente+","+lonCliente;

        $.ajax({
            type: "post",
            url: base_url+"visitas/googledirections",
            dataType: 'json',
            data:{'punto_origen':origin, 'punto_destino':destination},
            beforeSend: function(){
              mapRuta.removePolylines();
              $(".info_mapa").html("Conectando con Google");
              // $(".loader").show();
            },
            success: function(data){
              mapRuta.drawPolyline({
                path: data,
                strokeColor: '#131540',
                strokeOpacity: 0.6,
                strokeWeight: 6
              });
              $(".info_mapa").html("Ruta dibujada");
              // $(".loader").hide();
            },
            async: true,
            cache: false
        });



        mapRuta.map.setZoom(16);
        mapRuta.map.setCenter(new google.maps.LatLng(latDisp,lngDisp));
        mapRuta.addMarker({
          lat: latDisp,
          lng: lngDisp,
          icon: iconMarker,
          title: 'Mi ubicación',
          click: function(e) {
            alert('Mi ubicación');
          }
        });
        // var marker = new google.maps.Marker({
        //     position: new google.maps.LatLng(pos.coords.latitude,pos.coords.longitude),
        //     map: mapRuta.map,
        //     title:"Posición actual"
        //   });
    }
</script>