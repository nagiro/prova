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

	 	$("#mesmaterial").click( function() { creaFormMaterial(); });			//Marquem que a cada click es farà un nou formulari	 	
	 
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

	function validaDisponibilitatMaterial(a)
	{
		$.post(	"<?php echo url_for('gestio/gCessio'); ?>",
				{ accio: "VM", idM: a.options[a.selectedIndex].value },
				function (data){ if(data.length > 0) alert(data); });				   		
	}

	function creaFormMaterial()
	{
		
		var id = $("#idV").val();		
		id = (parseInt(id) + parseInt(1));
		$("#idV").val(id);		
				
		var options = '<?php echo MaterialgenericPeer::selectAjax(); ?>';
		$("#divTxt").append('<span id="row['+id+']"><select onChange="ajax(this,'+id+')" name="generic[' + id + ']"> id="generic[' + id + ']">' + options + '</select> <select onChange="validaDisponibilitatMaterial(this)" name="material[' + id + ']" id="material[' + id + ']"></select>	<input type="button" onClick="esborraLinia('+id+');" id="mesmaterial" value="-"></input><br /></span>');
		ajax($("generic\\["+id+"\\]"),id);  //Carreguem el primer																	
	}

	function esborraLinia(id) { $("#row\\["+id+"\\]").remove(); }

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

</script>
   
    <TD colspan="3" class="CONTINGUT">

	<?php include_partial('breadcumb',array('text'=>'CESSIÓ')); ?>
                                 
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
                <?php echo $FCessio?>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<button class="BOTO_ACTIVITAT" name="BESCULL_MATERIAL">Seguir cessió --></button>						
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
     </form>    

  <?php elseif( $MODE == 'ESCULL_MATERIAL' ): ?>
      
	<form action="<?php echo url_for('gestio/gCessio') ?>" method="POST" id="fmaterial">            
	 	<DIV class="REQUADRE">
	 	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gCessio?accio=C'))?>
	    	<table class="FORMULARI" width="550px">	    		    		   
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <tr><td id="material"></td></tr>                								
                <tr>
                	<td width="100%">
                	<div class="TITOL">Escull el material de la cessió: </div>
                	<?php 
						$id = 1;  $VAL = "";
						if(!isset($MATERIALOUT)): $MATERIALOUT = array(); endif;        	
	             		foreach($MATERIALOUT AS $M=>$idM):
	
	             		$VAL .= '
	  	 	  	        		<span id="row['.$id.']">
	  	 	  	        			<select onChange="ajax(this,'.$id.')" name="generic['.$id.']"> id="generic['.$id.']">'.options_for_select(MaterialgenericPeer::select(),$idM['generic']).'</select>
	  	 	  	        			<select onChange="validaDisponibilitatMaterial(this)" name="material['.$id.']" id="material['.$id.']">'.options_for_select(MaterialPeer::selectGeneric($idM['generic']),$idM['material']).'</select>	
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
	            	<td colspan="2" class="dreta">
	            		<button class="BOTO_ACTIVITAT" name="B_SAVE_CESSIO">Finalitzar cessió</button>						
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
     </form>    

  <?php elseif( $MODE == 'FINALITZAT' ): ?>
      
            
 	<DIV class="REQUADRE">
 	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gCessio?accio=C'))?>
	    	<table class="FORMULARI" width="550px">	    		    		   
	    	<tr><td width="100px"></td><td width="500px"><b>Material cedit correctament.</b></td></tr>                            								                                            	 
	    	
      		</TABLE>
      </DIV>        

  <?php elseif( $MODE == 'NOU_RETORN' || $MODE == 'EDICIO_RETORN' ): ?>    

	<form action="<?php echo url_for('gestio/gCessio') ?>" method="POST">            
	 	<DIV class="REQUADRE">
	 	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gCessio?accio=C'))?>
	    	<table class="FORMULARI" width="550px">
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <?php echo $FCessio ?>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<?php include_partial('botonera',array('element'=>'la cessió','tipus'=>'Guardar','nom'=>'BSAVE_RETORN')); ?>	            				
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
                      			<TD class=\"$PAR\">".UsuarisPeer::getNom($C->getUsuariid())."</TD>
                      			<TD class=\"dreta $PAR\">".$C->getDataCessio('d/m/Y')."</TD>
                      			<TD class=\"dreta $PAR\">".$C->getDataRetorn('d/m/Y')."</TD>								                      			
                      			<TD class=\"dreta $PAR\">".$DRetT."</TD>
                      			<TD class=\"$PAR\">".creaOpcions($C->getCessioId())."</TD>
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
  $R .= link_to(image_tag('template/printer.png').'<span>Imprimeix el document</span>','gestio/gCessio?accio=PRINT&IDC='.$idC,array('class'=>'tt2')).' ';
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
 