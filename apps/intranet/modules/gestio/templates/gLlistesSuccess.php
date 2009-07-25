    <TD colspan="3" class="CONTINGUT">
    
      <?php echo nice_form_tag('gestio/gLlistes',array('method'=>'post')); ?>
          
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL"> <?php echo link_to(image_tag('tango/32x32/actions/document-new.png', array('size'=>'16x16','alt'=>'Nova llista')),'gestio/gLlistes'.getPar($IDL,'N')); ?> Llistes disponibles</DIV>
                <TABLE class="DADES">
                <?php                 
                  if( sizeof($LLISTES) == 0 ) echo '<TR><TD class="LINIA" colspan="5">No hi ha cap llista disponible.</TD></TR>';
                                    
                  foreach($LLISTES as $L):                  
                      echo '<TR><TD class="LINIA">'.link_to($L->getNom(),'gestio/gLlistes?accio=E&IDL='.$L->getIdllistes()).'</TD>
                                <TD class="OPCIONS">'.creaOpcions($L->getIdllistes()).'</TD>
                            </TR>';                                   
                  endforeach;                                  
                  
                ?>
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>

  <?php IF( $NOU || $EDICIO ): ?>
      
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Dades llista</DIV>
                <?php echo input_hidden_tag('accio','S'); ?>
                <?php echo input_hidden_tag('NOU',$NOU); ?>                
                <?php if($EDICIO) echo input_hidden_tag('IDL',$LLISTA->getIdllistes()); ?>
                <TABLE class="DADES">
                  <TR><TD class="ERRORS" colspan="2"><?php echo implode("<br />",$ERRORS); ?></TD>
                  <TR><TD class="LINIA"> NOM </TD><TD> <?php echo input_tag('NOM',$LLISTA->getNom()); ?> </TD>                  
                  <TR><TD class="LINIA">  </TD><TD> <?php echo submit_tag('Envia'); ?> </TD>                                    
                </TABLE>                                          
              </TD>
        </TR>
      </TABLE>


  <?php ELSEIF( $USUARIS ): ?>

      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                                                              
                <DIV class="TITOL">Filtra usuaris </DIV>                
                <DIV class="CERCA">
                   <?=input_tag('CERCA',$CERCA, array('size'=>'50%'))?>
                   <?=select_tag('CERCA_TIPUS',options_for_select(array('llista'=>'Usuaris pertanyents a la llista','nollista'=>'Usuaris no pertanyents a la llista'),$CERCA_TIPUS))?>
                   <?=submit_tag('Filtra',array('name'=>'BCERCA'))?></DIV>                                                                 
              </TD>
        </TR>
      </TABLE>

	<?=input_hidden_tag('IDL',$IDL) ?>
    
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Usuaris a la llista (<?=$USUARIS_LLISTA->getNbResults()?>)</DIV>                                               
                <TABLE class="DADES">                 
                  <?php foreach($USUARIS_LLISTA->getResults() as $U): ?>                                                       
                  	<TR>
                  		<TD width="10%" class="LINIA"><?=checkbox_tag('BAIXA_USUARI[]',$U->getUsuariid())?></TD>
                  		<TD width="15%" class="LINIA"><?=$U->getDni()?></TD>
                  		<TD width="75%" class="LINIA"><?=$U->getNomComplet()?></TD>                  		
                  	</TR>
                  <?php endforeach; ?>
                	<TR><TD><?=gestorPaginesUsuarisLlista( $CERCA , $USUARIS_LLISTA  , $CERCA_TIPUS , $IDL , $PAGINA2)?></TD><TD></TD><TD><?=submit_tag('DESVINCULA',array('name'=>'BDESVINCULA'))?></TD></TR>                   	
                 </TABLE>                                                                                             
              </TD>
        </TR>
      </TABLE>      

      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Usuaris disponibles (<?=$USUARIS_DISPONIBLES->getNbResults()?>)</DIV>                                               
                <TABLE class="DADES">
                  <?php foreach($USUARIS_DISPONIBLES->getResults() as $U):   // $U = new Usuaris(); ?>                                                       
                  	<TR>
                  		<TD width="10%" class="LINIA"><?=checkbox_tag('ALTA_USUARI[]',$U->getUsuariid())?></TD>
                  		<TD width="15%" class="LINIA"><?=$U->getDni()?></TD>
                  		<TD width="75%" class="LINIA"><?=$U->getNomComplet()?></TD>                  		
                  	</TR>
                  <?php endforeach; ?>    
	                <TR><TD><?=gestorPaginesUsuarisNoLlista( $CERCA , $USUARIS_DISPONIBLES , $CERCA_TIPUS , $IDL , $PAGINA )?></TD><TD></TD><TD><?=submit_tag('VINCULA',array('name'=>'BVINCULA'))?></TD></TR>                                 	
                 </TABLE>                                                                                             
              </TD>
        </TR>
      </TABLE>
      
  <?php ELSEIF( $MISSATGES ): ?>
    
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Escriu un missatge <?=LlistesPeer::retrieveByPK($IDL)->getNom() ?></DIV>
                <?php echo input_hidden_tag('accio','SM'); ?>
                <?php echo input_hidden_tag('IDL',$IDL); ?>                
                <?php echo input_hidden_tag('IDM',$MISSATGE->getIdmissatgesllistes()); ?>                
                <TABLE class="DADES">
                  <TR><TD class="ERRORS" colspan="2"><?php echo implode("<br />",$ERRORS); ?></TD>                  
                  <TR><TD class="LINIA"> Titol </TD><TD> <?php echo input_tag('TITOL',$MISSATGE->getTitol()); ?></TD>
                  <TR><TD class="LINIA"> Escriu </TD><TD> <?php echo textarea_tag('TEXT',$MISSATGE->getText(),array('rich'=>true,'size'=>'70x30')); ?></TD>
