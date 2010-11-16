<TD colspan="3" class="CONTINGUT_ADMIN">
     
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
                	
                	if(empty($MISSATGES)): echo '<tr><td></td></tr>'; endif; 	
                
					foreach($MISSATGES as $M):
						echo '<TR>';
						$nom_id = "MISS".$M->getMissatgeid();                  								
						echo '	<TD width="70%">'.image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE')).' <a href="#TB_inline?height=300&width=500&inlineId='.$nom_id.'&modal=false" class="thickbox tt2">'.$M->getTitol().'<span id="'.$nom_id.'"><p style="font-size:12px; text-align:justify">'.$M->getText().'</p></span></a></TD>';																								
						$U = $M->getUsuaris();											
						echo '  <TD width="20%">'.$U->getNom().' '.$U->getCog1().'</TD>';
						echo '  <TD width="10%">'.$M->getPublicacio('d/m/Y').'</TD>';
						echo '</TR>';											
					endforeach;                               
                ?>                                                         
      	</TABLE>      
      </DIV>



	<DIV class="REQUADRE">
		<DIV class="TITOL">Feines i notificacions per avui</DIV>
      	<TABLE class="DADES">
                <?php

					foreach($NOTIFICACIONS as $F):						
						$SPAN = '<SPAN>'.$F['TEXT'].'</SPAN>';
                        $TIPUS = "N/D";
                        switch($F['TIPUS']){
                            case PersonalPeer::AP_FESTA: $TIPUS = 'Festa'; break;
                            case PersonalPeer::CANVI_HORARI: $TIPUS = 'Horari puntual'; break;
                            case PersonalPeer::HORARI_USUARI: $TIPUS = 'Horari habitual'; break;
                        }                        
						echo '<TR>
								<TD width="20%">'.image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE')).' <a href="#" class="tt2">'.$TIPUS.'</TD>																								
                                <TD><a href="#" class="tt2">'.$F['SUBTEXT'].$SPAN.'</TD>                                
								<TD width="20%">'.$F['USUARIA'].'</TD>
							  </TR>';						
                	endforeach;

                    foreach($INCIDENCIES as $I):						
						$SPAN = '<SPAN>'.$I->getDescripcio().'</SPAN>';
						echo '<TR>
								<TD width="20%">'.image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE')).' <a href="#" class="tt2">Incidència</TD>																								
                                <TD><a href="#" class="tt2">'.$I->getTitol().$SPAN.'</TD>                                
								<TD width="20%">'.UsuarisPeer::getNom($I->getQuiinforma()).'</TD>
							  </TR>';						
                	endforeach;                    
                                                   
					foreach($FEINES as $F):						
						$SPAN = '<SPAN>'.$F['TEXT'].'</SPAN>';
						echo '<TR>
								<TD width="20%">'.image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE')).' <a href="#" class="tt2">Feina</TD>																								
                                <TD><a href="#" class="tt2">'.$F['SUBTEXT'].$SPAN.'</TD>                                
								<TD width="20%">'.$F['USUARI'].'</TD>
							  </TR>';						
                	endforeach;
                                        
                ?>                                                       
      	</TABLE>      
      </DIV>



         
	<DIV class="REQUADRE">
		<DIV class="TITOL">Activitats per avui</DIV>
      	<TABLE class="DADES">
                <?php                
                
                	if(empty($ACTIVITATS)): echo '<tr><td></td></tr>'; endif;
                
					foreach($ACTIVITATS as $A):						
						echo '<TR>';                      	
						if( strlen( $A['AVIS'] ) > 2 ):  $AVIS = '<a href="#" class="tt2">'.image_tag('tango/32x32/emblems/emblem-important.png', array('size'=>'16x16')).'<span>'.$A['AVIS'].'</span></a>'; else: $AVIS = ""; endif;
	                  	echo '<TD>'.image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE')).' '.$A['NOM_ACTIVITAT'].$AVIS.'</TD>';	                    
	                  	echo '<TD><span style="font-weight:bold; font-size:10px; color:green;">'.$A['HORA_INICI'].'</span></TD>';	                  	
	                  	echo '<TD>'.$A['HORA_FI'].'</TD>';
	                  	$ESPAIS = "";	  
	                  	$Z = $A['ESPAIS'];                		                  	   
	                  	if(sizeof($A['ESPAIS']) > 0) $ESPAIS = implode('<br />',$Z);
	                    echo '<TD><span style="font-weight:bold; font-size:10px; color:#880000;">'.$ESPAIS.'</span></TD>';
	                    
	                    $MATERIAL = "";	     	                 	                               	
	                  	if(sizeof($A['MATERIAL']) > 0) $MATERIAL = implode("<BR />",$A['MATERIAL']);
	                    echo '<TD>'.$MATERIAL.'</TD>';						            
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
