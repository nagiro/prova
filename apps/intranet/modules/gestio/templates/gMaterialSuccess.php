<?php use_helper('Form')?>
<STYLE>
.cent { width:100%; }
.vuitanta { width:80%; }
.cinquanta { width:50%; }
.HTEXT { height:100px; }
</STYLE>

<script type="text/javascript">

	$(document).ready( function() { 
		$('#cerca_text').change( function() { 
			$('#FCERCA').submit(); 
		});
		$('#FORMSUBMIT').submit(ValidaFormulari);
	});

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
		if($('#material_Identificador').val().length == 0) { alert('L\'identificador no pot estar buit.'); return false; }
		if($('#material_Nom').val().length == 0) { alert('El nom no pot estar buit.'); return false; }
		if($('#material_Ubicacio').val().length == 0) { alert('L\'ubicació no pot estar buida.'); return false; }
		if($('#material_NumSerie').val().length == 0) { alert('El número de sèrie no pot estar buit.'); return false; }		
		if($('#material_DataCompra_day').val().length == 0 ) { alert('La data compra no pot estar buida.'); return false; } 
		if($('#material_DataGarantia_day').val().length == 0 ) { alert('La data de garantia no pot estar buida.'); return false; }
		if($('#material_DataRevisio_day').val().length == 0 ) { alert('La data de propera revisió no pot estar buida.'); return false; }		
		if($('#material_DataBaixa_day').val().length == 0) { alert('La data de baixa no pot estar buida.'); return false; }				
		return true;				 
	}

</script>
   
    <TD colspan="3" class="CONTINGUT">
    
      
    <form action="<?php echo url_for('gestio/gMaterial') ?>" method="POST" id="FCERCA">
	    <DIV class="REQUADRE">
	    	<table class="FORMULARI">          
	            <?php echo $FCerca ?>
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="BCERCA" value="Prem per buscar" />
	            		<input type="submit" name="BNOU" value="Nou material" />
	            	</td>
	            </tr>
	        </table>
	     </DIV>
     </form>   
    
      
<?php IF( $NOU || $EDICIO ): ?>
      
	<form action="<?php echo url_for('gestio/gMaterial') ?>" method="POST" id="FORMSUBMIT">            
	 	<DIV class="REQUADRE">
	 	<div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gMaterial?accio=L'); ?></div>
	    	<table class="FORMULARI" width="550px">
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <?php echo $FMaterial?>                								
                <tr>
                	<td></td>
		           	<td colspan="2" class="dreta">
	            		<?php include_partial('botonera',array('element'=>'el material'))?>
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
     </form>    

<?php ELSE: ?>

      <DIV class="REQUADRE">
        <DIV class="TITOL">Llistat de material</DIV>
      	<TABLE class="DADES">
 			<?php 
				if( empty( $MATERIALS ) ):
					echo '<TR><TD class="LINIA" colspan="3">No s\'ha trobat material disponible.</TD></TR>';
				else: 
					$i = 0;
					foreach($MATERIALS->getResults() as $M):
                      	$PAR = ParImpar($i++);	                      	
                      	echo "<TR>
                      			<TD class=\"$PAR\">".link_to($M->getIdentificador(), 'gestio/gMaterial'.getParam('E',$M->getIdmaterial(),$TIPUS,$PAGINA))."</TD>
                      			<TD class=\"$PAR\">{$M->getNom()}</TD>                      			
                      		  </TR>";
                    endforeach;
                 endif;                     
             ?>      
              <TR><TD colspan="3" class="TITOL"><?php echo gestorPagines($TIPUS , $MATERIALS);?></TD></TR>    	
      	</TABLE>      
      </DIV>

<?php ENDIF; ?>
    
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
    

  <?php 

function getParam( $accio = "" , $IDM = "" , $TIPUS = "" , $PAGINA = 1)
{
    $opt = array();
    if(!empty($accio)) $opt[] = "accio=$accio";
    if(!empty($IDM)) $opt['IDM'] = "IDM=$IDM";
    if(!empty($TIPUS)) $opt['TIPUS'] = "TIPUS=$TIPUS";
    if(!empty($PAGINA)) $opt['PAGINA'] = "PAGINA=$PAGINA";
    
    RETURN "?".implode( "&" , $opt);
}

function ParImpar($i)
{
	if($i % 2 == 0) return "PAR";
	else return "IPAR";
}


function gestorPagines($TIPUS , $MATERIALS)
{
  if($MATERIALS->haveToPaginate())
  {       
     echo link_to(image_tag('tango/16x16/actions/go-previous.png'), 'gestio/gMaterial'.getParam(null,null,$TIPUS,$MATERIALS->getPreviousPage()));
     echo " ";
     echo link_to(image_tag('tango/16x16/actions/go-next.png'), 'gestio/gMaterial'.getParam(null,null,$TIPUS,$MATERIALS->getNextPage()));
  }
}

?>
 