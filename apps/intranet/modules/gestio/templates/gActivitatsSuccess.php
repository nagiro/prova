<?php use_helper('Form') ?>

<style>
	
	.row { width:500px; } 
	.row_field { width:70%; } 
	.row_title { width:30%; }
	.row_field input { width:100%; }
	input.ul_cat { background-color:white; border:0px; width:20px; }
	li.ul_cat { width:220px; }
	#TD1 td { border: 0px solid #DB9296; padding:0px 2px; font-size:10px; }
	#TD1 { border-collapse:collapse; }
	.LIST2 { padding:10px;  } 
		
</style>

	<script type="text/javascript">

    var hora;

	 $(document).ready(function() {	
		 $("#id").val(1);														//Inicialitzem el valor identificador de nou camp a 1								
		 $("#mesmaterial").click( function() { creaFormMaterial(); });			//Marquem que a cada click es farà un nou formulari
		 $("#mesespais").click( function () { creaFormEspais(); });
                                                                                                      
         $('#activitats_form_new').validate({            
                rules:{
                    "activitats[Preu]": { number: true },
                    "activitats[PreuReduit]": { number: true }
                }                                                             
         });                            
		 
		 $("#activitats_cicle").change(function (){ Cicle(this.value); });
		 
		 $("#activitats_nom").fadeOut(0);						 
		 $("label[for=activitats_nom]").fadeOut(0);
         
		 $("#horaris_HoraPre_hour").change(function(){
		      hora = parseInt($("#horaris_HoraPre_hour").val());              
		      $("#horaris_HoraInici_hour").val(hora);
              $("#horaris_HoraPost_hour").val(hora+1);
              $("#horaris_HoraFi_hour").val(hora+1);
            });
            
         $("#horaris_HoraInici_hour").change(function(){
		      hora = parseInt($("#horaris_HoraInici_hour").val());              		      
              $("#horaris_HoraPost_hour").val(hora+1);
              $("#horaris_HoraFi_hour").val(hora+1);
            });
            
         $("#horaris_HoraFi_hour").change(function(){
		      hora = parseInt($("#horaris_HoraFi_hour").val());
              $("#horaris_HoraPost_hour").val(hora);
            });

	 });

	function jq(myid)
	  { return '#'+myid.replace(/:/g,"\\:").replace(/\./g,"\\.");}
	

	function Cicle(val)
	{	
		if(val == 1){
			$("#activitats_nom").fadeOut(1000);						 
			$("label[for=activitats_nom]").fadeOut(1000);
		} else {
			$("#activitats_nom").fadeIn(1000);
			$("label[for=activitats_nom]").fadeIn(1000); 
		}
	}

    //Funció que captura de quin genèric parlem i busca els disponibles. 
	function ajax(d, iCtrl)
	{
												
        $.get(
                '<?php echo url_for('gestio/AjaxSelectMaterial') ?>',  
                { dies: $('#multi999Datepicker').val() , 
                  horapre: $('#horaris_HoraPre_hour').val()+':'+$('#horaris_HoraPre_minute').val() ,
                  horapost: $('#horaris_HoraPost_hour').val()+':'+$('#horaris_HoraPost_minute').val(),
                  generic: d.value 
                } , 
                function(data) { $("select#material\\["+iCtrl+"\\]").html(data); }
            );                                                
                                                
    }
    
    //Generem el desplegable de material genèric
	function creaFormMaterial()
	{
		
		var id = $("#idV").val();        		
		id = (parseInt(id) + parseInt(1));
		$("#idV").val(id);				                        
        				
        var options = '<?php echo MaterialgenericPeer::selectAjax($IDS) ?>';        
		$("#divTxt").append(
                        '<span id="row['+id+']">'+
                        '<select onChange="ajax(this,'+id+')" name="generic[' + id + ']"> id="generic[' + id + ']">' + options + '</select>'+
                        '<select name="material[' + id + ']" id="material[' + id + ']"></select>' +
                        '<input type="button" onClick="esborraLinia('+id+');" id="mesmaterial" value="-"></input><br /></span>');
		ajax($("generic\\["+id+"\\]"),id);  //Carreguem el primer																	
	}

    //Generem el desplegable dels espais
	function creaFormEspais()
	{
				
		var id = $("#idE").val();
		id = (parseInt(id) + parseInt(1));
		$("#idE").val(id);
		
		var options = '<?php echo EspaisPeer::selectJavascript($IDS); ?>';
		$("#divTxtE").append('<span id="rowE['+id+']"><select name="espais['+id+']" id="espais['+id+']">'+ options +'</select><input type="button" onClick="esborraLiniaE('+id+');" id="mesespais" value="-"></input><br /></span>');

	}
	
	function esborraLinia(id) { $("#row\\["+id+"\\]").remove(); }
	function esborraLiniaE(id) { $("#rowE\\["+id+"\\]").remove(); }
	
	</script>
  
