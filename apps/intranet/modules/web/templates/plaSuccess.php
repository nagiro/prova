<TR>
	<?php 	   
	   $i = 1;
		foreach($FOTOS as $F):		   
		   if((sizeof($FOTOS)) == $i):
              echo '<td class="FOTOS">'.image_tag('portada/IMG'.$F.'.jpg' , array('class'=>'IMG_FOTO','style'=>'padding-right:2px;')).'</TD>';
           elseif($i == 1):
              echo '<td class="FOTOS">'.image_tag('portada/IMG'.$F.'.jpg' , array('class'=>'IMG_FOTO','style'=>'padding-left:2px;')).'</TD>';
           else:
              echo '<td class="FOTOS">'.image_tag('portada/IMG'.$F.'.jpg' , array('class'=>'IMG_FOTO')).'</TD>';
		   endif;
			$i++;			
		endforeach;			
		
	?>
</TR>

<TR>
<!-- CONTINGUT -->

	<?php 

	switch($ACCIO){
	   case 'espais'	 : include_partial('espais',array('')); break;	   	    
	}
	    	    
    ?>
    	
    
<!-- FI CONTINGUT -->
</TR>