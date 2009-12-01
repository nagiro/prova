<?php use_helper('Form')?>
<?php use_javascript('/sfFormExtraPlugin/js/jquery.autocompleter.js') ?>
<?php use_stylesheet('/sfFormExtraPlugin/css/jquery.autocompleter.css') ?>
   
   
   <TD colspan="3" class="CONTINGUT">

<?php if($MODE == 'CONSULTA'): ?>  
	<DIV class="REQUADRE">
	<div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'apps/gDocuments?accio=CD'); ?></div>	
	<div class="titol">Directoris <span style="font-weight:normal"> ( <?php echo $ACTUAL->getRutaActual() ?> )</span></div>		
      	<TABLE class="DADES"> 			  
			<?php echo mostraDirectoris($DIRECTORIS,$ACTUAL->getIddirectori(),$ACTUAL->getPare()); ?>		                   	
    	</TABLE>    	         	
	</DIV>
	
	<DIV class="REQUADRE">
	<div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'apps/gDocuments?accio=CD'); ?></div>	
	<div class="titol">Arxius ( <?php echo link_to('Carrega un nou arxiu',url_for('apps/gDocuments?accio=UPLOAD'))?> )</div>		
      	<TABLE class="DADES"> 			  
			<?php echo mostraArxius($ACTUAL); ?>		                   	
    	</TABLE>    	         	
	</DIV>
<?php ENDIF; ?>

<?php IF($MODE == 'UPLOAD'): ?>

 	<form action="<?php echo url_for('apps/gDocuments') ?>" method="POST" enctype="multipart/form-data">
	    <DIV class="REQUADRE">
	    <div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'apps/gDocuments?accio=CD'); ?></div>	    
	    	<table class="FORMULARI" width="100%">
	 			<?php echo $FUPLOAD; ?>
	 		
	 			<td colspan="2" class="dreta"><br>
	 				<?php echo submit_tag('Carrega l\'arxiu',array('name'=>'B_SAVE_UPLOAD','class'=>'BOTO_ACTIVITAT')) ?>	            			            	
	            </td>
	 		      
	        </table>
	     </DIV>
     </form>	


<?php ENDIF; ?>

   </TD>



<?php	
	
	function mostraDirectoris($DIRECTORIS,$ACTUAL,$PARE)
	{	
		$RET = "";
		if(!is_null($PARE)):
			$RET .= '<tr><td>'.link_to('<- Directori anterior ','apps/gDocuments?accio=CD&IDD='.$PARE).'</td></tr>';
		endif; 
		
		if(isset($DIRECTORIS[$ACTUAL])):	
			foreach($DIRECTORIS[$ACTUAL] as $ID => $NOM):				
				$RET .= '<tr><td>'.link_to($NOM,'apps/gDocuments?accio=CD&IDD='.$ID).'</td></tr>';				
			endforeach;		
		//else: 
		//	$RET .= '<tr><td>'.link_to('BASE','apps/gDocuments?accio=CD&IDD=0').'</td></tr>';
		endif;
		
		return $RET;
	}
	
	
	function mostraArxius($DIRECTORI_ACTUAL_ID)
	{	
		$RET = "";
		
		$ARXIUS = $DIRECTORI_ACTUAL_ID->getAppDocumentsArxiuss();
		
		if(sizeof($ARXIUS) == 0) $RET .= '<tr><td>No hi ha cap arxiu disponible</td></tr>';
		
		foreach($ARXIUS as $ARXIU):					
			$RET .= '<tr>
						<td>'.$ARXIU->getNom().'</td>
						<td>'.link_to(image_tag('template/blog.png').'<span>Edita el document</span>',url_for('apps/gDocuments?accio=UPLOAD&IDA='.$ARXIU->getIddocument()),array('class'=>'tt2')).' 
						'.link_to(image_tag('template/drive_disk.png').'<span>Descarrega\'t el document</span>',sfConfig::get('sf_webroot').sfConfig::get('sf_webappdocuments').$ARXIU->getUrl(),array('class'=>'tt2')).'</td>
					</tr>';								
		endforeach; 				
		
		return $RET;
	}

?>
