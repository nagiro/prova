<?php use_helper('Form') ?>
<STYLE>
.cent { width:100%; }
.vuitanta { width:80%; }
.cinquanta { width:50%; }
.HTEXT { height:100px; }
.FETA { text-decoration:line-through; }

</STYLE>

<script type="text/javascript">

	$(document).ready( function() { 
		$('#cerca_text').change( function() { 
			$('#FCERCA').submit(); 
		});
	});
	
</script>


<script type="text/javascript">

	function vacio(q){for(i=0;i<q.length;i++){if(q.charAt(i)!=" "){return true}}return false}
	function validaData(q){		
		var userPattern = new RegExp("^[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}$");		
		if (userPattern.exec(q) == null) return false; else return true;
	}
	
	function validaCodi(q){
		var userPattern = new RegExp("^[A-Za-z]{3}[0-9]{3}\.[0-9]{2}$");		
		if (userPattern.exec(q) == null) return false; else return true;
	}
	

	function ValidaFormulari(){
		if(vacio(D_TITOL.value) == false) { alert('El títol no pot estar en blanc.'); return false; }
		if(vacio(DF.value) == false) { alert('Les dates no poden estar buides.'); return false; }		
		if(vacio(DF2.value) == false) { alert('Les dates no poden estar buides.'); return false; } 		 
		if(validaData(DF.value) == false ) { alert('El format de la data aparició és incorrecte.'); return false; } 
		if(validaData(DF2.value) == false ) { alert('El format de la data desaparició és incorrecte.'); return false; }		 
	}

</script>

   
    <TD colspan="3" class="CONTINGUT">
    
	<form action="<?php echo url_for('gestio/gTasques') ?>" method="POST" id="FCERCA">
	    <DIV class="REQUADRE">
	    	<table class="FORMULARI">          
	            <?php echo $FCerca ?>
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="BCERCA" value="Prem per buscar" />
	            		<input type="submit" name="BNOU" value="Nova tasca" />
	            	</td>
	            </tr>
	        </table>
	     </DIV>
     </form>  
     
