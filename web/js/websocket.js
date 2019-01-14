var urlRest = $("#urlRest").val();
var urlSocket = $("#urlSocket").val();
var userSocket = $("#userSocket").val();
var passSocket = $("#passSocket").val();
var base_url = $("#base_url").val();
var markers_validate = [];
var optionsDates = {
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "numeric",
    minute: "numeric"
};

var devices_array = [];
var devices_array_all = [];

$.ajax({
    url: base_url+"site/getdispositivosusuario",
    dataType: "json",
    success: function(data){
        $.each(data, function(){
            devices_array.push( parseInt(this.id) );
            devices_array_all[ parseInt(this.id) ] = this.tipo ;
        });
    }
});


$.ajaxSetup({
	crossDomain: true,
	xhrFields: {
	    withCredentials: true
	}
});
$.ajax({
    url: urlRest+"session",
    dataType: "json",
    type: "POST",
    data: {
        email: userSocket,
        password: passSocket
    },
    success: function(user){
        var conn = new WebSocket( urlSocket );
		conn.onmessage = function(event) {
			var data = JSON.parse(event.data);
			if (data.positions) {
				agregaMarcas( data.positions );
            }
            if (data.devices) {
				actualizarDataDispositivos( data.devices );
            }
            // else{
            //     actualizarDataDispositivosApagados( data.positions )
            // }
		};
		conn.onopen = function(e) {
		   
		};
    }
});

function agregaMarcas(data) {
    var markers_data = [];
    $.each(data, function(){
        if( $.inArray(this.deviceId, devices_array) != -1 ){
        	if( this.attributes.batteryLevel ){
        		if( this.attributes.batteryLevel >= 50 ){
        			$(".bateria-icono-"+this.deviceId).attr("src", base_url+"images/dispositivos-accesorios/bateria100.png");
        		}
        		if( this.attributes.batteryLevel <= 65 ){
        			$(".bateria-icono-"+this.deviceId).attr("src", base_url+"images/dispositivos-accesorios/bateria50.png");
        		}
        		if( this.attributes.batteryLevel <= 25 ){
        			$(".bateria-icono-"+this.deviceId).attr("src", base_url+"images/dispositivos-accesorios/bateria25.png");
        		}
        		$("#bateria-"+this.deviceId).html( this.attributes.batteryLevel+"%" );
        	}else{
                $(".bateria-icono-"+this.deviceId).attr("src", base_url+"images/dispositivos-accesorios/bateriano.png");
            }

            if( this.attributes.motion ){
                $(".movimiento-icono-"+this.deviceId).attr("src", base_url+"images/dispositivos-accesorios/movimiento.png");
            }else{
                $(".movimiento-icono-"+this.deviceId).attr("src", base_url+"images/dispositivos-accesorios/detenido.png");
            }

            $("#velocidad-"+this.deviceId).html( Math.round( convertirknotsaKm( this.speed ) )+"km" );
        	
        	var dispositivo_fecha = new Date(this.deviceTime);
        	$("#dispositivo-fecha-"+this.deviceId).html( dispositivo_fecha.toLocaleDateString("es", optionsDates) );

        	$("#dispositivo-"+this.deviceId).attr( "latitude", this.latitude );
        	$("#dispositivo-"+this.deviceId).attr( "longitude", this.longitude );


            if( this.attributes.temp1 ){
                $(".temperatura-icono-"+this.deviceId).attr("src", base_url+"images/dispositivos-accesorios/tempon.png");
                $("#temperatura-"+this.deviceId).html( Math.round(this.attributes.temp1)+"&#8451;" );
            }else{
                $(".temperatura-icono-"+this.deviceId).attr("src", base_url+"images/dispositivos-accesorios/tempoff.png");
            }

            if( this.attributes.ignition ){
                $(".ignicion-icono-"+this.deviceId).attr("src", base_url+"images/dispositivos-accesorios/encendido.png");
                $("#ignicion-"+this.deviceId).html( "On" );
            }else{
                $(".ignicion-icono-"+this.deviceId).attr("src", base_url+"images/dispositivos-accesorios/apagado.png");
                $("#ignicion-"+this.deviceId).html( "Off" );
            }        

            // if( this.address ){
            //     $("#direccion-"+this.deviceId).html( this.address );
            // }

          	var iconMarker = base_url + '/images/iconos/asociado.png';
            if( devices_array_all[ this.deviceId ] == "Roja" ){
                iconMarker = base_url + '/images/iconos/roja.png';
            }
            if( devices_array_all[ this.deviceId ] == "Naranja" ){
                iconMarker = base_url + '/images/iconos/naranja.png';
            }
            if( devices_array_all[ this.deviceId ] == "Verde" ){
                iconMarker = base_url + '/images/iconos/verde.png';
            }
            
    	    if( markers_validate[this.deviceId] > 0 ){
    	    	var position = this;
    	    	$.each(map.markers, function(){
    		      var objM = this;
    		      if( objM.id == position.deviceId ){ 
    		        objM.setPosition(new google.maps.LatLng( position.latitude, position.longitude ));
    		      }   
    		    });
    	    }else{
    	    	markers_validate[this.deviceId] = this.deviceId;
    		    markers_data.push({
    		        id: this.deviceId,
    		        lat: this.latitude,
    		        lng: this.longitude,
    		        icon: iconMarker,
    		        infoWindow: {
    		          content: "<img src='"+base_url+"images/ajax-loader.gif'>",
    		          closeclick:function(){
    		            this.setContent( "<img src='"+base_url+"images/ajax-loader.gif'>" );
    		          }
    		        },
    		        click: function(e) {
                        var lat = $("#dispositivo-"+e.id).attr("latitude");
                        var lng = $("#dispositivo-"+e.id).attr("longitude");
    		        	if(  isset(lat) ){
    		        		map.setCenter( lat, lng );
          					map.setZoom(17);
    		        	}
    		          	$.ajax({
    		                type: "get",
    		                url: base_url+"site/getdatamarker/?traccar_id="+e.id,
    		                dataType: 'html',
    		                success: function(data){
    		                  e.infoWindow.setContent(data);
    		                },
    		                async: true,
    		                cache: false
    		            });
    		        }
    		    });
    	    }
        }
    });
    map.addMarkers(markers_data);
}

