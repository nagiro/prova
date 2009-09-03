<?php use_helper('Form')?>

<script type="text/javascript">

	function vacio(q){for(i=0;i<q.length;i++){if(q.charAt(i)!=" "){return true}}return false}  

	function ValidaReserva(){	
		if(valida_nif_cif_nie(fRegistre.usuaris_DNI.value) < 1) { alert("El DNI entrat no és correcte"); return false; }		
		if(vacio(fRegistre.usuaris_Passwd.value)== false){ alert("Has d\'entrar una contrasenya"); return false; }
		if(vacio(fRegistre.usuaris_Nom.value)== false){ alert("Has d'omplir el nom"); return false; }
		if(vacio(fRegistre.usuaris_Cog1.value)== false){ alert("Has d'omplir el primer cognom"); return false; }
		if(vacio(fRegistre.usuaris_Cog2.value)== false){ alert("Has d'omplir el segon cognom"); return false; }
		if(isValidEmail(fRegistre.usuaris_Email.value) == false){ alert("L'adreça de correu electrònic és incorrecta"); return false; }
		if(vacio(fRegistre.usuaris_Adreca.value)== false){ alert("Has d'omplir l'adreça postal"); return false; }
		if(vacio(fRegistre.usuaris_CodiPostal.value)== false){ alert("Has d'omplir el codi postal"); return false; }
		if(fRegistre.usuaris_Poblacio.selectedIndex<1){ alert("Has d'escollir alguna població"); return false; }				
		if(vacio(fRegistre.usuaris_Telefon.value)== false){ alert("Has d'omplir el telèfon"); return false; }
		if(fRegistre.VLOGIN.value != 'c!#G1'){ alert("El text de verificació no correspòn a la imatge"); return false; }
		
		return true;
			
	}

	function isValidEmail(str) {
   		return (str.indexOf(".") > 2) && (str.indexOf("@") > 0);
	}

	//Retorna: 1 = NIF ok, 2 = CIF ok, 3 = NIE ok, -1 = NIF error, -2 = CIF error, -3 = NIE error, 0 = ??? error
	function valida_nif_cif_nie(a) 
	{	
		var temp=a.toUpperCase();
		var cadenadni="TRWAGMYFPDXBNJZSQVHLCKE";
	 
		if (temp!==''){
			if ((!/^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$/.test(temp) && !/^[T]{1}[A-Z0-9]{8}$/.test(temp)) && !/^[0-9]{8}[A-Z]{1}$/.test(temp)){return 0;}
			if (/^[0-9]{8}[A-Z]{1}$/.test(temp))
			{posicion = a.substring(8,0) % 23;letra = cadenadni.charAt(posicion);var letradni=temp.charAt(8);if (letra == letradni){return 1;}else{return -1;}}
			suma = parseInt(a[2])+parseInt(a[4])+parseInt(a[6]);
			for (i = 1; i < 8; i += 2){temp1 = 2 * parseInt(a[i]);temp1 += '';temp1 = temp1.substring(0,1);temp2 = 2 * parseInt(a[i]);temp2 += '';temp2 = temp2.substring(1,2);if (temp2 == ''){temp2 = '0';}suma += (parseInt(temp1) + parseInt(temp2));}
			suma += '';
			n = 10 - parseInt(suma.substring(suma.length-1, suma.length));
			if (/^[KLM]{1}/.test(temp)){if (a[8] == String.fromCharCode(64 + n)){return 1;}else{return -1;}}
			if (/^[ABCDEFGHJNPQRSUVW]{1}/.test(temp)){temp = n + '';if (a[8] == String.fromCharCode(64 + n) || a[8] == parseInt(temp.substring(temp.length-1, temp.length))){return 2;}else{return -2;}}
			if (/^[T]{1}/.test(temp)){if (a[8] == /^[T]{1}[A-Z0-9]{8}$/.test(temp)){return 3;}else{return -3;}} 
			if (/^[XYZ]{1}/.test(temp)){pos = str_replace(['X', 'Y', 'Z'], ['0','1','2'], temp).substring(0, 8) % 23;if (a[8] == cadenadni.substring(pos, pos + 1)){return 3;}else{return -3;}}
		}
 
		return 0;
	}

</script>

<TD colspan="3" class="CONTINGUT">
   
   <form action="<?php echo url_for('web/registrat')?>" method="post" name="fRegistre" onSubmit="return ValidaReserva(this);">
      
   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Registre de nou usuari</LEGEND>   
   <TABLE class="FORMULARI">
   	<?
   	 
	   if($ESTAT == 'OK'):
	      ?><TR><TD class="OK" colspan="2">Usuari donat d'alta correctament<BR /><BR /></TD></TR><?
       elseif($ESTAT == 'ERROR'):
	      ?><TR><TD class="ERROR" colspan="2">L'usuari ja existeix.<br /> Si vol que li enviem la contrasenya al seu correu cliqui <?php echo link_to('aquí','web/reenviaContrasenya?DNI='.$FUSUARI->getValue('DNI'),array('class'=>'taronja'))?>.<BR /><BR /></TD></TR><?php       
       endif;	
       
       echo $FUSUARI;
    
    ?>
   
	<TR><TD><b>Verificació</b></TD><TD><?php echo image_tag('intranet/verificaLogin.png'); echo "<br />Escriu el text de la imatge: ".input_tag('VLOGIN','',array('style'=>'width:30%')); ?></TD></TR>
   </TABLE>      
   </FIELDSET>       

   <FIELDSET class="REQUADRE" style="width:50%"><LEGEND class="LLEGENDA">Accions</LEGEND>
   <TABLE class="FORMULARI">
	   <TR><TD><?php echo submit_tag('Registra\'m',array('style'=>'width:100px;')); ?> </TD><TD></TD><TD></TD></TR>                        
   </TABLE>      
   </FIELDSET>       

   
   </FORM>	
   
   <DIV STYLE="height:40px;"></DIV>
   
</TD>