var selCat;
var selServ;

var arrServ = [];
var arrCat = [];

var navStep = 1;
var nPanels = 0;
// var getSrv = null;

function getStep(){
    return parseInt(navStep);
}
function setStep(step){
    navStep = step;
}
function getServicio(srvID){
    return Promise.resolve($.ajax({
        method:"GET",
        url:"/ajax/getservicio",
        data: {serviceID: parseInt(srvID)}
    }));
    // return promise.then(function(value){return JSON.parse(value);});
}

$(document).ready(function () {

    // Swal.fire({
    //     type:"info",
    //     text:"Antes de continuar asegúrate de disponer en tu teléfono o PC una imagen actualizada de tu perfil o logo si es una empresa, imagen de tu Cédula o RUC o RISE o Pasaporte con permiso de Trabajo, dependiendo del tipo de documento que necesites ingresar"
    // });

    $("#servicios-wrapper").on("click", ".btn-vermas", function(e){
        // console.log($(this).attr("data-srv"));
        if(parseInt($(this).attr("data-srv")) >  0){
            var getSrv = getServicio(parseInt($(this).attr("data-srv")));
            getSrv.then(function(data){
                var servicioData = JSON.parse(data);
                servicio = servicioData.servicio;
                var inHtml = '';
                if(servicio.nombre!= null){
                inHtml += "<h4>Nombre del servicio</h4>";
                inHtml += "<p>" + servicio.nombre +"</p>";
                }
                if(servicio.incluye != null){
                    inHtml += "<h4>Incluye</h4>";
                    inHtml += "<p>" + servicio.incluye +"</p>";
                }
                
                if(servicio.no_incluye != null){
                    inHtml += "<h4>No incluye</h4>";
                    inHtml += "<p>" + servicio.no_incluye +"</p>";
                }
                
                inHtml += "<h4>Precio</h4>";
                if(servicio.total != null){
                    inHtml += "<p>" + servicio.total +"</p>";
                }else{
                    inHtml += "<p>no disponible</p>";
                }
                Swal.fire({
                    html:inHtml
                });
            });
        }
    });

    if(sessionStorage.length >= 1){
        for(var i=1; i<= sessionStorage.length; i++){
            if(document.getElementById(sessionStorage.key(i)) != null){
                var el = document.getElementById(sessionStorage.key(i));
                el.value = sessionStorage.getItem(el.id);
                if(el.id == "usuarios-categorias"){
                    var cats = el.value.split(",");
                    for(var j = 0; j<cats.length; j++){
                    arrCat.push(cats[j]);
                    }
                }
                if(el.id == "usuarios-servicios"){
                    var srvs = el.value.split(",");
                    for(var j = 0; j<srvs.length; j++){
                        arrServ.push(srvs[j]);
                        var getSrv = getServicio(parseInt(srvs[j]));
                        getSrv.then(function(data){
                            var servicioData = JSON.parse(data);
                            servicio = servicioData.servicio;
                            $("#servicios-agregados").append("<div class='label label-primary label-servicios' data-cat='" + parseInt(servicio.cat_id) + "' data-srv='" + parseInt(servicio.id) + "'>" + servicio.nombre + "<span class='delete-service' data-srv='" + parseInt(servicio.id) + "'>x</span></div>")
                        });
                    }
                }
            }
        }
    }

    nPanels  = $(".btn-step");

    var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        allSaveBtn = $('.saveBtn'),
        allBackBtn = $('.backBtn'),
        allNextBtn = $('.nextBtn');

    allWells.hide();

    navListItems.click(function (e) {
            e.preventDefault();

            var badPassword = true;
            var empty = false;
            var fields = [];
            tStep = getStep();

            $('#step-' + tStep + ' *[aria-required=true], #step-' + tStep + ' #usuarios-numero_celular, #step-' + tStep + ' .required > input').each(function(){
            if($(this).val()==""){
                empty =true;
                fields.push($(this).attr("id"));
                }
            });

            var clave = $("#usuarios-clave").val();
            var confirmaClave = $("#confirmar_clave").val();

            if(clave == confirmaClave){
                badPassword = false;
            }

            var ulFields = '<ul style="text-align:left;">';
                for(var j=0;j<fields.length;j++){
                    var fieldText = fields[j].replace("usuarios-", "");
                    fieldText = fieldText.replace("_", " ");
                    fieldText = fieldText.replace("cat1-id", "país");
                    fieldText = fieldText.replace("subcat11-id", "ciudad");
                    ulFields += '<li>' + fieldText + ' vacío</li>';
                }
                if(!badPassword){
                    ulFields += '<li>Las contraseñas no coinciden.</li>';
                }
            ulFields += '</ul>';

            if(empty || badPassword){
                Swal.fire({
                    title:'Alerta!',
                    html:'Existen errores o campos vacíos: <br>' + ulFields,
                    type: 'error'
                });
                return 0;
            }

        var $target = $($(this).attr('href')),
            $item = $(this);

        if (!$item.hasClass('disabled')) {
            // navListItems.removeClass('btn-success').addClass('btn-default');
            // $item.addClass('btn-success');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }

        var selected = parseInt($(this).attr("data-step"));

        for(var i = 1; i<=nPanels.length; i++){
            if(i <= selected){
                $("#btn-step-" + i ).removeClass("btn-default");
                $("#btn-step-" + i ).addClass("btn-success");
            }else if(i > selected){
                $("#btn-step-" + i ).removeClass("btn-success");
                $("#btn-step-" + i ).addClass("btn-default");
            }
        }
        
        setStep(selected);
    });

    allNextBtn.click(function () {
        // var curStep = $(this).closest(".setup-content"),
        //     curStepBtn = curStep.attr("id"),
        //     nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
        //     curInputs = curStep.find("input[type='text'],input[type='url']"),
        //     isValid = true;

        // $(".form-group").removeClass("has-error");
        // for (var i = 0; i < curInputs.length; i++) {
        //     if (!curInputs[i].validity.valid) {
        //         isValid = false;
        //         $(curInputs[i]).closest(".form-group").addClass("has-error");
        //     }
        // }

        // if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');
        let nextBtn = getStep();
        nextBtn++;
        // console.log(nextBtn);
        $("#btn-step-" + nextBtn).trigger("click");
    });

    allBackBtn.click(function () {
        let nextBtn = getStep();
        nextBtn--;
        // console.log(nextBtn);
        $("#btn-step-" + nextBtn).trigger("click");
    });

    //$('div.setup-panel div a.btn-success').trigger('click');

    $(".panel-default").show();

    $(".seleccion_plan").click(function(){
        $("#usuarios-plan_id").val( $(this).attr("plan-id") );
        $(".plan_seleccionado").html( "Plan seleccionado: " + $(this).attr("plan-nombre") );
        $(".plan_seleccionado").show();
    });

    // $("#usuario-tipo-cuenta").click(function(e)){
    //     if(e.val() ==)
    // }
});

function saveForm(){
    var el = document.querySelector("form[action='/registro/asociado']");
    var inputs = el.querySelectorAll("input:not(#usuarios-clave):not(#confirmar_clave), select");

    for(var i = 1; i<inputs.length; i++){
        if(inputs[i].value != "" && inputs[i] != undefined){
            sessionStorage.setItem(inputs[i].id, inputs[i].value)
        }
    }

    Swal.fire({
        type: "success",
        title: "Datos guardados",
        html: "<p>Tus datos de registro han sido guardados.</p><p><b>Recuerda!</b><br/> Por seguridad, las imágenes y claves solo se guardarán cuando llenes todo el registro y estes listo para enviar el formulario.</p>"
    });

}

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

    // $(document).ready(function(){
    //     $(".btn-step").click(function(e){
            // alert("Hola mundo!");
            // e.preventDefault();
            // e.stopPropagation();
            
            // var empty = true;

            // var num = $(this).attr("data-step");
            // for(var i = 1; i<num; i++){
            //     $("#btn-step-" + num ).removeClass("btn-normal");
            //     $("#btn-step-" + num ).addClass("btn-success");
            // }

            // $('#step-' + navStep + ' input[aria-required=true], #step-' + navStep + ' select[aria-required=true], step-' + navStep + ' #usuarios-numero_celular').each(function(){
            // if($(this).val()!=""){
            //     empty =false;
            //     }
            // });

            // if(empty){
            //     // Swal.fire(
            //     //     'Alerta!',
            //     //     'Aún tiene campos vacíos por llenar.',
            //     //     'error'
            //     // );
            //     //throw new Error();
            // }
    //     });
    // });

    $("#servicios-wrapper").on("click", ".btn_add_service", function(){
        var srvID = $(this).attr("data-srv");
        var srvName = $(this).attr("data-name");
        var srvCatID = $(this).attr("data-cat");

        if(!(arrCat.includes(srvCatID))){
            arrCat.push(srvCatID);
            $("#usuarios-categorias").val(arrCat);
        };
        if(!(arrServ.includes(srvID))){
            arrServ.push(srvID);
            $("#usuarios-servicios").val(arrServ);
            Swal.fire(
                'Servicio Agregado!',
                'Has añadido el servicio a tu lista!',
                'success'
            );
            $("#servicios-agregados").append("<div class='label label-primary label-servicios' data-cat='" + srvCatID + "' data-srv='" + srvID + "'>" + srvName + "<span class='delete-service' data-srv='" + srvID + "'>x</span></div>")
        }else{
            Swal.fire(
                'Información!',
                'Este servicio ya fue agregado!',
                'error'
            );
        };


    });

    $("#servicios-agregados").on("click", ".delete-service", function(){
        let srvID = $(this).attr("data-srv");
        let newCatArr = [];
        $(".label-servicios[data-srv='" + srvID + "']").fadeOut();
        $(".label-servicios[data-srv='" + srvID + "']").remove();
        for( var i = 0; i < arrServ.length; i++){ 
            if ( arrServ[i] === srvID) {
                arrServ.splice(i, 1); 
            }
         }
        $("#usuarios-servicios").val(arrServ);

        $(".label-servicios").each(function(ind, val){ 
             newCatArr[ind] = $(val).attr("data-cat");  
        });

        arrCat = [];

        $.each(newCatArr, function(i, el){
            if($.inArray(el, arrCat) === -1) arrCat.push(el);
        });

        $("#usuarios-categorias").val(arrCat);

    });

    $(".cat-item").on("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        $(".cat-item").removeClass("active");
        $( this ).addClass("active");
        // loader.id="ajax-loader-obj";
        var loaders = document.getElementsByClassName("loader-wrapper");
        [].forEach.call(loaders, function(loaders){
            var loader = document.createElement("div");
            loader.className="ajax-loader-obj";
            loaders.appendChild(loader);
        });
        // selCat = $(this).attr("data-id");
        $.ajax({
            method:"POST",
            url:"/ajax/listadoservicios",
            data:{depdrop_parents: $(this).attr("data-id")},
            complete:function(rs){
                $(".ajax-loader-obj").remove();
                var json = JSON.parse(rs.responseText);
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
                        el.setAttribute("data-name", obj[k].nombre);
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
                $('html, body').animate({
                    scrollTop: $("#seccion-servicios").offset().top
                }, 1500);
            }
        });
    });

})(jQuery);