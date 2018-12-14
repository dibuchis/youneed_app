jQuery(document).ready(function ($) {
    
    $(document).on('change', '#categorias-aplica_iva', function(){
        var valor = $(this).val();
        if( valor == 0 ){
            $(".field-categorias-subtotal").hide();
            $(".field-categorias-iva").hide();
        }else{
            $(".field-categorias-subtotal").show();
            $(".field-categorias-iva").show();
        }
    });

    $(document).on('change', '#servicios-proveedor_aplica_iva', function(){
        var valor = $(this).val();
        if( valor == 0 ){
            $(".field-servicios-proveedor_subtotal").hide();
            $(".field-servicios-proveedor_iva").hide();
        }else{
            $(".field-servicios-proveedor_subtotal").show();
            $(".field-servicios-proveedor_iva").show();
        }
    });

    $(document).on('change', '#servicios-aplica_iva', function(){
        var valor = $(this).val();
        if( valor == 0 ){
            $(".field-servicios-subtotal").hide();
            $(".field-servicios-iva").hide();
        }else{
            $(".field-servicios-subtotal").show();
            $(".field-servicios-iva").show();
        }
    });

    // Calculo de descuentos para planes
    $(document).on('blur', '#planes-sin_descuento', function(){ 
        var sin_descuento = $(this).val();
        var descuento_aplicado = $("#planes-descuento_1").val();
        if( parseFloat(sin_descuento) > 0 && parseFloat(descuento_aplicado) > 0 ){
            var planes_pvp = (parseFloat(descuento_aplicado) * parseFloat(sin_descuento)) / 100;
            planes_pvp = parseFloat(sin_descuento) - planes_pvp
            $("#planes-pvp").val( parseFloat(planes_pvp) );
        }
    });

    $(document).on('blur', '#planes-descuento_1', function(){ 
        var sin_descuento = $("#planes-sin_descuento").val();
        var descuento_aplicado = $(this).val();
        if( parseFloat(sin_descuento) > 0 && parseFloat(descuento_aplicado) > 0 ){
            var planes_pvp = (parseFloat(descuento_aplicado) * parseFloat(sin_descuento)) / 100;
            planes_pvp = parseFloat(sin_descuento) - planes_pvp
            $("#planes-pvp").val( parseFloat(planes_pvp) );
        }
    });

});

$(document).on('blur', '#categorias-subtotal', function(){ 
    calcularMontosIva( '#categorias-subtotal', '', '#categorias-iva', '#categorias-total' );
});

$(document).on('blur', '#categorias-total', function(){ 
    calcularMontosIvaDesglose( '#categorias-subtotal', '#categorias-iva', '#categorias-total' );
});

$(document).on('blur', '#servicios-proveedor_subtotal', function(){ 
    calcularMontosIva( '#servicios-proveedor_subtotal', '', '#servicios-proveedor_iva', '#servicios-proveedor_total' );
});

$(document).on('blur', '#servicios-proveedor_total', function(){ 
    calcularMontosIvaDesglose( '#servicios-proveedor_subtotal', '#servicios-proveedor_iva', '#servicios-proveedor_total' );
});

$(document).on('blur', '#servicios-subtotal', function(){ 
    calcularMontosIva( '#servicios-subtotal', '', '#servicios-iva', '#servicios-total' );
});

$(document).on('blur', '#servicios-total', function(){ 
    calcularMontosIvaDesglose( '#servicios-subtotal', '#servicios-iva', '#servicios-total' );
});

function calcularMontosIva( componente_total_iva, componente_total_sin_iva, componente_valor_iva, componente_a_pagar ){
    var valor_impuesto_iva = $("#valor_iva").val();
    var valor_iva = ( $( componente_total_iva ).val() > 0) ? $( componente_total_iva ).val() : 0;
    if( componente_total_sin_iva != "" ){
    	var valor_sin_iva = ( $( componente_total_sin_iva ).val() ) ? $( componente_total_sin_iva ).val() : 0;
    }else{
    	var valor_sin_iva = 0;
    }
    
    var total_iva = parseFloat(valor_iva) * parseFloat(valor_impuesto_iva);
    var solo_iva = parseFloat(total_iva) - parseFloat(valor_iva);
    
    $( componente_valor_iva ).val(solo_iva.toFixed(2));
    var a_pagar = parseFloat( total_iva ) + parseFloat(valor_sin_iva);    

    $( componente_a_pagar ).val( a_pagar.toFixed(2) );
}

function calcularMontosIvaDesglose( componente_total_iva, componente_valor_iva, componente_a_pagar ){
	// '#servicios-subtotal', '', '#servicios-iva', '#servicios-total'
    var valor_impuesto_iva = $("#valor_iva").val();

    var a_pagar = ( $( componente_a_pagar ).val() > 0 ) ? $( componente_a_pagar ).val() : 0;
    a_pagar = parseFloat( a_pagar );
    var subtotal = parseFloat( a_pagar ) / parseFloat(valor_impuesto_iva);
    var valor_iva = parseFloat(a_pagar) - parseFloat(subtotal);
    
    $( componente_a_pagar ).val( a_pagar.toFixed(2) );
    $( componente_valor_iva ).val( valor_iva.toFixed(2) );
    $( componente_total_iva ).val( subtotal.toFixed(2) );
}