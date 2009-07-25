<TD colspan="3" class="CONTINGUT">
    
      <?php echo nice_form_tag('gestio/gPromocions',array('method'=>'post','multipart'=>true)); ?>
          
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">
		        <DIV class="TITOL"> <?php echo link_to(image_tag('tango/32x32/actions/document-new.png', array('size'=>'16x16','alt'=>'Nova llista')),'gestio/gPromocions?accio=N'); ?> Llistat de promocions</DIV>                
                <TABLE class="DADES">
                <?php                                                   
                  foreach($PROMOCIONS as $P):                                                         
                      echo '<TR><TD class="LINIA">'.$P->getNom().'</TD>
                                <TD class="OPCIONS">'.creaOpcions($P->getPromocioid()).'</TD>
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
                <DIV class="TITOL">Dades promocio</DIV>                
                <?php echo input_hidden_tag('idP',$PROMOCIO->getPromocioid()); ?>
                <?php echo input_hidden_tag('NOU',$NOU); ?>
                <TABLE class="DADES">
                  <TR><TD class="ERRORS" colspan="2"><?php if(isset($ERRORS)) echo implode("<br />",$ERRORS); ?></TD>
                  <TR><TD class="LINIA"> Nom </TD><TD><?php echo input_tag('NOM',$PROMOCIO->getNom()); ?></TD>
                  <TR><TD class="LINIA"> Enllaç </TD><TD> <?php echo input_tag('URL',$PROMOCIO->getUrl()); ?> </TD>
                  <TR><TD class="LINIA"> Imatge </TD>
                      <TD>
                          <?php if($EDICIO) echo image_tag('banners/'.$PROMOCIO->getExtensio(), array('size'=>'175x70','alt'=>'Imatge promoció')); ?>
                          <?php echo '<BR>'.input_file_tag('ARXIU'); ?>
                      </TD>
                  <TR><TD class="LINIA"> Està activa? </TD><TD> <?php echo select_tag('ISACTIVA',options_for_select(array(true=>'Sí',false=>'No'),$PROMOCIO->getIsactiva())); ?> </TD>                
                  <TR><TD class="LINIA"> Sempre visible? </TD><TD> <?php echo select_tag('ISFIXA',options_for_select(array(true=>'Sí',false=>'No'),$PROMOCIO->getIsfixa())); ?> </TD>				  
                  <TR><TD class="LINIA">  </TD><TD> <?php echo submit_tag('Guarda',array('name'=>'SavePromocio')); ?> </TD>                  
                  
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

function creaOpcions($IDP)
{      
  $R   = link_to(image_tag('tango/32x32/actions/edit-find-replace.png', array('size'=>'16x16','alt'=>'Edita promoció')),"gestio/gPromocions?idP=$IDP&accio=E");
  $R  .= link_to(image_tag('tango/32x32/actions/go-top.png', array('size'=>'16x16','alt'=>'Pujar posició')),"gestio/gPromocions?idP=$IDP&accio=P");
  $R  .= link_to(image_tag('tango/32x32/actions/go-bottom.png', array('size'=>'16x16','alt'=>'Baixa posició')),"gestio/gPromocions?idP=$IDP&accio=B");
  $R  .= link_to(image_tag('tango/32x32/places/user-trash.png', array('size'=>'16x16','alt'=>'Baixa posició')),"gestio/gPromocions?idP=$IDP&accio=D");
  return $R;
}

function fletxeta()
{
  return image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE'));
}


function getPar($cerca = NULL, $pagina = NULL, $idU = NULL, $accio = NULL)
{
    $A = "";
    if(!is_null($cerca)) $A[] = 'CERCA='.$cerca;
    if(!is_null($pagina)) $A[] = 'PAGINA='.$pagina;
    if(!is_null($idU)) $A[] = 'idU='.$idU;
    if(!is_null($accio)) $A[] = 'accio='.$accio;
    if(!empty($A)) return '?'.implode('&',$A); 
    else return '';
    
}


  function mostraPaginacio($PAGER_USUARIS,$CERCA)
  {
    $RET = "";
    if ($PAGER_USUARIS->haveToPaginate()):
      $RET  = link_to('&laquo;', 'gestio/gUsuaris'.getPar($CERCA,$PAGER_USUARIS->getFirstPage()));
      $RET .= link_to('&lt;', 'gestio/gUsuaris'.getPar($CERCA,$PAGER_USUARIS->getPreviousPage())); 
      $links = $PAGER_USUARIS->getLinks(); foreach ($links as $page):
        $RET .= ($page == $PAGER_USUARIS->getPage()) ? $page : link_to($page, 'gestio/gUsuaris'.getPar($CERCA,$page));
        if ($page != $PAGER_USUARIS->getCurrentMaxLink()): endif;
      endforeach;
      $RET .= link_to('&gt;', 'gestio/gUsuaris'.getPar($CERCA,$PAGER_USUARIS->getNextPage()));
      $RET .= link_to('&raquo;', 'gestio/gUsuaris'.getPar($CERCA,$PAGER_USUARIS->getLastPage()));
    endif;
    
    
    return $RET;
  }



?>