<!--              <TR><TD class="LINIA"> Antics </TD><TD class="LINIA"><?php // echo generaLlistaMails( $LLISTA_MISSATGES , $IDL ); ?> </TD> -->                  
                  <TR><TD class="LINIA">  </TD><TD> <?php echo submit_tag('Guarda el mailing',array('name'=>'BSAVE')); ?> </TD>
                  <TR><TD class="LINIA">  </TD><TD> <?php echo submit_tag('Envia el mail',array('name'=>'BSEND')); ?> </TD>                                    
                </TABLE>                                          
              </TD>
        </TR>
      </TABLE>      

  <?php ELSEIF( $ENVIAT ): ?>
    
      <TABLE class="BOX"><TR><TD class="NOTICIA">MISSATGE ENVIAT A <?=$MAILS?> PERSONES.</TD></TR></TABLE>      

  <?php ELSEIF( $LLISTAT ): ?>
    
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Llistat de missatges de la llista:  <?php echo $LLISTA->getNom(); ?></DIV>
                <?php echo input_hidden_tag('accio','SM'); ?>
                <?php echo input_hidden_tag('IDL',$LLISTA->getIdllistes()); ?>                                               
                <TABLE class="DADES">
                	<TR><TD class="TITOL">Missatge</TD><TD class="TITOL">Data enviament</TD></TR>
                  <?php foreach($LMISSATGES as $M): ?>                                                       
                  	<TR>
                  		<TD class="LINIA"><?=link_to($M->getTitol(),'gestio/gLlistes?accio=MV&IDM='.$M->getIdmissatgesllistes().'&IDL='.$LLISTA->getIdllistes())?></TD>
						<TD class="LINIA"><?=$M->getEnviat('d/m/Y')?></TD>
              		</TR>
                  <?php endforeach; ?>
                   	
                 </TABLE>                                                                                             
              </TD>
        </TR>
      </TABLE>      
  
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

function getParPaginacio($ACCIO,$CERCA,$TIPUS_CERCA,$PAGINA , $PAGINA2 ,$IDL)
{
    $A = "";        
    if(!empty($ACCIO)) $A[] = 'accio='.$ACCIO;
    if(!empty($CERCA)) $A[] = 'CERCA='.$CERCA;
    if(!empty($PAGINA)) $A[] = 'PAGINA='.$PAGINA;
    if(!empty($PAGINA2)) $A[] = 'PAGINA2='.$PAGINA2;
    if(!empty($TIPUS_CERCA)) $A[] = 'TIPUS_CERCA='.$TIPUS_CERCA;
    if(!empty($IDL)) $A[] = 'IDL='.$IDL;
    
    if(!empty($A)) return '?'.implode('&',$A); 
    else return '';
    
}

function gestorPaginesUsuarisLlista( $CERCA , $USUARIS , $TIPUS_CERCA , $IDL , $PAGINA2 )
{
   if($USUARIS->haveToPaginate())
   {       
      echo link_to(image_tag('tango/16x16/actions/go-previous.png'), "gestio/gLlistes".getParPaginacio('U',$CERCA,$TIPUS_CERCA,$USUARIS->getPreviousPage(),$PAGINA2,$IDL));
	  echo " ";
	  echo link_to(image_tag('tango/16x16/actions/go-next.png'), "gestio/gLlistes".getParPaginacio('U',$CERCA,$TIPUS_CERCA,$USUARIS->getNextPage(),$PAGINA2,$IDL));
   }
}

function gestorPaginesUsuarisNoLlista( $CERCA , $USUARIS , $TIPUS_CERCA , $IDL , $PAGINA )
{
   if($USUARIS->haveToPaginate())
   {       
      echo link_to(image_tag('tango/16x16/actions/go-previous.png'), "gestio/gLlistes".getParPaginacio('U',$CERCA,$TIPUS_CERCA,$PAGINA,$USUARIS->getPreviousPage(),$IDL));
	  echo " ";
	  echo link_to(image_tag('tango/16x16/actions/go-next.png'), "gestio/gLlistes".getParPaginacio('U',$CERCA,$TIPUS_CERCA,$PAGINA,$USUARIS->getNextPage(),$IDL));
   }
}


?>
