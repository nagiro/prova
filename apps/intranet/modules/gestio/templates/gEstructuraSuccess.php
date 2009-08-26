<?php use_helper('Form')?>

<TD colspan="3" class="CONTINGUT">
          

    <form action="<?php echo url_for('gestio/gEstructura') ?>" method="post">
	    <DIV class="REQUADRE">
	    <DIV class="TITOL"><?=link_to(image_tag('tango/32x32/actions/document-new.png', array('size'=>'16x16','alt'=>'Nou node')),'gestio/gEstructura?accio=N') ?> Estructura</DIV>
	    	<table class="DADES">          
                  <?php echo llistaNodes($NODES); ?>
	        </table>
	     </DIV>
     </form>                

  <?php IF( $NOU || $EDICIO ): ?>

	<form action="<?php echo url_for('gestio/gEstructura') ?>" method="POST">            
	 	<DIV class="REQUADRE">
	    	<table class="FORMULARI" width="500px">
                <?=$FNode?>                								
                <tr>
                	<td width="100px"></td>               	
	            	<td class="dreta" width="400px">
	            		<br>
	            		<?=submit_image_tag('icons/Colored/PNG/action_check.png',array('name'=>'BSAVE'))?>
	            		<?=link_to(image_tag('icons/Colored/PNG/action_delete.png'),'gestio/gEstructura',array('confirm'=>'Segur que vols esborrar-lo?'))?>
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
     </form>    

  <?php ELSEIF($HTML): ?>

	<form action="<?php echo url_for('gestio/gEstructura') ?>" method="post">
      <DIV class="REQUADRE">
        <DIV class="TITOL">HTML - <?php echo $NODE->getTitolmenu(); ?></DIV>
      	<TABLE class="DADES">
      	<tr><td>
 			<?php echo input_hidden_tag('idN',$NODE->getIdnodes());
            		if($NODE->getIsphp())
                  		echo input_tag('HTML',$NODE->getHTML(),array('width'=>'100%'));                         
                        else echo textarea_tag('HTML',$NODE->getHTML(),array('rich'=>true,'size'=>'100x50')); ?>
                  <BR />
                  <?php echo submit_tag('Actualitza',array('name'=>'SaveHTML')); ?>
        </td></tr>        
        </TABLE>      
      </DIV>
   </form>
   
  <?php ENDIF; ?>
  
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
    
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
	$text = $Nivell.$imatge.link_to('&nbsp;&nbsp;'.$N->getTitolmenu(),'gestio/gEstructura?idN='.$N->getIdnodes().'&accio=E');    
    if(!$N->getIsactiva()) $text = '<strike>'.$text.'</strike>';       
    echo '<TR><TD class="LINIA">'.$N->getOrdre().'</TD><TD class="LINIA">'.$text.'</TD><TD class="OPCIONS">'.creaOpcions($N->getIdnodes()).'</TD></TR>';       
  endforeach;
  

}


?>