<TD colspan="3" class="CONTINGUT_ADMIN">	


	<?php include_partial('breadcumb',array('text'=>'ACTIVITATS')); ?>		
		                   	                   
	<?php IF ( isset($MODE['CONSULTA']) || isset($MODE['LLISTAT']) ): ?>

	<form action="<?php echo url_for('gestio/gActivitats') ?>" method="POST">
	    <DIV class="REQUADRE">
	    	<table class="FORMULARI">          
	            <?php echo $FCerca ?>
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="BCERCA" value="Prem per buscar" />
	            		<input type="submit" name="BNOU" value="Nova activitat" />
	            	</td>
	            </tr>
	        </table>
	     </DIV>
     </form>  
    
     <form action="<?php echo url_for('gestio/gPromocions') ?>" method="post" enctype="multipart/form-data">
	    <DIV class="REQUADRE">
	    <DIV class="TITOL">Calendari d'activitats<SPAN id="MESOS"> <?php echo getSelData($DATAI); ?></SPAN></DIV>
	    	<table id="CALENDARI_ACTIVITATS">          
                <?php                 
                  
                  echo llistaCalendariV($DATAI,$CALENDARI);                                              

                ?>
	        </table>
	     </DIV>
     </form>                  
     
  <?php endif; if( isset($MODE['NOU']) || isset($MODE['EDICIO']) ): ?>

	 <!-- Escollim si és un cicle o bé una activitat -->
     <form action="<?php echo url_for('gestio/gActivitats') ?>" method="POST">
 	 		
	 	<div class="REQUADRE fb">	 	
		 	<?php // include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gActivitats?accio=C')) ?>
		 	
			<div class="titol"><?php if(isset($MODE['NOU'])): echo 'Editant una activitat nova'; else: echo 'Editant l\'activitat: '.$FActivitat->getValue('Nom'); endif; ?></div>
				
	 		<div style="padding-top:10px;" class="FORMULARI fb">
	 		
               	<?php echo $FCicle ?>		 		
	 			<?php include_partial('botoneraDiv',array('tipus'=>'Blanc','nom'=>'BCICLE','text'=>'Segueix editant...')); ?>
	 					
	 		</div>
	 			 	 	
		</div>
 		     
     </form>         

	<?php elseif( isset($MODE['CICLE']) ): ?>

                  
     <form action="<?php echo url_for('gestio/gActivitats') ?>" method="POST" enctype="multipart/form-data">
 	 		
	 	<div class="REQUADRE fb">	 	
		 	<?php echo include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gActivitats?accio=C')) ?>
		 	
			<div class="titol">Editant la descripció del cicle</div>
				
	 		<div style="padding-top:10px;" class="FORMULARI fb">
	 		
	 			<?php echo $FCicle ?>		 		
	 			<?php include_partial('botoneraDiv',array('tipus'=>'Blanc','nom'=>'BCICLESAVE','text'=>'Segueix amb horaris...')); ?>
	 					
	 		</div>
	 			 	 	
		</div>
 		     
     </form>         
    
  	<?php endif; if( (isset($MODE['ACTIVITAT_CICLE']) || isset($MODE['ACTIVITAT_ALONE'])) ): ?>   

	<DIV class="REQUADRE">
	<?php echo include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gActivitats?accio=C')) ?>		
	<div class="titol">Editant les activitats ( <?php echo $CICLE ?> )</div>
		
		<DIV class="TITOL">Activitats actuals <?php IF( isset($MODE['ACTIVITAT_CICLE']) ): ?> ( <?php echo link_to('Nova activitat','gestio/gActivitats?accio=ACTIVITAT&IDC='.$IDC,array('class'=>'blau')) ?> )<?php ENDIF; ?></DIV>
      	<TABLE class="DADES">
 			<?php if( sizeof($ACTIVITATS) == 0 ): echo '<TR><TD class="LINIA">No hi ha cap activitat definida.</TD></TR>'; endif; ?>  
			<?php 	foreach($ACTIVITATS as $A):
						$NH = ($A->countHorarisActius($IDS) == 0)?'Afegeix l\'horari':'Edita horaris';
						$DESC = ($A->getDMig()=="")?'Afegeix descripció':'Edita descripció';
                        $PrimerDia = $A->getPrimeraData();
						echo '<TR>
								<TD class="" width="">'.link_to($A->getNom(),'gestio/gActivitats?accio=ACTIVITAT&IDA='.$A->getActivitatid()).' ('.$PrimerDia.')</TD>
								<TD class="" width="100px">'.link_to($NH,'gestio/gActivitats?accio=HORARI&IDA='.$A->getActivitatid()).'</TD>
								<TD class="" width="100px">'.link_to($DESC,'gestio/gActivitats?accio=DESCRIPCIO&IDA='.$A->getActivitatid()).'</TD>								 
							  </TR>';
					endforeach;				
			?>			                   	
    	</TABLE>
    	<!-- 
    	<table class="DADES">
    	  <tr>
    	    <td class="dreta">	            			            		
    			<?php // echo link_to('<input type="button" value="Finalitza i tanca" class="BOTO_ACTIVITAT" >','gestio/gActivitats?accio=C'); ?>    				            
	        </td>
	      </tr>     
    	</table>
    	 -->     
    	
	</DIV>
		
	<?php if(isset($FActivitat) && !isset($MODE['DESCRIPCIO'])): ?>
    
     <form id="activitats_form_new" action="<?php echo url_for('gestio/gActivitats') ?>" method="POST" enctype="multipart/form-data">
 	 		
	 	<div class="REQUADRE fb">	 	
		 	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gActivitats?accio=ACTIVITAT&form=0&IDA='.$IDA)) ?>
		 	
			<div class="titol">Descripció de l'activitat</div>
				
	 		<div style="padding-top:10px;" class="FORMULARI fb">
	 		
	 			<?php echo $FActivitat ?>
	 			<div style="text-align:right; padding-top:40px;">
				<button type="submit" name="BACTIVITATSAVE" class="BOTO_ACTIVITAT">
					<?php echo image_tag('template/disk.png').' Guarda ' ?>
				</button>
				<button type="submit" name="BACTIVITATDELETE" class="BOTO_PERILL" onClick="return confirm('Segur que vols esborrar-ho? No ho podràs recuperar! ')">
					<?php echo image_tag('tango/16x16/status/user-trash-full.png').' Eliminar' ?>
				</button>	 				 				 				 				 				 				 			
	 			</div>	
	 		</div>
	 			 	 	
		</div>
 		     
     </form>         
     
     <?php endif; ?>
    	    
  <?php endif; if( isset($MODE['HORARI']) ): ?>
      
	<DIV class="REQUADRE">
	<div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gActivitats?accio=ACTIVITAT&form=0&IDA='.$IDA); ?></div>	
	<div class="titol">
	 		<?php echo 'Editant horaris de l\'activitat: '.$NOMACTIVITAT; ?>
	 	</div>
		<DIV class="TITOL">Horaris actuals ( <?php echo link_to('Nou horari','gestio/gActivitats?accio=HORARI&IDA='.$IDA.'&nou=2',array('class'=>'blau')) ?> )</DIV>
      	<TABLE class="DADES">
 			<?php if( sizeof($HORARIS) == 0 ): echo '<TR><TD class="LINIA">Aquesta activitat no té cap horari definit.</TD></TR>'; endif; ?>  
			<?php 	foreach($HORARIS as $H): $M = $H->getArrayHorarisEspaisMaterial(); $HE = $H->getArrayHorarisEspaisActiusAgrupats();
						echo '<TR>
								<TD class="" width="">'.link_to($H->getHorarisid(),'gestio/gActivitats?accio=HORARI&IDA='.$IDA.'&IDH='.$H->getHorarisid()).'</TD>
								<TD class="" width="">'.$H->getDia('d/m/Y').'</TD>
								<TD class="" width="">'.$H->getHorapre('H:i').'</TD>
								<TD class="" width="">'.$H->getHorainici('H:i').'</TD>
								<TD class="" width="">'.$H->getHorafi('H:i').'</TD>
								<TD class="" width="">'.$H->getHorapost('H:i').'</TD>
								<TD class="" width="">'; foreach($HE as $HESPAI): echo $HESPAI.'<br />'; endforeach; echo '</TD>'; 
						echo 	'<TD class="" width="">'; foreach($M as $MATERIAL): echo $MATERIAL['nom'].'<br />'; endforeach; echo '</TD>'; 
						echo '</TR>';
					endforeach;
				
			?>			                   	
    	</TABLE>
    	
	</DIV>

	<?php if(isset($FHorari)): ?>		 
	     <form action="<?php echo url_for('gestio/gActivitats') ?>" method="POST">
	     	<?php if(isset($MISSATGE)):  ?>
	     	<div style="padding:20px; margin-left:20px; border:10px solid red; width:650px; background-color: black; color:yellow; font-weight:bold;"><?php echo '<ul>'; if(!isset($MISSATGE)) $MISSATGE = array(); foreach($MISSATGE as $M) echo '<li>'.$M.'</li>';	echo '</ul>'; ?></div>	     	
	     	<?php endif; ?>            
		 	<div class="REQUADRE">
		 	<div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gActivitats?accio=HORARI&IDA='.$IDA.'&form=0'); ?></div> 		
		 		<DIV class="TITOL">Edició horaris</DIV>
		    	<table class="FORMULARI" width="550x">		    	                  			    	
		    	<tr><td width="100px"></td><td width="450x"></td></tr>
	
	               	<?php echo $FHorari?>
	             
	             <tr>
	             	<td>Espais: </td><td>
	             	
	             	<?php                         
						$id = 1;  $VAL = "";
						if(!isset($ESPAISOUT)): $ESPAISOUT = array(); endif;            	
	             		foreach($ESPAISOUT AS $idE=>$nom):	
	             		$VAL .= '<span id="rowE['.$id.']">
	             					<select name="espais['.$id.']" id="espais['.$id.']">'.EspaisPeer::selectJavascript($IDS,$idE).'</select>
	             					<input type="button" onClick="esborraLiniaE('.$id.');" id="mesespais" value="-"></input>
	             					<br />
	             			  	 </span>
	             			  ';
	             		      $id++;      	
	             		      	
	             		endforeach;
	
	             		echo '<input type="button" id="mesespais" value="+"></input><br />';             		             		             		             		    				   
	   					echo '<input type="hidden" id="idE" value="'.$id.'"></input>';   					
					    echo '<div id="divTxtE">'.$VAL.'</div>';
	             	?>             	             	            
	             		
					 </td>
				</tr>   
				 <tr>
				 <td>Material: </td><td>		
	
	             	<?php 
						$id = 1;  $VAL = "";
						if(!isset($MATERIALOUT)): $MATERIALOUT = array(); endif;                                                        	
	             		foreach($MATERIALOUT AS $M=>$idM):
	
	             		$VAL .= '
	  	 	  	        		<span id="row['.$id.']">
	  	 	  	        			<select onChange="ajax(this,'.$id.')" name="generic['.$id.']"> id="generic['.$id.']">'.options_for_select(MaterialgenericPeer::select($IDS),$idM['generic']).'</select>
	  	 	  	        			<select name="material['.$id.']" id="material['.$id.']">'.options_for_select(MaterialPeer::selectGeneric($idM['generic'],$IDS,$idM['material']),$idM['material']).'</select>	
	  	 	  	        			<input type="button" onClick="esborraLinia('.$id.');" id="mesmaterial" value="-"></input>
	  	 	  	        			<br />
	  	 	  	        		</span>  	 	  	        			
	             			  ';
	             		      $id++;      	             		      
	             		                   		      	
	             		endforeach;					
	             		echo '<input type="button" id="mesmaterial" value="+"></input><br />';
	             		echo '<input type="hidden" id="idV" value="'.$id.'"></input>';   					
					    echo '<div id="divTxt">'.$VAL.'</div>';
	             						    
	             	?>             	             	            
	             		
	             	</td>
	             </tr>  				
	                <tr>
	                	<td></td>	                	
		            	<td colspan="2" class="dreta">
			            	<?php include_partial('botonera',array('element'=>'l\\\'horari','tipus'=>'Guardar','nom'=>'BHORARISAVE')); ?>			 				            		
			            	<?php include_partial('botonera',array('element'=>'l\\\'horari','tipus'=>'Esborrar','nom'=>'BHORARIDELETE')); ?>
		            	</td>
		            </tr>                	 
	      		</table>      		
	      	</div>
            
		<script type="text/javascript">
			$(function() {			     
		               $('#multi999Datepicker').datepick({numberOfMonths: 3, multiSelect: 999, showOn: 'both', buttonImageOnly: true, buttonImage: '<?php echo image_path('template/calendar_1.png')?>'});               			
		    });   
		</script>

            
	     </form>
	     
	<?php endif; ?>
    
  <?php endif; if( isset($MODE['DESCRIPCIO']) ): ?>

     <form action="<?php echo url_for('gestio/gActivitats') ?>" method="POST" enctype="multipart/form-data">
 	 		
	 	<div class="REQUADRE fb">	 	
		 	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gActivitats?accio=ACTIVITAT&form=0&IDA='.$IDA)) ?>
		 	
			<div class="titol">Informació relativa a l'activitat</div>
				
	 		<div style="padding-top:10px;" class="FORMULARI fb">
	 		
	 			<?php echo $FActivitat ?>
	 			
				<div class="clear" style="text-align:right; padding-top:40px;">
					<button type="submit" name="BDESCRIPCIOSAVE" class="BOTO_ACTIVITAT">
						Guarda i tanca
					</button>
					<button type="submit" name="BGENERANOTICIA" class="BOTO_ACTIVITAT">
						Genera notícia (text mig)
					</button>
				</div>
	 			
	 					
	 		</div>
	 			 	 	
		</div>
 		               	   
     </form>
      
  <?php endif; if( isset($MODE['LLISTAT']) && isset($ACTIVITATS) ): ?>


     <DIV class="REQUADRE">
        <DIV class="TITOL">Llistat d'activitats </DIV>
      	<TABLE class="DADES">
 			<?php 	if( sizeof($ACTIVITATS) == 0 ): echo '<TR><TD class="LINIA">No s\'ha trobat cap activitat.</TD></TR>'; endif; 
 					$i = 0; $j=0; $Tall = 30; 					  			   			
					foreach($ACTIVITATS as $A):			
	                  	if($i >= $Tall*($PAGINA-1) && $i < ($Tall*($PAGINA-1)+$Tall)  ):
	                    
		                  	$AVIS = ""; $ESP = ""; $MAT = "";	
		                  	if( !empty( $A['ESPAIS'] ) ):     $ESP = implode("<br />",$A['ESPAIS']); endif;
		                  	if( !empty( $A['MATERIAL'] ) ):   $MAT = implode("<br />",$A['MATERIAL']); endif;            		 
		                  	if( strlen( $A['AVIS'] ) > 2 ):  $AVIS = '<a href="#" class="tt2">'.image_tag('tango/32x32/emblems/emblem-important.png', array('size'=>'16x16')).'<span>'.$A['AVIS'].'</span></a>'; else: $AVIS = ""; endif;
		                  	$j = 1;
		                  	$PAR = ParImpar($j++);                  	

	                  		echo '	<tr><td style="background-color:#EEEEEE; border:1px solid #EEEEEE; height:15px;" colspan="6"></td></tr>';		                  	
		                  	echo '	<tr><td class="LIST2 '.$PAR.'" colspan="6">'.link_to($A['NOM_ACTIVITAT'],'gestio/gActivitats?accio=ACTIVITAT&IDA='.$A['ID'],array('style'=>'font-size:12px')).$AVIS.'</td></tr>';		                  	
		                  	echo '	<TR>                      						               							                	
		                  				<TD class="LIST2 '.$PAR.'"><span style="font-weight:bold; font-size:10px; color:#880000;">'.$A['HORA_PRE'].'</span></TD>	
					               		<TD class="LIST2 '.$PAR.'"><span style="font-weight:bold; font-size:12px; color:green;">'.$A['HORA_INICI'].'</span></TD>
					               		<TD class="LIST2 '.$PAR.'"><b>'.$A['HORA_FI'].'</b></TD>		                  				
					                	<TD class="LIST2 '.$PAR.'"><span style="font-weight:bold; font-size:12px; color:#800000;">'.$ESP.'</span></TD>
					                	<TD class="LIST2 '.$PAR.'">'.$MAT.'</TD>
					                	<TD class="LIST2 '.$PAR.'">'.$A['DIA'].'</TD>						            
					                </TR>';		                  			                  	
	                 	endif;
	                 	$i++;
				 	endforeach; 
				 
				 	$sof = sizeof($ACTIVITATS);			 
	                	$TALL = intval($sof/$Tall)+1;                  
	                  	if($TALL > 1):
		                	echo '<TR><TD class="LINIA" colspan="5" align="CENTER">';	                                                     
		                  	for($i = 1; $i <= $TALL ; $i++ ):
		                  		echo link_to("pàg ".$i." - ",'gestio/gActivitats?PAGINA='.$i);                  	
		                  	endfor;
	                  	 echo '</TD></TR>';
	                  endif;
	                ?>            	
      	</TABLE>      
      </DIV>

  <?php ENDIF; ?>
  
      <DIV STYLE="height:40px;"></DIV>
                
