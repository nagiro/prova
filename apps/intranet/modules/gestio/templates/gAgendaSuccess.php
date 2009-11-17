<?php use_helper('Form'); ?>

<STYLE>
.cent { width:100%; }
</STYLE>

<script type="text/javascript">

$(document).ready(function() {	
	 $("#id").val(1);																		
	 $("#mesdades").click( function() { creaNovaDada(); });
	 <?php 	
	 	if(isset($DADES)): 			 
	 		foreach($DADES as $K => $V):	 			
	 			$T = $V->getTipus(); $D = $V->getDada(); $N = $V->getNotes(); $S = AgendatelefonicadadesPeer::getSelectHTML($V->getTipus());
	 			echo "creaNovaDadaVella(".$T.",'".$D."','".$N."','".$S."',".$V->getAgendatelefonicadadesid().");";
	 		endforeach;
	 	endif;
	 		
	 ?>
	 
});	


function creaNovaDada()
{
	
	var id = $("#id").val();		
	id = (parseInt(id) + parseInt(1));
	$("#id").val(id);		
				
	var select  = '<?php echo AgendatelefonicadadesPeer::getSelectHTML() ?>';
	$("#taula").append('<tr id="row['+id+']"><td><input type="hidden" value="0" name="Dades['+id+'][id]"></input><select name="Dades['+id+'][Select]">'+select+'</select></td><td><input name="Dades['+id+'][Dada]" value="" type="text"></td><td><input name="Dades['+id+'][Notes]" type="text"></td><td><input type="button" onClick="esborraLinia('+id+');" id="mesmaterial" value="-"></input></td></tr>');
																				
}

function creaNovaDadaVella(t, d, n, s, idA)
{
	
	var id = $("#id").val();		
	id = (parseInt(id) + parseInt(1));
	$("#id").val(id);		
					
	$("#taula").append('<tr id="row['+id+']"><td><input type="hidden" value="'+idA+'" name="Dades['+id+'][id]"></input><select name="Dades['+id+'][Select]">'+s+'</select></td><td><input name="Dades['+id+'][Dada]" value="'+d+'" type="text"></td><td><input name="Dades['+id+'][Notes]" value="'+n+'" type="text"></td><td><input type="button" onClick="esborraLinia('+id+');" id="mesmaterial" value="-"></input></td></tr>');
																				
}


function esborraLinia(id) { $("#row\\["+id+"\\]").remove(); }

</script>
   
    <TD colspan="3" class="CONTINGUT">
     	 
    <form action="<?php echo url_for('gestio/gAgenda') ?>" method="POST" id="FCERCA">
	    <DIV class="REQUADRE">
	    	<table class="FORMULARI">	    	         
	            <?php echo $FCerca ?>
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="BCERCA" value="Prem per buscar" />
	            		<input type="submit" name="BNOU" value="Nou contacte" />
	            	</td>
	            </tr>
	        </table>
	     </DIV>
     </form>    

      
  <?php IF( $MODE == 'NOU' || $MODE == 'EDICIO' ): ?>
      
	<form action="<?php echo url_for('gestio/gAgenda') ?>" method="POST">
		            
	 	<DIV class="REQUADRE">	 		
	    	<table class="FORMULARI" width="500px">	    			    		
                <?php echo $FAgenda?>                			    
			    <tr><td></td><td colspan="3">			    		
			    		<input type="hidden" value="<?php echo sizeof($DADES) ?>" id="id"></input>
			    		<table id="taula">			    	
			    		</table>			    	
			    	</td>
			    </tr>                	             
			    <tr><td></td><td colspan="3"><input type="button" value="+" id="mesdades"></input></td></tr>   								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<br>
	            		<?php echo submit_image_tag('icons/Colored/PNG/action_check.png',array('name'=>'BSAVE','confirm'=>'Segur que vols guardar els canvis?'))?>
	            		<?php echo link_to(image_tag('icons/Colored/PNG/action_delete.png'),'gestio/gAgenda?accio=D',array('confirm'=>'Segur que vols esborrar-lo?'))?>
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
     </form>    
    
  <?php ELSE: ?>
      
      <DIV class="REQUADRE">
        <DIV class="TITOL">Llistat contactes</DIV>
      	<TABLE class="DADES">
 			<?php 
				if( empty( $AGENDES ) ):
					echo '<TR><TD class="LINIA" colspan="3">No s\'ha trobat cap resultat d\'entre '.AgendatelefonicaPeer::getLinies().' disponibles.</TD></TR>';
				else: 
					$i = 0;
					foreach($AGENDES as $A):
                      	$SPAN = '<SPAN>';                      	
                      	foreach($A->getAgendatelefonicadadess() as $ATD): $SPAN  .= AgendatelefonicadadesPeer::getTipus($ATD->getTipus()).': '.$ATD->getDada().' - '.$ATD->getNotes().'<BR />'; endforeach;
                      	$SPAN .= '</SPAN>';
                      	$PAR = ParImpar($i++);	                      	
                      	echo "<TR>
                      			<TD class=\"$PAR\">".link_to($A->getNom().$SPAN,'gestio/gAgenda'.getParam( 'E' , $A->getAgendatelefonicaid() , $CERCA ) , array('class'=>'tt2') )."</TD>
                      			<TD class=\"$PAR\">{$A->getEntitat()}</TD>
                      			<TD class=\"$PAR\">{$A->getTags()}<TD>
                      		  </TR>";
                    endforeach;
                 endif;                     
             ?>      
      	
      	</TABLE>      
      </DIV>
               
  <?php ENDIF; ?>
               
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>        
    
<?php 

function ParImpar($i)
{
	if($i % 2 == 0) return "PAR";
	else return "IPAR";
}

function getParam( $accio , $AID , $CERCA )
{
    $opt = array();
    if(isset($accio)) $opt[] = "accio=$accio";
    if(isset($AID)) $opt['AID'] = "AID=$AID";
    if(isset($CERCA)) $opt['CERCA'] = "CERCA=$CERCA";
    
    RETURN "?".implode( "&" , $opt);
}

?>
