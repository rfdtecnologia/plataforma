$(document).ready(function() {
  var error = '';
  var autocompletar = new Array();
  var consulta = '';
  var id_organizacion = 0;
  var tipo = '';
  var c_ruc = '';
  var num = 0;

  $("#nombre_institucion").prop('disabled', true);
  $("#ruc_institucion").prop('disabled', true);
  $('#btnDel').attr('disabled','disabled');

  $("#tipo_organizacion").on('change',function(event) {//activa el campo buscar por nombre de institución o RUC al cambiar
    event.preventDefault();
    limpiar('#nombre_institucion');
    limpiar('#ruc_institucion');
    tipo = $(this).val();
    if (tipo > -1) {
      if ($('#ruc_i').hasClass('active') || $('#nombre_i').hasClass('active')) {//según la pestaña que está activa, habilita el input
        $("#ruc_institucion").prop('disabled', false);
        $("#nombre_institucion").prop('disabled', false);
      }
    }else {//Desabilita los input cuando las pestañas no están activas
      $("#nombre_institucion").prop('disabled', true);
      $("#ruc_institucion").prop('disabled', true);
    }
  });

  $('#serarch_for a').on('click',function(event) {//al hacer clic en cada pestaña quito la clase requerido de los input
    event.preventDefault();
    $("#content_name input").each(function() {
      $(this).removeClass('required');
    });
    var camp_requerido = $(this).attr('alt');//tomo el valor de "alt" de la pestaña (que se hace clic) que tiene el mismo valor de la id del input respectivo
    $('#'+camp_requerido).addClass('required');//a ese input, agregamos la clase 'required'
  });

  $('#ruc_institucion').on('focusin',function(event) {//borro el contenido del nombre de la instirución cuando toma el foco el campo de RUC
    event.preventDefault();
    if ($('#ruc_i').hasClass('active')) {
      $('#nombre_institucion').val('');
    }
  });
  $('#nombre_institucion').on('focusin',function(event) {//borro el contenido del RUC cuando toma el foco el campo de nombre de institución
    event.preventDefault();
    if ($('#nombre_i').hasClass('active')) {
      $('#ruc_institucion').val('');
    }
  });

  $('#nombre_institucion').on('keyup',function(event) {//realiza la consulta en la base de datos según las letras que se va ingresando en el input nombre de la institución
    event.preventDefault();
    var nom_institucion = $(this).val();
    if($('#nombre_i').hasClass('active')){//defino el tipo de consulta que se hace
      consulta = 'nombre';
    }
    $.ajax({
      url: 'functions/consultas.php',
      type: 'POST',
      dataType: 'html',
      data: {tipo_organizacion: tipo,
        tipo_consulta: consulta,
        i_letras: nom_institucion}
    })
    .done(function(resp) {
      $("#content_name_option").css('display', 'block');
      var cadena = resp.split("\t");
      var aux = '';
      for (var i = 0; i < (cadena.length)-1; i = i+2) {
        aux += '<li alt="'+ cadena[i+1] +'">'+cadena[i]+'</li>';
        $('#content_name_option').html(aux);//lleno con los resultados de la consulta
      }
      $("#content_name_option li").mouseover(function(){//recorriendo el resultado de los nombres con el mouse
        $(this).addClass('selected');//agrego la clase 'selected' a c/elemento del resultado de la busqueda por dónde paso el mouse
        $(this).click(function(event) {//en el item q hago clic:
          var nam_selected = $(this).text();//tomo el nombre
          id_organizacion = $(this).attr('alt');//tomo el valor de 'id_organizacion'
          $('#nombre_institucion').val(nam_selected);//pongo en el campo 'nombre de institucion' el valor seleccionado
          $('#nombre_institucion').focus();//le doy el foco al campo 'nombre de institucion'
          $("#content_name_option").css('display', 'none');//oculto el cuadro que muestra los resultados
          $('#content_name_option').html('');//vacío el cuadro que muestra los resultados
        });
      });
      $("#content_name_option li").mouseout(function(){
        $(this).removeClass('selected');
      });
    });
  });

  $('#nombre_institucion').on('focusout',function(event) {//cuando pierde el foco el campo 'nombre_institucion', lleno los datos de facturación
    event.preventDefault();
    if($('#nombre_i').hasClass('active')){
      consulta = 'organizacion';
    }
    $.ajax({
      url: 'functions/consultas.php',
      type: 'POST',
      dataType: 'html',
      data: {id_organizacion: id_organizacion,
        tipo_consulta: consulta}
    })
    .done(function(resp) {
      var cadena = resp.split("\t");
      if (cadena[0] != 'No hay datos') {
        $('#nombre_f').val(cadena[0]);
        $('#cedula_f').val(cadena[1]);
        $('#direccion_f').val(cadena[2]);
        $('#telefono_f').val(cadena[3]);
        $('#id_org').val(id_organizacion);
      }
    });
  });

  $('#ruc_institucion').on('focusout', function(event) {//cuando pierde el foco el campo RUC, se realiza la consulta a la base y se llena los campos de facturación
    event.preventDefault();
    $('#ruc_i .form-group').removeClass('has-error');
    c_ruc = $(this).val();
    if (c_ruc.length != 0){
      if($('#ruc_i').hasClass('active')){
        consulta = 'ruc';
        $.ajax({
          url: 'functions/consultas.php',
          type: 'POST',
          dataType: 'html',
          data: {ruc:c_ruc,
            tipo_consulta: consulta}
        })
        .done(function(resp) {
          var cadena = resp.split("\t");
          if (cadena[0] == 'No hay datos') {
            $('#ruc_i .form-group').addClass('has-error');
          }else {
            $('#ruc_i .form-group').removeClass('has-error');
            $('#nombre_f').removeClass('error').val(cadena[0]);
            $('#cedula_f').removeClass('error').val(cadena[1]);
            $('#direccion_f').removeClass('error').val(cadena[2]);
            $('#telefono_f').removeClass('error').val(cadena[3]);
          }
        });
      }
    }
  });

  $('#a_nombre_f_1').on('change', function(event) {//cuando selecciono 'factura a nombre de la institución' lleno los campos con los de la institución seleccionada anteriormente
    event.preventDefault();
    $('.error_message p').remove();
    $('.error_message').css('display', 'none');
    var campos = ["#nombre_f", "#cedula_f", "#direccion_f", "#telefono_f"];
    $(campos).each(function(i) {
      $(campos[i]).prop('readonly', true);
      $(campos[3]).removeClass('validar');
    });
    if (consulta = 'organizacion') {//según como se haya buscado la institución, si es por nombre o por ruc
      $.ajax({
        url: 'functions/consultas.php',
        type: 'POST',
        dataType: 'html',
        data: {id_organizacion: id_organizacion,
          tipo_consulta: consulta}
      })
      .done(function(resp) {
        var cadena = resp.split("\t");
        if (cadena[0] != 'No hay datos') {
          $('#nombre_f').removeClass('error').val(cadena[0]);
          $('#cedula_f').removeClass('error').val(cadena[1]);
          $('#direccion_f').removeClass('error').val(cadena[2]);
          $('#telefono_f').removeClass('error').val(cadena[3]);
        }
      });
    }else{
      if (consulta = 'ruc') {//según como se haya buscado la institución, si es por nombre o por ruc
        $.ajax({
          url: 'functions/consultas.php',
          type: 'POST',
          dataType: 'html',
          data: {ruc:c_ruc,
            tipo_consulta: consulta}
        })
        .done(function(resp) {
          var cadena = resp.split("\t");
          if (cadena[0] != 'No hay datos'){
            $('#ruc_i .form-group').removeClass('has-error');
            $('#nombre_f').removeClass('error').val(cadena[0]);
            $('#cedula_f').removeClass('error').val(cadena[1]);
            $('#direccion_f').removeClass('error').val(cadena[2]);
            $('#telefono_f').removeClass('error').val(cadena[3]);
          }
        });
      }
    }
  });
  $('#a_nombre_f_2').on('change', function(event) {//cuando selecciono 'factura a nombre de otro' limpio los campos
    event.preventDefault();
    var campos = ["#nombre_f", "#cedula_f", "#direccion_f", "#telefono_f"];
    $(campos).each(function(i) {
      $(campos[i]).prop('readonly', false);
      $(campos[3]).addClass('validar');
      limpiar(campos[i]);
    });
    $('.error_message p').remove();
    $('.error_message').css('display', 'none');
  });

  $('#btnAdd').click(function() {//añadir campos dinámicamente
    num = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
    var newNum = new Number(num + 1); // the numeric ID of the new input field being added
    // create the new element via clone(), and manipulate it's ID using newNum value
    if (num % 2 == 0) {//para poner fondo a los pares
      var newElem = $('#input' + num).clone().attr('id', 'input' + newNum).addClass('new_camp');
    }
    else{
      var newElem = $('#input' + num).clone().attr('id', 'input' + newNum).removeClass('new_camp');
    }
    // manipulate the name/id values of the input inside the new element
    newElem.find('div').removeClass('has-error');
    newElem.find('label').css('display', 'none');
    newElem.find('input').removeClass('error');
    newElem.find('.form-control1').attr('id', 'cedula_p-' + newNum ).attr('name', 'cedula_p[]').prop('required', 'true').val('');
    newElem.find('.form-control2').attr('id', 'apellido_p-' + newNum ).attr('name', 'apellido_p[]' + newNum).prop('required', 'true').val('');
    newElem.find('.form-control3').attr('id', 'nombre_p-' + newNum ).attr('name', 'nombre_p[]').prop('required', 'true').val('');
    newElem.find('.form-control4').attr('id', 'genero_p-' + newNum ).attr('name', 'genero_p[]').prop('required', 'true').val('F');
    newElem.find('.form-control5').attr('id', 'area_t_p-' + newNum ).attr('name', 'area_t_p[]').prop('required', 'true').val('');
    newElem.find('.form-control6').attr('id', 'correo_p-' + newNum ).attr('name', 'correo_p[]').val('');
    newElem.find('.form-control7').attr('id', 'telefono_c_p-' + newNum ).attr('name', 'telefono_c_p[]').val('');
    // insert the new element after the last "duplicatable" input field
    $('#input' + num).after(newElem);
    // enable the "remove" button
    $('#btnDel').attr('disabled',false);
    // business rule: you can only add 10 names
    if (newNum == 10)
    $('#btnAdd').attr('disabled','disabled');
  });
  $('#btnDel').click(function() {//borrar campos creados dinámicamente
    var num = $('.clonedInput').length; // how many "duplicatable" input fields we currently have
    $('#input' + num).remove(); // remove the last element
    // enable the "add" button
    $('#btnAdd').attr('disabled',false);
    // if only one element remains, disable the "remove" button
    if (num-1 == 1)
    $('#btnDel').attr('disabled','disabled');
  });

  $('#datos_personales').on('focusout', 'input', function() {//llenar campos de participantes, según la cedúla ingresada
    var RowIndex = $(this).prop('id').split('-')[1];
    if($(this).prop('id') == 'cedula_p-'+RowIndex){
      $(this).parent().removeClass('has-error');
      var cedula_p = $('#cedula_p-'+RowIndex).val();
      if (cedula_p.length != 0 && esCedula(cedula_p)) {
        consulta = 'c_participante';
        $.ajax({
          url: 'functions/consultas.php',
          type: 'POST',
          dataType: 'html',
          data: {cedula_participante: cedula_p,
            tipo_consulta: consulta}
        })
        .done(function(resp) {
          var cadena = resp.split("\t");
          if (cadena[0] != 'No hay datos') {
            $('#apellido_p-'+RowIndex).removeClass('error').val(cadena[0]);
            $('#nombre_p-'+RowIndex).removeClass('error').val(cadena[1]);
            $('#genero_p-'+RowIndex).removeClass('error').val(cadena[2]);
            $('#area_t_p-'+RowIndex).removeClass('error').val(cadena[3]);
            $('#correo_p-'+RowIndex).removeClass('error').val(cadena[4]);
            $('#telefono_c_p-'+RowIndex).removeClass('error').val(cadena[5]);
          }
        });
      } else {
        $(this).parent().addClass('has-error');
        //error += "Ingrese el número de cédula del participante que está registrando";
      }
    }
  });

  $('#datos_personales').on('focusin', 'input', function() {//limpiar los campos de participantes cuando toma el focos
    var RowIndex = $(this).prop('id').split('-')[1];
    if($(this).prop('id') == 'cedula_p-'+RowIndex){
      limpiar('#apellido_p-'+RowIndex);
      limpiar('#nombre_p-'+RowIndex);
      $('#genero_p-'+RowIndex).val('F');
      $('#area_t_p-'+RowIndex).val('');
      limpiar('#correo_p-'+RowIndex);
      limpiar('#telefono_c_p-'+RowIndex);
    }
  });
  //----VALIDACIONES----
  $('#tipo_organizacion').change(function(event) {//cuando cambie el valor en tipo de organización, limpiar los campos de facturación
    var campos = ["#nombre_f", "#cedula_f", "#direccion_f", "#telefono_f"];
    $(campos).each(function(i) {
      limpiar(campos[i]);
    });
  });

  $("#formulario_principal").validate({
    rules:{
      nombre_institucion:{
        required: true
      },
      pers_conta_f:{
        required: true
      },
      cedula_f:{
        digits: true,
        minlength: 10,
        maxlength: 13
      }
    },
    messages:{
      nombre_institucion:{
        required: "Campo requerido",
      },
      pers_conta_f:{
        required: "Campo requerido",
      },
      cedula_f:{
        digits: "Ingrese un número de CI o RUC válido",
        minlength: $.validator.format("Ingrese un número de CI o RUC válido"),
        maxlength: $.validator.format("Ingrese un número de CI o RUC válido")
      }
    }
  });

  $('#formulario_principal').on('focusout', 'input', function() {
    var RowIndex = $(this).prop('id').split('-')[1];
    if($(this).prop('id') == 'cedula_p-'+RowIndex){
      $(this).rules("add", {
        required: true,
        digits: true,
        minlength: 10,
        maxlength: 10,
        messages: {
          required: "Campo requerido",
          digits: "Ingrese sólo números",
          minlength: $.validator.format("Ingrese un número de cédula válido"),
          maxlength: $.validator.format("Ingrese un número de cédula válido")
        }
      });
    }
    if($(this).prop('id') == 'apellido_p-'+RowIndex){
      $(this).rules("add", {
        required: true,
        minlength: 2,
        messages: {
          required: "Campo requerido",
          minlength: $.validator.format("Ingrese un apellido válido")
        }
      });
    }
    if($(this).prop('id') == 'nombre_p-'+RowIndex){
      $(this).rules("add", {
        required: true,
        minlength: 2,
        messages: {
          required: "Campo requerido",
          minlength: $.validator.format("Ingrese un nombre válido")
        }
      });
    }
    if($(this).prop('id') == 'correo_p-'+RowIndex){
        var formato_correo = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
        if ($(this).val()!='' && !formato_correo.test($.trim($(this).val()))) {
          $(this).addClass('error');
        }else {
          $(this).removeClass('error');
        }
    }
    if($(this).prop('id') == 'telefono_c_p-'+RowIndex){
      $(this).rules("add", {
        digits: true,
        minlength: 10,
        maxlength: 10,
        messages: {
          digits: "Ingrese sólo números",
          minlength: $.validator.format("Ingrese un número de celular válido"),
          maxlength: $.validator.format("Ingrese un número de celular válido")
        }
      });
    }
  });


  $('#guardar').on('click',function(event) {
    event.preventDefault();
    var contador_errores = 0;
    error='';
    $('.error_message').css('display', 'none');;
    $('.error_message p').remove();
    $('#formulario_principal input').each(function() {
      $(this).removeClass('error');
      if ($(this).hasClass('required') && $(this).val() == '') {
        contador_errores++;
        $(this).addClass('error');
      }
      if ($(this).hasClass('validar') && $(this).prop('id') == 'telefono_f') {
        var es_digito = /^\d+$/;
        if ($(this).val() !='' && !es_digito.test($.trim($(this).val()))) {
          contador_errores++;
          $(this).addClass('error');
          $('.error_message').css('display', 'block').append('<p>Ingrese sólo números</p>');
        }
      }
    });
    $('#formulario_principal select').each(function() {
      $(this).removeClass('error');
      if ($(this).hasClass('required') && ($(this).val() == '' || $(this).val() == '-1')) {
        //error += 'Los campos con (*) son obligatorios';
        contador_errores++;
        $(this).addClass('error');
      }
    });

    $('.clonedInput input').each(function() {
      var RowIndex = $(this).prop('id').split('-')[1];
      if ($(this).prop('id') == 'cedula_p-'+RowIndex) {
        $(this).removeClass('error');
        if (esCedula($(this).val())) {
          error = '';
        }else {
          $(this).addClass('error');
          error +='Verifique el número de cédula del Participante\n';
        }
      }
      if($(this).prop('id') == 'correo_p-'+RowIndex){
        $(this).removeClass('error');
          var formato_correo = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
          if ($(this).val() !='' && !formato_correo.test($.trim($(this).val()))) {
            error +='\nVerifique el correo del Participante ingresado';
            $(this).addClass('error');
          }
      }
    });
    if (contador_errores == 0) {
      $("form#formulario_principal").submit();

    }else {
      error += 'Los campos con (*) son obligatorios\n';
      if (error != '') {
        alert(error);
      }
    }
  });

  //-------FUNCIONES----------//
  function limpiar(campo){//funión para limpiar los campos
    $(campo).val('');
  }
  function esCedula (cedula){//función para validar la cédula
    array = cedula.split("");
    num=array.length;
    var provincia = "";
    var pares = "";
    var impares = "";
    sumatoria = 0;
    verificador=cedula.charAt(9);
    if (num=="10") {
      for (var i = 0; i <=1; i++) {
        provincia += parseInt(array[i]);
      };
      if (provincia > 0 && provincia<=24) {
        //digitos pares
        for (var i = 1; i < (num-1); i+=2) {
          pares += parseInt(array[i]);
        };
        //digitos impares
        for (var i = 0; i < (num-1); i+=2) {
          array[i]=((array[i]*2)>9)?((array[i]*2)-9):(array[i]*2);
          impares += parseInt(array[i]);
        };
        suma= pares+impares;
        array2 = suma.split("");
        long_array2 = array2.length;
        for (var i = 0; i <=(long_array2 - 1); i++) {
          sumatoria += parseInt(array2[i]);
        }
        //restamos de la decena superior
        //si la diferencia es cero el verificador es 0
        if(sumatoria%10==0 && sumatoria%10==verificador){
          return true;
        }else if ((10-(sumatoria%10))==verificador)
        {
          return true;
        }else{
          //error = "número de cédula incorrecto"
          return false;
        }
      }else{
        //error = "número de cédula incorrecto"
        return false;
      };
    }else{
      //error = "número de cédula incorrecto"
      return false;
    }
  }
  //-----------------//
});
