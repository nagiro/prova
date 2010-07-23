<?php use_helper('Form'); ?>

<STYLE>
.cent { width:100%; }
.noranta { width:90%; }
.cinquanta { width:50%; }
.gray { background-color: #EEEEEE; }
.NOM { width:20%; } 

	.row { width:500px; } 
	.row_field { width:80%; } 
	.row_title { width:20%; }
	.row_field input { width:100%; } 


</STYLE>
   
    <TD colspan="3" class="CONTINGUT">
      
    <?php include_partial('breadcumb',array('text'=>'CICLES')); ?>                      

  	<?php IF( isset($MODE['NOU']) || isset($MODE['EDICIO']) ): ?>
      
	<form action="<?php echo url_for('gestio/gCicles') ?>" method="POST" enctype="multipart/form-data">
	
	 	<div class="REQUADRE fb">
	 	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gCicles?accio=C')) ?>
					 	 		
	 		<div class="FORMULARI fb">
	 			<?php echo $FCICLES ?>
	 			<?php include_partial('botoneraDiv',array('element'=>'TOTA la descripció')); ?>	 					
	 		</div>
	 			 	 	
      	</div>
			
	</form>      
      
  <?php ELSEIF(isset($LACTIVITATS)): ?>

  	<DIV class="REQUADRE">
  	<DIV class="TITOL">Llistat d'activitats del cicle <?php $FCICLES->getObject()->getNom() ?></DIV>
  		<table class="DADES">
                <?php  
                    if( sizeof($LACTIVITATS) == 0 ) echo '<TR><TD colspan="3">No s\'ha trobat cap resultat.</TD></TR>';
                    else {                
                    	echo '<tr><th>Títol</th></tr>';
                      	foreach($LACTIVITATS as $id => $A) {                                                            		     	                          	
                      		echo "<TR>                      				                      		
                      				<TD class='LINIA'>".link_to(image_tag('intranet/Submenu2.png').' '.$A->getNom(),'gestio/gActivitats?accio=ACTIVITAT&IDA='.$A->getActivitatid() )."</TD>                      				
                      			  </TR>";                      		
                      	}                    	
                    }
                ?>
                
		</table>     			        
           
  <?php ELSE: ?>
  
  	<DIV class="REQUADRE">
  	<DIV class="TITOL">Llistat de cicles (<a href="<?php echo url_for('gestio/gCicles?accio=NOU'); ?>">Afegir nou cicle</a>)</DIV>
  		<table class="DADES">
                <?php  
                    if( sizeof($CICLES) == 0 ) echo '<TR><TD colspan="3">No s\'ha trobat cap resultat d\'entre '.CiclesPeer::doCount(new Criteria()).' disponibles.</TD></TR>';
                    else {                
                    	echo '<tr><th>Títol</th><th># Act</th><th>Data</th><th>Estat</th></tr>';
                      	foreach($CICLES as $id => $C) {                                                            		     	                          	
                      		echo "<TR>                      				
                      				<TD class='LINIA'>".link_to(image_tag('intranet/Submenu2.png').' '.$C['TITOL'],'gestio/gCicles?accio=EDITA&IDC='.$id )."</TD>
                      				<TD class='LINIA'>".$C['ACTIVITATS']."</TD>
                      				<TD class='LINIA'>".date('d/m/Y',$C['DIA'])."</TD>
									<TD class='LINIA'>".(($C['EXTINGIT'])?'Inactiu':'Actiu')."</TD>
                      				<TD class='LINIA'>".link_to(image_tag('template/text_list_bullets.png').'<span>Llistat d\'activitats pertanyents al cicle</span>','gestio/gCicles?accio=LLISTA&IDC='.$id,array('class'=>'tt2'))."</TD>
                      				
                      			  </TR>";                      		
                      	}                    	
                    }
                ?>     			
        <tr><td colspan="2" style="text-align:center">
         
        <?php
        	
        if($PAGINA > 1) echo link_to('<-- Veure cicles anteriors', 'gestio/gCicles?PAGINA='.($PAGINA-1));
  		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";  
  		echo link_to('Veure cicles següents -->', 'gestio/gCicles?PAGINA='.($PAGINA+1));  
	 
		?>
        
        </td></tr>
  		</table>
  	</DIV>
  	  
  <?php ENDIF; ?>
  
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
    