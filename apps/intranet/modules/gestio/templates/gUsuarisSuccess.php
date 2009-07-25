    <TD colspan="3" class="CONTINGUT">
    
      <?php echo nice_form_tag('gestio/gUsuaris',array('method'=>'post')); ?>

      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                                                              
                <DIV class="TITOL">Cerca a usuaris </DIV>                
                <DIV class="CERCA"><?php echo input_tag('CERCA',$CERCA, array('size'=>'50%')).submit_tag('Cerca',array('name'=>'BCERCA')).' '.submit_tag('Nou usuari',array('name'=>'NOU')); ?></DIV>                                                                 
              </TD>
        </TR>
      </TABLE>

      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Llistat usuaris (<?=$PAGER_USUARIS->getNbResults()?>)</DIV>
                <TABLE class="DADES">
                <? if($PAGER_USUARIS->getNbResults() == 0): ?>
                  	<TR><TD class="LINIA" colspan="4">No s'ha trobat cap usuari.</TD></TR>
                <? else: ?>                
	                <? foreach($PAGER_USUARIS->getResults() as $U): ?>
	                 	<TR><TD class="LINIA"><?=link_to($U->getDni(),'gestio/gUsuaris'.getPar($CERCA,$PAGINA,$U->getusuariid(),'E'))?></TD>
	                        <TD class="LINIA"><?=$U->getNomComplet()?></TD>
	                        <TD class="LINIA"><?=$U->getTelefon()?></TD> 
	                        <TD class="OPCIONS"><?=creaOpcions($CERCA, $PAGINA, $U->getusuariid(), NULL)?></TD>
	                    </TR>                                   
	                <? endforeach; ?>                     
	                	<TR><TD><?=gestorPaginesUsuaris( $CERCA , $PAGER_USUARIS )?></TD></TR>
	            <? endif; ?>
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>

    
  <?php IF( $NOU || $EDICIO ): ?>
      
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Dades usuari</DIV>
                <?php echo input_hidden_tag('accio','S'); ?>
                <?php echo input_hidden_tag('IDU',$IDU); ?>
                <TABLE class="DADES">
                  <TR><TD class="ERRORS" colspan="2"><?php if(isset($ERRORS)) echo implode("<br />",$ERRORS); ?></TD>
                  <TR><TD class="LINIA"> Nivell </TD><TD><?php echo select_tag('NIVELL',options_for_select(NivellsPeer::getSelect()),$USUARI->getNivellsIdnivells()); ?></TD>
                  <TR><TD class="LINIA"> DNI </TD><TD> <?php echo input_tag('DNI',$USUARI->getDNI()); ?> </TD>
                  <TR><TD class="LINIA"> Contrasenya </TD><TD> <?php echo input_password_tag('PASSWD',$USUARI->getPasswd()); ?> </TD>
                  <TR><TD class="LINIA"> Nom </TD><TD> <?php echo input_tag('NOM',$USUARI->getNom()); ?> </TD>
                  <TR><TD class="LINIA"> Primer cognom </TD><TD> <?php echo input_tag('COG1',$USUARI->getCog1()); ?> </TD>
                  <TR><TD class="LINIA"> Segon cognom </TD><TD> <?php echo input_tag('COG2',$USUARI->getCog2()); ?> </TD>
                  <TR><TD class="LINIA"> Email </TD><TD> <?php echo input_tag('EMAIL',$USUARI->getEmail()); ?> </TD>
                  <TR><TD class="LINIA"> Adreça postal </TD><TD> <?php echo input_tag('ADRECA',$USUARI->getAdreca()); ?> </TD>
                  <TR><TD class="LINIA"> Codi postal </TD><TD> <?php echo input_tag('CODIPOSTAL',$USUARI->getCodiPostal()); ?> </TD>
                  <TR><TD class="LINIA"> Població </TD><TD> <?php echo select_tag('POBLACIO',options_for_select(PoblacionsPeer::select(),$USUARI->getPoblacio())); echo input_tag('POBLACIOT',$USUARI->getPoblaciotext()); ?>  </TD>                                   
                  <TR><TD class="LINIA"> Telèfon </TD><TD> <?php echo input_tag('TELEFON',$USUARI->getTelefon()); ?> </TD>
                  <TR><TD class="LINIA"> Mòbil </TD><TD> <?php echo input_tag('MOBIL',$USUARI->getMobil()); ?> </TD>
                  <TR><TD class="LINIA"> Entitat </TD><TD> <?php echo input_tag('ENTITAT',$USUARI->getEntitat()); ?> </TD>
                  <TR><TD class="LINIA">  </TD><TD> <?php echo submit_tag('Envia'); ?> </TD>                  
                  
                </TABLE>                                          
              </TD>
        </TR>
      </TABLE>
  
  <?php ELSEIF($LLISTES): ?>
  
        <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Llistes subscrites </DIV>
                <TABLE class="DADES">
                <?php
                                   
                  echo input_hidden_tag('D[IDU]',$USUARI->getUsuariid());
                  echo input_hidden_tag('CERCA',$CERCA);
                  echo input_hidden_tag('PAGINA',$PAGINA);                  
                  
                  if($USUARI->countUsuarisllistess() == 0) echo '<TR><TD class="LINIA" colspan="5">L\'Usuari no està subscrit a cap llista.</TD></TR>';                                    
                  foreach($USUARI->getUsuarisllistess() as $L):                  
                      echo '<TR>
                       			<TD width="10px" class="LINIA">'.checkbox_tag('D[IDL][]',$L->getLlistesIdllistes(),false).'<TD class="LINIA">'.$L->getLlistes()->getNom().'</TD>                                                           
                            </TR>';                                   
                  endforeach;                                  
                  echo '<TR><TD colspan="2">'.submit_tag('DESVINCULA',array('name'=>'BDESVINCULA')).'</TD></TR>';                  
                ?>
                </TABLE>                                                                          
            </TD>
        </TR>
      </TABLE>
      
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Llistes disponibles</DIV>
                <TABLE class="DADES">
                <?php
                                   
                  echo input_hidden_tag('D[IDU]',$USUARI->getUsuariid());
                  echo input_hidden_tag('CERCA',$CERCA);
                  echo input_hidden_tag('PAGINA',$PAGINA);                  
                  
                  if(empty($LLISTAT_LLISTES)) echo '<TR><TD class="LINIA" colspan="5">No s\'ha trobat cap llista disponible.</TD></TR>';                                    
                  foreach($LLISTAT_LLISTES as $IDL => $L):                  
                      echo '<TR>
                       			<TD width="10px" class="LINIA">'.checkbox_tag('D[IDL][]',$IDL,false).'<TD class="LINIA">'.$L.'</TD>                                                           
                            </TR>';                                   
                  endforeach;                                  
                  echo '<TR><TD colspan="2">'.submit_tag('VINCULA',array('name'=>'BVINCULA')).'</TD></TR>';                  
                ?>
                </TABLE>                                                                          
            </TD>
        </TR>
      </TABLE>
  
  
  <?php ELSEIF($CURSOS): ?>
  
        <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Llistat de matrícules (<?php echo link_to('Nova matricula','gestio/gMatricules?accio=N&IDU='.$USUARI->getUsuariid()); ?>)</DIV>
                <TABLE class="DADES">
                <?php                 
                  if($USUARI->countMatriculess() == 0) echo '<TR><TD class="LINIA" colspan="5">L\'Usuari no ha fet cap curs a la Casa de Cultura.</TD></TR>';                                    
                  foreach($USUARI->getMatriculess() as $M):
                      $CURSOS = $M->getCursos();                      
                      echo '<TR><TD class="LINIA">'.$CURSOS->getCodi().'</TD>
                                <TD class="LINIA">'.$CURSOS->getTitolCurs().'</TD>
                                <TD class="LINIA">'.$M->getEstat().'</TD>
                                <TD class="LINIA">'.$M->getDataInscripcio().'</TD>
                                <TD class="LINIA">'.$M->getDescompte().'</TD>
                                <TD class="LINIA">'.$M->getComentari().'</TD>                                                                                           
                            </TR>';                                   
                  endforeach;                                                    
                ?>
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>
  
  <?php ELSEIF($REGISTRES): ?>
  
        <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Llistat de registres</DIV>
                <TABLE class="DADES">
                <?php                  
                  if($USUARI->countReservaespaiss() == 0) echo '<TR><TD class="LINIA" colspan="5">L\'Usuari no ha fet cap reserva.</TD></TR>';                                    
                  foreach($USUARI->getReservaespaiss() as $R):                                            
                      echo "<TR><TD class=\"LINIA\">".link_to($R->getNom(),'gestio/gReserves?accio=E&IDR='.$R->getReservaespaiid())."</TD><TD class=\"LINIA\">".$R->getUsuaris()->getNomComplet()."</TD><TD class=\"LINIA\">".$R->getDataactivitat()."</TD><TD class=\"LINIA\">".$R->getEstatText()."<TD></TR>";
                  endforeach;                                  

                ?>
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>


  <? ENDIF; ?>
    
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

