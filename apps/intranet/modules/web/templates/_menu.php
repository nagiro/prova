<script type="text/javascript">

function showElement(theClass) {

	//Create Array of All HTML Tags
	var allHTMLTags=document.getElementsByName(theClass);

	//Loop through all tags using a for loop
	for (i=0; i<allHTMLTags.length; i++) { 
		if(allHTMLTags[i].style.display=="none"){ allHTMLTags[i].style.display="block";	} else { allHTMLTags[i].style.display="none"; }
	}

	return false;
}
	

</script>

<?php if($TIPUS_MENU == 'WEB' || $TIPUS_MENU == 'ADMIN'): ?>
		<TD class="MENU"><center>
		<div id="ESPAI"></div>      

        <?=llistaMenu($MENU,$OBERT,$SELECCIONAT)?>
        
<?php    if($TIPUS_MENU == 'ADMIN'): ?>	  	   	  	   		     
		  	   <TR><TD class="SUBMENU1"><?=link_to(image_tag('intranet/Submenu1.png', array('align'=>'ABSMIDDLE')).' Zona privada' , 'web/index', array( 'anchor' => true ))?></TD></TR>
		  	   <TR><TD>
		  	   		<TABLE>
		  	   			<TR><TD class="SUBMENU2"><?=link_to(image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE')).' Gestiona dades' , 'web/gestio?accio=gd')?></TD></TR>
				    	<TR><TD class="SUBMENU2"><?=link_to(image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE')).' Gestiona cursos' , 'web/gestio?accio=gc')?></TD></TR>
		  	   	    	<TR><TD class="SUBMENU2"><?=link_to(image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE')).' Gestiona reserves' , 'web/gestio?accio=gr')?></TD></TR>
		  	   	    	<TR><TD class="SUBMENU2"><?=link_to(image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE')).' Gestiona llistes' , 'web/gestio?accio=gl')?></TD></TR>
		  	   	  	</TABLE>
		  	   	</TD></TR>
		  	    <TR><TD id="REGISTRAT"><?=link_to("TANCA SESSIÓ" , 'web/logout')?></TD></TR>		  	   	
		  	  </TABLE>			
	  	   
<?php	   else: ?>
			
			<TR><TD id="REGISTRAT"><?=link_to("ZONA USUARIS" , 'web/login')?></TD></TR></TABLE>				

<?php	   endif; ?>

		</center></TD>
		
<?php	endif;
  

  function llistaMenu($Menu, $OBERT = 0 , $SELECCIONAT = 0)
  {
  	
  	foreach($Menu as $M):
  		if($M->getNivell() == 1) { 
  			$RET[$M->getIdnodes()]['TITOL'] = $M->getTitolmenu(); 
  			$RET[$M->getIdnodes()]['NODE'] = $M->getIdnodes();
  			$RET[$M->getIdnodes()]['NIVELL2'] = array();  			 
  			$PrimerNivell = $M->getIdnodes(); }
  		else { 
  			$RET[$PrimerNivell]['NIVELL2'][$M->getIdnodes()]['NODE'] = $M->getIdnodes(); 
  			$RET[$PrimerNivell]['NIVELL2'][$M->getIdnodes()]['TITOL'] = $M->getTitolmenu();  			
  		}
  	endforeach; 	  	 	
  	
  	echo '<TABLE class="MENU_TABLE">';
  	foreach($RET as $M1 => $D):
  		echo '<TR><TD class="SUBMENU1">'.link_to(image_tag('intranet/Submenu1T.png').' '.$D['TITOL'] , 'web/index' , array('onClick'=> 'javascript:showElement(\'Menu'.$M1.'\'); return false;','anchor'=>true));
  		foreach($D['NIVELL2'] as $M2 => $D2):  			
  			$style = ($OBERT == $M1)?'style="display:block"':'style="display:none"';
  			echo '<TR><TD class="SUBMENU2" name="Menu'.$M1.'" '.$style.'>'.link_to(image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE')).' '.$D2['TITOL'], 'web/index?accio=cp&node='.$M2.'&obert='.$M1).'</TD></TR>';  			
  		endforeach;
  		echo '</td></tr>';
  	endforeach;  	
  	
    		
  }


?>
