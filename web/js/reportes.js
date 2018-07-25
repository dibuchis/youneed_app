var map;

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