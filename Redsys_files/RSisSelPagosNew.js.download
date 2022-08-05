/****************************************************************************************************
* VARIABLES contenidas en RSisSelPagosNew.js :					COMUN 
*****************************************************************************************************/

// Para la traduccion de los errores. 
// Ver: anadirLiteral(etiqueta, valor)
//      getError(etiqueta)
var errores = new Array();

// Por defecto el más restrictivo. 3 = optativo, 4 = obligatorio. 
// Ver fijarCVV2(valor)
//     validaCVV2(tarjeta, campoCVV2)
var indicadorCVV2 = 4;
var threeDsMethodEnviado = false;

/****************************************************************************************************
* FUNCIONES contenidas en RSisSelPagosNew.js :										
* 											 										
* [Ref0001]:	MM_findObj(n, d)  					Referencia en utilSis		
* [Ref0002]:	MM_showHideLayers()  				Referencia en utilSis									
* [Ref0003]:	fijarInicioURLReferencia()			Referencia en utilSis									
* [Ref0004]:	fijarInicioURLReferencia2(url)	Referencia en utilSis									
* [Ref0005]:	fijarFinURLReferencia()				Referencia en utilSis								
* [Ref0006]:	fProcesandoPeticion(ver)			Referencia en utilSis									
* [Ref0007]:	anadirLiteral(etiqueta, valor)	Creamos una referencia v2 en utilSis
* [Ref0008]:	getError(etiqueta)					Creamos una referencia v2 en utilSis
* [Ref0009]:	fijarCVV2(valor)		
* [Ref0010]:	validarTarjetaEspaciosNumero()
* [Ref0010]:	validarTarjetaEspaciosNumeroUPI()
* [Ref0011]:	validar()
* [Ref0011]:	validarUPI()
* [Ref0012]:	validaFormTarjeta()		
* [Ref0012]:	validaFormTarjetaUPI()
* [Ref0013]:	cancelar()								Creamos una referencia v2 en utilSis
* [Ref0014]:	validaPagoConTarjeta()		
* [Ref0014]:	validaPagoConTarjetaUPI()
* [Ref0015]:	validaCVV2(tarjeta, campoCVV2)	
* [Ref0015]:	validaCVV2UPI(tarjeta, campoCVV2)
* [Ref0016]:	trim(cadena)		
* [Ref0017]:	esVisa(laTarjeta)		
* [Ref0018]:	esMaster(laTarjeta)		
* [Ref0019]:	esAMEX(laTarjeta)		
* [Ref0020]:	esDINERS(laTarjeta)		
* [Ref0021]:	esJCB(laTarjeta)		
* [Ref0022]:	load()		
* [Ref0023]:	ventanaInfoVisa1()		
* [Ref0024]:	ventanaInfoCVV2(idioma)		
* [Ref0025]:	getWindowHeight()			
* [Ref0026]:	resizeDiv()
* [Ref0027]:	validaIsNumerico_v2(campo,msgError)  Referencia en validations
* [Ref0028]:	dameValorTarjeta()
* [Ref0029]:	focoTarjeta(boolean)
* [Ref0030]:	PasarFoco(boolean)
* [Ref0031]:	es4B(laTarjeta) Indica que es una tarjeta marca 4B no privada
*
*****************************************************************************************************/


/************************************************************
* 												[Ref0001]								
* Funcion: MM_findObj										
* Parametros:												
*		n: identificador del objeto							
*		d: documento										
* Devuelve el objeto buscado dentro del documento			
************************************************************/
function MM_findObj(n, d)
{ 
	var p,i,x;
	
	if(!d)
		d=document;

	if((p=n.indexOf("?")) > 0 && parent.frames.length)
	{
 		d=parent.frames[n.substring(p+1)].document;
 	 	n=n.substring(0,p);
  	}
 	
	if(!(x=d[n]) && d.all)
		x=d.all[n];

	for (i=0;!x && i<d.forms.length;i++)
		x=d.forms[i][n];

	for(i=0;!x && d.layers && i<d.layers.length;i++)
		x=MM_findObj(n,d.layers[i].document);

	if(!x && d.getElementById)
		x=d.getElementById(n);
				
	return x;
}

/************************************************************
* 												[Ref0002]	
* Funcion: MM_showHideLayers								
* Devuelve:													
************************************************************/
function MM_showHideLayers() 
{
	var i,p,v,obj,args=MM_showHideLayers.arguments;
	
	for (i=0; i<(args.length-2); i+=3)
	{
		if ((obj=MM_findObj(args[i]))!=null)
		{
			v=args[i+2];
			if (obj.style) {
				obj=obj.style;
			 	v=(v=='show')?'visible':(v=='hide')?'hidden':v;
			}
			obj.visibility=v; 
		}	
	}
	return true;			
}

/************************************************************
* 												[Ref0003]	
* Funcion: fijarInicioURLReferencia							
* Devuelve:													
************************************************************/
function fijarInicioURLReferencia()
{
	document.write("<a href='/sis/pantallaReferencia;jsessionid=3JTCFN5D02N4RKFELBIYIHA?param="+ new Date().getTime()+"'>");
}

