<STYLE>
.cent { width:100%; }
</STYLE>

<?php use_helper('Form'); ?>


<script type="text/javascript">

	function vacio(q){for(i=0;i<q.length;i++){if(q.charAt(i)!=" "){return true}}return false}  

	function ValidaReserves(){		
		if(vacio(D_NOM.value)== false){ alert('El nom d\'activitat no pot estar buit.'); return false; }
		if(vacio(D_DATAACTIVITAT.value)== false){ alert('La data d\'activitat no pot estar buit.'); return false; }
		if(vacio(D_HORARIACTIVITAT.value)== false){ alert('L\'hora d\'activitat no pot estar buida.'); return false; }
		if(D_ESPAIS.selectedIndex<0){ alert('Has d\'escollir com a mínim un espai on realitzar l\'acte'); return false; }		
	}

</script>
   
    <TD colspan="3" class="CONTINGUT">
    
    <form action="<?php echo url_for('gestio/gReserves') ?>" method="POST">
	    <DIV class="REQUADRE">
	    	<table class="FORMULARI">          
	            <?php echo $FCerca ?>
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="BCERCA" value="Prem per buscar" />
	            	<!-- <input type="submit" name="BNOU" value="Nova reserva" /> -->
	            	</td>
	            </tr>
	        </table>
	     </DIV>
     </form>   
      
  <?php IF( $MODE['NOU'] || $MODE['EDICIO'] ): ?>
      
      	<form action="<?php echo url_for('gestio/gReserves') ?>" method="POST">            
	 	<DIV class="REQUADRE">
	    	<table class="FORMULARI" width="550px">
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
	    		<tr><TD>Qui sol·licita?</TD>
	    			<TD><?php  
	    				$OUsuari = UsuarisPeer::retrieveByPK($FReserva->getObject()->getUsuarisusuariid());
	    				if($OUsuari instanceof Usuaris) echo $OUsuari->getDni().' - '.$OUsuari->getNomComplet(); 
	    			 ?></TD></tr>
                <?php echo $FReserva?>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<br>
	            		<?php echo submit_image_tag('icons/Colored/PNG/action_check.png',array('value'=>'SAVE','name'=>'BSAVE'))?>
	            		<?php echo link_to(image_tag('icons/Colored/PNG/action_delete.png'),'gestio/gReserves',array('name'=>'BDELETE','confirm'=>'Segur que vols esborrar-lo?'))?>
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
     </form>          

  <?php ELSE: ?>
    
      <DIV class="REQUADRE">
        <DIV class="TITOL">Llistat de reserves </DIV>
      	<TABLE class="DADES">
 			<?php 
				if( empty( $RESERVES ) ):
					echo '<TR><TD class="LINIA" colspan="3">No s\'ha trobat cap reserva amb aquestes dades.</TD></TR>';
				else: 
					$i = 0;
					foreach($RESERVES->getResults() as $R):																	
                      	$PAR = ParImpar($i++); 	                      	
                      	echo '<TR><TD class="'.$PAR.'">'.link_to($R->getNom(),'gestio/gReserves?accio=E&IDR='.$R->getReservaespaiid()).'</TD>
                      	    	  <TD class="'.$PAR.'">'.$R->getUsuaris()->getNomComplet().'</TD>
                      	          <TD class="'.$PAR.'">'.$R->getDataactivitat().'</TD>
                      	          <TD class="'.$PAR.'">'.$R->getEstatText().'<TD>
                      	      </TR>';
                    endforeach;
                 endif;                    
             ?>      
              <TR><TD colspan="3" class="TITOL"><?php echo gestorPagines($RESERVES);?></TD></TR>    	
      	</TABLE>      
      </DIV>

    
  <?php ENDIF; ?>
  
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>        
    
<?php 

function getParam( $accio , $AID , $CERCA )
{
    $opt = array();
    if(isset($accio)) $opt[] = "accio=$accio";
    if(isset($AID)) $opt['AID'] = "AID=$AID";
    if(isset($CERCA)) $opt['CERCA'] = "CERCA=$CERCA";
    
    RETURN "?".implode( "&" , $opt);
}

function gestorPagines($MODEL)
{
  if($MODEL->haveToPaginate())
  {       
  	
     echo link_to(image_tag('tango/16x16/actions/go-previous.png'), 'gestio/gReserves'.getParam( null , null , $MODEL->getPreviousPage() ));
     echo " ";
     echo link_to(image_tag('tango/16x16/actions/go-next.png'), 'gestio/gReserves'.getParam( null , null , $MODEL->getNextPage()));
  }
}

function ParImpar($i)
{
	if($i % 2 == 0) return "PAR";
	else return "IPAR";
}


?>
