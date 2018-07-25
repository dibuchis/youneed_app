// $(document).ready(function(){
// 	$(".mapa-modal").click(function(){

// 	});
// });


$('#ajaxCrudModal').on('shown.bs.modal', function (e) {

	$(".enviarLugar").click(function(){
		// $('#formulario-lugares').yiiActiveForm('validate', true);
		$('#formulario-lugares').submit();
		// $('#formulario-lugares').on('afterValidate', function (e) {
		// 	if (!confirm("Everything is correct. Submit?")) {
		// 		return false;
		// 	}
		// 	return true;
		// });
	});

  	var coordinates = [];
	var polygons = [];
	var geoCoords = [];
	var arrayCoorGeo = [];
	var map;
	$(document).ready(function(){
	  map = new GMaps({
	    div: '#mapLugares',
	    lat: -0.20174155274736552, 
	    lng: -78.49236593988576,
	    zoom: 19,
	    minZoom: 8,
	    maxZoom: 19,
	    mapTypeControlOptions: {
	      mapTypeIds : ["hybrid", "roadmap", "satellite", "terrain", "osm"]
	    },
	  });

	  

	  // Mostrar zonas
	    map.addControl({
	      position: 'top_left',
	      content: 'Mostrar Zonas',
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
	    // Mostrar zonas 

	  // $.ajax({
	  //     type: "get",
	  //     url: base_url+"/ajax/geocercasglobal",
	  //     dataType: 'json',
	  //     beforeSend: function(){
	  //         $(".mensaje_busqueda").show();
	  //         $(".loader").show();
	  //     },
	  //     success: function(data){
	  //         $.each(data, function(){
	  //             var arrayGeo = [];
	  //             $.each(this, function(){
	  //                 arrayGeo.push( [ this[0], this[1] ] );
	  //             });

	  //             polygon = map.drawPolygon({
	  //               paths: arrayGeo, // pre-defined polygon shape
	  //               // draggable: true,
	  //               fillOpacity: 0.2,
	  //               strokeOpacity: 0.2,
	  //               strokeWeight: 1,
	  //               clickable: false,
	  //               fillColor: '#000000',
	  //               strokeColor: '#000000'
	  //             });
	  //         });
	  //         $(".mensaje_busqueda").hide();
	  //         $(".loader").hide();
	  //     },
	  //     async: true,
	  //     cache: false
	  // });

	  
	  var drawingManager = new google.maps.drawing.DrawingManager({
	  drawingMode: google.maps.drawing.OverlayType.POLYGON,
	  drawingControl: true,
	  drawingControlOptions: {
	        position: google.maps.ControlPosition.TOP_RIGHT,
	        drawingModes: [
	          google.maps.drawing.OverlayType.POLYGON
	        ]
	      },
	      polygonOptions: {
	        fillColor: '#157FCC',
	        fillOpacity: 0.3,
	        strokeWeight: 2,
	        clickable: false,
	        editable: true,
	        zIndex: 1
	      }
	    });

	  google.maps.event.addDomListener(drawingManager, 'polygoncomplete', function(polygon) {
	    polygon.setEditable(true);
	    drawingManager.setDrawingMode(null);
	    drawingManager.setOptions({
	      drawingControl: false
	    });
	    save_coordinates_to_array(polygon);
	    google.maps.event.addListener(polygon.getPath(), 'set_at', function () {
	        save_coordinates_to_array(polygon);
	        });
	    google.maps.event.addListener(polygon.getPath(), 'insert_at', function () {
	        save_coordinates_to_array(polygon);
	        });
	  });


	drawingManager.setMap(map.map); // map.map is the reference to original map object


	  map.addMapType("osm", {
	    getTileUrl: function(coord, zoom) {
	      return "https://a.tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
	    },
	    tileSize: new google.maps.Size(256, 256),
	    name: "OpenStreetMap",
	    maxZoom: 19
	  });
	  map.setMapTypeId("osm");

	  // Bloque cuando sea actualizacion
	  var data = $("#lugares-poligono").val();
	  if( data != "" ){
	      var arrayCoorGeo = $.parseJSON(data);
	      for(var i = 0 ; i < arrayCoorGeo.length ; i++){
	          geoCoords.push( new google.maps.LatLng(arrayCoorGeo[i][0], arrayCoorGeo[i][1]) );
	      }
	      geocerca = new google.maps.Polygon({
	          paths: geoCoords,
	          // draggable: true,
	          editable: true,
	          fillColor: '#157FCC'
	      });

	      geocerca.setMap(map.map);
	      google.maps.event.addListener(geocerca, "dragend", function() { save_coordinates_to_array(geocerca); } );
	      google.maps.event.addListener(geocerca.getPath(), "insert_at", function() { save_coordinates_to_array(geocerca); } );
	      google.maps.event.addListener(geocerca.getPath(), "remove_at", function() { save_coordinates_to_array(geocerca); } );
	      google.maps.event.addListener(geocerca.getPath(), "set_at", function() { save_coordinates_to_array(geocerca); } );

	      geocerca.setEditable(true);
	      drawingManager.setDrawingMode(null);
	      drawingManager.setOptions({
	        drawingControl: false
	      });

	      if( isset( arrayCoorGeo[0][0] ) ){
	          map.setCenter( arrayCoorGeo[0][0], arrayCoorGeo[0][1] );
	      }      
	  }
	  // Bloke cuando sea actualizacion

	  // Buscador de lugares
	    // var input = document.getElementById('pac-input');
	    //   var searchBox = new google.maps.places.SearchBox(input);
	    //   map.map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

	    //   map.map.addListener('bounds_changed', function() {
	    //     searchBox.setBounds(map.getBounds());
	    //   });

	    //   searchBox.addListener('places_changed', function() {
	    //     var places = searchBox.getPlaces();

	    //     if (places.length == 0) {
	    //       return;
	    //     }

	    //     var bounds = new google.maps.LatLngBounds();
	    //     places.forEach(function(place) {
	    //       var icon = {
	    //         url: place.icon,
	    //         size: new google.maps.Size(71, 71),
	    //         origin: new google.maps.Point(0, 0),
	    //         anchor: new google.maps.Point(17, 34),
	    //         scaledSize: new google.maps.Size(25, 25)
	    //       };

	      

	    //       if (place.geometry.viewport) {
	    //         bounds.union(place.geometry.viewport);
	    //       } else {
	    //         bounds.extend(place.geometry.location);
	    //       }
	    //     });
	    //     map.map.fitBounds(bounds);
	    //   });
	  // Buscador de lugares

	});
	function save_coordinates_to_array(polygon)
	{
	    polygons.push(polygon);
	    var coordinates = [];
	    var polygonBounds = polygon.getPath();
	    for(var i = 0 ; i < polygonBounds.length ; i++)
	    {
	        coordinates.push([polygonBounds.getAt(i).lat(), polygonBounds.getAt(i).lng()]);
	    }   
	    var myJsonString = JSON.stringify(coordinates);
	    $("#lugares-poligono").val(myJsonString);
	    $("#lugares-wkt").val( GMapPolygonToWKT(polygon) );
	}

	function GMapPolygonToWKT(poly)
	{
	 // Start the Polygon Well Known Text (WKT) expression
	 var wkt = "POLYGON(";

	 var paths = poly.getPaths();
	 for(var i=0; i<paths.getLength(); i++)
	 {
	  var path = paths.getAt(i);
	  
	  // Open a ring grouping in the Polygon Well Known Text
	  wkt += "(";
	  for(var j=0; j<path.getLength(); j++)
	  {
	   // add each vertice and anticipate another vertice (trailing comma)
	   wkt += path.getAt(j).lng().toString() +" "+ path.getAt(j).lat().toString() +",";
	  }
	  
	  // Google's approach assumes the closing point is the same as the opening
	  // point for any given ring, so we have to refer back to the initial point
	  // and append it to the end of our polygon wkt, properly closing it.
	  //
	  // Also close the ring grouping and anticipate another ring (trailing comma)
	  wkt += path.getAt(0).lng().toString() + " " + path.getAt(0).lat().toString() + "),";
	 }
	 
	 // resolve the last trailing "," and close the Polygon
	 wkt = wkt.substring(0, wkt.length - 1) + ")";
	 
	 return wkt;
	}
});

function isset(variable) {
    try {
        return typeof eval(variable) !== 'undefined';
    } catch (err) {
        return false;
    }
}