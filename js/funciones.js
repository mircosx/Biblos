function escaneaDB(quebuscas) {
    if(quebuscas.length == 0) {
        $('#coincidencias').hide();
    } else {
        $.post("rpc.php", {
            queryString: ""+quebuscas+""
        }, function(data){
            if(data.length >0) {
                $('#coincidencias').show();
                $('#listaCoincidenciasGenerada').html(data);
            }
        });
    }
} 

function rellenaNube(thisValue) {
    $('#quescribe').val(thisValue);
    setTimeout("$('#coincidencias').hide();", 200);
}

function cambiaInput(valor){
    document.formulario_consulta.quebuscas.defaultValue = valor
}

function grafica_filtro(valor) {
    if(document.getElementById) {
        var div1 = document.getElementById('oculto').style;
        var div2 =document.getElementById('oculto2').style;
        div1.display=valor;
        div2.display='none';
        return true;
    }
    return false;
}

function grafica_filtro2(valor) {
    if(document.getElementById) {
        var div1 = document.getElementById('oculto2').style;
        var div2 = document.getElementById('oculto').style;
        div1.display=valor;
        div2.display='none';
        return true;
    }
    return false;
}

function grafica_filtro_autor(valor) {
    if(document.getElementById) {
        var div1 = document.getElementById('oculto_autor').style;
        var div2 = document.getElementById('oculto_titulo').style;
        var div3 = document.getElementById('oculto_categoria').style;
        div1.display=valor;
        div2.display='none';
        div3.display='none';
        return true;
    }
    return false;
}

function grafica_filtro_titulo(valor) {
    if(document.getElementById) {
        var div1 = document.getElementById('oculto_autor').style;
        var div2 = document.getElementById('oculto_titulo').style;
        var div3 = document.getElementById('oculto_categoria').style;
        div2.display=valor;
        div1.display='none';
        div3.display='none';
        return true;
    }
    return false;
}

function grafica_filtro_categoria(valor) {
    if(document.getElementById) {
        var div3 = document.getElementById('oculto_categoria').style;
        div3.display=valor;
        div1.display='none';
        div2.display='none';
        return true;
    }
    return false;
}

function esconde_div() {
    grafica_filtro('none');
    grafica_filtro2('none');
    grafica_filtro_autor('none');
    grafica_filtro_titulo('none');
    grafica_filtro_categoria('none');
}

function esconde_filtros() {
    grafica_filtro('none');
    grafica_filtro2('none');
}
function validacampo(formulario){
    var poscursor=true;
    var frm = formulario;
    var cajatexto="";
    var errorm = "";
    var errorcamp= "";
    //var reac = A-z0-9-'.'-','-'-'-'('-')';
    //var ren = 0-9;
    for (i=0;i<frm.elements.length;i++){
        cajatexto = frm.elements[i];
        if ( cajatexto.className=="obligatorio" && cajatexto.value==""){
            //cajatexto.style.backgroundColor='#FFFF00';
            cajatexto.style.borderColor='#ff0000';
            
            errorcamp="Debe rellenar todos los campos con *"
            errorm = errorcamp
            if(poscursor==true){
                cajatexto.focus();
                poscursor=false;
            }
        }
        //else{
        //  if (!reac.test(cajatexto.value)) {
        //    cajatexto.style.backgroundColor='#FFFF00';
        //  cajatexto.style.borderColor='#ff0000';
        //  errorcamp="Ha introducido caracteres no validos";
        //if(errorcamp){
        //  errorm=errorm+" "+errorcamp;
        //}else {
        //  errorm=errorcamp;
        // }
        //cajatexto.value = cajatexto.value.replace (A-z0-9-'.'-','-'-'-'('-')');
        //if(poscursor==true){
        // cajatexto.focus();
        //poscursor=false;
        //}
        //}
            
        //else {
        //  if (cajatexto.className=="numerico" && !ren.test(cajatexto.value)) {
        //      cajatexto.style.backgroundColor='#FFFF00';
        //      cajatexto.style.borderColor='#ff0000';
        //      errorcamp="Ha introducido caracteres no validos";
        //      if(errorcamp){
        //       errorm=errorm+" "+errorcamp;
        //      }else {
        //          errorm=errorcamp;
        //      }
        //      cajatexto.value = cajatexto.value.replace(0-9);
        //      if(poscursor==true){
        //          cajatexto.focus();
        //          poscursor=false;
        //      }
        //  }
        else
        {
            cajatexto.style.backgroundColor='';
            cajatexto.style.borderColor='';
        }
    //   }
    //  }
    }    
    if(poscursor==false){
        alert (errorm);
        return false;
    }
    else
    {
        return true;
    }    
}

function solonumero(myfield, e, dec)
{
    var key;
    var keychar;

    if (window.event)
        key = window.event.keyCode;
    else if (e)
        key = e.which;
    else
        return true;
    keychar = String.fromCharCode(key);


    if ((key==null) || (key==0) || (key==8) || 
        (key==9) || (key==13) || (key==27) )
        return true;


    else if ((("0123456789").indexOf(keychar) > -1))
        return true;


    else if (dec && (keychar == "."))
    {
        myfield.form.elements[dec].focus();
        return false;
    }
    else
        return false;
    
}
function no_caracter_esp(myfield, e, dec)
{
    var key;
    var keychar;

    if (window.event)
        key = window.event.keyCode;
    else if (e)
        key = e.which;
    else
        return true;
    keychar = String.fromCharCode(key);


    if ((key==null) || (key==0) || (key==8) || 
        (key==9) || (key==13) || (key==27) )
        return true;


    else if ((("0123456789abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ-'-'-'('-')'-'.'-','-'-'").indexOf(keychar) > -1))
        return true;


    else if (dec && (keychar == "."))
    {
        myfield.form.elements[dec].focus();
        return false;
    }
    else
        return false;
    
}
