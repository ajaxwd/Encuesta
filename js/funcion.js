
// ************************* FUNCION EMAIL ********************************
 
// Verifica que el email sea valido y no este vacio

function email (emailStr,msg) {

var emailPat=/^(.+)@(.+)$/
var specialChars="\\(\\)<>@,;:\\\\\\\"\\.\\[\\]"
var validChars="\[^\\s" + specialChars + "\]"
var firstChars=validChars
var quotedUser="(\"[^\"]*\")"
var ipDomainPat=/^\[(\d{1,3})\.(\d{1,3})\.(\d{1,3})\.(\d{1,3})\]$/
var atom="(" + firstChars + validChars + "*" + ")"
var word="(" + atom + "|" + quotedUser + ")"
var userPat=new RegExp("^" + word + "(\\." + word + ")*$")
var domainPat=new RegExp("^" + atom + "(\\." + atom +")*$")
var matchArray=emailStr.match(emailPat)

if (matchArray==null) {
   alert(msg)
   return false;
}

var user=matchArray[1]
var domain=matchArray[2]

if (user.match(userPat)==null) {
    alert(msg)
    return false
}
var IPArray=domain.match(ipDomainPat)
if (IPArray!=null) { 
	  for (var i=1;i<=4;i++) {
	    if (IPArray[i]>255) {
	        alert(msg)
		return false
	    }
    }
    return true
}

var domainArray=domain.match(domainPat)
if (domainArray==null) {
	alert(msg);
    return false
}

var atomPat=new RegExp(atom,"g")
var domArr=domain.match(atomPat)
var len=domArr.length
if (domArr[domArr.length-1].length<2 || 
    domArr[domArr.length-1].length>3) {
   alert(msg);
   return false
}

if (domArr[domArr.length-1].length >= 2 && len < 2) {
   var errStr=msg
   alert(errStr)
   return false
}
return true;
}


//**** funcion que evita que el campo solo contenga caracter espacio


 function vacio(q,msg) {
        q = String(q);
	for ( i = 0; i<q.length; i++ ) {
		if ( q.charAt(i) != " " ) {
        		return true;
        	}
	}

	alert(msg);
	return false;

}


//********************************** FUNCION PARA UN COMENTARIO ********************************


// function que verifica que el campo tenga caracteres para un cuadro de comentario

function comentario(campo,caract_extra,nulo,msg){
  if (nulo == 1 && campo == ""){
    alert(msg);
    return false;}

  var ubicacion;
  var enter = "\n";
  var caracteres="abcdefghijklmnopqrstuvwxyzñ1234567890 AQZXSWEDCVFRTGBNÑHYMJUIKLOP:=.,$@¿?\\//~+-*\"#'&¡!()[]áéíóúÁÉÍÓÚ"+String.fromCharCode(13)+enter+caract_extra;

  var contador = 0;    
      for (var i=0; i < campo.length; i++){
            ubicacion = campo.substring(i, i + 1);
            if (caracteres.indexOf(ubicacion) != -1){
              contador ++;}
            else{
              alert(msg + ", " + ubicacion);
              return false;}
      }
}

// ********************** VERIFICA EL LARGO DEL CAMPO ***********************************

// Campo es el nombre del campo a verificar y largo el numero maximo de caracteres

function largo(campo,largo){

 if (campo.length > largo){ 
     alert ("ATENCIÓN : Solo Puede Ingresar Hasta "+largo+" Caracteres");
     return false;}
  }

// ******************** FUNCION ALFABETICO *****************************************

//  verifica que el campo tenga solo caracteres alfabeticos + caracteres especiales

