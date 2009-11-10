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
                                <TD class="OPCIONS" width="80px">'.creaOpcions($L->getIdllistes()).'</TD>
                            </TR>';                                   
                  endforeach;                                  
                ?>
    
	        </table>
	     </DIV>
	     
	   	<DIV class="REQUADRE">
	    <DIV class="TITOL"> <?php echo link_to(image_tag('tango/32x32/actions/document-new.png', array('size'=>'16x16','alt'=>'Nova llista')),'gestio/gLlistes?accio=EM'); ?> Missatges disponibles</DIV>
	    	<table class="DADES" width="100%">	    		          
                <?php                 
                  if( sizeof($MISSATGES) == 0 ) echo '<TR><TD class="LINIA" colspan="5">No hi ha cap missatge enviat.</TD></TR>';
                                    
                  foreach($MISSATGES->getResults() as $M):                  
                      echo '<TR><TD class="LINIA">'.link_to($M->getTitol(),'gestio/gLlistes?accio=EM&IDM='.$M->getidMissatge()).'</TD>
		 	                   	<TD class="LINIA">'.getMissatgesEnviatsLlistes($M).'</TD>
                                <TD width="80px" class="OPCIONS">'.creaOpcionsM($M->getIdmissatge()).'</TD>
                            </TR>';                                   
                  endforeach;                                  
                ?>
    
	        </table>
	     </DIV>	     
	     	     
     </form>                  
  
  <?php IF( $MODE == 'NOU' || $MODE == 'EDICIO' ): ?>

	<form action="<?php echo url_for('gestio/gLlistes') ?>" method="post">            
	 	<DIV class="REQUADRE">
	 		<div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gLlistes'); ?></div>
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
  <?php IF( $MODE == 'USUARIS' ): ?>

	<form action="<?php echo url_for('gestio/gLlistes') ?>" method="post">
 	    <DIV class="REQUADRE">
 	    	<div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gLlistes'); ?></div>
 	    	<DIV class="TITOL">Filtra usuaris</DIV>
	    	<table class="FORMULARI">          
	            <?php echo $FCerca ?>
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="BCERCA" value="Prem per buscar" />	            		
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
  <?php IF( $MODE == 'MISSATGES' ): ?>


	<form action="<?php echo url_for('gestio/gLlistes') ?>" method="post">            
	 	<DIV class="REQUADRE">	 	
	    	<table class="FORMULARI" width="600px">	    	
                <?php echo $FMissatge?>                								
                <tr>
                	<td width="100px"></td>               	
	            	<td class="dreta" width="400px">
	            		<br>
	            		<?php echo submit_tag("Guardar",array('class'=>"BOTO_ACTIVITAT",'name'=>'BSAVE_MISSATGE')) ?>    			
	            		<?php echo submit_tag('Segueix -->>',array('class'=>"BOTO_ACTIVITAT",'name'=>'BSEGUEIX_LLISTES')) ?>	            	            		
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
      	
     </form>  

    
  <?php ENDIF; ?>
  
  <?php IF( $MODE == 'MISSATGES_LLISTES' ): ?>


	<form action="<?php echo url_for('gestio/gLlistes') ?>" method="post">            
	 	<DIV class="REQUADRE">	 	
	    	<table class="FORMULARI" width="600px">
	    		<tr><td>Llistes: </td><td><?php echo select_tag('LLISTES_ENVIAMENT',options_for_select(LlistesPeer::select(),$LLISTES_ENVIAMENT),array('multiple'=>true)); ?></td></tr>	    	                								
                <tr>
                	<td width="100px"></td>               	
	            	<td class="dreta" width="400px">
	            		<br>
	            		<?php echo submit_tag("Guardar",array('class'=>"BOTO_ACTIVITAT",'name'=>'BSAVE_LLISTES')) ?>    			
	            		<?php echo submit_tag('Segueix -->>',array('class'=>"BOTO_ACTIVITAT",'name'=>'BSEGUEIX_ENVIAMENT')) ?>	            	            		
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
      	
     </form>  

    
  <?php ENDIF; ?>
  

  <?php IF( $MODE == 'FER_PROVA' ): ?>


	<form action="<?php echo url_for('gestio/gLlistes') ?>" method="post">            
	 	<DIV class="REQUADRE">	 	
	    	<table class="FORMULARI" width="600px">
	    		<tr><td>Email: </td><td><?php echo input_tag('email'); ?></td></tr>	    	                								
                <tr>
                	<td width="100px"></td>               	
	            	<td class="dreta" width="400px">
	            		<br>
	            		<?php echo submit_tag("Enviar prova",array('class'=>"BOTO_ACTIVITAT",'name'=>'BSEND_PROVA')) ?>    			
	            		<?php echo submit_tag('Finalitzar',array('class'=>"BOTO_ACTIVITAT",'name'=>'BFI')) ?>	            	            		
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
      	
     </form>  

    
  <?php ENDIF; ?>

  
  
  <?php IF( $MODE == 'ENVIAT' ): ?>
    
      <TABLE class="BOX"><TR><TD class="NOTICIA">MISSATGE ENVIAT A <?php echo $MAILS?> PERSONES.</TD></TR></TABLE>      

  <?php ENDIF; ?>
  <?php IF( $MODE == 'LLISTAT' ): ?>

	    <DIV class="REQUADRE">
	    <DIV class="TITOL">Llistat de missatges de la llista:  <?php echo $LLISTA->getNom(); ?></DIV>
	    	<table class="DADES">          
                  <?php foreach($LMISSATGES as $M):  ?>                                                       
                  	<TR>
                  		<TD class="LINIA"><?php echo link_to($M->getTitol(),'gestio/gLlistes?accio=M&IDM='.$M->getIdmissatgesllistes().'&IDL='.$M->getLlistesIdllistes())?></TD>
						<TD class="LINIA">
							<?php 
								if(!is_null($M->getEnviat('d/m/Y'))):
									echo $M->getEnviat('d/m/Y');
								else:
									echo 'No enviat';
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
	
  $R  = link_to('<span>Gestió dels usuaris de la llista</span>'.image_tag('template/user.png',array('alt'=>'Gestió d\'usuaris de la llista.')),'gestio/gLlistes?accio=U&IDL='.$IDL,array('class'=>'tt2'));
  $R .= " ";  
  $R .= link_to('<span>Llistat de missatges enviats</span>'.image_tag('template/page_white_stack.png',array('alt'=>'Llistat de missatges enviats.')),'gestio/gLlistes?accio=L&IDL='.$IDL,array('class'=>'tt2'));
  $R .= " ";
  $R .= link_to('<span>Genera pdf per imprimir etiquetes</span>'.image_tag('template/printer.png',array('alt'=>'Genera PDF amb etiquetes.')),'gestio/gLlistes?accio=P&IDL='.$IDL,array('class'=>'tt2'));
  
  return $R;
}

function creaOpcionsM($IDM)
{      
	
  $R = link_to('<input type="button" value="Edita missatge">','gestio/gLlistes?accio=EM&IDM='.$IDM,array('class'=>'tt2'));    
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

function getMissatgesEnviatsLlistes($M)
{
	$RET = "";
	
	foreach($M->getMissatgesllistess() as $L):						
		$RET .= $L->getLlistes()->getNom().'<br />';
	endforeach;
	
	return $RET;
	
}

?>
