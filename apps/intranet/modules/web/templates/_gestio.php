<?php use_helper('Form'); ?>
<?php use_helper('Javascript')?>

<script>

	$(document).ready(function() {
		var ok;
		ok = false; 
		$("#FORM_CURSOS").submit(function(){
			$(".class_cursos").each(function(){				
				if(this.checked) ok=true;
			});
			if(!ok) alert('Per poder-vos matricular, heu de seleccionar algun curs'); 
			return ok; 
		});	   
		
		$("#BOTO_SUBMIT_RESERVA").click(fesReserva);
		$("#BOTO_NOVA_RESERVA").click(function(){ window.location.href='<?php echo url_for('web/gestio?accio=gr'); ?>'; return false; });
		$("#BOTO_DEL_RESERVA").click(function(){ window.location.href='<?php echo url_for('web/gestio?accio=ar'); ?>'; return false; });		
		
	});
	
	function ValidaReserves(){
		var espais = true;
		$(".ul_espais:checked").each(function (a){ espais = false; } );						
		if($("#reservaespais_Nom").val().length == 0) { alert("El nom d'activitat no pot estar buit."); return false; }
		if($("#reservaespais_DataActivitat").val().length == 0) { alert("La data d'activitat no pot estar buit."); return false; }
		if($("#reservaespais_HorariActivitat").val().length == 0) { alert("L'hora d'activitat no pot estar buida."); return false; }
		if(espais) { alert("Has d'escollir com a mínim un espai on realitzar l'acte"); return false; }
		if($("#reservaespais_Condicions").val() == 0) { alert("Has d'acceptar les condicions per fer una prereserva"); return false; }
		return true;  				
	}
	
	
	function fesReserva()
	{
		if(ValidaReserves()){
		
			$.post(
					"<?php echo url_for('web/gestio?accio=sr'); ?>", 
					$("#fReserves").serialize(),
					function (data){ 
							if(data == 'OK') 
							{ 
								alert("Prereserva feta amb èxit.");		
								window.location.href='<?php echo url_for('web/gestio?accio=gr'); ?>';						
							} else {
								alert("Hi ha hagut algun problema fent la prereserva. Si us plau, revisi-la o truqui a secretaria.");								 
							}
						}
					);
			return false;		
		} else return false; 
		
	}
		

</script>

