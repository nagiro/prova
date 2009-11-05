<?php use_helper('Form')?>
<?php use_javascript('/sfFormExtraPlugin/js/double_list.js') ?>

<STYLE>
.cent { width:100%; }
.vuitanta { width:80%; }
.cinquanta { width:50%; }
.HTEXT { height:100px; }

</STYLE>
   
    <TD colspan="3" class="CONTINGUT">
                                 
    <form action="<?php echo url_for('gestio/gCessio') ?>" method="POST">
	    <DIV class="REQUADRE">
	    	<table class="FORMULARI">          
	            <?php echo $FCerca ?>
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="BCERCA" value="Prem per buscar" />
	            		<input type="submit" name="BNOU" value="Nova cessió" />
	            	</td>
	            </tr>
	        </table>
	     </DIV>
     </form>   
  
  <?php IF( $MODE['NOU'] || $MODE['EDICIO'] ): ?>
      
	<form action="<?php echo url_for('gestio/gCessio') ?>" method="POST">            
	 	<DIV class="REQUADRE">
	    	<table class="FORMULARI" width="550px">
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <?php echo $FCessiomaterial?>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<br>
	            		<?php echo submit_image_tag('icons/Colored/PNG/action_check.png',array('value'=>'SAVE','name'=>'BSAVE'))?>
	            		<?php echo link_to(image_tag('icons/Colored/PNG/action_delete.png'),'gestio/gCessio?accio=D',array('confirm'=>'Segur que vols esborrar-lo?'))?>
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
     </form>    

  <?php else: ?>    

      <DIV class="REQUADRE">
        <DIV class="TITOL">Llistat de cessions</DIV>
      	<TABLE class="DADES">
 			<?php 
				if( empty( $CESSIONS ) ):
					echo '<TR><TD class="LINIA" colspan="3">No s\'ha trobat material disponible.</TD></TR>';
				else: 
					$i = 0;
					foreach($CESSIONS->getResults() as $C):												
                      	$PAR = ParImpar($i++);	                      	
                      	echo "<TR>
                      			<TD class=\"$PAR\">".link_to($C->getMaterial()->getNom(), 'gestio/gCessio'.getParam('E',$C->getIdcessiomaterial(),$PAGINA))."</TD>                      			
                      			<TD class=\"$PAR\">".$C->getCedita()."</TD>
                      			<TD class=\"$PAR\">".$C->getDatacessio()."</TD>
                      			<TD class=\"$PAR\">".$C->getDataretorn()."</TD>								                      			
                      		  </TR>";
                    endforeach;
                 endif;                     
             ?>      
              <TR><TD colspan="3" class="TITOL"><?php echo gestorPagines($CESSIONS);?></TD></TR>    	
      	</TABLE>      
      </DIV>

  <?php ENDIF; ?>
  
    
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
    

  <?php 
  
function getParam( $accio = "" , $IDC = "" , $PAGINA = 1)
{
    $opt = array();
    if(!empty($accio)) $opt[] = "accio=$accio";
    if(!empty($IDC)) $opt['IDC'] = "IDC=$IDC";    
    if(!empty($PAGINA)) $opt['PAGINA'] = "PAGINA=$PAGINA";
    
    RETURN "?".implode( "&" , $opt);
}

function gestorPagines($CESSIONS)
{
  if($CESSIONS->haveToPaginate())
  {       
     echo link_to(image_tag('tango/16x16/actions/go-previous.png'), 'gestio/gCessio'.getParam( null , null , $INCIDENCIES->getPreviousPage() ));
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
 