<?php IF( !$NOU && !$EDICIO ): ?>     
     
  	<DIV class="REQUADRE">
  	<DIV class="TITOL">Llistat de tasques que has encomanat </DIV>
  		<table class="DADES">
                <?php if($TASQUES_ENCOMANADES->getNbResults() == 0): ?> 
                	<TR><TD>No s'ha trobat cap resultat.</TD></TR>
                <?php endif; ?>                 
                <?php foreach($TASQUES_ENCOMANADES->getResults() as $T): ?>	                
                <?php    $U = $T->getUsuarisRelatedByQuifa()->getNom()." ".$T->getUsuarisRelatedByQuifa()->getCog1(); ?>
                <?php    $SPAN = '<SPAN>'.$T->getAparicio('d/m/Y').' -> '.$T->getDesaparicio('d/m/Y').'<br />'.$T->getAccio().'</SPAN>'; ?>
                <?php if($T->getIsfeta()): ?>
  					<TR>
  						<TD class="ICOINI FETA"><?php echo link_to(image_tag('template/doc_text_image.png').$SPAN , "gestio/gTasques".getParam( 'E' , $T->getTasquesid() , $CERCA ) , array('class' => 'tt2') )?></TD>
  						<TD class="FETA"><?php echo link_to($T->getTitol().$SPAN , "gestio/gTasques".getParam( 'E' , $T->getTasquesid() , $CERCA ) , array('class' => 'tt2') )?></TD>
					    <TD  width="20%" class="FETA"><?php echo $U?></TD></TR> 											              
                <?php else: ?>
	                <TR>
		                <TD class="ICOINI"><?php echo link_to(image_tag('template/doc_text_image.png').$SPAN , "gestio/gTasques".getParam( 'E' , $T->getTasquesid() , $CERCA ) , array('class' => 'tt2') )?></TD>
	                	<TD ><?php echo link_to($T->getTitol().$SPAN , "gestio/gTasques".getParam( 'E' , $T->getTasquesid() , $CERCA ) , array('class' => 'tt2') )?></TD>
					    <TD width="20%"><?php echo $U?></TD></TR> 											
                <?php endif; ?>					
				<?php endforeach; ?>
				<TR><TD class="TITOL"><?php echo gestorPagines($CERCA , $TASQUES_ENCOMANADES);?></TD></TR>     			
  		</table>
  	</DIV>

  	<DIV class="REQUADRE">
  	<DIV class="TITOL">Llistat de tasques que t'han encomanat </DIV>
  		<table class="DADES">
                <?php if($TASQUES_PERFER->getNbResults() == 0): ?> 
                	<TR><TD>No s'ha trobat cap resultat.</TD></TR> 
                <?php endif; ?>
                <?php foreach($TASQUES_PERFER->getResults() as $T): ?>
                <?php    $U = $T->getUsuarisRelatedByQuimana()->getNom()." ".$T->getUsuarisRelatedByQuimana()->getCog1(); ?>	                
                <?php    $SPAN = '<SPAN>'.$T->getAparicio('d/m/Y').' -> '.$T->getDesaparicio('d/m/Y').'<br />'.$T->getAccio().'</SPAN>'; ?>                                						
                <?php    if($T->getIsfeta()): ?>
                	<TR>
                		<TD class="FETA ICOINI"><?php echo link_to(image_tag('template/doc_text_image.png').$SPAN , "gestio/gTasques".getParam( 'E' , $T->getTasquesid() , $CERCA ) , array('class' => 'tt2') )?></TD>
                	    <TD class="FETA"><?php echo link_to($T->getTitol().$SPAN , "gestio/gTasques".getParam( 'E' , $T->getTasquesid() , $CERCA ) , array('class' => 'tt2') )?></TD>
                	    <TD width="20%" class="FETA"><?php echo $U?></TD>
                	</TR>
                <?php    else: ?> 
                	<TR>
                		<TD class="ICOINI"><?php echo link_to(image_tag('template/doc_text_image.png').$SPAN , "gestio/gTasques".getParam( 'E' , $T->getTasquesid() , $CERCA ) , array('class' => 'tt2') )?></TD>
                		<TD><?php echo link_to($T->getTitol().$SPAN , "gestio/gTasques".getParam( 'E' , $T->getTasquesid() , $CERCA ) , array('class' => 'tt2') )?></TD>
                		<TD width="20%"><?php echo $U ?></TD></TR>
				<?php    endif; ?>                	 											
				<?php endforeach; ?>
                <TR><TD class="TITOL"><?php echo gestorPagines($CERCA , $TASQUES_PERFER);?></TD></TR>
		</table>
  	</DIV>     
     
           
  <?php ELSE: ?>
      
 	<form action="<?php echo url_for('gestio/gTasques') ?>" method="POST">      
		<DIV class="REQUADRE">
	 	<div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gTasques?accio=C'); ?></div>
			<table class="FORMULARI" width="80%">
				<tr><td width="15%"></td><td width="60%"></td></tr>
				<?php echo $FTasca ?>
        		<tr>
	            	<td colspan="2" class="dreta">
	            		<br>
	            		<?php echo submit_image_tag('icons/Colored/PNG/action_check.png',array('name'=>'BSAVE'))?>
	            		<?php echo link_to(image_tag('icons/Colored/PNG/action_delete.png'),'gestio/gTasques?accio=D',array('confirm'=>'Segur que vols esborrar-lo?'))?>
	            	</td>
	            </tr>				
			</table>				
		</DIV>		
	</form>
    
  <?php ENDIF; ?>      
      
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    

<?php 

function getParam( $accio , $IDT , $CERCA , $PAGINA = 1)
{
    $opt = array();
    if(isset($accio)) $opt[] = "accio=$accio";
    if(isset($IDT)) $opt['IDT'] = "IDT=$IDT";
    if(isset($CERCA)) $opt['CERCA'] = "CERCA=$CERCA";
    if(isset($PAGINA)) $opt['PAGINA'] = "PAGINA=$PAGINA";
    
    RETURN "?".implode( "&" , $opt);
}

function gestorPagines($CERCA , $TASQUES)
{
  if($TASQUES->haveToPaginate())
  {       
     echo link_to(image_tag('tango/16x16/actions/go-previous.png'), 'gestio/gTasques'.getParam( null , null , $CERCA , $TIPUS , $MATERIALS->getPreviousPage()));
     echo " ";
     echo link_to(image_tag('tango/16x16/actions/go-next.png'), 'gestio/gTasques'.getParam( null , null , $CERCA , $TIPUS , $MATERIALS->getNextPage()));
  }
}

?>