/************************************************************
* 												[Ref0004]	
* Funcion: fijarInicioURLReferencia2						
* Parametros:												
*		url													
* Devuelve:													
************************************************************/
function fijarInicioURLReferencia2(url)
{
	document.write("<a href='"+url+"?param="+ new Date().getTime()+"'>");
}

/************************************************************
* 												[Ref0005]	
* Funcion: fijarFinURLReferencia							
* Devuelve:													
************************************************************/
function fijarFinURLReferencia()
{
	document.write("</a>");
}

/************************************************************
* 												[Ref0006]	
* Funcion: fProcesandoPeticion								
* Parametros:												
*		ver													
* Devuelve:													
************************************************************/
function fProcesandoPeticion(ver)
{
   if (ver == 'N')
   {
  		MM_showHideLayers('realizandoPeticion','','hide');
  		setTimeout("fProcesandoPeticion('S')",350);
  	}	
   else
   {
     	MM_showHideLayers('realizandoPeticion','','show');
     	setTimeout("fProcesandoPeticion('N')",350);
   }
}

/************************************************************
* 												[Ref0007]	
* Funcion: anadirLiteral								
* Parametros:												
*		etiqueta
*		valor													
* Funcion que guarda en una matriz los valores de los errores, el texto y los 
*	literales asociados a los mismos. Se hace una sola vez en la carga												
************************************************************/
function anadirLiteral(etiqueta, valor) {
	var error  = new Array();
	error[0]= etiqueta;
	error[1]= valor;
	errores[errores.length] = error;
}

/************************************************************
* 												[Ref0008]	
* Funcion: getError								
* Parametros:												
*		etiqueta													
* Devuelve:	el literal asociado la operacion seleccionada												
************************************************************/
function getError(etiqueta) {
	var noencontrado=true;
	var i =0;
	while(noencontrado &&  i < errores.length ) {
		if (errores[i][0] == etiqueta)
			return errores[i][1];
		i++;
	}
	return "";
}

/************************************************************
* 												[Ref0009]	
* Funcion: fijarCVV2								
* Parametros:												
*		valor													
* Fija el valor del CVV2												
************************************************************/
function fijarCVV2(valor) {
	indicadorCVV2 = valor;
}

/************************************************************
* 												[Ref0010]	
* Funcion: validarTarjetaEspaciosNumero																				
* Devuelve:													
************************************************************/
function validarTarjetaEspaciosNumero(){
	var laTarjeta = dameValorTarjeta();
	return (validaIsNumerico_v2(laTarjeta, getError("msg15")));
}

/************************************************************
* 												[Ref0010]	
* Funcion: validarTarjetaEspaciosNumeroUPI
* Devuelve:													
************************************************************/
function validarTarjetaEspaciosNumeroUPI(){
	var laTarjeta = dameValorTarjetaUPI();
	return (validaIsNumerico_v2(laTarjeta, getError("msg15")));
}


/************************************************************
* 												[Ref0011]	
* Funcion: validar																				
* Devuelve:													
************************************************************/
//@s6108jl: Se controla el doble envío del formulario
var enviandoDatos = false;
function validar()
{
	if (!enviandoDatos) {
		var datosTarjeta = 0;
	
		if (!validarTarjetaEspaciosNumero())
			return;

		if(document.formTarjeta)
		{
			if (dameValorTarjeta().length != 0 ||
			   document.formTarjeta.Sis_Caducidad_Tarjeta_Mes.value.length != 0 ||
			   document.formTarjeta.Sis_Caducidad_Tarjeta_Anno.value.length != 0)
			   datosTarjeta = 1;
		}
	
		if(datosTarjeta == 0)
		{
			alert(getError("msg1"));
			decideFoco();
			return;
		}
	
		if(datosTarjeta == 1){
			enviandoDatos = true;
			var valid = validaFormTarjeta();
			if(!valid)
				enviandoDatos = false;
		}
	}
}

/************************************************************
* 												[Ref0011]	
* Funcion: validar																				
* Devuelve:													
************************************************************/
var enviandoDatos = false;
function validar3DS(jSesionId)
{
	if (!enviandoDatos) {
		var datosTarjeta = 0;
	
		if (!validarTarjetaEspaciosNumero())
			return;

		if(document.formTarjeta)
		{
			if (dameValorTarjeta().length != 0 ||
			   document.formTarjeta.Sis_Caducidad_Tarjeta_Mes.value.length != 0 ||
			   document.formTarjeta.Sis_Caducidad_Tarjeta_Anno.value.length != 0)
			   datosTarjeta = 1;
		}
	
		if(datosTarjeta == 0)
		{
			alert(getError("msg1"));
			decideFoco();
			return;
		}
	
		if(datosTarjeta == 1){
			enviandoDatos = true;
			var valid = validaFormTarjeta3DS(jSesionId);
			if(!valid)
				enviandoDatos = false;
		}
	}
}

