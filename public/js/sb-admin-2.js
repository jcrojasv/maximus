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
$.cargaSelect = function(url,div,cod)
{
  $.get(url,
    { id: cod },
    function(data) {

        $(div).empty();
        $(div).html(data);

    });
};

//Funcion para resetear campos de formulario
jQuery.fn.resetear = function () {
  $(this).find(':input').each(function(){
    var elemento = this;

     switch (elemento.type) 
     {
        case 'text':
            $(this).val('').removeAttr('checked');

         case 'checkbox':
         case 'radio':
            $(this).removeAttr('checked');

    }
   }); 
      
}

//funcion para llenar el formulario despues de una consulta via ajax 
jQuery.fn.llenarFormulario = function(arreglo){

    $(this).find(':input').each(function(){
        var elemento = this;
                
       
        switch (elemento.type) {
            case 'checkbox':
                if (arreglo[elemento.name] === true || arreglo[elemento.name] === 't' || arreglo[elemento.name] === 1){
                    elemento.checked = true;
                    elemento.value=true;
                }else{
                    elemento.value=false;
                }
                break;
            
            case 'radio':
                if (elemento.value === arreglo[elemento.name])
                    elemento.checked = true;
                break;
            case 'select-one':
                var lon = elemento.length;
                for (var i = 0; i < lon; i++) {
                    if (elemento.options[i].value === arreglo[elemento.name])
                    {
                        elemento.options[i].selected = true;
                        break;
                    }
                }
                break;

            default:
                elemento.value = '' + arreglo[elemento.name] + '';
        }
    });    
   
};
