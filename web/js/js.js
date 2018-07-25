var map;
var msgTemplate = "\u003Cdiv id=\u0022w0\u0022 class=\u0022col-xs-11 col-sm-3 alert alert-{0}\u0022 role=\u0022alert\u0022 data-notify=\u0022container\u0022\u003E\u003Cbutton type=\u0022button\u0022 class=\u0022close\u0022 data-notify=\u0022dismiss\u0022\u003E\u003Cspan aria-hidden=\u0022true\u0022\u003E\u0026times;\u003C\/span\u003E\u003C\/button\u003E\n\u003Cspan data-notify=\u0022icon\u0022\u003E\u003C\/span\u003E\n\u003Cspan data-notify=\u0022title\u0022\u003E{1}\u003C\/span\u003E\n\u003Chr class=\u0022kv-alert-separator\u0022\u003E\n\u003Cspan data-notify=\u0022message\u0022\u003E{2}\u003C\/span\u003E\n\u003Cdiv class=\u0022progress kv-progress-bar\u0022 data-notify=\u0022progressbar\u0022\u003E\u003Cdiv class=\u0022progress-bar progress-bar-{0}\u0022 role=\u0022progressbar\u0022 aria-valuenow=\u00220\u0022 aria-valuemin=\u00220\u0022 aria-valuemax=\u0022100\u0022 style=\u0022width:100%\u0022\u003E\u003C\/div\u003E\u003C\/div\u003E\n\u003Ca href=\u0022{3}\u0022 data-notify=\u0022url\u0022 target=\u0022{4}\u0022\u003E\u003C\/a\u003E\u003C\/div\u003E";
$(document).ready(function(){
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

    $(document).on('click', '.dispositivo-panel', function(){
      var lat = $(this).attr("latitude");
      var lng = $(this).attr("longitude");
      if( isset(lat) ){
        map.setCenter( lat, lng );
        map.setZoom(17);
      }else{
        // alert("");

        $.notify(
                  {
                    "className":"error",
                    "message":"El dispositivo seleccionado no esta transmitiendo, vuelva a intentarlo después de unos minutos.",
                    "icon":"glyphicon glyphicon-remove",
                    "title":"Geomonitoreo",
                }, {"showProgressbar":true,"delay":5000,"placement":{"from":"top","align":"right"},"type":"danger","template":msgTemplate});



      }
    });
    
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

});

jQuery.expr[":"].containsNoCase = function(el, i, m) {

   var search = m[3];

   if (!search) return false;

   return eval("/" + search + "/i").test($(el).text());

};

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

Split(['#a', '#b'], {
  gutterSize: 4,
  cursor: 'col-resize',
  sizes: [23, 77]
});

// Split(['#e', '#f'], {
//   direction: 'vertical',
//   sizes: [60, 40],
//   gutterSize: 4,
//   cursor: 'row-resize'
// });