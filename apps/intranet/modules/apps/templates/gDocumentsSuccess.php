   <TD colspan="3" class="CONTINGUT">
	<DIV class="REQUADRE">
	<div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'apps/gDocuments'); ?></div>	
	<div class="titol">Directoris</div>		
      	<TABLE class="DADES"> 			  
			<?php echo mostraDirectoris($DIRECTORIS,0); ?>		                   	
    	</TABLE>    	         	
	</DIV>
	
	<DIV class="REQUADRE">
	<div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'apps/gDocuments'); ?></div>	
	<div class="titol">Arxius</div>		
      	<TABLE class="DADES"> 			  
			<?php echo mostraArxius($ARXIUS); ?>		                   	
    	</TABLE>    	         	
	</DIV>
	
	
	
   </TD>



<?php	
	
	function mostraDirectoris($DIRECTORIS,$ACTUAL)
	{	
		$RET = "";
		if(isset($DIRECTORIS[$ACTUAL]) && $ACTUAL > 1):	
			foreach($DIRECTORIS[$ACTUAL] as $FILL):
				$RET .= '<tr><td>'.link_to($FILL['NOM'],'apps/gDocuments?accio=CD&IDD='.$FILL['ID']).'</td></tr>';				
			endforeach;		
		else: 
			$RET .= '<tr><td>'.link_to('BASE','apps/gDocuments?accio=CD&IDD=0').'</td></tr>';
		endif;
		
		return $RET;
	}
	
	
	function mostraArxius($ARXIUS)
	{	
		$RET = "";
		if(isset($DIRECTORIS[$ACTUAL]) && $ACTUAL > 1):	
			foreach($DIRECTORIS[$ACTUAL] as $FILL):
				$RET .= '<tr><td>'.link_to($FILL['NOM'],'apps/gDocuments?accio=CD&IDD='.$FILL['ID']).'</td></tr>';				
			endforeach;		
		else: 
			$RET .= '<tr><td>'.link_to('BASE','apps/gDocuments?accio=CD&IDD=0').'</td></tr>';
		endif;
		
		return $RET;
	}




?>