<?php 

function menu($seleccionat = 1,$nova = false)
{     
	echo "<TABLE class=\"REQUADRE\"><tr>";
		
	if(!$nova): 
	    if($seleccionat == 1) echo '<td class="SUBMEN1">'.link_to('Dades activitat','gestio/gActivitats?accio=CA').'</td>';
	    else  echo '<td class="SUBMEN">'.link_to('Dades activitat','gestio/gActivitats?accio=CA').'</td>';             
        if($seleccionat == 2) echo '<td class="SUBMEN1">'.link_to('Horaris','gestio/gActivitats?accio=CH').'</td>';
        else echo '<td class="SUBMEN">'.link_to('Horaris','gestio/gActivitats?accio=CH').'</td>';
        if($seleccionat == 3) echo '<td class="SUBMEN1">'.link_to('Descripció','gestio/gActivitats?accio=T').'</td>';
        else echo '<td class="SUBMEN">'.link_to('Descripció','gestio/gActivitats?accio=T').'</td>';
        if($seleccionat == 4) echo '<td class="SUBMEN1">'.link_to('Cicles','gestio/gActivitats?accio=AC').'</td>';
        else echo '<td class="SUBMEN">'.link_to('Cicles','gestio/gActivitats?accio=AC').'</td>';        
      else:
        if($seleccionat == 1) echo '<TD class="SUBMEN1">'.link_to('Dades activitat','gestio/gActivitats?accio=N').'</td>';
	    else  echo '<td class="SUBMEN">'.link_to('Dades activitat','gestio/gActivitats?accio=N').'</td>';
	    if($seleccionat == 4) echo '<TD class="SUBMEN1">'.link_to('Cicles','gestio/gActivitats?accio=AC').'</td>';
        else echo '<td class="SUBMEN">'.link_to('Cicles','gestio/gActivitats?accio=AC').'</td>';                             
      endif;
     
     echo "</tr></table>";
}


