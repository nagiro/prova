   <TD colspan="3" class="CONTINGUT">
	<DIV class="REQUADRE">
	<div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'apps/gDocuments'); ?></div>	
	<div class="titol">Directoris</div>		
      	<TABLE class="DADES"> 			  
			<?php echo mostraDirectoris($DIRECTORIS,$ACTUAL->getIddirectori()); ?>		                   	
    	</TABLE>    	         	
	</DIV>
	
	<DIV class="REQUADRE">
	<div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'apps/gDocuments'); ?></div>	
	<div class="titol">Arxius</div>		
      	<TABLE class="DADES"> 			  
			<?php echo mostraArxius($ACTUAL); ?>		                   	
    	</TABLE>    	         	
	</DIV>

<?php if($ADMIN): ?>

	<DIV class="REQUADRE">
	<div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'apps/gDocuments'); ?></div>	
	<div class="titol">Assigna permisos</div>		
      	<TABLE class="DADES"> 			  
			<?php echo $FDIRECTORIS;  ?>		                   	
    	</TABLE>    	         	
	</DIV>

<?php endif; ?>
		
   </TD>



<?php	
	
	function mostraDirectoris($DIRECTORIS,$ACTUAL)
	{	
		$RET = "";
		if(isset($DIRECTORIS[$ACTUAL])):	
			foreach($DIRECTORIS[$ACTUAL] as $ID => $NOM):				
				$RET .= '<tr><td>'.link_to($NOM,'apps/gDocuments?accio=CD&IDD='.$ID).'</td></tr>';				
			endforeach;		
		else: 
			$RET .= '<tr><td>'.link_to('BASE','apps/gDocuments?accio=CD&IDD=0').'</td></tr>';
		endif;
		
		return $RET;
	}
	
	
	function mostraArxius($DIRECTORI_ACTUAL_ID)
	{	
		$RET = "";
		
		$ARXIUS = $DIRECTORI_ACTUAL_ID->getAppDocumentsArxiuss();
		
		if(sizeof($ARXIUS) == 0) $RET .= '<tr><td>No hi ha cap arxiu disponible</td></tr>';
		
		foreach($ARXIUS as $ARXIU):					
			$RET .= '<tr><td>'.link_to($ARXIU->getNom(),'apps/gDocuments?accio=VA&IDA='.$ARXIU->idDocument()).'</td></tr>';								
		endforeach; 				
		
		return $RET;
	}




?>
