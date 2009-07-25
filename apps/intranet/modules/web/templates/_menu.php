<script type="text/javascript">

function showElement(layer){
	var myLayer = document.getElementById(layer);
	if(myLayer.style.display=="none"){
		myLayer.style.display="block";
//		myLayer.backgroundPosition="top";
	} else {
		myLayer.style.display="none";
}
	return false;
}
</script>

<?php if($TIPUS_MENU == 'WEB' || $TIPUS_MENU == 'ADMIN'): ?>
		<TD class="MENU"><center>
		<div id="ESPAI"></div>      

        <?=llistaMenu($MENU,$OBERT,$SELECCIONAT)?>
        
<?php    if($TIPUS_MENU == 'ADMIN'): ?>	  	   	  	   
		     <TABLE class="MENU_TABLE">
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
			
			<TABLE class="MENU_TABLE"><TR><TD id="REGISTRAT"><?=link_to("ZONA USUARIS" , 'web/login')?></TD></TR></TABLE>				

<?php	   endif; ?>

		</center></TD>
		
<?php	endif;
  

  function llistaMenu($Menu, $OBERT = 0 , $SELECCIONAT = 0)
  {
     $DinsNivell1 = false; $ultim1Nivell = 0; $style = ""; $titol = "";     
     foreach($Menu as $M){
        switch($M->getNivell()){
           case 1:              
              if($DinsNivell1): ?></TABLE></TD></TR></TABLE> <? endif;      //S'acaba el primer nivell, només si s'acaba. 
              $ultim1Nivell = $M->getIdnodes();                         //Agafem el nivell del node obert                            
              if($OBERT <> $M->getIdnodes()):                           //Si el que hem obert és aquest marquem style=block;
                 $style = 'style="display:none;"'; else: $style = 'style="display:block;"';
              endif;                  
                 ?>
                 	<TABLE class="MENU_TABLE">
                 	<TR><TD class="SUBMENU1"><?=link_to(image_tag('intranet/Submenu1T.png').' '.$M->getTitolmenu() , 'web/index' , array('onClick'=> 'javascript:showElement(\'Menu'.$M->getIdnodes().'\'); return false;','anchor'=>true))?></TD></TR>
                 	<TR><TD><TABLE class="MENU_TABLE" id="Menu<?=$M->getIdnodes()?>" <?=$style?>>                 			       				                 				              
              <?
                 break; 
           case 2:
              if($M->getIdnodes() == $SELECCIONAT) $titol = '<b>'.$M->getTitolmenu().'</b>'; else $titol = $M->getTitolmenu();                 
              echo '<TR><TD class="SUBMENU2">'.link_to(image_tag('intranet/Submenu2.png', array('align'=>'ABSMIDDLE')).' '.$titol, 'web/index?accio=cp&node='.$M->getIdnodes().'&obert='.$ultim1Nivell).'</TD></TR>';
              $DinsNivell1 = true;                
              break;
        }                   
     }
     ?></TABLE></TD></TR></TABLE><?     
  }

?>
