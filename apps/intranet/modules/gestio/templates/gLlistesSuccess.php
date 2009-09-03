<?php use_helper('Form')?>

    <TD colspan="3" class="CONTINGUT">
    
	<form action="<?php echo url_for('gestio/gLlistes') ?>" method="post" enctype="multipart/form-data">
  	    <DIV class="REQUADRE">
	    <DIV class="TITOL"> <?php echo link_to(image_tag('tango/32x32/actions/document-new.png', array('size'=>'16x16','alt'=>'Nova llista')),'gestio/gLlistes'.getPar(NULL,'N')); ?> Llistes disponibles</DIV>
	    	<table class="DADES">          
                <?php                 
                  if( sizeof($LLISTES) == 0 ) echo '<TR><TD class="LINIA" colspan="5">No hi ha cap llista disponible.</TD></TR>';
                                    
                  foreach($LLISTES as $L):                  
                      echo '<TR><TD class="LINIA">'.link_to($L->getNom(),'gestio/gLlistes?accio=E&IDL='.$L->getIdllistes()).'</TD>
                                <TD class="OPCIONS">'.creaOpcions($L->getIdllistes()).'</TD>
                            </TR>';                                   
                  endforeach;                                  
                ?>
    
	        </table>
	     </DIV>
     </form>                  
  
  <?php IF( $MODE['NOU'] || $MODE['EDICIO'] ): ?>

	<form action="<?php echo url_for('gestio/gLlistes') ?>" method="post">            
	 	<DIV class="REQUADRE">
	    	<table class="FORMULARI" width="500px">
                <?php echo $FLlista ?>                								
                <tr>
                	<td width="100px"></td>               	
	            	<td class="dreta" width="400px">
	            		<br>
	            		<?php echo submit_image_tag('icons/Colored/PNG/action_check.png',array('name'=>'BSAVE_LLISTA'))?>
	            		<?php echo link_to(image_tag('icons/Colored/PNG/action_delete.png'),'gestio/gLlistes',array('confirm'=>'Segur que vols esborrar-lo?'))?>
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
     </form>  

  <?php ENDIF; ?>
  <?php IF( $MODE['USUARIS'] ): ?>

	<form action="<?php echo url_for('gestio/gLlistes') ?>" method="post">
 	    <DIV class="REQUADRE">
 	    	<DIV class="TITOL">Filtra usuaris</DIV>
	    	<table class="FORMULARI">          
	            <?php echo $FCerca ?>
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="BCERCA" value="Prem per buscar" />
	            		<input type="submit" name="BNOU" value="Nou contacte" />
	            	</td>
	            </tr>
	        </table>
	     </DIV>

	<?php if($LLISTA): ?>
	     
	    <DIV class="REQUADRE">
	    <DIV class="TITOL">Usuaris a la llista (<?php echo $USUARIS_LLISTA->getNbResults()?>)</DIV>
	    	<table class="DADES">          
                  <?php foreach($USUARIS_LLISTA->getResults() as $U): ?>                                                       
                  	<TR>
                  		<TD width="10%" class="LINIA"><?php echo checkbox_tag('BAIXA_USUARI[]',$U->getUsuariid())?></TD>
                  		<TD width="15%" class="LINIA"><?php echo $U->getDni()?></TD>
                  		<TD width="75%" class="LINIA"><?php echo $U->getNomComplet()?></TD>                  		
                  	</TR>
                  <?php endforeach; ?>
                	<TR>
                		<TD><?php echo gestorPaginesUsuarisLlista( $USUARIS_LLISTA )?></TD>
                		<TD></TD><TD><?php echo submit_tag('DESVINCULA',array('name'=>'BDESVINCULA'))?></TD></TR>                   	  
	        </table>
	     </DIV>
                     
	<?php else: ?>                     
                     
		<DIV class="REQUADRE">
	    <DIV class="TITOL">Usuaris disponibles (<?php echo $USUARIS_DISPONIBLES->getNbResults()?>)</DIV>
	    	<table class="DADES">          
            <?php foreach($USUARIS_DISPONIBLES->getResults() as $U):   // $U = new Usuaris(); ?>                                                       
                  	<TR>
                  		<TD width="10%" class="LINIA"><?php echo checkbox_tag('ALTA_USUARI[]',$U->getUsuariid())?></TD>
                  		<TD width="15%" class="LINIA"><?php echo $U->getDni()?></TD>
                  		<TD width="75%" class="LINIA"><?php echo $U->getNomComplet()?></TD>                  		
                  	</TR>
                  <?php endforeach; ?>    
	                <TR><TD><?php echo gestorPaginesUsuarisNoLlista( $USUARIS_DISPONIBLES )?></TD><TD></TD><TD><?php echo submit_tag('VINCULA',array('name'=>'BVINCULA'))?></TD></TR>                   	  
	        </table>
	     </DIV>

      <?php endif; ?>
      
       </form>

  <?php ENDIF; ?>      
  <?php IF( $MODE['MISSATGES'] ): ?>


	<form action="<?php echo url_for('gestio/gLlistes') ?>" method="post">            
	 	<DIV class="REQUADRE">	 	
	    	<table class="FORMULARI" width="600px">	    	
                <?php echo $FMissatge?>                								
                <tr>
                	<td width="100px"></td>               	
	            	<td class="dreta" width="400px">
	            		<br>	            		
	            		<?php echo submit_image_tag('icons/Colored/PNG/action_check.png',array('name'=>'BSAVE_MISSATGE'))?>
	            		<?php echo link_to(image_tag('icons/Colored/PNG/action_delete.png'),'gestio/gLlistes',array('confirm'=>'Segur que vols esborrar-lo?'))?>
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
      	
     </form>  

    
  <?php ENDIF; ?>
  <?php IF( $MODE['ENVIAT'] ): ?>
    
      <TABLE class="BOX"><TR><TD class="NOTICIA">MISSATGE ENVIAT A <?php echo $MAILS?> PERSONES.</TD></TR></TABLE>      

  <?php ENDIF; ?>
  <?php IF( $MODE['LLISTAT'] ): ?>

	    <DIV class="REQUADRE">
	    <DIV class="TITOL">Llistat de missatges de la llista:  <?php echo $LLISTA->getNom(); ?></DIV>
	    	<table class="DADES">          
                  <?php foreach($LMISSATGES as $M):  ?>                                                       
                  	<TR>
                  		<TD class="LINIA"><?php echo link_to($M->getTitol(),'gestio/gLlistes?accio=M&IDM='.$M->getIdmissatgesllistes().'&IDL='.$M->getLlistesIdllistes())?></TD>
						<TD class="LINIA">
							<? 
								if(!is_null($M->getEnviat('d/m/Y'))):
									echo $M->getEnviat('d/m/Y');
								else:
									echo button_to('Envia','gestio/gLlistes?accio=SEND&IDM='.$M->getIdmissatgesllistes());
								endif;
							?>
						</TD>
              		</TR>
                  <?php endforeach; ?>
                  <TR>                	                   	  
	        </table>
	     </DIV>
  
  <?php ENDIF; ?>

  
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
    
    
<!-- FI CONTINGUT -->
<!-- CALENDARI -->
 <!-- >
    <TD class="CALENDARI">          
      
    </TD>
