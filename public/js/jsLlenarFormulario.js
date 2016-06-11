
function llenarFormulario(formulario, arreglo)
{
    var elementos = document.getElementById(formulario).elements;

    for (var ii = 0; ii < elementos.length; ii++)
    {
       //var idx = jQuery.inArray(elementos[ii].name, arreglo);

        //if (idx !== -1) {

        switch (elementos[ii].type) {
            case 'checkbox':
                if (arreglo[idx] === true || arreglo[idx] === 't' || arreglo[idx] === 1){
                    elementos[ii].checked = true;
                    elementos[ii].value=true;
                }else{
                    elementos[ii].value=false;
                }
                break;
            
            case 'radio':
                if (elementos[ii].value === arreglo[idx])
                    elementos[ii].checked = true;
                break;
            case 'select-one':
                var lon = elementos[ii].length;
                for (var i = 0; i < lon; i++) {
                    if (elementos[ii].options[i].value === arreglo[idx])
                    {
                        elementos[ii].options[i].selected = true;
                        break;
                    }
                }
                break;

            default:
                elementos[ii].value = '' + arreglo[idx] + '';
        }
        }
    }

}
