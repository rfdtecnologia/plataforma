$(document).ready(function() {
    var curso, curso_cert, curso_fact;
    var curso_id;
    var combos = ['cargo', 'genero', 'est_participacion', 'tip_certificado', 'entr_certificado'];
    $('#curso').change(function() {
      /* Act on the event */
        $('.table tbody').html("<tr><th colspan='10'></th></tr>");
        curso = $(this).val();
        curso_id = curso;
        $.ajax({
            url: 'functions/dynamic_query.php',
            type: 'POST',
            //dataType: 'json',
            data: {evento: curso_id}
        })
            .done(function(resp) {
                json = $.parseJSON(resp);
                if (json.length == 0) {
                    $('.table tbody').html("<tr><th colspan='10'><div class='alert alert-warning' role='alert'>NO SE HAN REGISTRADO PARTICIPANTES</div></th></tr>");
                    $('.actions_b').css('display', 'none');
                }else {
                    for(var i=0;i<json.length;i++){
                        var c = (json[i].celular_p.trim() == '') ? '-'  : json[i].celular_p.trim();
                        var e = (json[i].correo_p.trim() == '') ? '-'  : json[i].correo_p.trim();
                        var num = i+1;
                        $('.table tbody').append("<tr><td><input type='checkbox' value='a"+i+"'></td><td>"+num+"</td><td class='no_change' data-campo='n_organizacion'><span>"+json[i].n_organizacion+"</span></td><td class='editable' data-campo='apellido_p'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span class='val_edit'>"+json[i].apellido_p+"</span></td><td class='editable' data-campo='nombre_p'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span class='val_edit'>"+json[i].nombre_p+"</span></td><td class='participante_id no_change' data-campo='participante_id' id='participante_id_"+i+"'><span>"+json[i].participante_id+"</span></td><td class='editable' data-campo='cargo'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span class='val_edit'>"+json[i].desc_cargo+"</span></td><td class='editable' data-campo='genero'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span class='val_edit'>"+json[i].genero_p+"</span></td><td class='editable' data-campo='correo_p'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span class='val_edit'>"+e+"</span></td><td class='editable' data-campo='celular_p'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span class='val_edit'>"+c+"</span></td><td class='no_change' data-campo='fecha_r'><span>"+json[i].fecha_r+"</span></td></tr>");
                    }
                    $('.actions_b').css('display', 'block');
                }
            });
    });
    var td,campo,valor,id;
    $(document).on("click","td.editable span.val_edit",function(e){
        e.preventDefault();
        $(".actions_b button").prop('disabled', true);
        $("td:not(.no_change)").removeClass("editable");
        $("td").addClass('disabled');
        td=$(this).closest("td");
        campo=$(this).closest("td").data("campo");
        valor=$(this).text();
        id=$(this).closest("tr").find(".participante_id").text();
        for (var i = 0; i < combos.length; i++) {
            if (campo == combos[i]) {
                $.ajax({
                    url: 'functions/'+campo+'.php',
                    type: 'POST',
                    data: {area: valor}
                })
                    .done(function(resp) {
                        td.text("").html("<select class='"+campo+"' name='"+campo+"'>"+resp+"</select><div class='actions_b_u'><button type='button' class='btn btn-default btn-xs enlace guardar'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></button><button type='button' class='btn btn-default btn-xs enlace cancelar'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button></div>");
                    });
            }else{
                td.text("").html("<input type='text' name='"+campo+"' value='"+valor+"'><div class='actions_b_u'><button type='button' class='btn btn-default btn-xs enlace guardar'><span class='glyphicon glyphicon-ok' aria-hidden='true'></span></button><button type='button' class='btn btn-default btn-xs enlace cancelar'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></button></div>");
            }
        }
    });
    $('#curso_cert').change(function() {
      /* Act on the event */
        $('.table tbody').html("<tr><th colspan='10'></th></tr>");
        curso_cert = $(this).val();
        curso_id = curso_cert;
        $.ajax({
            url: 'functions/dynamic_query_cert.php',
            type: 'POST',
            //dataType: 'json',
            data: {evento: curso_id}
        })
            .done(function(resp) {
                json = $.parseJSON(resp);
                if (json.length == 0) {
                    //$('.table tbody').html("<tr><th></th><th>ORGANIZACION</th><th>APELLIDOS</th><th>NOMBRES</th><th>CÉDULA</th><th>ESTADO PARTICIPACIÓN</th><th>TIPO CERTIFICADO</th><th>ENTREGA CERTIFICADO</th>");
                    $('.table tbody').html("<tr><th colspan='10'><div class='alert alert-warning' role='alert'>NO SE HAN REGISTRADO PARTICIPANTES</div></th></tr>");
                }else {
                    for(var i=0;i<json.length;i++){
                        var num = i+1;
                        $('.table tbody').append("<tr><td>"+num+"</td><td class='no_change' data-campo='n_organizacion'><span>"+json[i].n_organizacion+"</span></td><td class='no_change' data-campo='apellido_p'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span>"+json[i].apellido_p+"</span></td><td class='no_change' data-campo='nombre_p'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span>"+json[i].nombre_p+"</span></td><td class='participante_id no_change' data-campo='participante_id' id='participante_id_"+i+"'><span>"+json[i].participante_id+"</span></td><td class='editable' data-campo='est_participacion'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span class='val_edit'>"+json[i].est_participacion+"</span></td><td class='editable' data-campo='tip_certificado'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span class='val_edit'>"+json[i].tip_certificado+"</span></td><td class='editable' data-campo='entr_certificado'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span class='val_edit'>"+json[i].entr_certificado+"</span></td></tr>");
                    }
                    $('.actions_b').css('display', 'block');
                }
            });
    });
    $('#curso_fact').change(function() {
      /* Act on the event */
        $('.table tbody').html("<tr><th colspan='10'></th></tr>");
        curso_fact = $(this).val();
        curso_id = curso_fact;
        $.ajax({
            url: 'functions/dynamic_query_fact.php',
            type: 'POST',
            //dataType: 'json',
            data: {evento: curso_id}
        })
            .done(function(resp) {
                json = $.parseJSON(resp);
                if (json.length == 0) {
                    //$('.table tbody').html("<tr><th></th><th>ORGANIZACION</th><th>APELLIDOS</th><th>NOMBRES</th><th>CÉDULA</th><th>ESTADO PARTICIPACIÓN</th><th>TIPO CERTIFICADO</th><th>ENTREGA CERTIFICADO</th>");
                    $('.table tbody').html("<tr><th colspan='10'><div class='alert alert-warning' role='alert'>NO SE HAN REGISTRADO PARTICIPANTES</div></th></tr>");
                }else {
                    for(var i=0;i<json.length;i++){
                        var num = i+1;
                        var  n_factura = (json[i].num_factura.trim() == '') ? '-'  : json[i].num_factura.trim();
                        $('.table tbody').append("<tr><td>"+num+"</td><td class='no_change' data-campo='n_organizacion'><span>"+json[i].n_organizacion+"</span></td><td class='no_change' data-campo='apellido_p'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span>"+json[i].apellido_p+"</span></td><td class='no_change' data-campo='nombre_p'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span>"+json[i].nombre_p+"</span></td><td class='participante_id no_change' data-campo='participante_id' id='participante_id_"+i+"'><span>"+json[i].participante_id+"</span></td><td class='editable' data-campo='num_factura'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span class='val_edit'>"+n_factura+"</span></td><td class='editable' data-campo='val_factura'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span class='val_edit'>"+json[i].val_factura+"</span></td></tr>");
                    }
                    $('.actions_b').css('display', 'block');
                }
            });
    });
    $(document).on("click",".cancelar",function(e){
        e.preventDefault();
        $(".actions_b button").prop('disabled', false);
        td.html("<span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span class='val_edit'>"+valor+"</span>");
        $("td:not(.no_change)").addClass("editable");
        $("td").removeClass('disabled');
    });
    $(document).on("click",".guardar",function(e){
        e.preventDefault();
        $(".actions_b button").prop('disabled', false);
        nuevovalor = $(this).closest("td").find("input, select").val();
        var texto_combo = $(this).closest("td").find("select option:selected").text();
        if(nuevovalor.trim() != "" || nuevovalor != 0){
            $.ajax({
                type: "POST",
                url: "functions/save.php",
                dataType: "HTML",
                data: { campo: campo, valor: nuevovalor, id:id, evento: curso_id}
            })
                .done(function(msg) {

                    for (var i = 0; i < combos.length; ++i) {
                        if (campo == combos[i]) {
                            td.html("<span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span class='val_edit'>"+texto_combo+"</span>");
                            break;
                        }else {
                            td.html("<span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span class='val_edit'>"+nuevovalor+"</span>");
                        }
                    }
                    $("td:not(.no_change)").addClass("editable");
                    $("td").removeClass('disabled');
                    setTimeout(function() {$('.ok,.ko').fadeOut('fast');}, 3000);
                });
        }else $(".mensaje").html("<p class='ko'>Debes ingresar un valor</p>");
    });
    $('#btn_borrar').on('click', function(event) {
        event.preventDefault();
        if (confirm("Seguro que desea eliminar el registro") == true) {
            $('tr input').each(function() {
                var row = $(this).val().split('a')[1];
                if ($(this).prop('checked')) {
                    var id_p = $(this).closest("tr").find("td#participante_id_"+row+" span").text();

                    $('.table tbody').html("<tr><td colspan='10'></td></tr>");
                    $.ajax({
                        url: 'functions/delete.php',
                        type: 'POST',
                        //dataType: 'json',
                        data: {evento: curso_id, valor: id_p}
                    })
                        .done(function(resp) {
                            json = $.parseJSON(resp);
                            $(".mensaje").html("<p class='ok'>Registro(s) eliminado(s) con &Eacute;xito</p>");
                            if (json.length == 0) {

                                $('.table tbody').html("<tr><th colspan='10'><div class='alert alert-warning' role='alert'>NO SE HAN REGISTRADO PARTICIPANTES</div></th></tr>");
                                $('.actions_b').css('display', 'none');
                            }else {
                                for(var i=0;i<json.length;i++){
                                    var c = (json[i].celular_p.trim() == '') ? '-'  : json[i].celular_p.trim();
                                    var e = (json[i].correo_p.trim() == '') ? '-'  : json[i].correo_p.trim();
                                    var num = i+1;
                                    $('.table tbody').append("<tr><td><input type='checkbox' value='a"+i+"'></td><td>"+num+"</td><td class='no_change' data-campo='n_organizacion'><span>"+json[i].n_organizacion+"</span></td><td class='editable' data-campo='apellido_p'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span class='val_edit'>"+json[i].apellido_p+"</span></td><td class='editable' data-campo='nombre_p'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span class='val_edit'>"+json[i].nombre_p+"</span></td><td class='participante_id no_change' data-campo='participante_id' id='participante_id_"+i+"'><span>"+json[i].participante_id+"</span></td><td class='editable' data-campo='cargo'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span class='val_edit'>"+json[i].desc_cargo+"</span></td><td class='editable' data-campo='genero'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span class='val_edit'>"+json[i].genero_p+"</span></td><td class='editable' data-campo='correo_p'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span class='val_edit'>"+e+"</span></td><td class='editable' data-campo='celular_p'><span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span><span class='val_edit'>"+c+"</span></td><td class='no_change' data-campo='fecha_r'><span>"+json[i].fecha_r+"</span></td></tr>");
                                }
                                $('.actions_b').css('display', 'block');
                            }
                            setTimeout(function() {$('.ok,.ko').fadeOut('fast');}, 3000);
                        });
                }
            });
        }
    });
});