function alfabeticos(campo,carac_extra,nulo,msg){
   if (nulo == 1 && campo == ""){
     alert(msg);
     return false;}
  
  var ubicacion;
//  var alfabetico ="abcdefghijklmnopqrstuvwñxyzAQZXSWEDCVFRTGBNHYMJÑUIKLOPáéíóúÁÉÍÓÚ";
  var alfabetico ="abcdefghijklmnopqrstuvwxyz";
  var caracteres = alfabetico + carac_extra;
  var contador = 0;    

      for (var i=0; i < campo.length; i++){
            ubicacion = campo.substring(i, i + 1);
            if (caracteres.indexOf(ubicacion) != -1)
           contador ++; 
            else{
              alert(msg + ", " + ubicacion);
              return false;}
	  }
}


// ******************* FUNCION ALFANUMERICO  **********************************

// function que verifica que el campo tenga solo caracteres alfanumericos pudiendo opcionalmente agregar caracteres
// permite que el campo quede vacio o no vacio = 0 permite quequede vacio vacio = 1 no puede quedar vacio

function alfanumero(campo,carac_extra,nulo,msg){
  if (nulo == 1 && campo == ""){
     alert(msg);
    return false;}

    var ubicacion;
    var alfanumerico ="abcdefghijklmnopqrstuvwxyzñ1234567890AQZXSWEDCVFRTGBNÑHYMJUIKLOPáéíóúÁÉÍÓÚ";
    var contador = 0;    
    var caracteres = alfanumerico + carac_extra;

  //  verifica que el campo tenga solo caracteres alfanumeico + caracteres extra
      for (var i=0; i < campo.length; i++){
            ubicacion = campo.substring(i, i + 1);
            if (caracteres.indexOf(ubicacion) != -1){
	           contador ++;}
            else{
              alert(msg + ", " + ubicacion);
              return false;}
	  }

}


// ****************** FUNCION TELEFONO ****************

// function que verifica que el campo tenga solo caracteres validos para un numero de telefono
// permite que el campo quede vacio dependiendo de la opcion 1 o 0

function telefono(campo,carac_extra,nulo,msg){
   if (nulo == 1 && campo == ""){
     alert(msg);
    return false;}

    var ubicacion;
    var car_fono = "1234567890";
    var caracteres = car_fono + carac_extra;
    var contador = 0;    

     for (var i=0; i < campo.length; i++){
            ubicacion = campo.substring(i, i + 1);
            if (caracteres.indexOf(ubicacion) != -1){
	           contador ++;}
            else{
              alert(msg + ", " + ubicacion);
              return false;}
	  }
}

// *************************** FUNCION PATH ****************************

// function que verifica que el campo tenga solo caracteres validos para una ruta de archivo + caracteres opcionales

function path(campo,carac_extra,nulo){
 
  if (nulo == 1 && campo == ""){
    alert("ERROR : No Puede Dejar Este Campo Vacio");
    return false;}

  var ubicacion;
  var car_path = "abcdefghijklmnopqrstuvwxyzñ1234567890ÑAQZXSWEDCVFRTGBNHYMJUIKLOP:/-_.~?%=&+$\\ ";
  var caracteres = car_path + carac_extra;
  var contador = 0;    

     for (var i=0; i < campo.length; i++){
            ubicacion = campo.substring(i, i + 1);
            if (car_path.indexOf(ubicacion) != -1 ){
               contador ++;}
          else{
              alert("ERROR : No Se Acepta el Caracter "+ubicacion);
              return false;}
  }
}

//* *********************** FUNCION NUMERICO  ****************************

// El campo solo recive datos numerico y puede estar vacia
 function numerico(campo,carac_extra,nulo,msg){
   if (nulo == 1 && campo == ""){
     alert(msg);
     return false;}
  
  var ubicacion;
  var numeros = "1234567890";
  var caracteres = numeros + carac_extra;
  var contador = 0;    

  //  verifica que el campo tenga solo caracteres numericos

      for (var i=0; i < campo.length; i++){
            ubicacion = campo.substring(i, i + 1);
            if (caracteres.indexOf(ubicacion) != -1){
           contador ++; }
          else{
              alert(msg + ", " + ubicacion);
              return false;}
	 }
}
      

// ******************* FUNCION VALIDA RUT ************************************

