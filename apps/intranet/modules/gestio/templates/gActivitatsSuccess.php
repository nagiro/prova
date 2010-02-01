<?php use_helper('Form') ?>
<?php use_helper('Javascript')?>
<?php use_javascript('jquery.datepick.package-3.7.1/jquery.datepick.js')?>
<?php use_javascript('jquery.datepick.package-3.7.1/jquery.datepick-ca.js')?>

  
    <TD colspan="3" class="CONTINGUT">

	<script type="text/javascript">

	function jq(myid)
	  { return '#'+myid.replace(/:/g,"\\:").replace(/\./g,"\\.");}
	
	 $(document).ready(function() {	
		 $("#id").val(1);														//Inicialitzem el valor identificador de nou camp a 1								
		 $("#mesmaterial").click( function() { creaFormMaterial(); });			//Marquem que a cada click es farà un nou formulari
		 $("#mesespais").click( function () { creaFormEspais(); });
		 $("#horaris_HoraPre_hour").change( function () { actualitzaHores(); });

	 });

	 //Funció que controla la crida AJAX 
	function ajax(d, iCtrl)
	{
												
		$.getJSON(
				 "<?php echo url_for('gestio/selectMaterial') ?>",						//Url que visita 
				 { id: d.value }, 												//Valor seleccionat a la primera llista
				 function(data,textStatus) { updateJSON( data, textStatus, iCtrl );  } //Carreguem les dades JSON
				);
	}


	function updateJSON(data, textStatus, iCtrl ){		
		var options = "";						
		for (var i = 0; i < data.length; i++) {
	        options += '<option value="' + data[i].key + '">' + data[i].value + '</option>';				
		}						
								
		$("select#material\\["+iCtrl+"\\]").html(options);								//Actualitzem el control iCtrl
	}

	function creaFormMaterial()
	{
		
		var id = $("#idV").val();		
		id = (parseInt(id) + parseInt(1));
		$("#idV").val(id);		
				
		var options = '<?php echo MaterialgenericPeer::selectAjax(); ?>';
		$("#divTxt").append('<span id="row['+id+']"><select onChange="ajax(this,'+id+')" name="generic[' + id + ']"> id="generic[' + id + ']">' + options + '</select> <select name="material[' + id + ']" id="material[' + id + ']"></select>	<input type="button" onClick="esborraLinia('+id+');" id="mesmaterial" value="-"></input><br /></span>');
		ajax($("generic\\["+id+"\\]"),id);  //Carreguem el primer																	
	}

	function creaFormEspais()
	{
				
		var id = $("#idE").val();
		id = (parseInt(id) + parseInt(1));
		$("#idE").val(id);
		
		var options = '<?php echo EspaisPeer::selectJavascript(); ?>';
		$("#divTxtE").append('<span id="rowE['+id+']"><select name="espais['+id+']" id="espais['+id+']">'+ options +'</select><input type="button" onClick="esborraLiniaE('+id+');" id="mesespais" value="-"></input><br /></span>');

	}
	
	function esborraLinia(id) { $("#row\\["+id+"\\]").remove(); }
	function esborraLiniaE(id) { $("#rowE\\["+id+"\\]").remove(); }

	function actualitzaHores(){
		var a;
		a =  parseInt($("#horaris_HoraPre_hour").val());
		af = a+1;		
		
		$("#horaris_HoraInici_hour").val(a);
		$("#horaris_HoraFi_hour").val(af);
		$("#horaris_HoraPost_hour").val(af);
		
	}
	
	</script>
	                   	                   
  <?php IF ($MODE['CONSULTA']): ?>


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
     
  <?php ENDIF; IF( $MODE['NOU'] || $MODE['EDICIO'] ): ?>
                  
     <form action="<?php echo url_for('gestio/gActivitats') ?>" method="POST">     	
	 	<div class="REQUADRE">
	 	<div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gActivitats?accio=C'); ?></div>            
	 	<div class="titol">
	 		<?php if($MODE['NOU']): echo 'Editant una activitat nova'; else: echo 'Editant l\'activitat: '.$FActivitat->getValue('Nom'); endif; ?>
	 	</div>	 			 			 		
	    	<table class="FORMULARI" width="600px">	    	                  			    
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <?php echo $FActivitat ?>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<br>	            		
	            		<?php echo submit_tag('Segueix editant...',array('name'=>'BSAVEACTIVITAT','class'=>'BOTO_ACTIVITAT'))?>
	            	</td>
	            </tr>                	 
      		</table>      		
      	</div>
     </form>         
    
  <?php ELSEIF( $MODE['HORARIS'] ): ?>
      
	<DIV class="REQUADRE">
	<div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gActivitats?accio=C'); ?></div>	
	<div class="titol">
	 		<?php echo 'Editant horaris de l\'activitat: '.$NOMACTIVITAT; ?>
	 	</div>
		<DIV class="TITOL">Horaris actuals ( <?php echo link_to('Nou horari','gestio/gActivitats?accio=CH&nou=2',array('class'=>'blau')) ?> )</DIV>
      	<TABLE class="DADES">
 			<?php if( sizeof($HORARIS) == 0 ): echo '<TR><TD class="LINIA">Aquesta activitat no té cap horari definit.</TD></TR>'; endif; ?>  
			<?php 	foreach($HORARIS as $H): $M = $H->getHorarisespaissJoinMaterial(); $HE = $H->getHorarisespaissJoinEspais();
						echo '<TR>
								<TD class="" width="">'.link_to($H->getHorarisid(),'gestio/gActivitats?accio=CH&IDH='.$H->getHorarisid()).'</TD>
								<TD class="" width="">'.$H->getDia('d/m/Y').'</TD>
								<TD class="" width="">'.$H->getHorapre('H:i').'</TD>
								<TD class="" width="">'.$H->getHorainici('H:i').'</TD>
								<TD class="" width="">'.$H->getHorafi('H:i').'</TD>
								<TD class="" width="">'.$H->getHorapost('H:i').'</TD>
								<TD class="" width="">'; foreach($HE as $HESPAI): if(is_object($HESPAI->getEspais())): echo $HESPAI->getEspais()->getNom().'<br />'; endif; endforeach; echo '</TD>'; 
						echo 	'<TD class="" width="">'; foreach($M as $MATERIAL): if(is_object($MATERIAL->getMaterial())): echo $MATERIAL->getMaterial()->getNom().'<br />'; endif; endforeach; echo '</TD>'; 
						echo '</TR>';
					endforeach;
				
			?>			                   	
    	</TABLE>
    	<table class="DADES">
    	  <tr>
    	    <td class="dreta">	            			            		
    			<?php echo link_to('<input type="button" value="<<-- Tornar anterior"  class="BOTO_ACTIVITAT" >','gestio/gActivitats?accio=CA'); ?>    			
	            <?php echo link_to('<input type="button" value="Segueix editant -->>" class="BOTO_ACTIVITAT" >','gestio/gActivitats?accio=CT'); ?>
	        </td>
	      </tr>     
    	</table>     
    	
	</DIV>

	<?php if(isset($FHorari)): ?>
		<script type="text/javascript">
			$(function() {
		               $('#multi999Datepicker').datepick({numberOfMonths: 3, multiSelect: 999, showOn: 'both', buttonImageOnly: true, buttonImage: '<?php echo image_path('template/calendar_1.png')?>'});               			
		    });   
		</script>
		 
	     <form action="<?php echo url_for('gestio/gActivitats') ?>" method="POST">            
		 	<div class="REQUADRE">
		 	<div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gActivitats?accio=C'); ?></div> 		
		 		<DIV class="TITOL">Edició horaris</DIV>
		    	<table class="FORMULARI" width="550x">
		    	<tr><td width="100px"></td><td class="missatge" width="450x"><?php echo '<ul>'; if(!isset($MISSATGE)) $MISSATGE = array(); foreach($MISSATGE as $M) echo '<li>'.$M.'</li>';	echo '</ul>'; ?> </td></tr>                  			    	
		    	<tr><td width="100px"></td><td width="450x"></td></tr>
	
	               	<?php echo $FHorari?>
	             
	             <tr>
	             	<td>Espais: </td><td>
	             	
	             	<?php 
						$id = 1;  $VAL = "";
						if(!isset($ESPAISOUT)): $ESPAISOUT = array(); endif;            	
	             		foreach($ESPAISOUT AS $E=>$idE):
	
	             		$VAL .= '<span id="rowE['.$id.']">
	             					<select name="espais['.$id.']" id="espais['.$id.']">'.EspaisPeer::selectJavascript($idE).'</select>
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
	  	 	  	        			<select onChange="ajax(this,'.$id.')" name="generic['.$id.']"> id="generic['.$id.']">'.options_for_select(MaterialgenericPeer::select(),$idM['generic']).'</select>
	  	 	  	        			<select name="material['.$id.']" id="material['.$id.']">'.options_for_select(MaterialPeer::selectGeneric($idM['generic']),$idM['material']).'</select>	
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
			            	<?php include_partial('botonera',array('element'=>'l\'horari','tipus'=>'Guardar','nom'=>'BSAVEHORARIS')); ?>			 				            		
			            	<?php include_partial('botonera',array('element'=>'l\'horari','tipus'=>'Esborrar','nom'=>'BDELETEHORARIS')); ?>
		            	</td>
		            </tr>                	 
	      		</table>      		
	      	</div>
	     </form>
	     
	<?php endif; ?>
    
  <?php ELSEIF( $MODE['TEXTOS'] ): ?>

     <form action="<?php echo url_for('gestio/gActivitats') ?>" method="POST" enctype="multipart/form-data">     	   
	 	<div class="REQUADRE">
	 		<div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gActivitats?accio=C'); ?></div>	 			 		
		 	<div class="titol">
		 		<?php echo 'Editant la informació de l\'activitat: '.$NOMACTIVITAT; ?>
		 	</div>             
	    	<table class="FORMULARI" width="600px">                  			    	
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <?php echo $FActivitat ?>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<br>	            		
	            		<?php echo link_to('<input type="button" value="<<-- Torna horaris" class="BOTO_ACTIVITAT" >','gestio/gActivitats?accio=CH'); ?>
	            		<?php echo submit_tag('Finalitzar',array('name'=>'BSAVEDESCRIPCIO','class'=>'BOTO_ACTIVITAT'))?>
	            	</td>
	            </tr>                	 
      		</table>      		
      	</div>
     </form>
      
  <?php ELSEIF( $MODE['CICLES'] ): ?>

     <form action="<?php echo url_for('gestio/gActivitats') ?>" method="POST">            
	 	<div class="REQUADRE">	 			 		
	    	<table class="DADES" width="600px">                  			    	
	    	<tr><td width="150px"></td><td width="400px"></td></tr>
              <?php
              	                                      
                   foreach($LLISTA_CICLES as $C):
                      
                      echo '<TR><TD>'.link_to(image_tag('template/bin_closed.png'),'gestio/gActivitats?accio=DC&idC='.$C->getCicleid()).' '.$C->getNom().'</TD><TD>'.$C->getDescripcio().'</TD></TR>';
                   
                   endforeach;
                   echo '<TR><TD class="LINIA">'.input_tag('NOM',$C->getNom()).'</TD><TD class="LINIA">'.input_tag('DESCRIPCIO',$C->getDescripcio()).'</TD></TR>';
                   echo '</TABLE>';
                   echo submit_tag('Afegir cicle',array('name'=>'BSAVECICLE'));                   
               ?>                                                                           								                	 
      		</table>      		
      	</div>
     </form>
       
    
  <?php ELSEIF( $MODE['LLISTAT'] && isset($ACTIVITATS) ): ?>


     <DIV class="REQUADRE">
        <DIV class="TITOL">Llistat d'activitats </DIV>
      	<TABLE class="DADES">
 			<?php 	if( sizeof($ACTIVITATS) == 0 ): echo '<TR><TD class="LINIA">No s\'ha trobat cap activitat.</TD></TR>'; endif; 
 					$i = 0; $j=0; $Tall = 10; 					  			   			
					foreach($ACTIVITATS as $A):			
	                  	if($i >= $Tall*($PAGINA-1) && $i < ($Tall*($PAGINA-1)+$Tall)  ):
	                    
		                  	$AVIS = ""; $ESP = ""; $MAT = "";	
		                  	if( !empty( $A['ESPAIS'] ) ):     $ESP = implode("<br />",$A['ESPAIS']); endif;
		                  	if( !empty( $A['MATERIAL'] ) ):   $MAT = implode("<br />",$A['MATERIAL']); endif;            		 
		                  	if( strlen( $A['AVIS'] ) > 2 ):  $AVIS = '<a href="#" class="tt2">'.image_tag('tango/32x32/emblems/emblem-important.png', array('size'=>'16x16')).'<span>'.$A['AVIS'].'</span></a>'; else: $AVIS = ""; endif;
		                  	$PAR = ParImpar($j++);                  	
		                             
		                  	echo '	<TR>                      	
					               		<TD class="'.$PAR.'">'.link_to($A['NOM_ACTIVITAT'],'gestio/gActivitats?accio=CA&IDA='.$A['ID']).$AVIS.'</TD>
					                	<TD class="'.$PAR.'">'.$A['DIA'].'</TD>
					               		<TD class="'.$PAR.'">'.$A['HORA_INICI'].'</TD>
					                	<TD class="'.$PAR.'">'.$ESP.'</TD>
					                	<TD class="'.$PAR.'">'.$MAT.'</TD>						            
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
                                        
          $RET .= '<TD class="DIES" style="background-color:'.$background.';">'.link_to($diaA.$SPAN,"gestio/gActivitats?accio=CD&DIA=".$CalDia , array('class'=>"tt2 $SELECCIONAT")).'</TD>';
          
        endif;    
      endfor;
      $RET .= "</TR>";
            
    endfor;
          
    return $RET;
      
  }

  
  function llistaCalendariV($DATAI, $CALENDARI)
  {
    
    //Inicialitzem variables i marquem els dies en blanc
    $Q = 4; 
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
		        	$SPAN  = '<span>';				 
		          		foreach($CALENDARI[$CalDia] as $CAL) $SPAN .= $CAL['HORA'].' - '.$CAL['TITOL'].'<br />';
		            $SPAN .= '</span>';
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