function actualizarDataDispositivos(data) {
    $.each(data, function(){
      	if( this.status == "online" ){
      		$(".status-icono-"+this.id).attr("src", base_url+"images/dispositivos-accesorios/senalon.png");
            $("#status-"+this.id).html("GPRS");
      	}else{
            $(".status-icono-"+this.id).attr("src", base_url+"images/dispositivos-accesorios/senaloff.png");
            $("#status-"+this.id).html(this.status);
      	}
    });
}

function convertirknotsaKm( valor ){
    if( valor > 0 ){
        var resultado = parseFloat(valor) / parseFloat(0.539956803456);
        return resultado;
    }else{
        return valor;
    }
}

$(document).ready(function(){
    $(".consulta_direccion").click(function(){
        var lat = $(this).parent().parent().attr("latitude");
        var lng = $(this).parent().parent().attr("longitude");
        var traccar_id = $(this).parent().parent().attr("traccar_id");
        if( isset( lat ) ){
            $.ajax({
              type: "post",
              url: base_url+"site/geodireccion",
              dataType: 'html',
              data:{ 'lat':lat, 'lng':lng },
              beforeSend: function(){
                $(".direccion-"+traccar_id).html("Buscando dirección, espere ...");
              },
              success: function(data){
                $(".direccion-"+traccar_id).html(data);
              },
              async: true,
              cache: false
          });
        }else{
            $(this).html("No disponible");
        }
    });
});

// function actualizarDataDispositivosApagados(data) {
//     $.each(data, function(){        
//         $(".status-icono-"+this.deviceId).attr("src", base_url+"images/dispositivos-accesorios/apagado.png");
//         $("#status-"+this.deviceId).html('Off');
        
//     });
// }