//Valida rut con un cuadro de texto

function rut(campo,msg){

	do {
		campo = campo.replace('.','');
	} while(campo.indexOf('.') >= 0);

var suma = 0;
var contador = 0;    
var caracteres = "1234567890-kK";
var rut = campo.substring(0,8);
var drut = campo.substring(9,10);
var dvr = '0';
var mul = 2;


if ( campo.length == 0 ){
   alert(msg);
    return false;
}

if ( campo.length == 9 ){
    rut = campo.substring(0,7);
	drut = campo.substring(8,9);
}

//  verifica que el campo tenga solo caracteres numericos - k

      for (var i=0; i < campo.length; i++){
            ubicacion = campo.substring(i, i + 1);
            if (caracteres.indexOf(ubicacion) != -1)
           contador ++;
      }

    if (contador != 10 && contador != 9){
       alert(msg);
       return false;}


   for (i= rut.length -1 ; i >= 0; i--)
    {
      suma = suma + rut.charAt(i) * mul
        if (mul == 7)
          mul = 2
        else    
          mul++
    }

  res = suma % 11
  if (res==1)
    dvr = 'k'
  else if (res==0)
    dvr = '0'
  else
    {
      dvi = 11-res
      dvr = dvi + ""
    }

  if ( dvr != drut.toLowerCase() )
    { alert(msg);
		return false; }
  else
    { 
		return true;
	}
}


function formatearRut(num){ 

	do {
		num = num.replace('.','');
	} while(num.indexOf('.') >= 0);

 var cadena = ""; var aux;  
   
 var cont = 1,m,k;  
   
 if(num<0) aux=1; else aux=0;  
   
 num=num.toString();  
   
   
   
 for(m=num.length-1; m>=0; m--){  
   
  cadena = num.charAt(m) + cadena;  
   
  if(cont%3 == 0 && m >aux)  cadena = "." + cadena; else cadena = cadena;  
   
  if(cont== 3) cont = 1; else cont++;  
   
 }  
   
 cadena = cadena.replace(/.,/,",");  
   
 return cadena;  
   

}


//******************************** FUNCION QUE VALIDA FECHA ******************************


function isValidDate(dateStr,nulo,msg) {

var datePat = /^(\d{1,2})(\/|-)(\d{1,2})\2(\d{4}|\d{4})$/;

   if (dateStr == "" && nulo == 0) {
         dateStr = "10/12/1990";
   }

var matchArray = dateStr.match(datePat); 

 if (matchArray == null) {
       alert(msg+"Fecha Invalida dd/mm/yyyy");
       return false;}

month = matchArray[3]; 
day = matchArray[1];
year = matchArray[4];


if (month < 1 || month > 12) { 
	alert(msg+"\nEl Mes se Encuentra Entre 1 y 12 Meses dd/mm/yyyy");
	return false;
}

if (day < 1 || day > 31) {
	alert(msg+"\nEl Día se Encuentra Entre 1 y 31 Días dd/mm/yyyy");
	return false;
}

if ((month==4 || month==6 || month==9 || month==11) && day==31) {
	alert(msg+"\nEl Mes "+month+" no Tiene 31 Días dd/mm/yyyy")
	return false
}

if (month == 2) { 
	var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
	if (day>29 || (day==29 && !isleap)) {
		alert(msg+"\nFebrero de " + year + " no Tiene " + day + " Días dd/mm/yyyy");
		return false;
	}
  }

if(year == false){
   alert(msg+"El Año Debe ser Distinto a 0");
    return false;}

  return true;
}



//******************************** FUNCION QUE VALIDA FECHA con mesaje mm/yyyy******************************


