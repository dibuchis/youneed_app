var selCat;
var selServ;

$(document).ready(function () {

    var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        allNextBtn = $('.nextBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-success').addClass('btn-default');
            $item.addClass('btn-success');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function () {
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url']"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        for (var i = 0; i < curInputs.length; i++) {
            if (!curInputs[i].validity.valid) {
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
    });

    $('div.setup-panel div a.btn-success').trigger('click');

    $(".seleccion_plan").click(function(){
        $("#usuarios-plan_id").val( $(this).attr("plan-id") );
        $(".plan_seleccionado").html( "Plan seleccionado: " + $(this).attr("plan-nombre") );
        $(".plan_seleccionado").show();
    });
});

(function($){
    $("#usuarios-tipo_identificacion").on("change", function(){ 
        var index = $(this).val();

        if(index == 1){
            $(".document-input-asociado").addClass("hidden");
             $("#form_fotografia_cedula_upload").removeClass("hidden");
        }
    
        if(index == 2){
            $(".document-input-asociado").addClass("hidden");
            $("#form_ruc_upload").removeClass("hidden");
       }
       
       if(index == 3){
           $(".document-input-asociado").addClass("hidden");
            $("#form_rise_upload").removeClass("hidden");
       }
    
       if(index == 4){
           $(".document-input-asociado").addClass("hidden");
            $("#form_visa_trabajo_upload").removeClass("hidden");
       }
    
       $("#form_fotografia_cedula_upload").removeClass("hidden");
       $("#form_referencias_personales_upload").removeClass("hidden");

       if(index == ""){
        $(".document-input-asociado").addClass("hidden");
            $("#form_fotografia_cedula_upload").removeClass("hidden");
        }
        
    });

    $("#vista_previa_imagen").click(function(){
        $("#usuarios-imagen_upload").trigger("click");
    });

    $(".registro-error-sumary").click(function(){ $( this ).fadeOut(); });

    $(".cat-item").click(function(e){
        e.preventDefault();
        e.stopPropagation();
        var loader = document.createElement("div");
        loader.className="ajax-loader-obj";
        loader.id="ajax-loader-obj";
        document.getElementById("servicios-wrapper").appendChild(loader);
        // selCat = $(this).attr("data-id");
        $.ajax({
            method:"POST",
            url:"/ajax/listadoservicios",
            data:{depdrop_parents: $(this).attr("data-id")},
            success:function(rs){
                document.getElementById("ajax-loader-obj").remove();
                var json = JSON.parse(rs);
                var obj = json.output;
                
                // console.log(obj);
                if(obj.length){
                    document.getElementById("owl-servicios").remove();
                    
                    var wrp = document.createElement("div");
                    wrp.className="owl-carousel owl-carousel-serv owl-theme";
                    wrp.id="owl-servicios";
                    document.getElementById("servicios-wrapper").appendChild(wrp);
                    for(var k in obj){
                        let el = document.createElement('div');
                        el.className="serv-item";
                        el.setAttribute("data-id", obj[k].id);
                        el.setAttribute("data-parent", obj[k].parent);
                        el.innerHTML = obj[k].body;

                        document.getElementById("owl-servicios").appendChild(el);
                    }
                    let owl = document.getElementById("owl-servicios");
                    $(owl).owlCarousel({
                        items: 6,
                        margin:45,
                        nav:true
                    });
                }else{
                    document.getElementById("owl-servicios").remove();
                    
                    var wrp = document.createElement("div");
                    wrp.className="owl-carousel owl-carousel-serv empty-category owl-theme";
                    wrp.id="owl-servicios";
                    wrp.innerHTML = "<span class='alert alert-info'>Lo sentimos, por el momento no existen servicios disponibles para esta categoría.</span>";

                    document.getElementById("servicios-wrapper").appendChild(wrp);
                    // document.getElementById("servicios-wrapper").innerHTML = "";
                }
            }
        });
    });

})(jQuery);