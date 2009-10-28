<TD colspan="3" class="CONTINGUT">
    
	<DIV class="REQUADRE">
		<DIV class="TITOL">Resum d'avui</DIV>
      	<TABLE class="DADES">
			<TR><TD>Incidències : 	</TD><TD><?=$NINCIDENCIES?></TD>
			<TD>Matrícules  : 		</TD><TD><?=$NMATRICULES?></TD>
			<TD>Material    : 		</TD><TD><?=$NMATERIAL?></TD>
			<TD>Missatges   : 		</TD><TD><?=$NMISSATGES?></TD>
			<TD>Feines      : 		</TD><TD><?=$NFEINES?></TD>
			<TD>Activitats  : 		</TD><TD><?=$NACTIVITATS?></TD></TR> 	 				    	
      	</TABLE>      
      </DIV>

	<DIV class="REQUADRE">
		<DIV class="TITOL">Missatges d'avui</DIV>
      	<TABLE class="DADES">
                <?php                
                	
                	if(empty($MISSATGES)): echo '<tr><td>Avui no hi ha cap missatge.</td></tr>'; endif; 	
                
					foreach($MISSATGES as $M):
						echo '<TR>';                  		
						echo '	<TD width="70%">'.image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE')).' '.link_to($M->getTitol().'<span>'.$M->getText().'</span>','#', array('class'=>'tt2')).'</TD>';						
						$U = $M->getUsuaris();											
						echo '  <TD width="20%">'.$U->getNom().' '.$U->getCog1().'</TD>';
						echo '  <TD width="10%">'.$M->getPublicacio().'</TD>';
						echo '</TR>';											
					endforeach;                               
                ?>                                                         
      	</TABLE>      
      </DIV>

	<DIV class="REQUADRE">
		<DIV class="TITOL">Feines per avui</DIV>
      	<TABLE class="DADES">
                <?php       
                
                	if(empty($MISSATGES)): echo '<tr><td>Avui no tens cap feina extra.</td></tr>'; endif;
                
					foreach($TASQUES->getResults() as $T):
						$U = $T->getUsuarisRelatedByQuimana()->getNom()." ".$T->getUsuarisRelatedByQuimana()->getCog1();
						$SPAN = '<SPAN>'.$T->getAparicio('d/m/Y').' -> '.$T->getDesaparicio('d/m/Y').'<br />'.$T->getAccio().'</SPAN>';
						echo '<TR>
								<TD>'.image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE')).' '.link_to($T->getTitol().$SPAN,'#',array('class'=>'tt2')).'</TD>																								
								<TD width="20%">'.$U.'</TD>
							  </TR>';						
                	endforeach;
                ?>                                                       
      	</TABLE>      
      </DIV>
         
	<DIV class="REQUADRE">
		<DIV class="TITOL">Activitats per avui</DIV>
      	<TABLE class="DADES">
                <?php                
					foreach($ACTIVITATS as $A):						
						echo '<TR>';                      	
	                  	echo '<TD>'.image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE')).' '.$A['NOM_ACTIVITAT'].'</TD>';
	                    echo '<TD>'.$A['DIA'].'</TD>';
	                  	echo '<TD>'.$A['HORA_INICI'].'</TD>';
	                    echo '<TD>'.implode("<BR />",$A['ESPAIS']).'</TD>';
	                    echo '<TD>'.implode("<BR />",$A['MATERIAL']).'</TD>';						            
	                    echo '</TR>';												
                	endforeach;
                ?>                                                       
		</TABLE>      
	</DIV>
      
            
      <DIV STYLE="height:40px;"></DIV>
                
    
    
<?php 

function fletxeta()
{
  return image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE'));
}


?>
