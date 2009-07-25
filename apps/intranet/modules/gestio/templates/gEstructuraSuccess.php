<TD colspan="3" class="CONTINGUT">
    
      <?php echo nice_form_tag('gestio/gEstructura',array('method'=>'post')); ?>
         
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL"><?=link_to(image_tag('tango/32x32/actions/document-new.png', array('size'=>'16x16','alt'=>'Nou node')),'gestio/gEstructura?accio=N') ?> Estructura</DIV>
                <TABLE class="DADES">
                                
                  <?php echo llistaNodes($NODES); ?>                       
                                  
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>

  <?php IF( $NOU || $EDICIO ): ?>
      
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Dades del Node</DIV>                
                <?php echo input_hidden_tag('idN',$NODE->getIdnodes()); ?>
                <?php echo input_hidden_tag('NOU',$NOU); ?>
                <TABLE class="DADES">
                  <TR><TD class="ERRORS" colspan="2"><?php echo implode("<br />",$ERRORS); ?></TD>
                  <TR><TD class="LINIA"> Títol menú </TD><TD><?php echo input_tag('TITOLMENU',$NODE->getTitolmenu()); ?></TD>
                  <TR><TD class="LINIA"> Ordre </TD><TD> <?php echo select_tag('ORDRE', options_for_select(NodesPeer::selectOrdre($NOU),$NODE->getOrdre())); ?> </TD>
                  <TR><TD class="LINIA"> Nivell </TD><TD> <?php echo select_tag('NIVELL', options_for_select(array(1=>1,2=>2),$NODE->getNivell())); ?> </TD>                  
                  <TR><TD class="LINIA"> Té contingut HTML? </TD><TD> <?php echo checkbox_tag('ISCATEGORIA',true,$NODE->getIscategoria()); ?> </TD>
                  <TR><TD class="LINIA"> Té contingut dinàmic? </TD><TD> <?php echo checkbox_tag('ISPHP',true,$NODE->getIsphp()); ?> </TD>
                  <TR><TD class="LINIA"> Està actiu? </TD><TD> <?php echo checkbox_tag('ISACTIVA',true,$NODE->getIsactiva()); ?> </TD>                                    
                  <TR><TD class="LINIA">  </TD><TD> <?php echo submit_tag('Guarda',array('name'=>'SaveNode')); ?> </TD>                                    
                </TABLE>                                          
              </TD>
        </TR>
      </TABLE>

  <?php ELSEIF($HTML): ?>
  
        <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">HTML - <?php echo $NODE->getTitolmenu(); ?></DIV>
                <DIV class="TEXT">
                  <?php echo input_hidden_tag('idN',$NODE->getIdnodes());
                        if($NODE->getIsphp())
                           echo input_tag('HTML',$NODE->getHTML(),array('width'=>'100%'));                         
                        else echo textarea_tag('HTML',$NODE->getHTML(),array('rich'=>true,'size'=>'100x50')); ?>
                  <BR />
                  <?php echo submit_tag('Actualitza',array('name'=>'SaveHTML')); ?>
                
                </DIV>                                                     
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

function creaOpcions($IDN)
{      
  $R  = link_to(image_tag('tango/32x32/actions/edit-find-replace.png', array('size'=>'16x16','alt'=>'Edita o visualitza les dades')),'gestio/gEstructura?idN='.$IDN.'&accio=E');
  $R .= link_to(image_tag('tango/32x32/apps/internet-web-browser.png', array('size'=>'16x16','alt'=>'Edita o visualitza les dades')),'gestio/gEstructura?idN='.$IDN.'&accio=H');
  $R .= link_to(image_tag('tango/32x32/places/user-trash.png', array('size'=>'16x16','alt'=>'Edita o visualitza les dades')),'gestio/gEstructura?idN='.$IDN.'&accio=D',array('confirm'=>'Segur que vols esborrar el node?'));

  return $R;
}

function llistaNodes( $NODES )
{     
  
  foreach($NODES as $N):
    $Nivell = "";  
    if($N->getNivell() == 1) $imatge = image_tag('tango/32x32/status/folder-open.png', array('align'=>'ABSMIDDLE','size'=>'16x16','alt'=>'Edita o visualitza les dades'));
    else $imatge = image_tag('tango/32x32/actions/document-open.png', array('align'=>'ABSMIDDLE','size'=>'16x16','alt'=>'Edita o visualitza les dades'));
    for($i = $N->getNivell(); $i > 0; $i--) $Nivell .= "&nbsp;&nbsp;&nbsp;&nbsp;";     
    echo '<TR><TD class="LINIA">'.$N->getOrdre().'</TD><TD class="LINIA">'.$Nivell.$imatge.link_to('&nbsp;&nbsp;'.$N->getTitolmenu(),'gestio/gEstructura?idN='.$N->getIdnodes().'&accio=E').'</TD><TD class="OPCIONS">'.creaOpcions($N->getIdnodes()).'</TD></TR>';       
  endforeach;
  

}


?>
