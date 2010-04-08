<TR>
	<?php 	  
		 
	   $i = 1;
		foreach($FOTOS as $F):		   
		   if((sizeof($FOTOS)) == $i):
              echo '<td class="FOTOS">'.image_tag('portada/IMG'.$F.'.jpg' , array('class'=>'IMG_FOTO')).'</TD>';
           elseif($i == 1):
              echo '<td class="FOTOS">'.image_tag('portada/IMG'.$F.'.jpg' , array('class'=>'IMG_FOTO')).'</TD>';
           else:
              echo '<td class="FOTOS">'.image_tag('portada/IMG'.$F.'.jpg' , array('class'=>'IMG_FOTO')).'</TD>';
		   endif;
			$i++;			
		endforeach;			
		
	?>
</TR>

<TR>
<!-- MENU -->
	
    <?php include_partial('menu', array( 'TIPUS_MENU' => $TIPUS_MENU , 'MENU' => $MENU , 'OBERT' => $OBERT , 'SELECCIONAT' => $SELECCIONAT , 'USUARI' => $USUARI) ); ?>

<!-- FI MENU -->
<!-- CONTINGUT -->

	<?php  
	$calendar = false;
	switch($ACCIO){
	   case 'web'        : $calendar = true;  include_partial('pagina'  ,  array( 'PAGINA' => $PAGINA )); break;
	   case 'gestio'     : $calendar = false; include_partial('gestio'  ,  array( 'MODUL' => $MODUL , 'FUSUARI' => $FUSUARI , 'MISSATGE' => $MISSATGE , 'LLISTES' => $LLISTES , 'FRESERVA' => $FRESERVA , 'RESERVES' => $RESERVES , 'MATRICULES' => $MATRICULES , 'CURSOS' => $CURSOS ) ); break;
	   case 'remember'   : $calendar = false; include_partial('remember',  array( 'ENVIAT' => $ENVIAT , 'ERROR' => $ERROR , 'FREMEMBER' => $FREMEMBER )); break;
	   case 'login'      : $calendar = false; include_partial('login'   ,  array( 'FLogin' => $FLogin , 'ERROR' => $ERROR )); break; 	      
//	   case 'agenda'     : $calendar = true;  include_partial('agenda'  ,  array( 'ACTIVITATS_LLISTAT' => $ACTIVITATS_LLISTAT , 'QUANTES' => $QUANTES , 'DATA' => $DATA )); break;
	   case 'noticies'   : $calendar = true;  include_partial('noticies',  array( 'NOTICIES' => $NOTICIES , 'NOTICIA' => $NOTICIA )); break;
	   case 'verifica'   : $calendar = false; include_partial('gestio'  ,  array( 'MODUL' => $MODUL , 'DADES_MATRICULA' => $DADES_MATRICULA , 'TPV' => $TPV )); break;
	   case 'registrat'  : $calendar = true;  include_partial('registrats'); break;
	   case 'cursos'	 : $calendar = false; include_partial('cursos'); break;
	   case 'contacte'   : $calendar = false; include_partial('contacte' , array('ENVIAT'=>$ENVIAT , 'FConsulta'=>$FConsulta)); break;
//	   case 'activitats' : $calendar = true;  include_partial('activitats' , array('ACTIVITATS_LLISTAT' => $ACTIVITATS_LLISTAT )); break;
	   case 'registre'   : $calendar = false; include_partial('registre' , array('FUSUARI'=>$FUSUARI, 'ESTAT' => $ESTAT)); break;
	   case 'espais'	 : $calendar = false;  include_partial('espais',array('')); break;
	   case 'missatge'   : $calendar = false; include_partial('missatge',array('MISSATGE'=>$MISSATGE)); break;
	   case 'llistat_activitats': $calendar = true; include_partial('llistatActivitats',array('LLISTAT_ACTIVITATS'=>$LLISTAT_ACTIVITATS,'TITOL'=>$TITOL,'MODE'=>$MODE)); break;
	   case 'showActivitatCategoria': $calendar = true; include_partial('showActivitatCategoria',array('DESCRIPCIO'=>$DESCRIPCIO,'TITOL'=>$TITOL)); break;	   	    
	}
	    	    
    ?>
    	
    
<!-- FI CONTINGUT -->
<!-- CALENDARI -->
    
    <?php

       if($calendar):
    
       include_partial('calendari', array( 	'BANNERS' => $BANNERS , 
    										'DATACALENDARI' => $DATACALENDARI , 
    										'ACTIVITATS_CALENDARI' => $ACTIVITATS_CALENDARI ,
    										'CERCA' => $CERCA ) ); 
       endif;
   
       ?>
    	
<!-- FI CALENDARI -->
</TR>