<style>

	.DH { display:block; float:left; padding-top:5px; }

	fieldset { border:3px solid #F3F3F3; margin-right:40px; padding:10px; }
	.MISSAT { color:black; font-weight:bold; font-size:10px; vertical-align:middle; text-align:center; background-color:White; padding-bottom:10px; }
	.CURS { font-size: 12px; padding:5px; vertical-align:bottom;  }
	.LLEGENDA { font-size:12px; font-weight:bold; padding:10px 10px 10px 10px;  }
	TEXTAREA { border:1px solid #CCCCCC; width:90%; }
	.DADES .LINIA .blue { color:blue; }
	.DADES .LINIA .blue:hover { color:blue; }
	.DADES .LINIA .blue:visited { color:blue; }	
	
</style>


   <TD colspan="3" class="CONTINGUT">

	<?php  
		
	   switch($MODUL){
	      case 'gestiona_dades': gestiona_dades( $FUSUARI , $MISSATGE ); break;
	      case 'gestiona_cursos': gestiona_cursos( $CURSOS , $MATRICULES , $MISSATGE ); break;
	      case 'gestiona_llistes': gestiona_llistes( $LLISTES , $MISSATGE ); break;
	      case 'gestiona_reserves': gestiona_reserves( $FRESERVA , $RESERVES , $MISSATGE ); break;
	      case 'gestiona_verificacio' : gestiona_verificacio($DADES_MATRICULA , $TPV); break;    
	   }
		
	?>   
      
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    

<?php 

function gestiona_dades($FUSUARI,$MISSATGE){
?> 

	<form name="gDades" action="<?php echo url_for('web/gestio?accio=sd') ?>" method="post">
       
	   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Dades personals</LEGEND>
	   
		   <TABLE class="FORMULARI">
		   <tr><td width="100px"></td><td><td></tr>
		   <?php echo missatge($MISSATGE); ?>		      
		   <?php echo $FUSUARI; ?>  
		   <TR><TD></TD><TD><br /><br /><?php echo submit_tag('Guardeu els canvis',array('class'=>'BOTO_ACTIVITAT','style'=>'width:150px;')); ?></TD></TR>                      
		   </TABLE>   
	   
	   </FIELDSET>
	   
	</form>	 
   
   <?php  
} 

function gestiona_llistes( $LLISTES , $MISSATGE ){
?>
	<form name="gDades" action="<?php echo url_for('web/gestio?accio=sl') ?>" method="post">
	  
		<FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Llistes de correu</LEGEND>
		   
			<table class="FORMULARI">
			
				<?php echo missatge($MISSATGE); ?>
			   
				<?php foreach(LlistesPeer::select() as $K=>$L): ?>
				          
					<TR><TD><?php echo checkbox_tag('LLISTA[]',$K,isset($LLISTES[$K]))?></TD><TD><?php echo $L?></TD></TR>
					      	
				<?php endforeach; ?>
					
			</table>
			         
		</FIELDSET>
	
	   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Accions</LEGEND>
	      
		<table class="FORMULARI">
		   
			<TR><TD colspan="2"><?php echo submit_tag('Modifiqueu', array('class'=>'BOTO_ACTIVITAT','style'=>'width:100px;')); ?></TD></TR>
			
		</table>
		         
	   </FIELDSET>

	</form>

   <?php
}

function gestiona_cursos( $CURSOS , $MATRICULES , $MISSATGES ) {
   ?>
   <form method="post" action="<?php echo url_for('web/gestio?accio=im') ?>" id="FORM_CURSOS">
   
	   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Cursos matriculats</LEGEND>
	              
		   <TABLE class="DADES">
		   
		   <?php if(sizeof($MATRICULES)==0): ?>
				<TR><TD>No tenim constància informàtica que hagueu realitzat un curs a la Casa de Cultura. Si no és així, si us plau notifiqueu-nos-ho. </TD></TR>                                   
		   <?php endif; ?>
		   
		   <?php foreach($MATRICULES as $M): ?>
		      <?php $CURSOS = $M->getCursos(); ?>                           
		   		<TR><TD><?php echo $CURSOS->getCodi()?></TD>
		      		<TD><?php echo $CURSOS->getTitolCurs()?></TD>
		      		<TD><?php echo MatriculesPeer::getEstatText( $M->getEstat() )?></TD>
		      		<TD><?php echo $M->getDataInscripcio()?></TD>
		      		<TD><?php echo MatriculesPeer::textDescomptes($M->getTReduccio()) ?></TD>                                                                                             
			     </TR>                                   
		   <?php endforeach; ?>                              
		   </TABLE>
		      
	   </FIELDSET>
	      
	      
	   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Cursos disponibles</LEGEND>
	      
	       	<?php $LCURSOS = CursosPeer::getCursos()->getResults(); ?>
	       	<?php if(empty($LCURSOS)): echo "Actualment no es pot matricular a cap curs. "; ?>
			<?php else: ?>	      
					   <TABLE class="DADES">
					   <?php $CAT_ANT = ""; ?>   
					   <?php foreach($LCURSOS as $C): ?>                      
					   <?php    if($CAT_ANT <> $C->getCategoria()): ?>
					   <?php       $PLACES = CursosPeer::getPlaces($C->getIdcursos()); ?>
								<TR><TD colspan="6" class="TITOL"><?php echo $C->getCategoriaText()?></TD></TR>
					   <?php    endif; ?>
					                       	
					   		<TR>
					      		<TD><?php echo radiobutton_tag('D[CURS]',$C->getIdcursos(),false,array('onClick'=>'ActivaBoto();','class'=>'class_cursos'))?></TD>
					      		<TD><?php echo $C->getCodi()?></TD>
					      		<TD><?php echo $C->getTitolcurs()?> ( <?php echo $C->getHoraris()?> ) </TD>
					      		<TD><?php echo $C->getPreu()?></TD>      							
					      		<TD><?php echo $C->getDatainici('d-m-Y')?></TD>
					      		<TD><?php echo $PLACES['OCUPADES'].'/'.$PLACES['TOTAL']?></TD>
					      	</TR>                		                 										
					   <?php $CAT_ANT = $C->getCategoria(); ?>			   
					   <?php endforeach; ?>        					                         
					   </TABLE>
					   <br /><br />
					   <TABLE class="FORMULARI" width="100%">					   		
					   		<TR><TD width="100px"><b>DESCOMPTE</b></TD><td><?php echo select_tag('D[DESCOMPTE]',options_for_select( MatriculesPeer::selectDescomptes(),MatriculesPeer::REDUCCIO_CAP))?></TD></TR>
					   		<TR><TD width="100px"></TD><td><?php if(!empty($LCURSOS)) echo submit_tag('Matriculeu-me',array('name'=>'BMATRICULA' , 'class'=>'BOTO_ACTIVITAT' , 'style'=>'width:100px')); ?></TD></TR>
					   </TABLE>
					   
			<?php endif; ?>
		            
	   </FIELDSET>
	   	   	
   	</form>
   
<?php  
}


function gestiona_verificacio($DADES_MATRICULA , $TPV)
{

     //Si la matricula es paga amb Targeta de crèdit, passem al TPV, altrament mostrem el comprovant     
     if($DADES_MATRICULA['MODALITAT'] == MatriculesPeer::PAGAMENT_TARGETA || $DADES_MATRICULA['MODALITAT'] == MatriculesPeer::PAGAMENT_TELEFON ):
     	 
         echo '<FORM name="COMPRA" action="https://sis-t.sermepa.es:25443/sis/realizarPago" method="POST" target="TPV">';
//         echo '<FORM name="COMPRA" action="https://sis.sermepa.es/sis/realizarPago" method="POST" target="TPV">';
         
         foreach($TPV as $K => $T) echo input_hidden_tag($K,$T);
         
     else:
     
        echo '<form method="post" action="gestio/gMatricules">'; 
     	                  
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
                  	<TR><TD><span class="TITOL">CURS </span></TD>  <TD >
                  								<TABLE width="100%">                  								
                  								<?php $CURS = CursosPeer::retrieveByPK($DADES_MATRICULA['CURS']);      ?>                  								
	                  								<TR>
	                  									<TD><?php echo $CURS->getCodi(); ?></TD>
	                  									<TD><?php echo $CURS->getTitolcurs(); ?></TD>
	                  									<TD><?php echo CursosPeer::CalculaPreu($CURS->getIdcursos() , $DADES_MATRICULA['DESCOMPTE']).'€'; ?></TD>
	                  								</TR>                  								                  								                  	                           
                  	                           </TABLE>
                  	                           </TD></TR>
                  		<TR><TD colspan="7"><?php echo submit_tag('Matriculeu-me',array('NAME'=>'BSAVE','style'=>'width:100px')); ?><BR /></TD></TR>                  	                                             	
                </TABLE>			                                  
            </TD>
        </TR>
      </TABLE>
      
	</FORM>
<?php  
}

//RESERVA o bé hi ha un registre que editem o un de nou
//RESERVES hi ha un llistat d'objectes reserva
//MISSATGE Missatge que informa d'algun problema o bé que tot ha anat bé

function gestiona_reserves( $FRESERVA , $RESERVES , $ESTAT , $MISSATGE = array() ){   
      
	if($FRESERVA->getValue('ReservaEspaiID') > 0) $ENABLED = false; else $ENABLED = true;  
	if($ENABLED) echo '<form name="fReserves" id="fReserves">';      
	      
	$ESPAIS = explode('@',$FRESERVA->getValue('EspaisSolicitats'));
	$MATERIAL= explode('@',$FRESERVA->getValue('MaterialSolicitat'));
	?>
	
	<FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Prereserves anteriors</LEGEND>
		<TABLE class="DADES">
     	<TR><TD class="TITOL">Codi reserva</TD><TD class="TITOL">Nom activitat</TD><TD class="TITOL">Data sol·licitud</TD><TD class="TITOL">Estat</TD></TR>
     	
	    <?php if(empty($RESERVES)): ?>
	    <TR><TD colspan="3">No s'han trobat prereserves anteriors</TD></TR>
	    <?php endif; ?> 
     
     	<?php foreach($RESERVES as $R):     			
     			echo '<TR>';
     			echo '	<TD>'.link_to($R->getCodi(),'web/gestio?accio=gr&idR='.$R->getReservaespaiid()).'</TD>';     			
     			echo '	<TD>'.link_to($R->getNom(),'web/gestio?accio=gr&idR='.$R->getReservaespaiid()).'</TD>';
     			echo '	<TD>'.$R->getDataalta('d/m/Y').'</TD>';
     			echo '	<TD>'.$R->getEstatText().'</TD>';
     			echo '</TR>'; 
		endforeach; ?>
     
     	</TABLE>     
	</FIELDSET>		
	
	<?php if($ESTAT = 'NOU'): ?>              	
  
	<FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Nova prereserva</LEGEND>
		<?php echo $FRESERVA['Estat']->render(); ?>
		<?php echo $FRESERVA['Usuaris_usuariID']->render(); ?>
		<?php echo $FRESERVA['DataAlta']->render(); ?>
		<?php echo $FRESERVA['ReservaEspaiID']->render(); ?>
		<?php echo $FRESERVA['Codi']->render(); ?>	    	    
	    
  	    <?php if($FRESERVA->getObject()->getEstat() != ReservaespaisPeer::EN_ESPERA):  ?>
	    
  	    <div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Compromís adquirit</b></span>
	    	<span class="DH" style="width:450px; height:50px;"><?php echo $FRESERVA->getObject()->getCompromis(); ?></span>
	    </div>
	    
	    <?php endif; ?>
	    
	    
	    <div style="clear:both" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Nom de l'activitat</b></span>
	    	<span class="DH"><?php echo $FRESERVA['Nom']->render(); ?></span>
	    </div>
	    	    
	    <div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Proposta de data</b></span>
	    	<span class="DH"><?php echo $FRESERVA['DataActivitat']->render(); ?></span>
	    </div>
	    
	    <div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Proposta d'hores</b></span>
	    	<span class="DH"><?php echo $FRESERVA['HorariActivitat']->render(); ?></span>
	    </div>
	    
	    <div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Espais</b> (<a class="blue" href="<?php echo url_for('web/espais') ?>" target="_NEW">veure'ls</a>)</span>
	    	<span class="DH checkbox_list" style="width:450px"><?php echo $FRESERVA['EspaisSolicitats']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Material</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['MaterialSolicitat']->render(); ?></span>
	    </div>
		
		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Tipus d'acte</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['TipusActe']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Representant a</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['Representacio']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Responsable</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['Responsable']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Organitzadors</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['Organitzadors']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Personal autoritzat</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['PersonalAutoritzat']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Previsio d'assistents</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['PrevisioAssistents']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Enregistrable?</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['isEnregistrable']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>És un cicle?</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['EsCicle']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Exempt de pagament?</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['Exempcio']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Vol un pressupost?</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['Pressupost']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Personal de suport?</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['ColaboracioCCG']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Comentaris</b></span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['Comentaris']->render(); ?></span>
	    </div>

		<div style="clear: both;" class="FORMULARI">
	    	<span class="DH" style="width:150px;"><b>Accepta les condicions?</b><br />(<a class="blue" href="<?php echo url_for('web/espais') ?>" target="_NEW">llegir-les</a>)</span>
	    	<span class="DH checkbox_list"><?php echo $FRESERVA['Condicions']->render(); ?></span>
	    </div>
				
		<div style="clear:both; padding-top:20px;" class="FORMULARI">
			<span class="DH" style="width:150px"></span>
			<span class="DH" style="width:450px">				
			<?php if($FRESERVA->isNew()): ?>
  				 	<button id="BOTO_SUBMIT_RESERVA" class="BOTO_ACTIVITAT" style="width:140px" >Sol·liciteu la reserva</button>  				 	  			
  			<?php else: ?>
					<button id="BOTO_NOVA_RESERVA" class="BOTO_ACTIVITAT" style="width:140px">Feu una nova reserva</button>
					<button id="BOTO_DEL_RESERVA" class="BOTO_ACTIVITAT" style="width:140px">Anul·leu la reserva</button>  					 					
			<?php endif; ?>		        		                                   
			</span>
			</div>      
	</FIELDSET>

	<?php endif; ?> 
      		  	
<?php } ?>
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

	function missatge($MISSATGE)
	{
		if(!empty($MISSATGE))
		{
			echo '<TR>';
		   	echo '<TD></TD><TD class="MISSAT_OK">';
		   	foreach($MISSATGE as $M): echo $M."<BR>";  endforeach;    				
		   	echo '</TD></TR>';			
		}		
	}

?>