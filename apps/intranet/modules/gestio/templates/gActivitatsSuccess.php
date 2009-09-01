<?php use_helper('Form') ?>
<?php use_helper('Javascript')?>
<?php use_javascript('jquery.datepick.package-3.7.1/jquery.datepick.js')?>
<?php use_javascript('jquery.datepick.package-3.7.1/jquery.datepick-ca.js')?>


<STYLE>
.CALENDARI { font-size: 7px; }
.CALENDARI A { text-decoration:none; color:black; }
.CALENDARI A:hover { text-decoration:none; color:black; font-weight: bolder; }
.CALENDARI A:visited {text-decoration:none; color:black; }
.CALENDARI TD { font-size:10px; text-align: left; padding:1px; }
.LINIA_ERROR { background-color: rgb(255,196,196); }
.HORA { width:80px;}
.CENT { width:50%; }
#CENT { width:100%; } 
#DEU { width:10%; }
#FDATA { width:80px; }
#MESOS { font-weight:normal; border: 3px solid #F3F3F3; background-color:#FAFAFA; margin-left:5px; }
.DIES { font-size: 10px;  }
.SELECCIONAT { font-weight:bold; }

</STYLE>
   
    <TD colspan="3" class="CONTINGUT">

	<script type="text/javascript">

	function jq(myid)
	  { return '#'+myid.replace(/:/g,"\\:").replace(/\./g,"\\.");}
	
	 $(document).ready(function() {	
		 $("#id").val(1);														//Inicialitzem el valor identificador de nou camp a 1
		 //ajax($("#generic\\[1\\]"),1);												//Inicialitzem la segona llista pel primer valor							
		 $("#mesmaterial").click( function() { creaFormMaterial(); });			//Marquem que a cada click es farà un nou formulari
		 $("#mesespais").click( function () { creaFormEspais(); });

	 });

	 //Funció que controla la crida AJAX 
	function ajax(d, iCtrl)
	{
												
		$.getJSON(
				 "<?=url_for('gestio/selectMaterial') ?>",						//Url que visita 
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
				
		var options = '<?=MaterialgenericPeer::selectAjax(); ?>';
		$("#divTxt").append('<span id="row['+id+']"><select onChange="ajax(this,'+id+')" name="generic[' + id + ']"> id="generic[' + id + ']">' + options + '</select> <select name="material[' + id + ']" id="material[' + id + ']"></select>	<input type="button" onClick="esborraLinia('+id+');" id="mesmaterial" value="-"></input><br /></span>');
		ajax($("generic\\["+id+"\\]"),id);  //Carreguem el primer																	
	}

	function creaFormEspais()
	{
				
		var id = $("#idE").val();
		id = (parseInt(id) + parseInt(1));
		$("#idE").val(id);
		
		var options = '<?=EspaisPeer::selectJavascript(); ?>';
		$("#divTxtE").append('<span id="rowE['+id+']"><select name="espais['+id+']" id="espais['+id+']">'+ options +'</select><input type="button" onClick="esborraLiniaE('+id+');" id="mesespais" value="-"></input><br /></span>');

	}
	
	function esborraLinia(id) { $("#row\\["+id+"\\]").remove(); }
	function esborraLiniaE(id) { $("#rowE\\["+id+"\\]").remove(); }
	
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
	    <DIV class="TITOL">Calendari d'activitats<SPAN id="MESOS"> <?php echo getSelData($DATAI);  ?></SPAN></DIV>
	    	<table class="CALENDARI">          
                <?php                 
                  
                  echo llistaCalendariH($DATAI,$CALENDARI);                                              

                ?>
	        </table>
	     </DIV>
     </form>                  
     
  <?php ENDIF; IF( $MODE['NOU'] || $MODE['EDICIO'] && !$MODE['CICLES'] ): ?>
      
      <?php menu(1,$ACTIVITAT_NOVA); ?>
      
     <form action="<?php echo url_for('gestio/gActivitats') ?>" method="POST">            
	 	<div class="REQUADRE">	 			 		
	    	<table class="FORMULARI" width="600px">                  			    	
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <?=$FActivitat?>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<br>	            		
	            		<?=submit_image_tag('icons/Colored/PNG/action_check.png',array('value'=>'Guarda','name'=>'BSAVEACTIVITAT'))?>
	            		<?=link_to(image_tag('icons/Colored/PNG/action_delete.png'),'gestio/gCursos',array('name'=>'BDELETE','confirm'=>'Segur que vols esborrar-lo?'))?>
	            	</td>
	            </tr>                	 
      		</table>      		
      	</div>
     </form>         
    
  <?php ELSEIF( $MODE['HORARIS'] ): ?>
  
    <?php menu(2,$ACTIVITAT_NOVA); ?>
    
	<DIV class="REQUADRE">
		<DIV class="TITOL">Horaris actuals</DIV>
      	<TABLE class="DADES">
 			<? if( sizeof($HORARIS) == 0 ): echo '<TR><TD class="LINIA">Aquesta activitat no té cap horari definit.</TD></TR>'; endif; ?>  
			<? foreach($HORARIS as $H): $M = $H->getHorarisespaissJoinMaterial(); $HE = $H->getHorarisespaissJoinEspais(); ?>			
				<TR>
					<TD class="<?php $PAR ?>" width=""><?=link_to($H->getHorarisid(),'gestio/gActivitats?accio=CH&IDH='.$H->getHorarisid())?></TD>
					<TD class="<?php $PAR ?>" width=""><?=$H->getDia('d/m/Y')?></TD>
					<TD class="<?php $PAR ?>" width=""><?=$H->getHorapre('H:m') ?></TD>
					<TD class="<?php $PAR ?>" width=""><?=$H->getHorainici('H:m') ?></TD>
					<TD class="<?php $PAR ?>" width=""><?=$H->getHorafi('H:m') ?></TD>
					<TD class="<?php $PAR ?>" width=""><?=$H->getHorapost('H:m') ?></TD>
					<TD class="<?php $PAR ?>" width=""><? foreach($HE as $HESPAI) { if(is_object($HESPAI->getEspais())) echo $HESPAI->getEspais()->getNom().'<br />'; } ?></TD>
					<TD class="<?php $PAR ?>" width=""><? foreach($M as $MATERIAL) { if(is_object($MATERIAL->getMaterial())) echo $MATERIAL->getMaterial()->getNom().'<br />'; } ?></TD>
				</TR>
			<? endforeach; ?>                        	
    	</TABLE>      
	</DIV>

<script type="text/javascript">
	$(function() {
               $('#multi999Datepicker').datepick({numberOfMonths: 3, multiSelect: 999, showOn: 'both', buttonImageOnly: true, buttonImage: '<?=image_path('template/calendar_1.png')?>'});               			
    });   
</script>
	 
     <form action="<?php echo url_for('gestio/gActivitats') ?>" method="POST">            
	 	<div class="REQUADRE">	 		
	 		<DIV class="TITOL">Edició horaris <?=link_to('Nou horari','gestio/gActivitats?accio=CH') ?></DIV>
	    	<table class="FORMULARI" width="550x">
	    	<tr><td width="100px"></td><td class="missatge" width="450x"><?php echo '<ul>'; if(!isset($MISSATGE)) $MISSATGE = array(); foreach($MISSATGE as $M) echo '<li>'.$M.'</li>';	echo '</ul>'; ?> </td></tr>                  			    	
	    	<tr><td width="100px"></td><td width="450x"></td></tr>

               	<?=$FHorari?>
             
             <tr>
             	<td>Espais: </td><td>
             	
             	<?php 
					$id = 1;  $VAL = "";
					if(!isset($ESPAISOUT)) $ESPAISOUT = array();            	
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
					if(!isset($MATERIALOUT)) $MATERIALOUT = array();            	
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
	            		<br>	            		
	            		<?=submit_image_tag('icons/Colored/PNG/action_check.png',array('value'=>'BSAVEHORARIS','id'=>'BASAVEHORARIS','name'=>'BSAVEHORARIS'))?>
	            		<?=link_to(image_tag('icons/Colored/PNG/action_delete.png'),'gestio/gActivitats',array('name'=>'BDELETEHORARI','confirm'=>'Segur que vols esborrar-lo?'))?>
	            	</td>
	            </tr>                	 
      		</table>      		
      	</div>
     </form>         
    
  <?php ELSEIF( $MODE['TEXTOS'] ): ?>

     <?php menu(3,$ACTIVITAT_NOVA); ?>

     <form action="<?php echo url_for('gestio/gActivitats') ?>" method="POST" enctype="multipart/form-data">            
	 	<div class="REQUADRE">	 			 		
	    	<table class="FORMULARI" width="600px">                  			    	
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <?=$FActivitat?>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<br>	            		
	            		<?=submit_image_tag('icons/Colored/PNG/action_check.png',array('value'=>'Guarda','name'=>'BSAVEDESCRIPCIO'))?>
	            		<?=link_to(image_tag('icons/Colored/PNG/action_delete.png'),'gestio/gCursos',array('name'=>'BDELETE','confirm'=>'Segur que vols esborrar-lo?'))?>
	            	</td>
	            </tr>                	 
      		</table>      		
      	</div>
     </form>
      
  <?php ELSEIF( $MODE['CICLES'] ): ?>

     <?php menu(4,$ACTIVITAT_NOVA); ?>

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
       
    
  <?php ELSEIF( $MODE['LLISTAT'] ): ?>


     <DIV class="REQUADRE">
        <DIV class="TITOL">Llistat d'activitats </DIV>
      	<TABLE class="DADES">
 			<? if( sizeof($ACTIVITATS) == 0 ): echo '<TR><TD class="LINIA">No s\'ha trobat cap activitat.</TD></TR>'; endif; ?>
 			<?php $i = 0; $j=0; $Tall = 10; ?> 			   			
			<? foreach($ACTIVITATS as $A):			
                  if($i >= $Tall*($PAGINA-1) && $i < ($Tall*($PAGINA-1)+$Tall)  ):
                    
                  	$AVIS = ""; $ESP = ""; $MAT = "";	
                  	if(!empty($A['ESPAIS'])) $ESP = implode("<br />",$A['ESPAIS']);
                  	if(!empty($A['MATERIAL'])) $MAT = implode("<br />",$A['MATERIAL']);                  		 
                  	if(strlen($A['AVIS'])>2) { $AVIS = '<a href="#" class="tt2">'.image_tag('tango/32x32/emblems/emblem-important.png', array('size'=>'16x16')).'<span>'.$A['AVIS'].'</span></a>'; } else { $AVIS = ""; }
                  	$PAR = ParImpar($j++);                  	
                  	?>                     
                  	<TR>                      	
	               		<TD class="<?=$PAR?>"><?=link_to($A['NOM_ACTIVITAT'],'gestio/gActivitats?accio=CA&IDA='.$A['ID']).$AVIS ?> </TD>
	                	<TD class="<?=$PAR?>"> <?=$A['DIA']?> </TD>
	               		<TD class="<?=$PAR?>"> <?=$A['HORA_INICI']?> </TD>
	                	<TD class="<?=$PAR?>"> <?=$ESP?> </TD>
	                	<TD class="<?=$PAR?>"> <?=$MAT?> </TD>						            
	                </TR>
                   <? endif;
                   $i++;
			 endforeach; 
			 
			 $sof = sizeof($ACTIVITATS);			 
                  $TALL = intval($sof/$Tall)+1;                  
                  if($TALL > 1):
	                  ?><TR><TD class="LINIA" colspan="5" align="CENTER"><?	                                                     
	                  for($i = 1; $i <= $TALL ; $i++ ):
	                  	echo link_to("pàg ".$i." - ",'gestio/gActivitats?PAGINA='.$i);                  	
	                  endfor;
                  	 ?></TD></TR><?
                  endif;
                ?>            	
      	</TABLE>      
      </DIV>

  <?php ENDIF; ?>
  
      <DIV STYLE="height:40px;"></DIV>
                
<!--  </TD> -->        
    
<!-- FI CONTINGUT -->
<!-- CALENDARI -->
 <!-- >
    <TD class="CALENDARI">          
      
    </TD>
-->
<!-- FI CALENDARI -->

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
              
    $mesI = $mes; $any = $year;
    $mesF = date('m',mktime(0,0,0,$mes+3,1,$year));
    if($mesF > 12) $mesF = $mesF-12;      
         
    $RET = "<TR><TD></TD>";
    for($i = 6; $i>0; $i--):
      $RET .= "<TD>Dll</TD><TD>Dm</TD><TD>Dc</TD><TD>Dj</TD><TD>Dv</TD><TD>Ds</TD><TD>Dg</TD>";
    endfor;
    $RET .= "</TR>";
    
    for($mes = $mesI; $mes < $mesF; $mes++):
      
      $dies = cal_days_in_month(CAL_GREGORIAN, $mes, $any );                           //Mirem quants dies té el mes      
      $diaSetmana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mes , 1 , $any) , 0 );       //Marquem quants blancs volem tenir      
      if($diaSetmana == 0) $blancs = 6-1; else  $blancs = $diaSetmana-2;
      
      if($mes % 2) $background = "beige"; else $background = "white";                   //Mirem el color del fons
      $RET .= "<TR><TD>".mesos($mes)."</TD>";
      
      //Bucle de pintar dies
      
      for($dia = 0; $dia < 40; $dia++):                                             //Generem el calendari
        $diaA = $dia-$blancs;
        if($dia <= $blancs || $diaA > $dies):                                        //Si és blanc el marquem com a tal i si el dia ha passat el màxim de dies del mes no el marquem
          $RET .= "<TD></TD>";
        else:                                  
          $diaSetmana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mes , $diaA , $any) , 0 );
          if( $diaSetmana == 6 || $diaSetmana == 0) $background="beige"; else $background = "white"; 
          
          $CalDia = mktime(0,0,0,$mes,$diaA,$any);
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
      
      if($mes == 12) $any = $any+1;
    endfor;
          
    return $RET;
      
  }

  function ParImpar($i)
{
	if($i % 2 == 0) return "PAR";
	else return "IPAR";
}
  
  
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
     $RET = link_to($ANY-1,'gestio/gActivitats?DATAI='.mktime(0,0,0,1,1,$ANY-1),array('class'=>'black'))." ";
     for($any = $ANY ; $any < $ANY+2 ; $any++ ):
     	$RET .= link_to($any,'gestio/gActivitats?DATAI='.mktime(0,0,0,1,1,$any),array('class'=>'black'))." ";
     	for($mes = 1; $mes < 13; $mes++):
     		$RET .= link_to(mesosSimplificats($mes),"gestio/gActivitats?DATAI=".mktime(0,0,0,$mes,1,$any),array('class'=>'black'))." ";
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