-->
<!-- FI CALENDARI -->

<?php 

function creaOpcions($IDL , $ACCIO = NULL)
{      
  $R  = link_to('U','gestio/gLlistes?accio=U&IDL='.$IDL);
  $R .= " ";
  $R .= link_to('M','gestio/gLlistes?accio=M&IDL='.$IDL);  
  $R .= " ";
  $R .= link_to('L','gestio/gLlistes?accio=L&IDL='.$IDL);
  
  return $R;
}


function generaTaula($USUARISLLISTES,$PAGINA)
{
  $RET = '<TABLE class="Dades">';        
  foreach($USUARISLLISTES as $UL):   
    $U = $UL->getUsuaris(); 
    $RET .= '<TR><TD class="linia">'.checkbox_tag('USUARIS[]',$U->getUsuariid(),false).'</TD><TD class="linia">'.$U->getDNI().'</TD><TD class="linia">'.$U->getCog1()." ".$U->getCog2().', '.$U->getNom().'</TD></TR>';    
  endforeach;
  $RET .= "</TABLE>";  
  
  return $RET;
}


function generaLlistaMails($MISSATGES,$IDL)
{
  $RET = '<TABLE class="Dades">';        
  foreach($MISSATGES->getResults() as $M):                
    $RET .= '<TR><TD class="linia">&nbsp;&nbsp;&nbsp;'.fletxeta().'&nbsp;&nbsp;&nbsp;'.link_to($M->getTitol(),'gestio/gLlistes'.getPar($IDL,'MV',$M->getIdmissatgesllistes())).'</TD><TD class="linia">'.$M->getDate().'</TD></TR>';    
  endforeach;
  $RET .= "</TABLE>";  
  
  return $RET;
}



function fletxeta()
{
  return image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE'));
}


function getPar($IDL = NULL, $accio = NULL, $IDM = NULL)
{
    $A = "";        
    if(!is_null($IDL)) $A[] = 'IDL='.$IDL;
    if(!is_null($accio)) $A[] = 'accio='.$accio;
    if(!is_null($IDM)) $A[] = 'IDM='.$IDM;
    if(!empty($A)) return '?'.implode('&',$A); 
    else return '';
    
}

function getParPaginacio($ACCIO , $PAGINA = 1, $IDL = null)
{
    $A = "";        
    if(!empty($ACCIO)) $A[] = 'accio='.$ACCIO;
    if(!empty($PAGINA)) $A[] = 'PAGINA='.$PAGINA;    
    if(!empty($IDL)) $A[] = 'IDL='.$IDL;
    
    if(!empty($A)) return '?'.implode('&',$A); 
    else return '';
    
}

function gestorPaginesUsuarisLlista( $USUARIS )
{
   if($USUARIS->haveToPaginate())
   {       
      echo link_to(image_tag('tango/16x16/actions/go-previous.png'), "gestio/gLlistes".getParPaginacio('U',$USUARIS->getPreviousPage()));
	  echo " ";
	  echo link_to(image_tag('tango/16x16/actions/go-next.png'), "gestio/gLlistes".getParPaginacio('U',$USUARIS->getNextPage()));
   }
}

function gestorPaginesUsuarisNoLlista( $USUARIS )
{
   if($USUARIS->haveToPaginate())
   {       
      echo link_to(image_tag('tango/16x16/actions/go-previous.png'), "gestio/gLlistes".getParPaginacio('U',$USUARIS->getPreviousPage()));
	  echo " ";
	  echo link_to(image_tag('tango/16x16/actions/go-next.png'), "gestio/gLlistes".getParPaginacio('U',$USUARIS->getNextPage()));
   }
}


?>
