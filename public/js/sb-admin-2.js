$(function() {

    $('#side-menu').metisMenu();

});

//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        topOffset = 50;
        width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    var element = $('ul.nav a').filter(function() {
        return this.href == url || url.href.indexOf(this.href) == 0;
    }).addClass('active').parent().parent().addClass('in').parent();
    if (element.is('li')) {
        element.addClass('active');
    }
});

//Funcion que me permite cargar un select dependiente
$.cargaSelect = function(url,div,cod,seleccionado)
{
  $.get(url,
    { id: cod , idSeleccionado: seleccionado},
    function(data) {

        $(div).empty();
        $(div).html(data);

    });
};

//Funcion para recargar el listado de mascotas-propietario
$.ajaxRenderSection = function(ruta,div) {

    $.get(ruta,null,function(data) {

        $(div).empty().append($(data));
            
            
    });
}

//Funcion generica que permite eliminar un registro desde un datatable
//Funcion para eliminar mascotas
jQuery.fn.eliminar = function() {
    var form = $('#frmDelete');
    var row  = $(this).parents('tr');
    var id   = $(this).data('id');
    var ruta = form.attr('action').replace(':ID',id);
    var data = form.serialize();

    if(confirm("Estas seguro de eliminar este registro?"))
    {
        $.ajax({
            url: ruta,
            type: 'post',
            dataType: 'json',
            data: data,
            
        }).done(function(respuesta){
            
            $('#pMensajes').html(' ');

            $('#divMensajes').removeClass('hidden').addClass('alert-success').fadeIn();

            $("#pMensajes").html('<strong>Yeah!!</strong> ' + respuesta.message);

            //Desvanezco el row
            row.fadeOut();

            
        }).fail(function(respuesta){

            var json = JSON.parse(respuesta.responseText);
            
            $('#pMensajes').html(' ');

            $('#divMensajes').removeClass('hidden').addClass('alert-danger').fadeIn();

            $("#pMensajes").html('<strong>Ooops!!</strong> ' + json.message);

        });
    }
};

//Funcion para editar renderizar el formulario de editar mascota
//Funcion para modificar mascota
    jQuery.fn.editar = function(propietario){
        var id = $(this).data('id');
        var ruta = "http://localhost:8000/mascota/"+id+"/edit";

        //lamado ajax metodo get para tomar el formulario
        $.get(ruta,{

            propietario : propietario,
            vista:        'mascota.forms.frmMascotaRenderListado',
        
        },function(data) {

            $('#divFrmMascota').empty().append($(data));
            
            //Muestro la ventana modal
            $('#ventanaModal').modal('toggle');

        }); 

    
    };

//Funcion para agregar o modificar mediante ajax
$.grabarRegistro = function(formulario,token){

    var form = $('#'+formulario);
    var ruta = form.attr('action');
    var data = form.serialize();
    
 
    $.ajax({
        url: ruta,
        headers: {'X-CSRF-TOKEN': token},
        type: 'post',
        dataType: 'json',
        data: data,
        beforeSend:  function(){
            $('span.help-block').addClass('hidden');
            $('div').removeClass('has-error');
        },

    }).done(function(respuesta) {

        //Recargo los datos en datatable para que muestre los cambios recientes
        $('#tabla').DataTable().ajax.reload();
        
        //Desvanecemos la ventana modal
        $('#ventanaModal').modal('hide');

        $('#mensaje').html(' ');

        $('#divMensajes').removeClass('hidden').addClass('alert-success').fadeIn();

        $("#pMensajes").html('<strong>Yeah!!</strong> ' + respuesta.message);


    }).fail(function(respuesta){

        $.each(respuesta.responseJSON,function (ind, elem) { 
        
            $('div.'+ind).removeClass('hidden').addClass('has-error');
            
            $('span.'+ind).removeClass('hidden');

            $('span.'+ind).html(' ');
            $('span.'+ind).html('<strong>'+elem+'</strong>');

        });
            

    });
}