/************************************************************
* 												[Ref0011]	
* Funcion: validarUPI																				
* Devuelve:													
************************************************************/
//@s6108jl: Se controla el doble envío del formulario
function validarUPI()
{
	if (!enviandoDatos) {
		var datosTarjeta = 0;
	
		if (!validarTarjetaEspaciosNumeroUPI())
			return;

		if(document.formTarjeta)
		{
			if (dameValorTarjetaUPI().length != 0)
			   datosTarjeta = 1;
		}
	
		if(datosTarjeta == 0)
		{
			alert(getError("msg1"));
			decideFoco();
			return;
		}
	
		if(datosTarjeta == 1){
			enviandoDatos = true;
			var valid = validaFormTarjetaUPI();
			if(!valid)
				enviandoDatos = false;
		}
	}
}

/************************************************************
* 												[Ref0012]	
* Funcion: validaFormTarjeta								
* Devuelve:													
************************************************************/
function validaFormTarjeta()
{
	if (validaPagoConTarjeta())
	{
		ocultaBoton();
		fProcesandoPeticion('S');
		document.formTarjeta.submit();
	} else {
		return false;
	}
}

/************************************************************
* 												[Ref0012]	
* Funcion: validaFormTarjeta								
* Devuelve:													
************************************************************/
function validaFormTarjeta3DS(jSesionId)
{
	if (validaPagoConTarjeta())
	{	
		
		// Validamos que el nombre del titular de la tarjeta no esté vacío
		var nombreTitular = document.formTarjeta.cardholderName;
		
		// Validamos que el número de tarjeta no esté vacío
		if (nombreTitular != undefined) {
			nombreTitular = nombreTitular.value;
			if(nombreTitular == "") {
				alert(getError("msg18"));
				focoTarjetaTitular(false);
				return false;
			}
		}
	
		document.getElementById('divImgAceptar').innerHTML="<img style='width:20px;height:20px;'src=\'/sis/graficos/botones/cargando.gif\'>";
		document.getElementById('divImgAceptar').disabled = true;
		document.getElementById('divImgCancelar').disabled = true;
		consultaTarjetaY3DsMethod(jSesionId);
	} else {
		return false;
	}
}

