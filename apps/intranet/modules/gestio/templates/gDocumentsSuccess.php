<?php use_helper('Form')?>
<?php use_javascript('/sfFormExtraPlugin/js/jquery.autocompleter.js') ?>
<?php use_stylesheet('/sfFormExtraPlugin/css/jquery.autocompleter.css') ?>
 
<script type="text/javascript">

$(document).ready( function() { 
	$('#IDD').change( function() {
		$('#FCERCA').append('<input type="hidden" name="B_VEURE_PERMISOS"></input>').submit(); 			
	});
});


</script>
 
<STYLE>
.cent { width:100%; }
.noranta { width:90%; }
.vuitanta  { width:80%; }
.setanta { width:75%; }
.cinquanta { width:50%; }
.HTEXT { height:100px; }
.espai { padding-left:5px; padding-right:5px; }

</STYLE>
   
    <TD colspan="3" class="CONTINGUT">
        
    <form action="<?php echo url_for('gestio/gDocuments') ?>" method="POST" id="FCERCA">
	    <DIV class="REQUADRE">
	    <DIV class="TITOL">Escull un directori: </DIV>
	    	<table class="FORMULARI">
	    		<?php echo select_tag('IDD',options_for_select(AppDocumentsDirectorisPeer::getSelectDirectoris(),$IDD));  ?>          	
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="B_VEURE_PERMISOS" value="Veure permisos" />	            
	            		<input type="submit" name="B_NOU" value="Nou directori" />
	            		<input type="submit" name="B_EDITA_DIRECTORI" value="Edita directori" />
	            	</td>
	            </tr>
	        </table>
	     </DIV>
     </form>   

	<?php IF( $MODE == 'CONSULTA' ): ?>      
        
        
	<form action="<?php echo url_for('gestio/gDocuments') ?>" method="POST">
	      <DIV class="REQUADRE">
	        <DIV class="TITOL">Llitat d'usuaris i permisos</DIV>
	      	<TABLE class="DADES">
	 			<?php 
					if( sizeof($LLISTAT_PERMISOS) == 0 ):					
						echo '<TR><TD colspan="3">Ningú hi té accés.</TD></TR>';						
					else:					 
						echo '<TR><th>DNI</th><th>Nom</th><th>Permís</th></TR>';
											
						foreach($LLISTAT_PERMISOS as $P):							                      	                	
	                    	echo '<TR>							
									<TD>'.$P['DNI'].'</TD>
								    <TD>'.$P['nomUsuari'].'</TD>
								    <TD>'.select_tag('nivell['.$P['idUsuari'].']',options_for_select(NivellsPeer::getSelectPermisos(),$P['idNivell'])).'</TD>
							      </TR>';							                		                 															                		                 															
	                    endforeach;
	                  
	                 endif;	                 
	             ?>
	                   	
	            <td colspan="3" class="dreta"><br>
	            	<?php echo submit_tag('Afegir usuari',array('name'=>'B_NEW_USER','class'=>'BOTO_ACTIVITAT')) ?>
	 				<?php echo submit_tag('Actualitza els permisos',array('name'=>'B_UPDATE_PERMISOS','class'=>'BOTO_ACTIVITAT')) ?>	            			            	
	            </td>
	                               	
	      	</TABLE>      
	      </DIV>
	</form>

  <?php ENDIF; ?>
  
  <?php IF( $MODE == 'NOU' ):  ?>

 	<form action="<?php echo url_for('gestio/gDocuments') ?>" method="POST">
	    <DIV class="REQUADRE">
	    <DIV class="TITOL">Nom del nou directori</DIV>
	    	<table class="FORMULARI" width="100%">
	    		<tr><th>Directori pare: </th><td><?php echo select_tag('IDD',options_for_select(AppDocumentsDirectorisPeer::getSelectDirectoris(),$IDD));  ?></td></tr>
	    		<tr><th>Nom del nou directori: </th><td><?php echo input_tag('NOMDIR'); ?></td></tr>
	 				 		
	 			<td colspan="2" class="dreta"><br>
	 				<?php echo submit_tag('Guarda el directori',array('name'=>'B_SAVE_NOU','class'=>'BOTO_ACTIVITAT')) ?>	            			            	
	            </td>
	 		      
	        </table>
	     </DIV>
     </form>	

  <?php ENDIF; ?>
  
  <?php IF( $MODE == 'EDITA_DIRECTORI' ):  ?>

 	<form action="<?php echo url_for('gestio/gDocuments') ?>" method="POST">
	    <DIV class="REQUADRE">
	    <DIV class="TITOL">Edita el directori</DIV>
	    	<table class="FORMULARI" width="100%">
	    		<?php echo $FDIRECTORI ?>
	 				 		
	 			<td colspan="2" class="dreta"><br>
	 				<?php echo submit_tag('Guarda el directori',array('name'=>'B_SAVE_EDITA_DIRECTORI','class'=>'BOTO_ACTIVITAT')) ?>	            			            	
	 				<?php echo submit_tag('Esborra el directori',array('name'=>'B_DELETE_DIRECTORI','class'=>'BOTO_ACTIVITAT')) ?>
	            </td>
	 		      
	        </table>
	     </DIV>
     </form>	

  <?php ENDIF; ?>
  
  
  
  <?php IF( $MODE == 'NOU_USUARI' ):  ?>

 	<form action="<?php echo url_for('gestio/gDocuments') ?>" method="POST">
	    <DIV class="REQUADRE">
	    <DIV class="TITOL">Escull el nou usuari i els permisos al directori</DIV>
	    	<table class="FORMULARI" width="100%">
	    		<?php echo $FPERMISOS; ?>
	 			<td colspan="2" class="dreta"><br>
	 				<?php echo submit_tag('Afegeix el nou usuari',array('name'=>'B_NOU_USUARI_PERMISOS','class'=>'BOTO_ACTIVITAT')) ?>	            			            	
	            </td>
	 		      
	        </table>
	     </DIV>
     </form>	

  <?php ENDIF; ?>