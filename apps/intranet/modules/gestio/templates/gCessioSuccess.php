<?php use_helper('Form')?>
<?php use_javascript('/sfFormExtraPlugin/js/jquery.autocompleter.js') ?>
<?php use_stylesheet('/sfFormExtraPlugin/css/jquery.autocompleter.css') ?>

<STYLE>
.cent { width:100%; }
.vuitanta { width:80%; }
.cinquanta { width:50%; }
.HTEXT { height:100px; }
</STYLE>

<script>

$(document).ready(function() {
	 
		$('#cerca_select').change( function() { 
			$('#FCERCA').submit(); 
		});
		
	   $("#fcessio").submit(function() {		 
	     if($("#cessiomaterial_Material_idMaterial").val().length == 0 ){ alert("Has d'escollir el material a cedir"); return false; }
	     if($("#autocomplete_cessiomaterial_Cedita").val().length == 0 ){ alert("Cal omplir el camp cedit a!"); return false; }
		 
	 	 if(parseInt($("#cessiomaterial_DataRetorn_year").val()) > parseInt($("#cessiomaterial_DataCessio_year").val())) { return true; }
	 	 else if(parseInt($("#cessiomaterial_DataRetorn_month").val()) > parseInt($("#cessiomaterial_DataCessio_month").val())) { return true; }
	 	 else if(parseInt($("#cessiomaterial_DataRetorn_day").val()) >= parseInt($("#cessiomaterial_DataCessio_day").val())) { return true; } 
	 	 else { alert('La data de retorn no pot ser inferior a la de cessió'); return false; }  
 
	   });
	 });


</script>
   
    <TD colspan="3" class="CONTINGUT">
                                 
    <form action="<?php echo url_for('gestio/gCessio') ?>" method="POST" id="FCERCA">
	    <DIV class="REQUADRE">
	    	<table class="FORMULARI">          
	            <?php echo $FCerca ?>
	            <tr>
	            	<td colspan="2">
	            		<button name="BCERCA">Prem per buscar</button>
	            		<button name="BNOU_CESSIO">Nova cessió</button>	            			            		
	            	</td>
	            </tr>
	        </table>
	     </DIV>
     </form>   
  
  <?php IF( $MODE == 'NOU_CESSIO' || $MODE == 'EDICIO_CESSIO' ): ?>
      
	<form action="<?php echo url_for('gestio/gCessio') ?>" method="POST" id="fcessio">            
	 	<DIV class="REQUADRE">
	 	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gCessio?accio=C'))?>
	    	<table class="FORMULARI" width="550px">
	    	<tr><td class="error" colspan="2"><?php echo ComprovaError($ERROR_OCUPAT); ?></td></tr>	    		    
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <?php echo $FCessiomaterial?>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
						<?php include_partial('botonera',array('element'=>'la cessió','nom'=>'CESSIO')); ?>
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
     </form>    

  <?php elseif( $MODE == 'NOU_RETORN' || $MODE == 'EDICIO_RETORN' ): ?>    

	<form action="<?php echo url_for('gestio/gCessio') ?>" method="POST">            
	 	<DIV class="REQUADRE">
	 	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gCessio?accio=C'))?>
	    	<table class="FORMULARI" width="550px">
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <?php echo $FCessiomaterial?>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<?php include_partial('botonera',array('element'=>'la cessió','nom'=>'RETORN')); ?>						
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
					echo '<TR><TD class="LINIA" colspan="6">No s\'ha trobat material disponible.</TD></TR>';
				else: 
					$i = 0;
					echo "<TR>
                      			<TD class=\"TITOL\">MATERIAL</TD>                      			
                      			<TD class=\"TITOL\">CEDIT A</TD>
                      			<TD class=\"TITOL\">DATA CESSIÓ</TD>
                      			<TD class=\"TITOL\">DATA PREVISTA RETORN</TD>								                      			
                      			<TD class=\"TITOL\">DATA DE RETORN</TD>
                      			<TD class=\"TITOL\"></TD>
                      		  </TR>";
					foreach($CESSIONS->getResults() as $C):												
                      	$PAR = ParImpar($i++);
                      	$DRet = $C->getDataretornat();
                      	$DRetT = (is_null($DRet))?"No s'ha retornat.":$DRet;                      	                      	
                      	echo "<TR>
                      			<TD class=\"$PAR\">".$C->getMaterial()->getNom()."</TD>                      			
                      			<TD class=\"$PAR\">".$C->getCedita()."</TD>
                      			<TD class=\"dreta $PAR\">".$C->getDatacessio()."</TD>
                      			<TD class=\"dreta $PAR\">".$C->getDataretorn()."</TD>								                      			
                      			<TD class=\"dreta $PAR\">".$DRetT."</TD>
                      			<TD class=\"$PAR\">".creaOpcions($C->getIdcessiomaterial())."</TD>
                      		  </TR>";
                    endforeach;
                 endif;                     
             ?>      
              <TR><TD colspan="6" class="TITOL"><?php echo gestorPagines($CESSIONS);?></TD></TR>    	
      	</TABLE>      
      </DIV>

  <?php ENDIF; ?>
  
    
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
    

  <?php 
  
function creaOpcions($idC)
{  

  $R  = link_to(image_tag('template/book_open.png').'<span>Edita la cessió</span>','gestio/gCessio?accio=EC&IDC='.$idC,array('class'=>'tt2')).' ';
  $R .= link_to(image_tag('template/book_next.png').'<span>Edita el retorn</span>','gestio/gCessio?accio=ER&IDC='.$idC,array('class'=>'tt2')).' ';     
  return $R;
}
  
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

function ComprovaError($ERROR_OCUPAT)
{
	
	$RET = "";
	if(!empty($ERROR_OCUPAT['HORARIS'])):
		$RET = '<ul>';
		foreach($ERROR_OCUPAT['HORARIS'] as $H):			
			$RET .= '<li>Està en ús el dia '.$H->getDia('Y-m-d').' a l\'activitat '.$H->getActivitats()->getNom().'</li>';
		endforeach;
		$RET .= '</ul>';
	
	elseif(!empty($ERROR_OCUPAT['CESSIONS'])):
		$RET .= '<ul>';
		foreach($ERROR_OCUPAT['CESSIONS'] as $C):			
			$RET .= '<li>Aquest material està cedit el dia '.$C->getDatacessio('d/m/Y').' fins el dia '.$C->getDataretorn('d/m/Y').'</li>';
		endforeach;
		$RET .= '</ul>';	
	endif; 
	
	return $RET;
	
}



?>
 