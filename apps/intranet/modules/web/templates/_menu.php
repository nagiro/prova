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

        <?php echo llistaMenu($MENU,$OBERT,$SELECCIONAT)?>
        
<?php    if($TIPUS_MENU == 'ADMIN'): ?>	  	   	  	   		     
		  	   <TR><TD class="SUBMENU_1"><?php echo link_to(image_tag('intranet/Submenu1.png', array('align'=>'ABSMIDDLE')).' Zona privada' , 'web/index', array( 'anchor' => true ))?></TD></TR>
		  	   <TR><TD>
		  	   		<TABLE>
		  	   			<TR><TD class="SUBMENU_2"><?php echo link_to(image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE')).' Gestiona dades' , 'web/gestio?accio=gd')?></TD></TR>
				    	<TR><TD class="SUBMENU_2"><?php echo link_to(image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE')).' Gestiona cursos' , 'web/gestio?accio=gc')?></TD></TR>
		  	   	    	<TR><TD class="SUBMENU_2"><?php echo link_to(image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE')).' Gestiona reserves' , 'web/gestio?accio=gr')?></TD></TR>
		  	   	    	<TR><TD class="SUBMENU_2"><?php echo link_to(image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE')).' Gestiona llistes' , 'web/gestio?accio=gl')?></TD></TR>
		  	   	    	<?php echo AltresApps($USUARI); ?>
		  	   	  	</TABLE>
		  	   	</TD></TR>
		  	    <TR><TD id="REGISTRAT"><?php echo link_to("TANCA SESSIÓ" , 'web/logout')?></TD></TR>		  	   	
		  	  </TABLE>			
	  	   
<?php	   else: ?>
			
			<TR><TD id="REGISTRAT"><?php echo link_to("ZONA USUARIS" , 'web/login')?></TD></TR></TABLE>				

<?php	   endif; ?>

		</center><br /><br /></TD>
		
<?php	endif;
  

  function llistaMenu($Menu, $OBERT = 0 , $SELECCIONAT = 0)
  {
  	  	
  	foreach($Menu as $M):
  		$RET[$M->getIdnodes()]['TITOL'] = $M->getTitolMenu();
  		$RET[$M->getIdnodes()]['NODE'] = $M->getIdnodes();
  		$RET[$M->getIdnodes()]['NIVELL'] = $M->getNivell();
  		$RET[$M->getIdnodes()]['URL'] = $M->getUrl();
  		  		  		  	
  	endforeach;

  	$Obert = array(1=>false,2=>false,3=>false); $NivellAnt = 0;
  	
  	echo '<TABLE class="MENU_TABLE">';
  	  	
  	foreach($RET as $N => $D):
  		  		
  		if($D['NIVELL'] == 1):  			   			
  			if(array_key_exists($D['NODE'],$OBERT)) $Obert['1'] = true;
  			else $Obert['1'] = false;
  			echo generaURL($D,$Obert['1']);
  		elseif($D['NIVELL'] == 2):
			if($Obert['1']) echo generaURL($D,$Obert['2']); 	  		
			if(array_key_exists($D['NODE'],$OBERT)) $Obert['2'] = true;
  			else $Obert['2'] = false;
  		elseif($D['NIVELL'] == 3):
			if($Obert['2'] && $Obert['1']) echo generaURL($D,$Obert['3']); 	  		
			if(array_key_exists($D['NODE'],$OBERT)) $Obert['3'] = true;
  			else $Obert['3'] = false;
  		endif;
  	endforeach;		  		  
    		
  }

  function generaURL( $NODE , $OBERT = false )
  {
  	$imatge = ($OBERT)?'':'T';
  	switch($NODE['NIVELL']){
  		case 1:
  			if(!empty($NODE['URL'])) return '<TR><TD class="SUBMENU_1">'.link_to(image_tag('intranet/Submenu1'.$imatge.'.png', array('align'=>'ABSMIDDLE')).' '.$NODE['TITOL'], $NODE['URL'],array('target'=>'_NEW','absolute'=>true)).'</TD></TR>';  
			else return '<TR><TD class="SUBMENU_1">'.link_to(image_tag('intranet/Submenu1'.$imatge.'.png', array('align'=>'ABSMIDDLE')).' '.$NODE['TITOL'], 'web/index?accio=cp&node='.$NODE['NODE']).'</TD></TR>';  			 
  			break;
  		case 2:
  			if(!empty($NODE['URL'])) return '<TR><TD class="SUBMENU_2">'.link_to(image_tag('intranet/Submenu3.png', array('align'=>'ABSMIDDLE')).' '.$NODE['TITOL'], $NODE['URL'],array('target'=>'_NEW','absolute'=>true)).'</TD></TR>'; 
  			else return '<TR><TD class="SUBMENU_2">'.link_to(image_tag('intranet/Submenu3.png', array('align'=>'ABSMIDDLE')).' '.$NODE['TITOL'], 'web/index?accio=cp&node='.$NODE['NODE']).'</TD></TR>';  			
  			break;
  		case 3:
  			if(!empty($NODE['URL'])) return '<TR><TD class="SUBMENU_3">'.link_to(image_tag('intranet/Submenu3.png', array('align'=>'ABSMIDDLE')).' '.$NODE['TITOL'], $NODE['URL'],array('target'=>'_NEW','absolute'=>true)).'</TD></TR>';  
  			else return '<TR><TD class="SUBMENU_3">'.link_to(image_tag('intranet/Submenu3.png', array('align'=>'ABSMIDDLE')).' '.$NODE['TITOL'], 'web/index?accio=cp&node='.$NODE['NODE']).'</TD></TR>';
  			break; 
  	}
  	  	
  }
  
  function AltresApps($USUARI)
  {  	
  	$PERMISOS = UsuarisAppsPeer::getPermisosOO($USUARI);
	echo "<TR><TD class=\"SUBMENU_2\">".image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE'))." Altres aplicacions</TD></TR>";  	 
  	foreach($PERMISOS as $APP):  		
  		echo "<TR><TD class=\"SUBMENU_3\">".link_to(image_tag('intranet/Submenu3.png', array('align'=>'ABSMIDDLE')).' '.$APP->getNom() , $APP->getUrl() )."</TD></TR>";
  	endforeach;  	
  }  

?>
