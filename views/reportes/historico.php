<?php
if( count( $polilineas ) > 0 ){
  $data_polis = json_encode( $polilineas, JSON_FORCE_OBJECT );
}else{
  $data_polis = 0;
}

/* @var $this yii\web\View */

$this->title = 'Geomonitoreo';
?>
<script type="text/javascript">
  var map;
var base_url = $("#base_url").val();
$(document).ready(function(){
 
 var data = <?php echo $data_polis; ?>;

  map = new GMaps({
    div: '#map_canvas',
    lat: -0.20174155274736552,
    lng: -78.49236593988576,
    mapTypeControlOptions: {
      mapTypeIds : ["hybrid", "roadmap", "satellite", "terrain", "osm"]
    },
    zoom: 7,
    minZoom: 7,
    maxZoom: 19
  });

  map.addMapType("osm", {
      getTileUrl: function(coord, zoom) {
        return "https://a.tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
      },
      tileSize: new google.maps.Size(256, 256),
      name: "Open Street Maps",
      minZoom: 7,
      maxZoom: 19
    });
    map.setMapTypeId("osm");

    map.addControl({
      position: 'top_left',
      content: 'Mostrar zonas',
      style: {
        margin: '10px',
        padding: '8px 6px',
        background: '#fff'
      },
      events: {
        click: function(){
          if( $(this).html() == "Ocultar zonas" ){
            $(this).css("font-weight", "normal");
            $(this).html("Mostrar zonas");
            map.removePolygons();
          }else{
            $(this).css("font-weight", "bold");
            $(this).html("Ocultar zonas");
            setZonas();
          }
        }
      }
    });

    // Buscador de lugares
    var searchOptions = document.getElementById('search-options');
    map.map.controls[google.maps.ControlPosition.TOP_LEFT].push(searchOptions);
    // Buscador de lugares

    // map.addControl({
    //   position: 'top_left',
    //   content: '<span class="glyphicon glyphicon-send" aria-hidden="true"></span>',
    //   style: {
    //     margin: '10px',
    //     padding: '8px 8px',
    //     background: '#fff'
    //   },
    //   events: {
    //     click: function(){
          
    //     }
    //   }
    // });

   
    
    $("#kwd_search").keyup(function(){
      if( $(this).val() != "")
      {
        // Show only matching TR, hide rest of them
        $("#crud-datatable table tbody>tr").hide();
        $("#crud-datatable table td:containsNoCase('" + $(this).val() + "')").parent("tr").show();
      }
      else
      {
        // When there is no input or clean again, show everything back
        $("#crud-datatable table tbody>tr").show();
      }
    });

    buscadorMapa();

    if( isJson(data) ){
      var allCoordinates = new Array();
                $.each(data, function(){
                  allCoordinates.push( new google.maps.LatLng(this[0], this[1]) );

                  map.addMarker({
                    lat: this[0],
                    lng: this[1],
                    title: 'Evento',
                    icon: base_url + '/images/iconos/evento-historico.png',
                    infoWindow: {
                      content: '<strong>Lat:</strong> '+this[0]+'<br><strong>Lon:</strong> '+this[1]+'<br><strong>Fecha:</strong> '+this[2] + '<br><strong>Temperatura:</strong> '+this[3]
                    }
                  });

                });

                for (var i = 0, n = allCoordinates.length; i < n; i++) {

                    var coordinates = new Array();
                    for (var j = i; j < i+2 && j < n; j++) {
                        coordinates[j-i] = allCoordinates[j];
                    }

                    map.drawPolyline({
                      path: coordinates,
                      strokeColor: '#2995F1',
                      strokeOpacity: 1.0,
                      strokeWeight: 4,
                      icons: [{
                          // icon: {path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW},
                          offset: '100%'
                      }]
                    });

                }

                if( isset(data[0]) ){
                  map.addMarker({
                    lat: data[0][0],
                    lng: data[0][1],
                    infoWindow: {
                      content: "Origen",
                    },
                    icon: base_url + '/images/iconos/deposito-icon.png',
                  });

                  
                  // var lastItem = data.pop();
                  // map.addMarker({
                  //   lat: lastItem[0],
                  //   lng: lastItem[1],
                  //   infoWindow: {
                  //     content: "Destino",
                  //   },
                  //   icon: base_url + '/images/iconos/deposito-icon.png',
                  // });

                  map.setCenter(data[0][0], data[0][1]);
                  map.setZoom(19);
                }
  }

});


function buscadorMapa(tipo = "G"){
  // $("#auto_complete_producto_busqueda_rapida").val("");
  $("#pac-input").val("");
  var input = document.getElementById('pac-input');
  var searchBox = new google.maps.places.SearchBox(input);
  map.map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });

  searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {
      var icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

  

      if (place.geometry.viewport) {
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.map.fitBounds(bounds);
  });
  // if( tipo == "G"){
  //   $("#auto_complete_producto_busqueda_rapida").hide();
  //   $("#pac-input").show();
  // }else{
  //   $("#auto_complete_producto_busqueda_rapida").show();
  //   $("#pac-input").hide();
  //   // google.maps.event.clearInstanceListeners(input);
  // }
}

function isset(variable) {
    try {
        return typeof eval(variable) !== 'undefined';
    } catch (err) {
        return false;
    }
}

function isJson(item) {
    item = typeof item !== "string"
        ? JSON.stringify(item)
        : item;

    try {
        item = JSON.parse(item);
    } catch (e) {
        return false;
    }

    if (typeof item === "object" && item !== null) {
        return true;
    }

    return false;
}
</script>
<div id="map_canvas" class="map_canvas"></div>
<div id="search-options">
  <?php 
      // $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
      //     'name'=>'auto_complete_producto_busqueda_rapida',
      //     'source'=>$this->createUrl('ajax/listadozonasmapa'),
      //       'options'=>array(
      //         'showAnim'=>'fold',
      //         'select' => 'js:function(event, ui){ centrar_poligono(ui.item.poligono) }',
      //         'change' => 'js:function(event, ui){
      //           if(ui.item===null){
      //             $("#auto_complete_producto_busqueda_rapida").val("");
      //           }            
      //         }',
      //       ),
      //       'htmlOptions'=>array(
      //         'class'=>'pac-input', 
      //         'placeholder'=>'Buscar lugares ...',
      //       ),
      // ));
    ?>

  <input id="pac-input" class="pac-input" type="text" placeholder="Buscar lugares ...">
  <!-- <select id="pac-input-select">
    <option value="G">Google</option>
    <option value="Z">Zonas</option>
  </select> -->
</div>