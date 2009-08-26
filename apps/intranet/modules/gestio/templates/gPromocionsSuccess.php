<?php use_helper('Form')?>

<TD colspan="3" class="CONTINGUT">
    
            
     <form action="<?php echo url_for('gestio/gPromocions') ?>" method="post" enctype="multipart/form-data">
	    <DIV class="REQUADRE">
	    <DIV class="TITOL"><?=link_to(image_tag('tango/32x32/actions/document-new.png', array('size'=>'16x16','alt'=>'Nou node')),'gestio/gPromocions?accio=N') ?> Llistat de promocions</DIV>
	    	<table class="DADES">          
                <?php                                                   
                  foreach($PROMOCIONS as $P):                  	                                         
                      echo '<TR><td width="100px">'.link_to(image_tag('/images/banners/'.$P->getExtensio()),'gestio/gPromocions?IDP='.$P->getPromocioid().'&accio=E').'</TD></tr>';                      
                  endforeach;                                  
                  
                ?>  
	        </table>
	     </DIV>
     </form>                  

  <?php IF( $NOU || $EDICIO ): ?>
      
	<form action="<?php echo url_for('gestio/gPromocions') ?>" method="post" enctype="multipart/form-data">            
	 	<DIV class="REQUADRE">
	    	<table class="FORMULARI" width="500px">
                <?=$FPromocio?>                								
                <tr>
                	<td width="50px"></td>               	
	            	<td class="dreta" width="400px">
	            		<br>
	            		<?=submit_image_tag('icons/Colored/PNG/action_check.png',array('name'=>'BSAVE'))?>
	            		<?=link_to(image_tag('icons/Colored/PNG/action_delete.png'),'gestio/gPromocions',array('confirm'=>'Segur que vols esborrar-lo?'))?>
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
     </form>    
      
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