function creaOpcions($CERCA, $PAGINA, $IDU, $ACCIO)
{  
//  $R  = link_to(image_tag('tango/32x32/actions/edit-find-replace.png', array('size'=>'16x16','alt'=>'Edita o visualitza les dades')),'gestio/gUsuaris'.getPar($CERCA,$PAGINA,$IDU,'E'));  
//  $R .= link_to(image_tag('tango/32x32/actions/mail-forward.png', array('size'=>'16x16','alt'=>'Edita o visualitza les dades')),'gestio/gUsuaris'.getPar($CERCA,$PAGINA,$IDU,'L'));
//  $R .= link_to(image_tag('tango/32x32/categories/applications-accessories.png', array('size'=>'16x16','alt'=>'Edita o visualitza les dades')),'gestio/gUsuaris'.getPar($CERCA,$PAGINA,$IDU,'C'));  
//  $R .= link_to(image_tag('tango/32x32/categories/applications-accessories.png', array('size'=>'16x16','alt'=>'Edita o visualitza les dades')),'gestio/gUsuaris'.getPar($CERCA,$PAGINA,$IDU,'C'));
  
//  $R  = link_to('E','gestio/gUsuaris'.getPar($CERCA,$PAGINA,$IDU,'E')).' ';  
  $R  = link_to('L','gestio/gUsuaris'.getPar($CERCA,$PAGINA,$IDU,'L')).' ';
  $R .= link_to('C','gestio/gUsuaris'.getPar($CERCA,$PAGINA,$IDU,'C')).' ';  
  $R .= link_to('R','gestio/gUsuaris'.getPar($CERCA,$PAGINA,$IDU,'R')).' ';
   
  return $R;
}


function fletxeta()
{
  return image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE'));
}


function getPar($CERCA = "", $PAGINA = "", $IDU = "", $ACCIO = "")
{
   
    $A = "";
    if(!empty($CERCA)) $A[] = 'CERCA='.$CERCA;
    if(!empty($PAGINA)) $A[] = 'PAGINA='.$PAGINA;
    if(!empty($IDU)) $A[] = 'IDU='.$IDU;
    if(!empty($ACCIO)) $A[] = 'accio='.$ACCIO;
    if(!empty($A)) return '?'.implode('&',$A); 
    else return '';
    
}


function gestorPaginesUsuaris( $CERCA , $USUARIS )
{
   if($USUARIS->haveToPaginate())
   {       
      echo link_to(image_tag('tango/16x16/actions/go-previous.png'), "gestio/gUsuaris".getPar($CERCA,$USUARIS->getPreviousPage()));
	  echo " ";
	  echo link_to(image_tag('tango/16x16/actions/go-next.png'), "gestio/gUsuaris".getPar($CERCA,$USUARIS->getNextPage()));
   }
}


?>
