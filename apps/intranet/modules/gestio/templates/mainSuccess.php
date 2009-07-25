    <TD colspan="3" class="CONTINGUT">
    
	  <TABLE class="BOX">
	  	<TR>
	  		<TD class="NOTICIA">
	  			<DIV class="TITOL">Resum avui</DIV>
				<TABLE class="DADES">
					<TR><TD>Incidències : </TD><TD><?=$NINCIDENCIES?></TD></TR>
					<TR><TD>Matrícules  : </TD><TD><?=$NMATRICULES?></TD></TR>
					<TR><TD>Material    : </TD><TD><?=$NMATERIAL?></TD></TR>
					<TR><TD>Missatges   : </TD><TD><?=$NMISSATGES?></TD></TR>
					<TR><TD>Feines      : </TD><TD><?=$NFEINES?></TD></TR>
					<TR><TD>Activitats  : </TD><TD><?=$NACTIVITATS?></TD></TR>	                                                                        
                </TABLE>                                                                  
	  		</TD>
	  	</TR>
	  </TABLE>

      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Missatges d'avui</DIV>
                <TABLE class="DADES">
                <?php                
                    if(empty($MISSATGES)):
                     echo '<TR><TD class="LINIA">'.image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE')).' Avui no hi ha missatges nous.</TD></TR>';                  								
                    endif;
					foreach($MISSATGES as $M):
						echo '<TR>';                  		
						echo '	<TD class="LINIA" width="70%">'.image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE')).' '.link_to($M->getTitol().'<span>'.$M->getText().'</span>','#', array('class'=>'tt2')).'</TD>';						
						$U = $M->getUsuaris();											
						echo '  <TD class="LINIA" width="20%">'.$U->getNom().' '.$U->getCog1().'</TD>';
						echo '  <TD class="LINIA" width="10%">'.$M->getPublicacio().'</TD>';
						echo '</TR>';											
					endforeach;                               
                ?>                                                         
                </TABLE>                                                                  
              </TD>
        </TR>
      </TABLE>

      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Feines per avui</DIV>
                <TABLE class="DADES">
                <?php
                	if( $TASQUES->getNbResults() == 0 )  echo '<TR><TD class="LINIA">'.image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE')).' Avui no tens tasques extres. </TD></TR>';
					foreach($TASQUES->getResults() as $T):
						$U = $T->getUsuarisRelatedByQuimana()->getNom()." ".$T->getUsuarisRelatedByQuimana()->getCog1();
						$SPAN = '<SPAN>'.$T->getAparicio('d/m/Y').' -> '.$T->getDesaparicio('d/m/Y').'<br />'.$T->getAccio().'</SPAN>';
						echo '<TR>
								<TD class="LINIA">'.image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE')).' '.link_to($T->getTitol().$SPAN,'#',array('class'=>'tt2')).'</TD>																								
								<TD class="LINIA" width="20%">'.$U.'</TD>
							  </TR>';						
                	endforeach;
                ?>
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>
      
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Activitats d'avui</DIV>
                <TABLE class="DADES">
                <?php                
					foreach($ACTIVITATS as $A):						
						echo '<TR>';                      	
	                  	echo '<TD class="LINIA">'.image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE')).' '.$A['NOM_ACTIVITAT'].'</TD>';
	                    echo '<TD class="LINIA">'.$A['DIA'].'</TD>';
	                  	echo '<TD class="LINIA">'.$A['HORA_INICI'].'</TD>';
	                    echo '<TD class="LINIA">'.implode("<BR />",$A['ESPAIS']).'</TD>';
	                    echo '<TD class="LINIA">'.implode("<BR />",$A['MATERIAL']).'</TD>';						            
	                    echo '</TR>';												
                	endforeach;
                ?>

                </TABLE>                                          
              </TD>
        </TR>
      </TABLE>
      
      
      <DIV STYLE="height:40px;"></DIV>
                
    
    
<?php 

function fletxeta()
{
  return image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE'));
}


?>