function getPar($CERCA = NULL, $PAGINA = NULL, $IDA = NULL, $ACCIO = NULL , $ANY = NULL , $MES = NULL , $DIA = NULL , $DATAI = NULL )
{
    $A = "";
    if(!is_null($CERCA) && !empty($CERCA))    $A[] = 'CERCA='.$CERCA;
    if(!is_null($PAGINA))   $A[] = 'PAGINA='.$PAGINA;
    if(!is_null($IDA))      $A[] = 'IDA='.$IDA;
    if(!is_null($ACCIO))    $A[] = 'accio='.$ACCIO;
    if(!is_null($ANY))      $A[] = 'ANY='.$ANY;
    if(!is_null($MES))      $A[] = 'MES='.$MES;
    if(!is_null($DIA))      $A[] = 'DIA='.$DIA;    
    if(!is_null($DATAI))    $A[] = 'DATAI='.$DATAI;
    if(!empty($A)) return '?'.implode('&',$A); 
    else return '';
    
}


  function llistaCalendariH($DATAI, $CALENDARI)
  {
    
    //Inicialitzem variables i marquem els dies en blanc
    $mes  = date('m',$DATAI);
    $year = date('Y',$DATAI);
              
    $any = $year;
    $mesI = $mes;
    $mesF = $mes+3;      
         
    $RET = "<TR><TD></TD>";
    for($i = 6; $i>0; $i--):
      $RET .= "<TD>Dll</TD><TD>Dm</TD><TD>Dc</TD><TD>Dj</TD><TD>Dv</TD><TD>Ds</TD><TD>Dg</TD>";
    endfor;
    $RET .= "</TR>";

    
    for($mes = $mesI; $mes < $mesF; $mes++):
    
      
      $mesReal = ($mes > 12)?($mes-12):$mes;
      $anyReal = ($mes == 13)?$any+1:$any;
            
      
      $dies = cal_days_in_month(CAL_GREGORIAN, $mesReal, $anyReal );                   		//Mirem quants dies té el mes      
      $diaSetmana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mesReal , 1 , $anyReal) , 0 );    //Marquem quants blancs volem tenir      
      if($diaSetmana == 0) $blancs = 6-1; else  $blancs = $diaSetmana-2;
      
      if($mesReal % 2) $background = "beige"; else $background = "white";                   //Mirem el color del fons
      $RET .= "<TR><TD>".mesos($mesReal)."</TD>";
      
      //Bucle de pintar dies
      
      for($dia = 0; $dia < 40; $dia++):                                             //Generem el calendari
        $diaA = $dia-$blancs;
        if($dia <= $blancs || $diaA > $dies):                                        //Si és blanc el marquem com a tal i si el dia ha passat el màxim de dies del mes no el marquem
          $RET .= "<TD></TD>";
        else:                                  
          $diaSetmana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mesReal , $diaA , $anyReal) , 0 );
          if( $diaSetmana == 6 || $diaSetmana == 0) $background="beige"; else $background = "white"; 
          
          $CalDia = mktime(0,0,0,$mesReal,$diaA,$anyReal);
          $SPAN = ""; $color = "";
          
          if(isset($CALENDARI[$CalDia])) { $SELECCIONAT = "SELECCIONAT";
            $SPAN  = '<span>';				 
          	foreach($CALENDARI[$CalDia] as $CAL) $SPAN .= $CAL['HORA'].' - '.$CAL['TITOL'].'<br />';          		                    	          	
            $SPAN .= '</span>';
          } else { $SELECCIONAT = ""; }
                                        
          $RET .= '<TD class="DIES" style="background-color:'.$background.';">'.link_to($diaA.$SPAN,"gestio/gActivitats?accio=CD&DATAI=".$this->DATAI."&DIA=".$CalDia , array('class'=>"tt2 $SELECCIONAT")).'</TD>';
          
        endif;    
      endfor;
      $RET .= "</TR>";
            
    endfor;
          
    return $RET;
      
  }

  
  function llistaCalendariV($DATAI, $CALENDARI)
  {
    
    //Inicialitzem variables i marquem els dies en blanc
    $Q = 3; 
    $mes  = date('m',$DATAI);
    $year = date('Y',$DATAI);
    $RET = "";
              
    $any = $year;
    $mesI = $mes;
    $mesF = $mes+$Q;      

    //Omplim els mesos
    $RET .= '<tr>'; $dies = array(); $IndexMes = 0;
    for($mes = $mesI; $mes < $mesF; $mes++):  
    
    	$mesReal = ($mes > 12)?($mes-12):$mes;
      	$anyReal = ($mes == 13)?$any+1:$any;
    
    	$week = 1; $IndexMes++; 
    	$diesMes = cal_days_in_month(CAL_GREGORIAN, $mesReal, $anyReal );
    	
    	for($dia = 1; $dia <= $diesMes; $dia++ ):
    	    	
    		$diaSetmana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mesReal , $dia , $anyReal) , 0 );
    		$diaSetmana = ($diaSetmana==0)?7:$diaSetmana;
    		    		 
    		$dies[$week][$diaSetmana][$IndexMes]['day'] = $dia;
    		$dies[$week][$diaSetmana][$IndexMes]['month'] = $mesReal;
    		$dies[$week][$diaSetmana][$IndexMes]['year'] = $anyReal;
    		
    		if($diaSetmana == 7) $week++;
    		
    	endfor;
    	    	
    	$RET .= "<TD class=\"titol_mes\" colspan=\"7\">".mesos($mesReal)."</TD><td width=\"20px\"></td>";
    	    
    endfor;
   
	$RET .= '</tr>';	

	$RET .= "<TR>";    
    for($i = 0; $i < $Q; $i++):
    	$RET .= "<TD>Dll</TD><TD>Dm</TD><TD>Dc</TD><TD>Dj</TD><TD>Dv</TD><TD>Ds</TD><TD>Dg</TD><TD></TD>";
    endfor;    
    $RET .= "</TR>";
        
    
    for($row = 1; $row <= 6; $row++):
    	$RET .= "<tr>";
	    for($col = 1; $col<=(7*$Q); $col++):    		
		
			$IndexMes = ceil($col / 7);
			$colR = $col - (7 * ($IndexMes-1));

			//Color de fons per diferenciar els mesos
			if($IndexMes % 2) $background = "beige"; else $background = "beige";
			
			//Color de fons per diferenciar els caps de setmana
			if( $colR == 6 || $colR == 7) $background="#CCCCCC";			 
						
			if(isset($dies[$row][$colR][$IndexMes])):

				$dades = $dies[$row][$colR][$IndexMes];
			
				$SPAN = ""; $color = "";
		        $CalDia = mktime(0,0,0,$dades['month'],$dades['day'],$dades['year']);
		        
		        if(isset($CALENDARI[$CalDia])):
		        	$SELECCIONAT = "SELECCIONAT";		        	
		        	$SPAN  = '<span><table id="TD1"><tr><th>Inici</th><th>Fi</th><th>Espai</th><th>Títol</th><th>Organitzador</th></tr>';				 
		          		foreach($CALENDARI[$CalDia] as $CAL) $SPAN .= '<tr><td>'.$CAL['HORAI'].'</td><td>'.$CAL['HORAF'].'</td><td>'.$CAL['ESPAIS'].'</td><td>'.$CAL['TITOL'].'</td><td>'.$CAL['ORGANITZADOR'].'</td></tr>';
		            $SPAN .= '</table></span>';
		        else: 
		        	$SELECCIONAT = "";
		        endif; 
		                                        
				$RET .= '<TD class="DIES" style="background-color:'.$background.';">'.link_to($dades['day'].$SPAN,"gestio/gActivitats?accio=CD&DIA=".$CalDia , array('class'=>"tt2 $SELECCIONAT")).'</TD>';
      																						
			else: 
				
				$RET .= '<TD class="DIES" style="background-color:'.$background.';"></TD>';
			
			endif; 			

			if($colR == 7): $RET .= '<td></td>'; endif; 
			
		endfor;        
		$RET .= "</tr>";
    endfor;
    
    $RET .= "</TR>";
	        
    return $RET;
      
  }
  
  

  function ParImpar($i){ if($i % 2 == 0) return "PAR"; else return "IPAR"; }
  
  
  /**
   * A partir d'una DataI generem els enllaços del menú
   * @param time() $DATAI
   * @return string
   */
  
  function getSelData($DATAI = NULL)
  {

     $MES = date('m',$DATAI); 
     $ANY = date('Y',$DATAI);            
     
     $RET = "";
     $RET = link_to($ANY-1,'gestio/gActivitats?accio=CC&DATAI='.mktime(0,0,0,1,1,$ANY-1),array('class'=>'negreta'))." ";
     for($any = $ANY ; $any < $ANY+2 ; $any++ ):
     	$RET .= link_to($any,'gestio/gActivitats?accio=CC&DATAI='.mktime(0,0,0,1,1,$any),array('class'=>'negreta'))." ";
     	for($mes = 1; $mes < 13; $mes++):
     		$RET .= link_to(mesosSimplificats($mes),"gestio/gActivitats?accio=CC&DATAI=".mktime(0,0,0,$mes,1,$any),array('class'=>'mesos_unit'))." ";
     	endfor;     
     endfor;
      
     return $RET;
     
  }
  
  function mesos($mes)  
  {
    switch($mes){
      case 1: $text = "Gener"; break;
      case 2: $text = "Febrer"; break;
      case 3: $text = "Març"; break;
      case 4: $text = "Abril"; break;
      case 5: $text = "Maig"; break;
      case 6: $text = "Juny"; break;
      case 7: $text = "Juliol"; break;
      case 8: $text = "Agost"; break;
      case 9: $text = "Setembre"; break;
      case 10: $text = "Octubre"; break;
      case 11: $text = "Novembre"; break;
      case 12: $text = "Desembre"; break;
    }
    
    return $text; //utf8_encode($text);
  
  }
  
  function mesosSimplificats($mes)  
  {
    switch($mes){
      case 1: $text = "G"; break;
      case 2: $text = "F"; break;
      case 3: $text = "M"; break;
      case 4: $text = "A"; break;
      case 5: $text = "M"; break;
      case 6: $text = "J"; break;
      case 7: $text = "J"; break;
      case 8: $text = "A"; break;
      case 9: $text = "S"; break;
      case 10: $text = "O"; break;
      case 11: $text = "N"; break;
      case 12: $text = "D"; break;
    }
    
    return utf8_encode($text);
  
  }
  

  function fletxeta()
  {    
    return image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE'));    
  }

  ?>