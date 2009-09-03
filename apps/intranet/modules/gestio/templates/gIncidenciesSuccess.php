<?php use_helper('Form') ?>

<STYLE>
.cent { width:100%; }
.vuitanta { width:80%; }
.cinquanta { width:50%; }
.HTEXT { height:100px; }

</STYLE>
   
    <TD colspan="3" class="CONTINGUT">
    
	<form action="<?php echo url_for('gestio/gIncidencies') ?>" method="POST">
	    <DIV class="REQUADRE">
	    	<table class="FORMULARI">          
	            <?php echo $FCerca ?>
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="BCERCA" value="Prem per buscar" />
	            		<input type="submit" name="BNOU" value="Nova incidencia" />
	            	</td>
	            </tr>
	        </table>
	     </DIV>
     </form>  
    
      
<?php IF( $MODE['NOU'] || $MODE['EDICIO'] ): ?>
      
      	<form action="<?php echo url_for('gestio/gIncidencies') ?>" method="POST">            
	 	<DIV class="REQUADRE">
	    	<table class="FORMULARI" width="550px">
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <?php echo $FIncidencia ?>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<br>
	            		<?php echo submit_image_tag('icons/Colored/PNG/action_check.png',array('value'=>'SAVE','name'=>'BSAVE')) ?>
	            		<?php echo link_to(image_tag('icons/Colored/PNG/action_delete.png'),'gestio/gIncidencies',array('name'=>'BDELETE','confirm'=>'Segur que vols esborrar-lo?')) ?>
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
     </form>         

  <?php ELSE: ?>
  
        <DIV class="REQUADRE">
        <DIV class="TITOL">Llistat d'incidencies </DIV>
      	<TABLE class="DADES">
 			<?php 
				if( empty( $INCIDENCIES ) ):
					echo '<TR><TD class="LINIA" colspan="3">No s\'ha trobat cap incidencia amb aquestes dades.</TD></TR>';
				else: 
					$i = 0;
					foreach($INCIDENCIES->getResults() as $I):												
                      	$PAR = ParImpar($i++);
                      	echo '<TR><TD class="'.$PAR.'">'.link_to($I->getTitol(),'gestio/gIncidencies'.getParam( 'E' , $I->getIdincidencia() , $PAGINA )).'</TD>
						    	  <TD class="'.$PAR.'">'.$I->getEstatText().'</TD></TR>';                                	
                    endforeach;
                    
                 endif;                    
             ?>      
              <TR><TD colspan="3" class="TITOL"><?php echo gestorPagines($INCIDENCIES);?></TD></TR>    	
      	</TABLE>      
      </DIV>
  

  <?php ENDIF; ?>
  
    
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
    

  <?php 
  
function getParam( $accio = "" , $IDI = "" , $PAGINA = 1)
{
    $opt = array();
    if(!empty($accio)) $opt[] = "accio=$accio";
    if(!empty($IDI)) $opt['IDI'] = "IDI=$IDI";    
    if(!empty($PAGINA)) $opt['PAGINA'] = "PAGINA=$PAGINA";
    
    RETURN "?".implode( "&" , $opt);
}

function gestorPagines($INCIDENCIES)
{
  if($INCIDENCIES->haveToPaginate())
  {       
     echo link_to(image_tag('tango/16x16/actions/go-previous.png'), 'gestio/gIncidencies'.getParam( null , null , $INCIDENCIES->getPreviousPage() ));
     echo " ";
     echo link_to(image_tag('tango/16x16/actions/go-next.png'), 'gestio/gIncidencies'.getParam( null , null , $INCIDENCIES->getNextPage()));
  }
}


function ParImpar($i)
{
	if($i % 2 == 0) return "PAR";
	else return "IPAR";
}


?>
 