function isValidDate1(dateStr,nulo,msg) {

var datePat = /^(\d{1,2})(\/|-)(\d{1,2})\2(\d{4}|\d{4})$/;

   if (dateStr == "" && nulo == 0) {
         dateStr = "10/12/1990";
   }

var matchArray = dateStr.match(datePat); 

 if (matchArray == null) {
       alert(msg+"Fecha Invalida mm/yyyy");
       return false;}

month = matchArray[3]; 
day = matchArray[1];
year = matchArray[4];


if (month < 1 || month > 12) { 
	alert(msg+"\nEl Mes se Encuentra Entre 1 y 12 Meses mm/yyyy");
	return false;
}

if (day < 1 || day > 31) {
	alert(msg+"\nEl Día se Encuentra Entre 1 y 31 Días mm/yyyy");
	return false;
}

if ((month==4 || month==6 || month==9 || month==11) && day==31) {
	alert(msg+"\nEl Mes "+month+" no Tiene 31 Días mm/yyyy")
	return false
}

if (month == 2) { 
	var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
	if (day>29 || (day==29 && !isleap)) {
		alert(msg+"\nFebrero de " + year + " no Tiene " + day + " Días mm/yyyy");
		return false;
	}
  }

if(year == false){
   alert(msg+"El Año Debe ser Distinto a 0");
    return false;}

  return true;
}


// ************** FUNCION QUE TRANSFORMA La " " a %20 ************************
function change_char(campo){
   var posicion = new String();
   var new_string = new String();
   var space = " ";
   var contador = 0;    

      for (var i=0; i < campo.length; i++){
              new_string = new_string + posicion;
              posicion = campo.substring(i, i + 1);
        if (space.indexOf(posicion) == -1)
            contador ++; 
        else
             posicion = "%20"; 
      }
   new_string = new_string + posicion;
   return new_string;
}


function fecha()
{
        today = new Date();
        day = today.getDay();

        if ( day == 0 ) { document.write("Domingo "); }
        if ( day == 1 ) { document.write("Lunes "); }
        if ( day == 2 ) { document.write("Martes "); }
        if ( day == 3 ) { document.write("Mi&eacute;rcoles "); }
        if ( day == 4 ) { document.write("Jueves "); }
        if ( day == 5 ) { document.write("Viernes "); }
        if ( day == 6 ) { document.write("S&aacute;bado "); }

        today = new Date();
        year = today.getYear();
		if ( year <= 200) {year = year + 1900}
        if ( today.getMonth() == 0 ) { month = "Enero" }
        if ( today.getMonth() == 1 ) { month = "Febrero" }
        if ( today.getMonth() == 2 ) { month = "Marzo" }
        if ( today.getMonth() == 3 ) { month = "Abril" }
        if ( today.getMonth() == 4 ) { month = "Mayo" }
        if ( today.getMonth() == 5 ) { month = "Junio" }
        if ( today.getMonth() == 6 ) { month = "Julio" }
        if ( today.getMonth() == 7 ) { month = "Agosto" }
        if ( today.getMonth() == 8 ) { month = "Septiembre" }
        if ( today.getMonth() == 9 ) { month = "Octubre" }
        if ( today.getMonth() == 10 ) { month = "Noviembre" }
        if ( today.getMonth() == 11 ) { month = "Diciembre" }

       document.write( today.getDate(), " de ", month, " ", year);
}

function ReloadPage(NombrePagina,Parametro){
	
	param = Parametro.options[Parametro.selectedIndex].value;
	location.href = NombrePagina+"?CodigoReloadPage="+param;

}

function checkAll( n, fldName ) {
  if (!fldName) {
     fldName = 'cb';
  }
	var f = document.form1;
	var c = f.toggle.checked;
	var n2 = 0;
	for (i=0; i < n; i++) {
		cb = eval( 'f.' + fldName + '' + i );
		if (cb) {
			cb.checked = c;
			n2++;
		}
	}
	if (c) {
		document.form1.boxchecked.value = n2;
	} else {
		document.form1.boxchecked.value = 0;
	}
}


function isChecked(isitchecked){
	if (isitchecked == true){
		document.form1.boxchecked.value++;
	}
	else {
		document.form1.boxchecked.value--;
	}
}
