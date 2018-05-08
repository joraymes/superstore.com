/* -------------------------------  valida_form   ----------------------------------------------
Descripción	:   Evalua un Objeto formulario de multiples características
Recibe		: 	objForm:como un Objeto formulario del documento. 
				msgType:como string indicando el modo de mensaje de error (ver Mensajes de Error)
				msgLanguage:como string indicando el idioma de los mensajes de error ( ver Idioma)
				msgXmlDoc: como string indicando la ruta  del fichero xml de mensajes de error
							ej: '/js/valida_form.xml'
Devuelve	:	True si todos los elementos del formulario son correctos.
				False en caso de existir un campo o mas, mal rellenado.
			 
Uso:		Añadir en los elementos del formulario el atributo "class"
					con [opcion] para indicar a la función que formato se 
					requiere.
			
		[opcion]		: Descripcion
		"txt-obl"		: Para input text obligatorios.
		"isOnlyChars" 	: Para inputs text con formato solo caracteres.
		"isNumber"		: Para inputs text con formato numero entero.
		"email"			: Para inputs que requieren una dir. Correo
		"chk-obl"		: Para inputs checkbox obligatorios.
		"rad-obl"		: Para inputs radio obligatorios.
		"sel-obl"		: Para select obligatorios (no multiples).
		"mult-obl"		: Para select multiples obligatorios.
		"NIF"			: Para inputs que requieren un NIF.
		"passValid"		: Para inputs de password que requieren confirmar
						  si son iguales.
			"passValid-org" : para el original.
			"passValid-conf": para el de confirmacion.
			
		"isDate-dd-mm-yyyy"	: Para inputs con formato de fecha "dd/mm/yyy"
		
		"fechas"		: Para inputs de fechas con fechas inicio y fin. 
						  Compara ambas fechas  y comprueba que fechas-inicio 
						  sea anterior a fechas-fin.
			"fechas-inicio" : fecha inicial.
			"fechas-fin"	: fecha final.
			
		"fecha-max-dd-mm-yyyy" 	: Para inputs que requieren una fecha maxima. Ej class=" fecha-max-12-10-2010"
		"fecha-min-dd-mm-yyyy" 	: Para inputs que requieren una fecha minima. Ej class=" fecha-min-12-10-2010"
		
Mensajes de Error : Los valores msgType pueden ser:
		
		'sibling' 			:	El mensaje de error proviene del xml y  aparece en un nuevo contenedor hermano al campo.
		'id'				: 	El mensaje de error proviene del xml y aparece en el contenedor con id ="errMsg".
		'alert'				:	El mensaje de error proviene del xml y aparece en un alert cutre y salchichero.
		'displaySibling'	:	El mensaje de error se escribe en un hermano al lado del campo
	
Idioma: Los valores de msgLanguage pueden ser los que esten editados para cada combinacion de 
		[opcion] dentro del fichero xml . por defecto tenemos editados los idioma de 
		'es' : español , 'ca' : Catala, 'en':ingles , 'fr' : frances. 

Autor:		Quim Aymerich quim.aymerich@gmail.com				
Fecha:		Abril 2018.
----------------------------------------------------------------------------------------------*/


	function validaform(objForm, msgType,msgLanguage,msgXmlDoc){
		var totOk=true;

		// ----------------------- Eliminar todos los contenedores de error ----------
		var arrObj = document.getElementsByClassName("err-msg");
		while(arrObj.length > 0){
			arrObj[0].parentNode.removeChild(arrObj[0]);
	    }

		// ----------------------- Bucle principal de control de formulario -----------
		for(i=0; i<= objForm.elements.length-1 ; i++){
			// ----------------------------- txt-obl ----------------------------------
			if(objForm.elements[i].className.lastIndexOf('txt-obl')!=-1){
				if(objForm.elements[i].value.trim()==''){
					switch(msgType){
						case 'sibling':
							var objErr= document.createElement('p');
							var txtErr= document.createTextNode(validaform_loadXmlReports('txt-obl',msgLanguage,msgXmlDoc));
							objErr.appendChild(txtErr);
							var att = document.createAttribute("class");       // Create a "class" attribute
							att.value = "err-msg";                           // Set the value of the class attribute
							objErr.setAttributeNode(att);     
							objForm.elements[i].insertAdjacentElement('afterend',objErr);
							break;
						case 'id' :
							document.getElementById('errMsg').innerHTML=validaform_loadXmlReports('txt-obl',msgLanguage,msgXmlDoc);
							break;
						case 'alert':
							alert(validaform_loadXmlReports('txt-obl',msgLanguage,msgXmlDoc));
							break;
						case 'displaySibling':
							objForm.elements[i].nextElementSibling.style.visibility='visible';
							break;
						
					}
					
					totOk=false;
				}
			}
			/* --------------------- inici isOnlyChars -------------------*/
			if(objForm.elements[i].className.indexOf('isOnlyChars')!=-1 ){
				objForm.elements[i].value= validaform_eliminaEspacios(objForm.elements[i].value);
				if(  ! validaform_isOnlyChars(objForm.elements[i].value)   ){
					
					switch(msgType){
						case 'sibling':
							var objErr= document.createElement('p');
							var txtErr= document.createTextNode(validaform_loadXmlReports('isOnlyChars',msgLanguage,msgXmlDoc));
							objErr.appendChild(txtErr);
							var att = document.createAttribute("class");       // Create a "class" attribute
							att.value = "err-msg";                           // Set the value of the class attribute
							objErr.setAttributeNode(att);     
							objForm.elements[i].insertAdjacentElement('afterend',objErr);
							break;
						case 'id' :
							document.getElementById('errMsg').innerHTML=validaform_loadXmlReports('isOnlyChars',msgLanguage,msgXmlDoc);
							break;
						case 'alert':
							alert(validaform_loadXmlReports('isOnlyChars',msgLanguage,msgXmlDoc));
							break;
						case 'displaySibling':
							objForm.elements[i].nextSibling.style.visibility='visible';
							break;		
					}
					totOK=false;
				}
			}
			
			/* --------------------- inici isNumber -------------------*/
			if(objForm.elements[i].className.indexOf('isNumber')!=-1 ){
				objForm.elements[i].value= validaform_eliminaEspacios(objForm.elements[i].value);
				if(  ! validaform_isNumber(objForm.elements[i].value)   ){
					
					switch(msgType){
						case 'sibling':
							var objErr= document.createElement('p');
							var txtErr= document.createTextNode(validaform_loadXmlReports('isNumber',msgLanguage,msgXmlDoc));
							objErr.appendChild(txtErr);
							var att = document.createAttribute("class");       // Create a "class" attribute
							att.value = "err-msg";                           // Set the value of the class attribute
							objErr.setAttributeNode(att);     
							objForm.elements[i].insertAdjacentElement('afterend',objErr);
							break;
						case 'id' :
							document.getElementById('errMsg').innerHTML=validaform_loadXmlReports('isNumber',msgLanguage,msgXmlDoc);
							break;
						case 'alert':
							alert(validaform_loadXmlReports('isNumber',msgLanguage,msgXmlDoc));
							break;
						case 'displaySibling':
							objForm.elements[i].nextSibling.style.visibility='visible';
							break;		
					}
					totOK=false;
				}
			}
			
			/* --------------------- inici email -------------------*/
			if(objForm.elements[i].className.indexOf('email')!=-1 ){
				objForm.elements[i].value= validaform_eliminaEspacios(objForm.elements[i].value);
				if( ! validaform_parseEmail( objForm.elements[i].value)){
					objForm.elements[i].className += ' email-err ';
					switch(msgType){
						case 'sibling':
							var objErr= document.createElement('p');
							var txtErr= document.createTextNode(validaform_loadXmlReports('email',msgLanguage,msgXmlDoc));
							objErr.appendChild(txtErr);
							var att = document.createAttribute("class");       // Create a "class" attribute
							att.value = "err-msg";                           // Set the value of the class attribute
							objErr.setAttributeNode(att);     
							objForm.elements[i].insertAdjacentElement('afterend',objErr);
							break;
						case 'id' :
							document.getElementById('errMsg').innerHTML=validaform_loadXmlReports('email',msgLanguage,msgXmlDoc);
							break;
						case 'alert':
							alert(validaform_loadXmlReports('email',msgLanguage,msgXmlDoc));
							break;
						case 'displaySibling':
							objForm.elements[i].nextSibling.style.visibility='visible';
							break;		
					}
					totOK=false;
				}
			}
			
			/* --------------------- inici chk-obl -------------------*/
			if(objForm.elements[i].className.indexOf('chk-obl')!=-1 ){
				if(  objForm.elements[i].checked==false ){
					objForm.elements[i].className += ' chkobl-err ';
					switch(msgType){
						case 'sibling':
							var objErr= document.createElement('p');
							var txtErr= document.createTextNode(validaform_loadXmlReports('chk-obl',msgLanguage,msgXmlDoc));
							objErr.appendChild(txtErr);
							var att = document.createAttribute("class");       // Create a "class" attribute
							att.value = "err-msg";                           // Set the value of the class attribute
							objErr.setAttributeNode(att);     
							objForm.elements[i].insertAdjacentElement('afterend',objErr);
							break;
						case 'id' :
							document.getElementById('errMsg').innerHTML=validaform_loadXmlReports('chk-obl',msgLanguage,msgXmlDoc);
							break;
						case 'alert':
							alert(valida_form_loadXmlReports('chk-obl',msgLanguage,msgXmlDoc));
							break;
						case 'displaySibling':
							objForm.elements[i].nextSibling.style.visibility='visible';
							break;		
					}
					totOK=false;
				}
			}
			
			
			/* --------------------- inici rad-obl ------------------------*/
			if(objForm.elements[i].className.indexOf('rad-obl')!=-1 ){
				var isChecked=false;
				var arrObjRadio = document.getElementsByName(objForm.elements[i].name);
				for(var radio=0; radio<=arrObjRadio.length-1;radio++){
					if(arrObjRadio[radio].checked==true){
						isChecked=true;
					}
				}
				if(! isChecked){
					
					switch(msgType){
						case 'sibling':
							var objErr= document.createElement('p');
							var txtErr= document.createTextNode(validaform_loadXmlReports('rad-obl',msgLanguage,msgXmlDoc));
							objErr.appendChild(txtErr);
							var att = document.createAttribute("class");       // Create a "class" attribute
							att.value = "err-msg";                           // Set the value of the class attribute
							objErr.setAttributeNode(att);     
							objForm.elements[i].insertAdjacentElement('afterend',objErr);
							break;
						case 'id' :
							document.getElementById('errMsg').innerHTML=validaform_loadXmlReports('rad-obl',msgLanguage,msgXmlDoc);
							break;
						case 'alert':
							alert(validaform_loadXmlReports('rad-obl',msgLanguage,msgXmlDoc));
							break;
						case 'displaySibling':
							objForm.elements[i].nextSibling.style.visibility='visible';
							break;		
					}
					totOK=false;
				}
			}
			
			// ----------------------inici bloque sel-obl ---------------------------------
			
			if(objForm.elements[i].className.lastIndexOf('sel-obl')!=-1){
				if(objForm.elements[i].selectedIndex == 0){
					switch(msgType){
					case 'sibling':
						var objErr= document.createElement('p');
						var txtErr= document.createTextNode(validaform_loadXmlReports('sel-obl',msgLanguage,msgXmlDoc));
						objErr.appendChild(txtErr);
						var att = document.createAttribute("class");       // Create a "class" attribute
						att.value = "err-msg";                           // Set the value of the class attribute
						objErr.setAttributeNode(att);     
						objForm.elements[i].insertAdjacentElement('afterend',objErr);
						break;
					case 'id' :
						document.getElementById('errMsg').innerHTML=validaform_loadXmlReports('sel-obl',msgLanguage,msgXmlDoc);
						break;
					case 'alert':
						alert(validaform_loadXmlReports('txt-obl',msgLanguage,msgXmlDoc));
						break;
					case 'displaySibling':
						objForm.elements[i].nextElementSibling.style.visibility='visible';
						break;
					
				}
					totOk=false;
				}
			}
			
			// --------------------- inici bloque mult-obl ---------------------------- 
			if(objForm.elements[i].className.indexOf('mult-obl')!=-1 ){
				var isSelected=false;
				for(var opt=0 ; opt<=objForm.elements[i].length-1; opt++){
					if( objForm.elements[i].options[opt].selected==true   ){
						isSelected=true;
					}
				}
				if( !isSelected ){
					switch(msgType){
						case 'sibling':
							var objErr= document.createElement('p');
							var txtErr= document.createTextNode(validaform_loadXmlReports('mult-obl',msgLanguage,msgXmlDoc));
							objErr.appendChild(txtErr);
							var att = document.createAttribute("class");       // Create a "class" attribute
							att.value = "err-msg";                           // Set the value of the class attribute
							objErr.setAttributeNode(att);     
							objForm.elements[i].insertAdjacentElement('afterend',objErr);
							break;
						case 'id' :
							document.getElementById('errMsg').innerHTML=validaform_loadXmlReports('mult-obl',msgLanguage,msgXmlDoc);
							break;
						case 'alert':
							alert(validaform_loadXmlReports('mult-obl',msgLanguage,msgXmlDoc));
							break;
						case 'displaySibling':
							objForm.elements[i].nextSibling.style.visibility='visible';
							break;		
					}
					totOK=false;
				}
			}
			
			// --------------- Inicio bloque NIF ---------------------------------
			if(objForm.elements[i].className.indexOf('NIF')!=-1){
			  	objForm.elements[i].value=validaform_eliminaEspacios(objForm.elements[i].value);
			  	if(validaform_parseNIF(objForm.elements[i].value)==false){
					
					switch(msgType){
						case 'sibling':
							var objErr= document.createElement('p');
							var txtErr= document.createTextNode(validaform_loadXmlReports('NIF',msgLanguage,msgXmlDoc));
							objErr.appendChild(txtErr);
							var att = document.createAttribute("class");       // Create a "class" attribute
							att.value = "err-msg";                           // Set the value of the class attribute
							objErr.setAttributeNode(att);     
							objForm.elements[i].insertAdjacentElement('afterend',objErr);
							break;
						case 'id' :
							document.getElementById('errMsg').innerHTML=validaform_loadXmlReports('NIF',msgLanguage,msgXmlDoc);
							break;
						case 'alert':
							alert(validaform_loadXmlReports('NIF',msgLanguage,msgXmlDoc));
							break;
						case 'displaySibling':
							objForm.elements[i].nextSibling.style.visibility='visible';
							break;		
					}
					
					todoOk = false;
			  }	
			}
			
			// --------------- Inicio bloque PassValid -----------------------
			if(objForm.elements[i].className.indexOf('passValid')!=-1){
				var ArrPassword=new Array();
				for(k=0;k<=objForm.length-1;k++){
					if(objForm.elements[k].className.indexOf('passValid')!=-1){
						ArrPassword.push(objForm.elements[k].value);
					}
				}
				var Iguales=true;
				for(k=0;k<=ArrPassword.length-1;k++){ 
					if(ArrPassword[0]!=ArrPassword[k]){ 
						Iguales=false; 	console.log('no iguales');
					}
				}
				if((!Iguales) && (objForm.elements[i].className.indexOf('passValid-conf')!=-1) ){
					switch(msgType){
						case 'sibling':
							var objErr= document.createElement('p');
							var txtErr= document.createTextNode(validaform_loadXmlReports('passValid',msgLanguage,msgXmlDoc));
							objErr.appendChild(txtErr);
							var att = document.createAttribute("class");       // Create a "class" attribute
							att.value = "err-msg";                           // Set the value of the class attribute
							objErr.setAttributeNode(att);     
							objForm.elements[i].insertAdjacentElement('afterend',objErr);
							break;
						case 'id' :
							document.getElementById('errMsg').innerHTML=validaform_loadXmlReports('passValid',msgLanguage,msgXmlDoc);
							break;
						case 'alert':
							alert(validaform_loadXmlReports('passValid',msgLanguage,msgXmlDoc));
							break;
						case 'displaySibling':
							objForm.elements[i].nextSibling.style.visibility='visible';
							break;		
					}
					todoOk = false;
				}
			}
			
			// ---------------Inicio bloque isDate-dd-mm-yyyy -----------------
			if(objForm.elements[i].className.indexOf('isDate-dd-mm-yyyy')!=-1){
				objForm.elements[i].value=validaform_eliminaEspacios(objForm.elements[i].value);
				if(  validaform_parseDateDdMmYyyy(objForm.elements[i].value) == false    ){
					switch(msgType){
						case 'sibling':
							var objErr= document.createElement('p');
							var txtErr= document.createTextNode(validaform_loadXmlReports('isDateDdMmYyyy',msgLanguage,msgXmlDoc));
							objErr.appendChild(txtErr);
							var att = document.createAttribute("class");       // Create a "class" attribute
							att.value = "err-msg";                           // Set the value of the class attribute
							objErr.setAttributeNode(att);     
							objForm.elements[i].insertAdjacentElement('afterend',objErr);
							break;
						case 'id' :
							document.getElementById('errMsg').innerHTML=validaform_loadXmlReports('isDateDdMmYyyy',msgLanguage,msgXmlDoc);
							break;
						case 'alert':
							alert(validaform_loadXmlReports('isDateDdMmYyyy',msgLanguage,msgXmlDoc));
							break;
						case 'displaySibling':
							objForm.elements[i].nextSibling.style.visibility='visible';
							break;		
					}
					todoOk = false;
				}
			}
			
			// -------------- Inicio bloque fechas ----------------------------
			if(objForm.elements[i].className.indexOf('fechas-fin')!=-1){
				var fechasFin =validaform_eliminaEspacios(objForm.elements[i].value);
				var fechasInicio;
				for(var k=0;k<=objForm.length-1;k++){
					if(objForm.elements[k].className.indexOf('fechas-inicio')!=-1){
						fechasInicio=validaform_eliminaEspacios(objForm.elements[k].value);
					}
				}
				fechaAUX = fechasInicio.split("/");
				fechasInicio = new Date()
				fechasInicio.setDate(fechaAUX[0]);
				fechasInicio.setMonth(eval(fechaAUX[1])-1);
				fechasInicio.setYear(fechaAUX[2]);
				fechasInicio.setHours(0);
				fechasInicio.setMinutes(0);
				fechasInicio.setSeconds(0);

				fechaAUX = fechasFin.split("/");
				fechasFin = new Date()
				fechasFin.setDate(fechaAUX[0]);
				fechasFin.setMonth(eval(fechaAUX[1])-1);
				fechasFin.setYear(fechaAUX[2]);
				fechasFin.setHours(0);
				fechasFin.setMinutes(0);
				fechasFin.setSeconds(0);

				var NumDias = (fechasFin.getTime()/86400000)-(fechasInicio.getTime()/86400000);
				if(NumDias<=0){
					switch(msgType){
						case 'sibling':
							var objErr= document.createElement('p');
							var txtErr= document.createTextNode(validaform_loadXmlReports('fechas',msgLanguage,msgXmlDoc));
							objErr.appendChild(txtErr);
							var att = document.createAttribute("class");       // Create a "class" attribute
							att.value = "err-msg";                           // Set the value of the class attribute
							objErr.setAttributeNode(att);     
							objForm.elements[i].insertAdjacentElement('afterend',objErr);
							break;
						case 'id' :
							document.getElementById('errMsg').innerHTML=validaform_loadXmlReports('fechas',msgLanguage,msgXmlDoc);
							break;
						case 'alert':
							alert(validaform_loadXmlReports('fechas',msgLanguage,msgXmlDoc));
							break;
						case 'displaySibling':
							objForm.elements[i].nextSibling.style.visibility='visible';
							break;		
					}
					todoOk = false;
				}
			}
		}
		return totOk;
		
	}
	
	/* ---------------------- validaform_eliminaEspacios(Cadena)----------------------------------
	Descripcio : 		Eliminar espais de davant darrera i intermitjos d'una cadena.
	Valors d'entrada: 	Cadena  de text
	Valors de sortida: 	La mateixa cadena sense espais
	-----------------------------------------------------------------------------------*/
	function validaform_eliminaEspacios(Cadena){
		while(Cadena.charAt(0)==' '){
		// Elimina los Caracters del principi
			Cadena=Cadena.substring(1,Cadena.length);
		}
		while(Cadena.charAt(Cadena.length-1)==' '){ 
			// Eleminar caracteres del final
			Cadena=Cadena.substring(0,Cadena.length-1);
		}
		for( var pos=0;pos<=Cadena.length-1;pos++){
		//Recorer cadena desde pos=0 hasta pos=length-1 
			while(Cadena.charAt(pos)==" " && Cadena.charAt(pos+1)==" "){ 
				// mientras posicion actual y la siguiente son espacio en blanco pues...
				//Cortamos de pos=0 de Cadena hasta caracter en posicion 'pos'
				//sin incluir este.
				var parteA=Cadena.substring(0,pos); 
				// Cortamos des de caractes en pos+1 hasta el final de cadena.
				var parteB=Cadena.substring(pos+1);
				// Unimos las dos partes en una y volvemos a ponerlo en variable Cadena.
			Cadena=parteA+parteB;
			}
		}
		return Cadena;
	}
	
	/* ---------------------------- validaform_isOnlyChars -----------------------------
	Descripcio: busca un caracter numero dintre d'una caden
	Recibe: 	Objeto string Cadena
	Devuelve: 	true si no hay caracteres numero
				false si detecta algun caracter de 0 a 9
	 -------------------------------------------------------------------------------------*/
	function validaform_isOnlyChars(Cadena){
		if(Cadena.length==0){ return true;}
		var caracter=0;
		while(caracter<=Cadena.length-1){
			if( ! isNaN(Cadena.charAt(caracter)  ) &&  Cadena.charAt(caracter) !=' '    ){
				return false;
			}
			caracter++;
		}
		return true;
	}
	
	/* ----------------- validaform_isNumber(Cadena) -------------------------------------------------
	Descripcion: 	Detecta de una cadena los caracteres del 0 al 9
	Recibe: 		Un String en la variables local Cadena.
	Devuelve: 		true si detecta solo numeros, sino devuelve false cuando detecta letras
	--------------------------------------------------------------------------------------*/
	function validaform_isNumber(Cadena){
		var pos=(Cadena.charAt(0)=='-')? 1:0;
		while(pos<=Cadena.length-1){ //Recorer cadena desde pos=0 hasta pos=length-1 
			if(isNaN(Cadena.charAt(pos)) || Cadena.charAt(pos)==" " ){// si isNaN nos devuelve true(es una letra)
				return false; //Devolvemos  false si hay letras
			}
			pos++
		}
		return true; //Devolvemos  true si solo hay numeros
	}
	
	/* ---------------------------- validaform_parseEmail -----------------------------
	Descripcion: Evalua una cadena en formato Email
	Recibe: 	Objeto string Cadena
	Devuelve: 	true si es correcto
				false si NO es correcto
	 -------------------------------------------------------------------------------------*/
	function validaform_parseEmail(Cadena){
		if(Cadena.length==0) return true;
		var valido;
		Punto = Cadena.substring(Cadena.lastIndexOf('.') + 1, Cadena.length) ;           	// Cadena del .com  
		Dominio = Cadena.substring(Cadena.lastIndexOf('@') + 1, Cadena.lastIndexOf('.'));   // Dominio @lala.com  
		Usuario = Cadena.substring(0, Cadena.lastIndexOf('@'))   ;   // Cadena lalala@  
		Reserv = "@/º\"\'+*{}\\<>?¿[]áéíñóú#·¡!^*;,:"      ;         // Letras Reservadas  
  
		// Añadida por El Codigo para poder emitir un alert en funcion de si email valido o no  
		valido = true ; 
  
		// verifica qie el Usuario no tenga un caracter especial  
		for (var Cont=0; Cont<Usuario.length; Cont++) {  
   			 X = Usuario.substring(Cont,Cont+1) ; 
    		if (Reserv.indexOf(X)!=-1)   valido = false  ;
                
		}  

		// verifica qie el Punto no tenga un caracter especial  
		for (var Cont=0; Cont<Punto.length; Cont++) {  
    		X=Punto.substring(Cont,Cont+1)  ;
    		if (Reserv.indexOf(X)!=-1)  valido = false ;
        		 
		}  
                      
		// verifica qie el Dominio no tenga un caracter especial  
		for (var Cont=0; Cont<Dominio.length; Cont++) {  
    		X=Dominio.substring(Cont,Cont+1) ; 
    		if (Reserv.indexOf(X)!=-1)  valido = false ;
       			 
    	}  

		// Verifica la sintaxis básica.....  
		if (Punto.length<2 || Dominio <1 || Cadena.lastIndexOf('.')<0 || Cadena.lastIndexOf('@')<0 || Usuario<1) {  
    		valido = false  ;
		}  
  		return valido;
	}
	
	/* ------------------------------- validaform_loadXmlReports ------------------------------------
	Descripcion: Busca en un documento xml el mensaje de error de la funcion valida_form
	Recibe: 	errMsgCategory : clave de error, ejemplo: txtobl, radobl, etc....
				language : clave de idioma, ejemplo: ca, es, en, etc....
				msgXmlDoc: ruta al documento xml
	Devuelve: 	Cadena de texto del documento xml . 
	------------------------------------------------------------------------------------*/
	function validaform_loadXmlReports(errMsgCategory, language,msgXmlDoc){
		if (window.XMLHttpRequest){
			var xhttp=new XMLHttpRequest();
		}else{ // IE 5/6
			var xhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xhttp.open("GET",msgXmlDoc,false);
		xhttp.send(null);
		var xmlDoc=xhttp.responseXML;
		var errMsgNode=xmlDoc.getElementsByTagName("errMsg");
		for (var k=0;k<errMsgNode.length;k++){ 
			
			if(errMsgNode[k].attributes[0].value==errMsgCategory){
				var errLanguageNodes=errMsgNode[k].childNodes;
				for (var j=0;j<errLanguageNodes.length;j++){ 
					if(errLanguageNodes[j].nodeName==language){
						return errLanguageNodes[j].firstChild.nodeValue;
					}
				}
			}
		}
		return '';
	}
	
	/*--------------- ParseNIF --------------------------------------
	Descripción: Valida de nurmeo NIF de una cadena
	Recibe: cadena texto. por ejemplo un campo de texto de formulario.
	Devuelve: true si cadena es un NIF valido, sino false. 
	---------------------------------------------------------------*/
	function validaform_parseNIF(cadena){
		
		if(validaform_eliminaEspacios(cadena)==''){
			return true;
		}
		var Clave=new Array("T","R","W","A","G","M","Y","F","P","D","X","B"
				 ,"N","J","Z","S","Q","V","H","L","C","K","E","T");
		var PrimerDigito=cadena.substr(0,1).toUpperCase();
		var UltimoDigito=cadena.substr(cadena.length-1).toUpperCase();
		if (!isNaN(PrimerDigito)){
			Numeros=cadena.substr(0,8).toUpperCase();
		}else{
			switch (PrimerDigito) { 
				case "K": case "L": case "M": case "X":	case "Y": 
					Numeros=cadena.substr(1,7);
					break;
				default: return false;
			}
	    }
		if (isNaN(Numeros)){
			return false;
		}else{
			Letra=Clave[Numeros%23];
			if(Letra==UltimoDigito){
				return true;
			}else{
				return false;
			}
		}
	}
	
	/*--------------- validaform_parseDateDdMmYyyy --------------------------------------
	Descripció: Validació de format data dd/mm/yyyy.
	Recibe: cadena texto. por ejemplo un campo de texto de formulario.
	Devuelve: true si cadena es un NIF valido, sino false. 
	---------------------------------------------------------------*/
	function validaform_parseDateDdMmYyyy(Cadena){
		if( Cadena.length==0 ){ return true;} // si es cadena buida no cal seguir.
		var Fecha= new String(Cadena);  // ⁄⁄ Crea un string  
	    var RealFecha= new Date();//⁄⁄ Para sacar la fecha de hoy  
	    var Ano= new String(Fecha.substring(Fecha.lastIndexOf("/")+1,Fecha.length)); // Cadena Año
	    var Mes= new String(Fecha.substring(Fecha.indexOf("/")+1,Fecha.lastIndexOf("/")));//⁄⁄ Cadena Mes  
	    var Dia= new String(Fecha.substring(0,Fecha.indexOf("/")));//Cadena Día 
	    if (isNaN(Ano) || Ano.length<4 || parseFloat(Ano)<1900){//Valido el año  
	        return false ; 
	    }  
	    if (isNaN(Mes) || parseFloat(Mes)<1 || parseFloat(Mes)>12){//Valido el Mes  
	    	return false ; 
	    }  
	     if (isNaN(Dia) || parseInt(Dia, 10)<1 || parseInt(Dia, 10)>31){//⁄Valido el Dia 
	        return false ; 
	     }  
	     if (Mes==4 || Mes==6 || Mes==9 || Mes==11 || Mes==2) {  
	         if (Mes==2 && Dia > 28 || Dia>30) {  
	             return false;  
	         }  
	     }  
	   return true;   
	}
	
	