/************************************************************
* 												[Ref0012]	
* Funcion: validaFormTarjeta								
* Devuelve:													
************************************************************/
function consultaTarjetaY3DsMethod(jSesionId)
{
	// Llamada Ajax para obtener URL 3DSMethod
	var url = "/sis/services/rest/rest3DS/consultaTarjeta3DSPantalla" + jSesionId;
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	req.onreadystatechange=function() {
		if (req.readyState==4) {
			var jsonObj = eval('(' + req.responseText +')');
			var url3DS=jsonObj.threeDSMethodURL;
			if (url3DS != undefined && url3DS != 'NO_3DSMethod' && url3DS != 'NO_3DS') {
				// Si hay URL del 3DSMethod mínimo sería una N
				document.getElementById("threeDSCompInd").value = "N";
				var threeDSMData = jsonObj.threeDSMethodData;
				var iframe = document.createElement('iframe');
				iframe.id="iframe3DSM";
				iframe.style.cssText="width:0;height:0;border:0;border:none;display:none;";
				var html = '<body onload="document.form3DSM.submit();">'
				+ '<form action="'+ url3DS +'" id="form3DSM" name="form3DSM" method="post" target="">' 
				+ '<input type="hidden" name="threeDSMethodData" id="threeDSMethodData" value="'+ threeDSMData +'">' 
				+ '</form></body>';
				var ua = window.navigator.userAgent;
				if (ua.indexOf("MSIE ") > -1 || ua.indexOf("Trident/") > -1 || ua.indexOf("Edge/") > -1) {
					document.getElementById("iframe3DSMethod").appendChild(iframe);
					iframe.contentWindow.document.open();
					iframe.contentWindow.document.write(html);
					iframe.contentWindow.document.close();
				} else {
					iframe.src = 'data:text/html;charset=utf-8,' + encodeURI(html);
					document.getElementById("iframe3DSMethod").appendChild(iframe);
				}
				setTimeout(function(){ finalizarOperacion3DS();},10000);
			} else {
				ocultaBoton();
				fProcesandoPeticion('S');
				document.formTarjeta.submit();
			}
		}
	}

	req.open("POST", url, true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	req.send("tarjeta=" + document.formTarjeta.Sis_Numero_Tarjeta.value);
}

/************************************************************
* 												[Ref0012]	
* Funcion: validaFormTarjeta								
* Devuelve:													
************************************************************/
function finalizarOperacion3DS()
{
	if (!threeDsMethodEnviado) {
		threeDsMethodEnviado = true;
		ocultaBoton();
		fProcesandoPeticion('S');
		document.formTarjeta.submit();
	}
}


/************************************************************
* 												[Ref0012]	
* Funcion: validaFormTarjetaUPI								
* Devuelve:													
************************************************************/
function validaFormTarjetaUPI()
{
	if (validaPagoConTarjetaUPI())
	{
		ocultaBoton();
		fProcesandoPeticion('S');
		if (document.formTarjeta.ds_sis_pago_upi) {
			document.formTarjeta.ds_sis_pago_upi.value = 'true';
		}
		document.formTarjeta.submit();
	} else {
		return false;
	}
}


/************************************************************
* 												[Ref0013]	
* Funcion: cancelar								
* Devuelve:	
* Funcion para el botón de Cancelar para que llame y genere una 
* excepción con código SIS9915 -- 0915												
************************************************************/
function cancelar(){
		ocultaBoton();
		fProcesandoPeticion('S');
		document.formTarjeta.bcancel.value=1;
		document.formTarjeta.submit();
		
}
 
/************************************************************
* 												[Ref0014]	
* Funcion: validaPagoConTarjeta								
* Devuelve:		
* Validaciones del número de tarjeta y de la fecha de caducidad											
************************************************************/
function validaPagoConTarjeta() { 

	var laTarjeta = dameValorTarjeta();
	var mesCaduc  = document.formTarjeta.Sis_Caducidad_Tarjeta_Mes.value;
	var yearCaduc = document.formTarjeta.Sis_Caducidad_Tarjeta_Anno.value;
	
	// Validamos que el número de tarjeta no esté vacío
	if (laTarjeta == "") {
		alert(getError("msg2"));
		focoTarjeta(false);
		return false;
	}

	// Para validar si es numérico, primero se sustituyen los blancos por # y luego se valida
	laTarjeta = laTarjeta.replace(' ', '#');
	if (isNaN(laTarjeta)) {
		alert(getError("msg3"));
		focoTarjeta(true);
		return false;
	}

	// Se valida que la tarjeta no sea negativa
	if (laTarjeta < 0) {
		alert(getError("msg4"));
		focoTarjeta(true);
		return false;
	}

	// Validamos el digito de control
	if (!(validaEsTarjeta(laTarjeta))) {
		alert(getError("msg15"));
		document.formTarjeta.Sis_Numero_Tarjeta.select();
		document.formTarjeta.Sis_Numero_Tarjeta.focus();
		return false;
	}

	// Se valida la longitud minima y  máxima de la tarjeta (13-19 posiciones)
	if (laTarjeta.length < 13 || laTarjeta.length > 19) {
		alert(getError("msg15"));
		focoTarjeta(true);
		return false;
	}

	// Validamos que el mes de caducidad de la tarjeta no esté vacío
	if (mesCaduc == "") {
		alert(getError("msg5"));
		document.formTarjeta.Sis_Caducidad_Tarjeta_Mes.focus();
		return false;
	}

	// Para validar si es numérico, primero se sustituyen los blancos por # y luego se valida
	mesCaduc = mesCaduc.replace(' ','#');
	if (isNaN(mesCaduc)) {
		alert(getError("msg6"));
		document.formTarjeta.Sis_Caducidad_Tarjeta_Mes.select();
		document.formTarjeta.Sis_Caducidad_Tarjeta_Mes.focus();
		return false;
	}

	// Se valida que el mes de caducidad esté entre 1 y 12
	if (!(mesCaduc >= 1 && mesCaduc <= 12)) {
		alert(getError("msg7"));
		document.formTarjeta.Sis_Caducidad_Tarjeta_Mes.select();
		document.formTarjeta.Sis_Caducidad_Tarjeta_Mes.focus();
		return false;
	}

	//Se le ponen dos digitos al mes si el usuario no los ha puesto
	if (mesCaduc.length == 1) {
		document.formTarjeta.Sis_Caducidad_Tarjeta_Mes.value = "0" +
		document.formTarjeta.Sis_Caducidad_Tarjeta_Mes.value;
	}

	// Validamos que el año de caducidad de la tarjeta no esté vacío
	if (yearCaduc == "") {
		alert(getError("msg8"));
		document.formTarjeta.Sis_Caducidad_Tarjeta_Anno.focus();
		return false;
	}

	// Para validar si es numérico, primero se sustituyen los blancos por # y luego se valida
	yearCaduc = yearCaduc.replace(' ','#');
	if (isNaN(yearCaduc)) {
		alert(getError("msg9"));
		document.formTarjeta.Sis_Caducidad_Tarjeta_Anno.select();
		document.formTarjeta.Sis_Caducidad_Tarjeta_Anno.focus();
		return false;
	}

	// Se valida que el año de caducidad no sea negativo
	if (yearCaduc < 0) {
		alert(getError("msg10"));
		document.formTarjeta.Sis_Caducidad_Tarjeta_Anno.select();
		document.formTarjeta.Sis_Caducidad_Tarjeta_Anno.focus();
		return false;
	}

	//Se le ponen dos digitos al año si el usuario no los ha puesto
	if (yearCaduc.length == 1) {
		document.formTarjeta.Sis_Caducidad_Tarjeta_Anno.value = "0"
		+ document.formTarjeta.Sis_Caducidad_Tarjeta_Anno.value;
	}

	if(document.formTarjeta.Sis_Tarjeta_CVV2) {
		if(!validaCVV2(laTarjeta, document.formTarjeta.Sis_Tarjeta_CVV2))
			return false;
	}
	
	if(document.formTarjeta.numeroDocumento){
		if (document.formTarjeta.numeroDocumento.value.length != 9) {
			alert(getError("msg19"));
			return false;
		}
	}
	if(document.formTarjeta.expediente){
		if (document.formTarjeta.expediente.value.length != 12) {
			alert(getError("msg20"));
			return false;
		}
	}
	if(document.formTarjeta.fechaDevengo){
		if (document.formTarjeta.fechaDevengo.value.length != 8) {
			alert(getError("msg21"));
			return false;
		}
	}
	// Se fija el valor de la tarjeta si está en modo 4 posiciones
	if (document.formTarjeta.numTarjeta1) {
		document.formTarjeta.Sis_Numero_Tarjeta.value = laTarjeta;
	}

	return true;
}

/************************************************************
* 												[Ref0014]	
* Funcion: validaPagoConTarjetaUPI								
* Devuelve:		
* Validaciones del número de tarjeta y de la fecha de caducidad (opcional)
************************************************************/
function validaPagoConTarjetaUPI() { 

	var laTarjeta = dameValorTarjetaUPI();
	var mesCaduc  = document.formTarjeta.Sis_Caducidad_Tarjeta_Mes_UPI.value;
	var yearCaduc = document.formTarjeta.Sis_Caducidad_Tarjeta_Anno_UPI.value;
	
	// Validamos que el número de tarjeta no esté vacío
	if (laTarjeta == "") {
		alert(getError("msg2"));
		focoTarjetaUPI(false);
		return false;
	}

	// Para validar si es numérico, primero se sustituyen los blancos por # y luego se valida
	laTarjeta = laTarjeta.replace(' ', '#');
	if (isNaN(laTarjeta)) {
		alert(getError("msg3"));
		focoTarjetaUPI(true);
		return false;
	}

	// Se valida que la tarjeta no sea negativa
	if (laTarjeta < 0) {
		alert(getError("msg4"));
		focoTarjetaUPI(true);
		return false;
	}

	// Validamos el digito de control
	if (!(validaEsTarjeta(laTarjeta))) {
		alert(getError("msg15"));
		document.formTarjeta.Sis_Numero_Tarjeta_UPI.select();
		document.formTarjeta.Sis_Numero_Tarjeta_UPI.focus();
		return false;
	}

	// Se valida la longitud minima y  máxima de la tarjeta (13-19 posiciones)
	if (laTarjeta.length < 13 || laTarjeta.length > 19) {
		alert(getError("msg15"));
		focoTarjetaUPI(true);
		return false;
	}
	
	// Se validan los datos de caducidad y CVV2 sólo si se informan, porque son opcionales
	if (mesCaduc != "" || yearCaduc != "") {
		// Validamos que el mes de caducidad de la tarjeta no esté vacío
		if (mesCaduc == "") {
			alert(getError("msg5"));
			document.formTarjeta.Sis_Caducidad_Tarjeta_Mes_UPI.focus();
			return false;
		}
	
		// Para validar si es numérico, primero se sustituyen los blancos por # y luego se valida
		mesCaduc = mesCaduc.replace(' ','#');
		if (isNaN(mesCaduc)) {
			alert(getError("msg6"));
			document.formTarjeta.Sis_Caducidad_Tarjeta_Mes_UPI.select();
			document.formTarjeta.Sis_Caducidad_Tarjeta_Mes_UPI.focus();
			return false;
		}
	
		// Se valida que el mes de caducidad esté entre 1 y 12
		if (!(mesCaduc >= 1 && mesCaduc <= 12)) {
			alert(getError("msg7"));
			document.formTarjeta.Sis_Caducidad_Tarjeta_Mes_UPI.select();
			document.formTarjeta.Sis_Caducidad_Tarjeta_Mes_UPI.focus();
			return false;
		}
	
		//Se le ponen dos digitos al mes si el usuario no los ha puesto
		if (mesCaduc.length == 1) {
			document.formTarjeta.Sis_Caducidad_Tarjeta_Mes_UPI.value = "0" +
			document.formTarjeta.Sis_Caducidad_Tarjeta_Mes_UPI.value;
		}
	
		// Validamos que el año de caducidad de la tarjeta no esté vacío
		if (yearCaduc == "") {
			alert(getError("msg8"));
			document.formTarjeta.Sis_Caducidad_Tarjeta_Anno_UPI.focus();
			return false;
		}
	
		// Para validar si es numérico, primero se sustituyen los blancos por # y luego se valida
		yearCaduc = yearCaduc.replace(' ','#');
		if (isNaN(yearCaduc)) {
			alert(getError("msg9"));
			document.formTarjeta.Sis_Caducidad_Tarjeta_Anno_UPI.select();
			document.formTarjeta.Sis_Caducidad_Tarjeta_Anno_UPI.focus();
			return false;
		}
	
		// Se valida que el año de caducidad no sea negativo
		if (yearCaduc < 0) {
			alert(getError("msg10"));
			document.formTarjeta.Sis_Caducidad_Tarjeta_Anno_UPI.select();
			document.formTarjeta.Sis_Caducidad_Tarjeta_Anno_UPI.focus();
			return false;
		}
	
		//Se le ponen dos digitos al año si el usuario no los ha puesto
		if (yearCaduc.length == 1) {
			document.formTarjeta.Sis_Caducidad_Tarjeta_Anno_UPI.value = "0"
			+ document.formTarjeta.Sis_Caducidad_Tarjeta_Anno_UPI.value;
		}
	}
	
	// Si se informa el CVV2, se comprueba
	if(document.formTarjeta.Sis_Tarjeta_CVV2_UPI) {
		if(!validaCVV2UPI(laTarjeta, document.formTarjeta.Sis_Tarjeta_CVV2_UPI))
			return false;
	}

	return true;
}

/************************************************************
* 												[Ref0015]	
* Funcion: validaCVV2								
* Parametros:												
*		tarjeta
*		campoCVV2												
* Devuelve:													
************************************************************/
function validaCVV2(tarjeta, campoCVV2) {
	var isAMEX = esAMEX(tarjeta);
	var isDINERS = esDINERS(tarjeta);
	var isBINEspecial = esBinEspecial(tarjeta);
	var longitudMin = 3;
	var longitudMax = 3;
	var isValidable = false;
	var isJCB = esJCB(tarjeta);
	//alert('validaCVV2');
	isValidable = (isAMEX || isDINERS || isJCB || isBINEspecial || esMaster(tarjeta) || esVisa(tarjeta) || es4B(tarjeta));
	
	if(isAMEX) // Para AMEX son 3 o 4 posiciones en el CVV2
		longitudMax = 4;
	
	var cvv2 = trim(campoCVV2.value);
	
	// Se valida el código de seguridad
	if(isValidable) {
		if(indicadorCVV2 == 4 || cvv2 != "") {
			if (cvv2.length < longitudMin || cvv2.length > longitudMax) {
				alert(getError("msg11a") + " " + longitudMax + " " + getError("msg11b"));
				campoCVV2.select();
				campoCVV2.focus();
				return false;
			}
			
			cvv2 = cvv2.replace(' ','#');
			if (isNaN(cvv2)) {
				alert(getError("msg12"));
				campoCVV2.select();
				campoCVV2.focus();
				return false;
			}
			// Se valida que el código de seguridad no sea negativo
			if (cvv2 < 0) {
				alert(getError("msg13"));
				campoCVV2.select();
				campoCVV2.focus();
				return false;
			}
		}
	} else if(!isValidable && cvv2 != "") {
		alert(getError("msg14"));
		campoCVV2.select();
		campoCVV2.focus();
		return false;	
	}
	
	campoCVV2.value = cvv2;
	return true;
}

/************************************************************
* 												[Ref0015]	
* Funcion: validaCVV2UPI								
* Parametros:												
*		tarjeta
*		campoCVV2												
* Devuelve:													
************************************************************/
function validaCVV2UPI(tarjeta, campoCVV2) {
	var longitudMin = 3;
	var longitudMax = 4;
	var isValidable = true;
	var cvv2 = trim(campoCVV2.value);
	
	// Se valida el código de seguridad
	if(isValidable) {
		if(indicadorCVV2 == 4 || cvv2 != "") {
			if (cvv2.length < longitudMin || cvv2.length > longitudMax) {
				alert(getError("msg11a") + " " + longitudMin + " " + getError("msg11b"));
				campoCVV2.select();
				campoCVV2.focus();
				return false;
			}
			
			cvv2 = cvv2.replace(' ','#');
			if (isNaN(cvv2)) {
				alert(getError("msg12"));
				campoCVV2.select();
				campoCVV2.focus();
				return false;
			}
			// Se valida que el código de seguridad no sea negativo
			if (cvv2 < 0) {
				alert(getError("msg13"));
				campoCVV2.select();
				campoCVV2.focus();
				return false;
			}
		}
	} else if(!isValidable && cvv2 != "") {
		alert(getError("msg14"));
		campoCVV2.select();
		campoCVV2.focus();
		return false;	
	}
	
	campoCVV2.value = cvv2;
	return true;
}

/************************************************************
* 												[Ref0016]	
* Funcion: trim								
* Parametros:												
*		cadena													
* Devuelve:													
************************************************************/
function trim(cadena) {
	for(i=0; i<cadena.length; ) {
		if(cadena.charAt(i)==" ")
			cadena=cadena.substring(i+1, cadena.length);
		else
			break;
	}
	for(i=cadena.length-1; i>=0; i=cadena.length-1) {
		if(cadena.charAt(i)==" ")
			cadena=cadena.substring(0,i);
		else
			break;
	}
	return cadena;
}
 
/************************************************************
* 												[Ref0017]	
* Funcion: esVisa								
* Parametros:												
*		laTarjeta													
* Devuelve:		
* VISAs empiezan por 4											
************************************************************/
function esVisa(laTarjeta) {
	var tipoTarjeta = laTarjeta.substr(0,1);
	if(tipoTarjeta == 4)
		return true;
	else
		return false;
}

/************************************************************
* 												[Ref0018]	
* Funcion: esMaster								
* Parametros:												
*		laTarjeta													
* Devuelve:	
* MASTERs empiezan por 5 y 6 o estan dentro de rango especial												
************************************************************/
function esMaster(laTarjeta) {
	var tipoTarjeta = laTarjeta.substr(0,1);
	var bin = laTarjeta.substr(0,6);
	if(tipoTarjeta == 5 || tipoTarjeta == 6 || (bin >= 222100 && bin <= 272099))
		return true;
	else
		return false;
}

/************************************************************
* 												[Ref0019]	
* Funcion: esAMEX								
* Parametros:												
*		laTarjeta													
* Devuelve:		
* AMEX son de 15 digitos y empiezan por 34 o 37											
************************************************************/
function esAMEX(laTarjeta) {
	laTarjeta = trim(laTarjeta);
	var tipoTarjeta = laTarjeta.substr(0,2);
	if((tipoTarjeta == 34 || tipoTarjeta == 37) && laTarjeta.length == 15)
		return true;
	else
		return false;
}

/************************************************************
* 												[Ref0020]	
* Funcion: esDINERS								
* Parametros:												
*		laTarjeta													
* Devuelve:			
* DINERS son de 14 digitos y empiezan por 36										
************************************************************/
function esDINERS(laTarjeta) {
	laTarjeta = trim(laTarjeta);
	var tipoTarjeta = laTarjeta.substr(0,2);
	if(tipoTarjeta == 36 && laTarjeta.length == 14)
		return true;
	else
		return false;
}

/************************************************************
* 												[Ref0020]	
* Funcion: esBinEspecial								
* Parametros:												
*		laTarjeta																				
************************************************************/
function esBinEspecial(laTarjeta) {
	laTarjeta = trim(laTarjeta);
	var tipoTarjeta = laTarjeta.substr(0,6);
	if(tipoTarjeta == 972437)
		return true;
	else
		return false;
}

/************************************************************
* 												[Ref0021]	
* Funcion: esJCB								
* Parametros:												
*		laTarjeta													
* Devuelve:		
* JCB son de 16 digitos y empiezan por 35											
************************************************************/
function esJCB(laTarjeta) {
	laTarjeta = trim(laTarjeta);
	var tipoTarjeta = laTarjeta.substr(0,2);
	if(tipoTarjeta == 35 && laTarjeta.length == 16)
		return true;
	else
		return false;
}

/************************************************************
* 												[Ref0022]	
* Funcion: load		
* Funcion que se ejecuta cuando se termina de cargar la página													
************************************************************/
function load() {
	if(document.getElementById("divImgAceptar")){
		document.getElementById("divImgAceptar").style.visibility="visible";
	}
	if(document.getElementById("divImgAceptarNoScript")){
		document.getElementById("divImgAceptarNoScript").style.visibility="hidden";
	}
	
	if(document.getElementById("divImgCancelar")){
		document.getElementById("divImgCancelar").style.visibility="visible";
	}
	if(document.getElementById("divImgCancelarNoScript")){
		document.getElementById("divImgCancelarNoScript").style.visibility="hidden";	
	}

	if (document.formTarjeta) {
		fLoad(this);
	}
	//resizeDiv();
}

/************************************************************
* 												[Ref0023]	
* Funcion: ventanaInfoVisa1									
* Devuelve:													
************************************************************/
function ventanaInfoVisa1() {
	window.open("/sis/html/verifiedByVisa1.html","Info","width=500,height=500");	
}

/************************************************************
* 												[Ref0024]	
* Funcion: ventanaInfoCVV2								
* Parametros:												
*		idioma													
* Devuelve:													
************************************************************/
function ventanaInfoCVV2(idioma) {
	if(idioma==undefined){
		window.open("/sis/html/ayudaCVV2_1.html","Info","width=430,height=370");
	}
	else{
		var a = "/sis/html/ayudaCVV2_" + idioma + ".html";
		window.open(a,"Info","width=430,height=370");
	}	
}

/************************************************************
* 												[Ref0025]	
* Funcion: getWindowHeight								
* Parametros:												
*		ver													
* Devuelve:	
* colocar los div correctamente											
************************************************************/
function getWindowHeight(){
	if (navigator.appName.indexOf("Microsoft")!=-1) {
		return document.body.offsetHeight;
	}
	else{
		return window.innerHeight;
	}
}

/************************************************************
* 												[Ref0026]	
* Funcion: resizeDiv									
* Devuelve:													
************************************************************/					  
function resizeDiv(){
	var height = getWindowHeight();
	alert(height);
	document.getElementById('divCuerpo').style.height=height-70;	
}

/************************************************************
* 												[Ref0027]	
* Funcion: validaIsNumerico_v2								
* Parametros:												
*		campo
*		msgError													
* Devuelve:	true si es numerico
* colocar los div correctamente											
************************************************************/
function validaIsNumerico_v2(campo,msgError){
	campo = campo.replace(' ','#');
	if (isNaN(campo))
	{
		campo= campo.replace('#',' ');
		alert(msgError);
		decideFoco();
		return false;
	}
	return true;
}

/************************************************************
* 												[Ref0028]	
* Funcion: dameValorTarjeta
* Devuelve:													
************************************************************/
function dameValorTarjeta()
{
	if (document.formTarjeta.numTarjeta1) {
		return new String("" + document.formTarjeta.numTarjeta1.value
			+ "" + document.formTarjeta.numTarjeta2.value
			+ "" + document.formTarjeta.numTarjeta3.value
			+ "" + document.formTarjeta.numTarjeta4.value);
	} else {
		return new String(document.formTarjeta.Sis_Numero_Tarjeta.value);
	}
}

/************************************************************
* 												[Ref0028]	
* Funcion: dameValorTarjetaUPI
* Devuelve:													
************************************************************/
function dameValorTarjetaUPI()
{
	if (document.formTarjeta.Sis_Numero_Tarjeta_UPI && document.formTarjeta.Sis_Numero_Tarjeta_UPI.value != "") {
		return new String(document.formTarjeta.Sis_Numero_Tarjeta_UPI.value);
	} else {
		return "";
	}
}

/************************************************************
* 													[Ref0029]	
* Funcion: focoTarjeta
* Parametros:
*		hacerSelect: booleano que indica si hacer select o no
* Devuelve:													
************************************************************/
function focoTarjeta(hacerSelect)
{
	if (document.formTarjeta.numTarjeta1) {
		if (hacerSelect) {
			document.formTarjeta.numTarjeta1.select();
		}
		document.formTarjeta.numTarjeta1.focus();
	} else {
		if (hacerSelect) {
			document.formTarjeta.Sis_Numero_Tarjeta.select();
		}
		document.formTarjeta.Sis_Numero_Tarjeta.focus();
	}
}

/************************************************************
* 												[Ref0029]	
* Funcion: focoTarjetaUPI
* Parametros:
*		hacerSelect: booleano que indica si hacer select o no
* Devuelve:													
************************************************************/
function focoTarjetaUPI(hacerSelect)
{
	if (hacerSelect) {
		document.formTarjeta.Sis_Numero_Tarjeta_UPI.select();
	}
	document.formTarjeta.Sis_Numero_Tarjeta_UPI.focus();
}

/************************************************************
* 												[Ref0030]	
* Funcion: PasarFoco
* Parametros:
*		caja: Objeto de tipo input que almacena la tarjeta de cuatro posiciones
* Devuelve:													
************************************************************/
function PasarFoco(caja)
{
	if (caja.value.length == 4) {
		if (caja == document.formTarjeta.numTarjeta1) {
			document.formTarjeta.numTarjeta2.select();
			document.formTarjeta.numTarjeta2.focus();
		} else if (caja == document.formTarjeta.numTarjeta2) {
			document.formTarjeta.numTarjeta3.select();
			document.formTarjeta.numTarjeta3.focus();	
		} else if (caja == document.formTarjeta.numTarjeta3) {
			document.formTarjeta.numTarjeta3.select();
			document.formTarjeta.numTarjeta4.focus();
		}
	}
}

/************************************************************
* 												[Ref0031]	
* Funcion: es4B								
* Parametros:												
*		laTarjeta													
* Devuelve:		
* 4B son los rangos entre 972464 y 972474 con longitud 16
************************************************************/
function es4B(laTarjeta) {
	laTarjeta = trim(laTarjeta);
	var binTarjeta = laTarjeta.substr(0,6);
	//alert('1-' + binTarjeta);
	if(binTarjeta >= 972464 && binTarjeta <= 972474 && laTarjeta.length == 16)
		return true;
	else
		return false;
}

/************************************************************
* Funcion: validaEsTarjeta
* Devuelve:													
************************************************************/
function validaEsTarjeta(st) {
	var sum = 0;
	var mul = 1;
	var l = st.length;
	for (i = 0; i < l; i++) {
		digit = st.substring(l-i-1,l-i);
		tproduct = parseInt(digit ,10)*mul;
		if (tproduct >= 10)
			sum += (tproduct % 10) + 1;
		else
			sum += tproduct;

		if (mul == 1)
			mul++;
		else
			mul--;
	}
	if ((sum % 10) == 0) {
		return (true);
	} else {
		return (false);
	}
}