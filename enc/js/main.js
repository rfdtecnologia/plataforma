$(document).ready(function() {
  $('.type_2').each(function() {
    var RowIndex = $(this).prop('id').split('-')[1];
      for (var i = 1; i <= RowIndex; i++) {
        if($(this).prop('id') == 'type-'+RowIndex){
          $(this).css('display', 'none');
        }
      }
  });
  $('.input_radio').on('change',function(event) {
    event.preventDefault();
    $('.sub_r').removeClass('active');
    $(this).closest('div').removeClass();
    var respuesta_id = $(this).val().split('_')[0];
    var pregunta_id_aux = $(this).attr('name').split('[')[1];
    var pregunta_id = pregunta_id_aux.split(']')[0];
    $(this).closest('div').addClass('col-sm-8 nueva_'+respuesta_id+pregunta_id);
    var id_div_content = $(this).closest('.panel-body').attr('id')
      var id_div_type = $(this).closest('.form-group').attr('id');
      var no_hidden = id_div_type.split('-')[1];
      $.ajax({
      url: 'sub_p_enc.php',
      type: 'POST',
      dataType: 'html',
      data: {res_id: respuesta_id,
            preg_id: pregunta_id}
    })
    .done(function(msje) {
        var secuencia_grupo_aux = msje.split('gid_ynam')[1];
        var secuencia_grupo = secuencia_grupo_aux.split('sec_ynam')[0];
        var secuencia_pregunta = msje.split('sec_ynam')[1];
        var to_print = msje.split('gid_ynam'+ secuencia_grupo+'sec_ynam'+secuencia_pregunta);
      if (msje != '') {
        $('.nueva_'+respuesta_id+pregunta_id+' .sub_r').addClass('active');
      }
      $('.nueva_'+respuesta_id+pregunta_id+' .sub_r').html(to_print);
    
      switch(secuencia_grupo) {
        case '1':
        switch(secuencia_pregunta){
            case '1':
              muestra(id_div_content, no_hidden, 'block', 'removeClass');
            break;
            case '2':
              muestra(id_div_content, no_hidden, 'none', 'addClass');
            break;
          }
        break;
        case '2':
        switch(secuencia_pregunta){
            case '3':
                desabilita(id_div_content, no_hidden, 'deshabilita');
            break;
            case '4':
                desabilita(id_div_content, no_hidden, 'habilita');
            break;
          }
        break;
        default:
        console.log('Secuencia Grupo'+secuencia_grupo); 
      }
    });
  });
    var muestra = function (div_content, no_ocultar, mostrar, valida) {//para encuesta de satisfacción
        var content = '#'+div_content + ' .form-group';
        $(content).each(function () {
            var RowIndex = $(this).prop('id').split('-')[1];
            var content_quitar_check = content + '#type-' + RowIndex;
            if (RowIndex > no_ocultar){
                $(this).css('display', mostrar);
                if (valida == 'addClass'){
                    $(content_quitar_check+' div input:radio').addClass('no_read');
                    $(content_quitar_check+' div input:radio').prop('checked' , false);
                    if ($(content_quitar_check+' div textarea').length) {
                        $('textarea').val('');
                    }
                }else if (valida == 'removeClass' ){
                    $(content_quitar_check+' div input:radio').removeClass('no_read');
                }
            }
        });
    }
    var desabilita = function (div_content, no_ocultar, accion) {
        var content = '#'+div_content + ' .form-group';
        $(content).each(function () {
            var RowIndex = $(this).prop('id').split('-')[1];
            var content_quitar_check = content + '#type-' + RowIndex;
            if (accion === 'deshabilita'){
                if (RowIndex != no_ocultar) {
                    $(content_quitar_check+' div :radio').prop('disabled', true);
                    $(content_quitar_check+' div :radio').prop('checked' , false);
                    $(content+' div input').addClass('no_read');
                    $(content_quitar_check+' div label').addClass('lbl_disabled');
                }
            }else if(accion === 'habilita'){
                $(content_quitar_check+' div :radio').prop('disabled', false);
                $(content_quitar_check+' div :radio').prop('checked' , false);
                $(content+' div input').removeClass('no_read');
                $(content_quitar_check+' div label').removeClass('lbl_disabled');

            }
        });
    }
  $('#btn_send').on('click', function(event) {
    event.preventDefault();
    var error = 0;
    $('.form-group').removeClass('error');
    $('select').each(function() {
      var valor = $(this).val();
      if (valor == 0) {
        $(this).closest('.form-group').addClass('error');
        error = error + 1;
      }
    });
    var nombre_input = '';
    $('input').each(function() {
      nombre_input = $(this).attr('name');
      if (!$('input[name="'+nombre_input+'"]').is(':checked') && !$('input[name="'+nombre_input+'"]').hasClass('no_read')) {
        $(this).closest('.form-group').addClass('error');
        error = error + 1;
      }
    });
    if ($('textarea').val() == '') {
      $('textarea').closest('.form-group').addClass('error');
      error = error + 1;
    }
    if (error > 0) {
      alert('Todas las preguntas son obligatorias');
      return false;
    }else {
      $("form#form_enviar").submit();
    }
  });
});

