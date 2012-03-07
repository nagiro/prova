<?php
    
	if( $AGENDES->getNbResults() == 0 ):
	   echo '<TR><TD class="LINIA" colspan="3">No s\'ha trobat cap resultat d\'entre '.AgendatelefonicaPeer::getLinies($IDS).' disponibles.</TD></TR>';
	else: 
		$i = 0;
		foreach($AGENDES->getResults() as $A):
			$SPAN = '<SPAN>';                      	
		    foreach($A->getAgendatelefonicadadesActiu() as $ATD): $SPAN  .= AgendatelefonicadadesPeer::getTipus($ATD->getTipus()).': '.$ATD->getDada().' - '.$ATD->getNotes().'<BR />'; endforeach;
		    	$SPAN .= '</SPAN>';
		        $PAR = ParImpar($i++);	                      	
		        echo   	'<TR>
		                	<TD class="'.$PAR.'"><a href="'.url_for('gestio/gAgenda?accio=E&AID='.$A->getAgendatelefonicaid()).'" class="tt2" >'.image_tag('template/doc_text_image.png').$SPAN.'</TD>
		                    <TD class="'.$PAR.'"><a href="'.url_for('gestio/gAgenda?accio=E&AID='.$A->getAgendatelefonicaid()).'" class="tt2" >'.$A->getNom().$SPAN.'</TD>
		                    <TD class="'.$PAR.'">'.$A->getEntitat().'</TD>
		                    <TD class="'.$PAR.'">'.$A->getTags().'<TD>
		                 </TR>';
		endforeach;
	endif;
    
    echo '<tr><td colspan="4" style="text-align:center;">'.myUser::Paginacio($AGENDES,url_for('gestio/gAgenda').'?1=1').'</td></tr>';
	
?>