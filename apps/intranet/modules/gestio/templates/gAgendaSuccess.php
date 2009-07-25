<STYLE>
.cent { width:100%; }
 
</STYLE>

<?php use_helper('Javascript'); ?>

   
    <TD colspan="3" class="CONTINGUT">
     	 
    <form action="<?php echo url_for('gestio/gAgenda') ?>" method="POST">
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

      
  <?php IF( $MODE['NOU'] || $MODE['EDICIO'] ): ?>
      
	<form action="<?php echo url_for('gestio/gAgenda') ?>" method="POST">            
	 	<DIV class="REQUADRE">
	    	<table class="FORMULARI" width="500px">
                <?=$FAgenda?>                								
                <tr>
                	<td></td>
	            	<td><input type="submit" name="BSAVE" value="Prem per guardar" /></td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
     </form>    
    
  <?php ENDIF; ?>
      
      
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
