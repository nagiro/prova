<style>
	fieldset { border:3px solid #F3F3F3; margin-right:40px; padding:10px; }
	.MISSAT { color:black; font-weight:bold; font-size:10px; vertical-align:middle; text-align:center; background-color:White; padding-bottom:10px; }
	.CURS { font-size: 12px; padding:5px; vertical-align:bottom;  }
	.LEGEND { font-size:12px; font-weight:bold; padding:10px 10px 10px 10px;  }
	TEXTAREA { border:1px solid #CCCCCC; width:90%; }
	.DADES .LINIA .blue { color:blue; }
	.DADES .LINIA .blue:hover { color:blue; }
	.DADES .LINIA .blue:visited { color:blue; }
	
</style>


   <TD colspan="3" class="CONTINGUT">

	<?php  
		
	   switch($MODUL){
	      case 'gestiona_dades': gestiona_dades( $USUARI , $MISSATGE ); break;
	      case 'gestiona_cursos': gestiona_cursos( $CURSOS , $MATRICULES , $MISSATGE ); break;
	      case 'gestiona_llistes': gestiona_llistes( $LLISTES , $MISSATGE ); break;
	      case 'gestiona_reserves': gestiona_reserves( $RESERVA , $RESERVES , $MISSATGE ); break;
	      case 'gestiona_verificacio' : gestiona_verificacio($DADES_MATRICULA , $TPV); break;    
	   }
		
	?>   
      
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    

<?php 

function gestiona_dades($USUARI,$MISSATGE){
   echo nice_form_tag('web/gestio?accio=sd',array('method'=>'POST'));   
   ?> 
   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Dades personals</LEGEND>
   <TABLE class="DADES">
   <?php if(!empty($MISSATGE)): ?> 
   		<TR>
   			<TD class="MISSAT" colspan="2">
   				<? foreach($MISSATGE as $M): echo $M."<BR>";  endforeach; ?>    				
   			</TD>
   		</TR>
   	<? endif; ?>   
   <TR><TD class="LINIA">DNI</TD>                <TD class="LINIA"><?php echo input_tag('DNI',$USUARI->getDni(),array('disabled'=>false)); ?></TD></TR>      
   <TR><TD class="LINIA">Contrasenya</TD>        <TD class="LINIA"><?php echo input_password_tag('PASSWD',$USUARI->getPasswd()); ?></TD></TR>
   <TR><TD class="LINIA">Nom</TD>                <TD class="LINIA"><?php echo input_tag('NOM',$USUARI->getNom()); ?></TD></TR>
   <TR><TD class="LINIA">Primer cognom</TD>      <TD class="LINIA"><?php echo input_tag('COG1',$USUARI->getCog1()); ?></TD></TR>
   <TR><TD class="LINIA">Segon cognom</TD>       <TD class="LINIA"><?php echo input_tag('COG2',$USUARI->getCog2()); ?></TD></TR>
   <TR><TD class="LINIA">Correu electrònic</TD>  <TD class="LINIA"><?php echo input_tag('EMAIL',$USUARI->getEmail()); ?></TD></TR>
   <TR><TD class="LINIA">Adreça postal</TD>      <TD class="LINIA"><?php echo input_tag('ADRECA',$USUARI->getAdreca()); ?></TD></TR>
   <TR><TD class="LINIA">Codi postal</TD>        <TD class="LINIA"><?php echo input_tag('CODIPOSTAL',$USUARI->getCodiPostal()); ?></TD></TR>
   <TR><TD class="LINIA">Població</TD>           <TD class="LINIA"><?php echo select_tag('POBLACIO',options_for_select(PoblacionsPeer::select(),$USUARI->getPoblacio())); echo input_tag('POBLACIOT',$USUARI->getPoblaciotext()); ?></TD></TR>
   <TR><TD class="LINIA">Telèfon</TD>            <TD class="LINIA"><?php echo input_tag('TELEFON',$USUARI->getTelefon()); ?></TD></TR>
   <TR><TD class="LINIA">Mòbil</TD>              <TD class="LINIA"><?php echo input_tag('MOBIL',$USUARI->getMobil()); ?></TD></TR>
   <TR><TD class="LINIA">Entitat</TD>            <TD class="LINIA"><?php echo input_tag('ENTITAT',$USUARI->getEntitat()); ?></TD></TR>                        
   </TABLE>   
   
   </FIELDSET>
   
   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Dades personals</LEGEND>
   <TABLE class="FORMULARI">
	   <TR><TD></TD><TD><?php echo submit_tag('Modifica',array('style'=>'width:100px;')); ?> </TD>                        
   </TABLE>      
   </FIELDSET>
   
   <?php  
} 

function gestiona_llistes( $LLISTES , $MISSATGE ){
   
  echo nice_form_tag('web/gestio?accio=sl',array('method'=>'POST')); ?>
   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Llistes de correu</LEGEND>   
	<table class="FORMULARI">   
      <? foreach(LlistesPeer::select() as $K=>$L): ?>          
		<TR><TD><?=checkbox_tag('LLISTA[]',$K,isset($LLISTES[$K]))?></TD><TD><?=$L?></TD></TR>      	
      <? endforeach; ?>	
	</table>         
   </FIELDSET>

   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Accions</LEGEND>   
	<table class="FORMULARI">   
		<TR><TD colspan="2"><?=submit_tag('Modifica', array('style'=>'width:100px;')); ?></TD></TR>
	</table>         
   </FIELDSET>


   <?
}

function gestiona_cursos( $CURSOS , $MATRICULES , $MISSATGES ) {   
   echo nice_form_tag('web/gestio?accio=im',array('method'=>'POST'));
   ?>
   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Cursos matriculats</LEGEND>           
   <TABLE class="FORMULARI">
   <? if(sizeof($MATRICULES)==0): ?>
		<TR><TD class="LINIA">No has fet cap curs a la Casa de Cultura. Si no és així, si us plau notifica'ns-ho. </TD></TR>                                   
   <? endif; ?>
   <? foreach($MATRICULES as $M): ?>
      <? $CURSOS = $M->getCursos(); ?>                           
   		<TR><TD><?=$CURSOS->getCodi()?></TD>
      		<TD class="LINIA"><?=$CURSOS->getTitolCurs()?></TD>
      		<TD class="LINIA"><?=MatriculesPeer::getEstatText( $M->getEstat() )?></TD>
      		<TD class="LINIA"><?=$M->getDataInscripcio()?></TD>
      		<TD class="LINIA"><?=$M->getDescompte()?></TD>                                                                                             
	     </TR>                                   
   <? endforeach; ?>                              
   </TABLE>   
   </FIELDSET>
      
   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Cursos disponibles</LEGEND>   
   <TABLE class="DADES">
   <? $CAT_ANT = ""; ?>   
   <? foreach(CursosPeer::getCursos()->getResults() as $C): ?>                      
   <?    if($CAT_ANT <> $C->getCategoria()): ?>
   <?       $PLACES = CursosPeer::getPlaces($C->getIdcursos()); ?>
			<TR><TD colspan="4" class="TITOL"><?=$C->getCategoria()?></TD></TR>
   <?    endif; ?>
                       	
   		<TR>
      		<TD class="LINIA CURS"><?=checkbox_tag('D[CURSOS][]',$C->getIdcursos(),false)?></TD>
      		<TD class="LINIA CURS"><?=$C->getCodi()?></TD>
      		<TD class="LINIA CURS"><?=$C->getTitolcurs()?> ( <?=$C->getHoraris()?> ) </TD>
      		<TD class="LINIA CURS"><?=$C->getPreu()?></TD>      							
      		<TD class="LINIA CURS"><?=$C->getDatainici('d-m-Y')?></TD>
      		<TD class="LINIA CURS"><?=$PLACES['OCUPADES'].'/'.$PLACES['TOTAL']?></TD>
      	</TR>                		                 										
   <? $CAT_ANT = $C->getCategoria(); ?>			   
   <? endforeach; ?>        
   <TR><TD colspan="2" class="LINIA"><b>DESCOMPTE</b></TD><TD colspan="4"><?=select_tag('D[DESCOMPTE]',options_for_select( MatriculesPeer::selectDescomptes(),MatriculesPeer::REDUCCIO_CAP))?></TD></TR>                      
   </TABLE>         
   </FIELDSET>
   
	<FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Accions</LEGEND>   
	<TABLE class="FORMULARI"><TR><TD><?=submit_tag('Matricula\'m',array('name'=>'BMATRICULA' , 'style'=>'width:100px'))?></TD></TR></TABLE>         
   	</FIELDSET>
   
<?  
}


function gestiona_verificacio($DADES_MATRICULA , $TPV)
{
     //Si la matricula es paga amb Targeta de crèdit, passem al TPV, altrament mostrem el comprovant     
     if($DADES_MATRICULA['MODALITAT'] == MatriculesPeer::PAGAMENT_TARGETA || $DADES_MATRICULA['MODALITAT'] == MatriculesPeer::PAGAMENT_TELEFON ):
     	 
         echo '<FORM name="COMPRA" action="https://sis-t.sermepa.es:25443/sis/realizarPago" method="POST" target="TPV">';
//         echo '<FORM name="COMPRA" action="https://sis.sermepa.es/sis/realizarPago" method="POST" target="TPV">';
                  
         foreach($TPV as $K => $T) echo input_hidden_tag($K,$T);
         
     else:
     
         echo nice_form_tag('gestio/gMatricules',array('method'=>'POST'));
         
         
     endif;

     //Carreguem totes les dades de matrícula
     foreach($DADES_MATRICULA as $K => $V) { $str = "DADES_MATRICULA[".$K."]"; echo input_hidden_tag($str,$V); }
     
		   
	?>	
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Verificació de la matrícula</DIV>				
				<TABLE class="FORMULARI" style="magin-right:40px;">
                  	<TR><TD><span class="TITOL">DNI </span></TD>     <TD ><?php echo $DADES_MATRICULA['DNI']; ?></TD></TR>
                  	<TR><TD><span class="TITOL">NOM </span></TD>     <TD ><?php echo $DADES_MATRICULA['NOM']; ?></TD></TR>
                  	<TR><TD><span class="TITOL">PAGAMENT </span></TD><TD ><?php echo MatriculesPeer::textPagament($DADES_MATRICULA['MODALITAT']); ?></TD></TR>
                  	<TR><TD><span class="TITOL">IMPORT </span></TD>  <TD ><?php echo $DADES_MATRICULA['PREU'].'€'; ?></TD></TR>
                  	<TR><TD><span class="TITOL">DATA </span></TD>    <TD ><?php echo $DADES_MATRICULA['DATA']; ?></TD></TR>
                  	<TR><TD><span class="TITOL">DESCOMPTE </span></TD>  <TD ><?php echo MatriculesPeer::textDescomptes($DADES_MATRICULA['DESCOMPTE']); ?></TD></TR>
                  	<TR><TD><span class="TITOL">CURSOS </span></TD>  <TD >
                  								<TABLE width="100%">
                  								<?php foreach(explode('@',$DADES_MATRICULA['CURSOS']) as $C): ?>
                  								<?php $CURS = CursosPeer::retrieveByPK($C);      ?>                  								
	                  								<TR>
	                  									<TD><?php echo $CURS->getCodi(); ?></TD>
	                  									<TD><?php echo $CURS->getTitolcurs(); ?></TD>
	                  									<TD><?php echo CursosPeer::CalculaPreu($C , $DADES_MATRICULA['DESCOMPTE']).'€'; ?></TD>
	                  								</TR>                  								                  								
                  	                           <?php endforeach; ?>
                  	                           </TABLE>
                  	                           </TD></TR>
                  		<TR><TD colspan="7"><?php echo submit_tag('Matricular',array('NAME'=>'BSAVE','style'=>'width:100px')); ?><BR /></TD></TR>                  	                                             	
                </TABLE>			                                  
            </TD>
        </TR>
      </TABLE>
      
	</FORM>
<?php  
}

?> 

<script type="text/javascript">

	function vacio(q){for(i=0;i<q.length;i++){if(q.charAt(i)!=" "){return true}}return false}  

	function ValidaReserves(){		
		if(vacio(fReserves.D_NOM.value)== false){ alert('El nom d\'activitat no pot estar buit.'); return false; }
		if(vacio(fReserves.D_DATAACTIVITAT.value)== false){ alert('La data d\'activitat no pot estar buit.'); return false; }
		if(vacio(fReserves.D_HORARIACTIVITAT.value)== false){ alert('L\'hora d\'activitat no pot estar buida.'); return false; }
		if(fReserves.D_ESPAIS.selectedIndex<0){ alert('Has d\'escollir com a mínim un espai on realitzar l\'acte'); return false; }		
	}

</script>

	


<?php 


//RESERVA o bé hi ha un registre que editem o un de nou
//RESERVES hi ha un llistat d'objectes reserva
//MISSATGE Missatge que informa d'algun problema o bé que tot ha anat bé

function gestiona_reserves( $RESERVA , $RESERVES , $MISSATGE = array() ){   
      
   if($RESERVA->getReservaespaiid() > 0) $ENABLED = false; else $ENABLED = true;  
   if($ENABLED) echo nice_form_tag('web/gestio?accio=sr',array('method'=>'POST','onSubmit'=>'return ValidaReserves(this);','ID'=>'fReserves'));
      
   $ESPAIS = explode('@',$RESERVA->getEspaissolicitats());
   $MATERIAL= explode('@',$RESERVA->getMaterialsolicitat());
      ?> 
  
	<FIELDSET><LEGEND class="LEGEND">Reserves anteriors</LEGEND>
		<TABLE class="DADES">
     	<TR><TD class="TITOL">Nom activitat</TD><TD class="TITOL">Data sol·licitud</TD><TD class="TITOL">Estat</TD></TR>
     	
	    <? if(empty($RESERVES)): ?>
	    <TR><TD class="LINIA">No s'han trobat reserves anteriors</TD></TR>
	    <? endif; ?> 
     
     	<? foreach($RESERVES as $R): ?>
        <TR><TD class="LINIA"><?=link_to($R->getNom(),'web/gestio?accio=gr&idR='.$R->getReservaespaiid())?></TD><TD class="LINIA"><?=$R->getDataalta('d/m/Y')?></TD><TD class="LINIA"><?=$R->getEstatText()?></TD></TR> 
		<? endforeach; ?>
     
     	</TABLE>     
	</FIELDSET>
          
  
	<FIELDSET><LEGEND class="LEGEND">Dades reserva</LEGEND>
		<TABLE class="DADES">
        <? if(!empty($MISSATGE)): ?>
        <TR><TD class="MISSAT" colspan="2"><UL> <? foreach($MISSATGE as $M): ?> <LI><?=$M?></li><? endforeach ?> </TD></TR>   
		<? endif; ?>
		<TR><TD class="LINIA">Nom de l'activitat</TD>     <TD class="LINIA"><?php echo input_tag('D[NOM]',$RESERVA->getNom()); ?></TD></TR>
		<TR><TD class="LINIA">Data de l'activitat</TD>    <TD class="LINIA"><?php echo input_tag('D[DATAACTIVITAT]',$RESERVA->getDataactivitat()); ?></TD></TR>
		<TR><TD class="LINIA">Horari de l'activitat</TD>  <TD class="LINIA"><?php echo input_tag('D[HORARIACTIVITAT]',$RESERVA->getHorariactivitat()); ?></TD></TR>
		<TR><TD class="LINIA">Espais (<?=link_to("veure'ls",'web/espais',array('class'=>'blue','target'=>'_NEW'))?>)</TD>                 <TD class="LINIA"><?php echo select_tag('D[ESPAIS][]',options_for_select(EspaisPeer::select(),$ESPAIS),  array('multiple'=>true,'size'=>'3')); ?></TD></TR>
		<TR><TD class="LINIA">Material</TD>               <TD class="LINIA"><?php echo select_tag('D[MATERIAL][]',options_for_select(MaterialgenericPeer::select(),$MATERIAL),  array('multiple'=>true,'size'=>'3')); ?></TD></TR>
		<TR><TD class="LINIA">Tipus d'acte</TD>           <TD class="LINIA"><?php echo input_tag('D[TIPUSACTE]',$RESERVA->getTipusacte()); ?></TD></TR>
		<TR><TD class="LINIA">Es enregistrable?</TD>      <TD class="LINIA"><?php echo select_tag('D[ISENREGISTRABLE]',options_for_select(array('0'=>'No','1'=>'Sí'),$RESERVA->getIsenregistrable())); ?></TD></TR>
		<TR><TD class="LINIA">En representació de </TD>   <TD class="LINIA"><?php echo input_tag('D[REPRESENTACIO]',$RESERVA->getRepresentacio()); ?></TD></TR>      
		<TR><TD class="LINIA">Responsable</TD>            <TD class="LINIA"><?php echo input_tag('D[RESPONSABLE]',$RESERVA->getResponsable()); ?></TD></TR>
		<TR><TD class="LINIA">Organitzadors</TD>          <TD class="LINIA"><?php echo input_tag('D[ORGANITZADORS]',$RESERVA->getOrganitzadors()); ?></TD></TR>
		<TR><TD class="LINIA">Personal autoritzat</TD>    <TD class="LINIA"><?php echo input_tag('D[PERSONALAUTORITZAT]',$RESERVA->getPersonalautoritzat()); ?></TD></TR>
		<TR><TD class="LINIA">Previsió assistents</TD>    <TD class="LINIA"><?php echo input_tag('D[PREVISIOASSISTENTS]',$RESERVA->getPrevisioassistents()); ?></TD></TR>
		<TR><TD class="LINIA">Es un cicle?</TD>           <TD class="LINIA"><?php echo select_tag('D[ESCICLE]',options_for_select(array('0'=>'No','1'=>'Sí'),$RESERVA->getEscicle())); ?></TD></TR>
		<TR><TD class="LINIA">Exempció de pagament</TD>   <TD class="LINIA"><?php echo select_tag('D[EXEMPCIO]',options_for_select(array('0'=>'No','1'=>'Sí'),$RESERVA->getExempcio())); ?></TD></TR>
		<TR><TD class="LINIA">Necessiteu pressupost?</TD> <TD class="LINIA"><?php echo select_tag('D[PRESSUPOST]',options_for_select(array('0'=>'No','1'=>'Sí'),$RESERVA->getPressupost())); ?></TD></TR>
		<TR><TD class="LINIA">Col·laboració CCG?</TD>     <TD class="LINIA"><?php echo select_tag('D[COLLABORACIO]',options_for_select(array('0'=>'No','1'=>'Sí'),$RESERVA->getColaboracioccg())); ?></TD></TR>
		<TR><TD class="LINIA">Comentaris</TD>             <TD class="LINIA"><?php echo textarea_tag('D[COMENTARIS]','',array($ENABLED)); ?></TD></TR>                                    
		</TABLE>      
	</FIELDSET>

	<FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Accions</LEGEND>
		<TABLE class="FORMULARI"><TR><TD></TD><TD><?php if($ENABLED) echo submit_tag('Fes reserva',array('style'=>'width:100px;')); ?> </TD></TABLE>
	</FIELDSET>

  
<?      
}

?>

    
<?php 

	function generaData($DIA)
	{

		$ret = ""; list($ANY,$MES,$DIA) = explode("-",$DIA);
		$DATE = mktime(0,0,0,$MES,$DIA,$ANY);
		switch(date('N',$DATE)){
			case '1': $ret = "Dilluns, ".date('d',$DATE); break;  
			case '2': $ret = "Dimarts, ".date('d',$DATE); break;
			case '3': $ret = "Dimecres, ".date('d',$DATE); break;
			case '4': $ret = "Dijous, ".date('d',$DATE); break;
			case '5': $ret = "Divendres, ".date('d',$DATE); break;
			case '6': $ret = "Dissabte, ".date('d',$DATE); break;
			case '7': $ret = "Diumenge, ".date('d',$DATE); break;				
		}
				
		switch(date('m',$DATE)){
			case '01': $ret .= " de gener"; break;
			case '02': $ret .= " de febrer"; break;
			case '03': $ret .= " de març"; break;
			case '04': $ret .= " d'abril"; break;
			case '05': $ret .= " de maig"; break;
			case '06': $ret .= " de juny"; break;
			case '07': $ret .= " de juliol"; break;
			case '08': $ret .= " d'agost"; break;
			case '09': $ret .= " de setembre"; break;
			case '10': $ret .= " d'octubre"; break;
			case '11': $ret .= " de novembre"; break;
			case '12': $ret .= " de desembre"; break;
		}
		
		$ret .= " de ".date('Y',$DATE);
		
		return $ret;
		
	}


?>