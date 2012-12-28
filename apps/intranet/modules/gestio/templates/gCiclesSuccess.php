<?php use_helper('Form'); ?>
<?php $BASE = ''; ?>

<script>

    $(document).ready(function(){
        $('#cerca_select').change(function(){
            $('#CERCA').submit();    
        });    
    });
    
    /** Aquesta funció genera un botó d'upload **/
    function genUpload( ELEMENT , TIPUS , TEXT , ACTIVITAT ){
            
        var uploader = new qq.FileUploader({
            element: document.getElementById( ELEMENT ),
            uploadButtonText: TEXT,
            action: '<?php echo url_for('gestio/Upload') ?>',
            debug: false,
            onSubmit: function(){ uploader.setParams({ IDA: ACTIVITAT , TIPUS: TIPUS , OPCIO: 'CICLE' }); },                        
        });
        
    }
        
</script>

<style>
.cent { width:100%; }
.noranta { width:90%; }
.cinquanta { width:50%; }
.gray { background-color: #EEEEEE; }
.NOM { width:20%; } 

	.row { width:500px; } 
	.row_field { width:80%; } 
	.row_title { width:20%; }
	.row_field input { width:100%; }     


</style>
   
    <td colspan="3" class="CONTINGUT_ADMIN">
      
    <?php include_partial('breadcumb',array('text'=>'CICLES')); ?>                      

	<form id="CERCA" action="<?php echo url_for('gestio/gCicles') ?>" method="POST">        
	    <div class="REQUADRE">
            <div class="FORMULARI fb">
                <div style="margin-bottom:4px;">	    	          
	               <?php echo $FCerca ?>       
                   <div style="clear:both;"></div>    
                </div>                     
	            <div>	            	
	            		<input type="submit" name="BCERCA" value="Prem per buscar" />
	            		<input type="submit" name="BNOU" value="Nou cicle" />	            	
	            </div>
                <div style="clear:both;"></div>                
	        </div>            
            <div style="clear:both;"></div>
	     </div>
     </form>  


  	<?php if( isset($MODE['NOU']) || isset($MODE['EDICIO']) ): ?>
      
	<form action="<?php echo url_for('gestio/gCicles') ?>" method="POST" enctype="multipart/form-data">
	
	 	<div class="REQUADRE fb">
	 	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gCicles?accio=C')) ?>
					 	 		
	 		<div class="FORMULARI fb">
	 			<?php echo $FCICLES ?>
                <?php include_partial('uploads',array('DIRECTORI_WEB' => '/images/cicles/' , 'NOM_ARXIU' => 'C-'.$FCICLES->getObject()->getCicleid())); ?>                 
                
	 			<?php include_partial('botoneraDiv',array('element'=>'TOTA la descripció')); ?>	 					
	 		</div>
	 			 	 	
      	</div>
			
	</form>      
      
  <?php elseif(isset($LACTIVITATS)): ?>

  	<div class="REQUADRE">
  	<div class="TITOL">Llistat d'activitats del cicle <?php $FCICLES->getObject()->getNom() ?></div>
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
           
  <?php else: ?>
  
  	<div class="REQUADRE">
  	<div class="TITOL">Llistat de cicles (<a href="<?php echo url_for('gestio/gCicles?accio=NOU'); ?>">Afegir nou cicle</a>)</div>
  		<table class="DADES">
            <?php if($CICLES->getNbResults() == 0): ?>
                <tr><td colspan="3">No s'ha trobat cap resultat.</td></tr>
            <?php else: ?>                
                <tr><th>Títol</th><th># Act</th><th>Data</th><th>Accions</th></tr>
               	<?php foreach($CICLES->getResults() as $C): ?>
           	        <?php $NACT = $C->getNumActivitats(); $idC = $C->getCicleid(); ?>
              		<tr>                      				
                        <td class="LINIA"> <?php echo link_to(image_tag('intranet/Submenu2.png').' '.$C->getNom(),'gestio/gCicles?accio=EDITA&IDC='.$idC ); ?> <?php echo link_to('(canvi estat)','gestio/gCicles?accio=ACTIVACIO&IDC='.$idC,array('style'=>'font-size:8px; color:green;')) ?> </td>                        
                        <td class="LINIA"><?php echo $NACT ?></td>
    				    <td class="LINIA"><?php echo $C->getPrimerDia() ?></td>									
                        <?php if($NACT > 0): ?>                        
                            <td class="LINIA">                                
                                <?php echo link_to(image_tag('template/text_list_bullets.png').'<span>Llista les activitats del cicle</span>','gestio/gCicles?accio=LLISTA&IDC='.$idC,array('class'=>'tt2')) ?> &nbsp;
                                <?php $OA = $C->getPrimeraActivitat(); ?>
                                <?php if($OA instanceof Activitats): ?>                                                        
                                    <?php echo link_to(image_tag('template/pencil.png').'<span>Edita les activitats del cicle</span>','gestio/gActivitats?accio=ACTIVITAT_NO_EDIT&IDA='.$OA->getActivitatid(),array('class'=>'tt2')) ?>
                                <?php endif; ?> 
                            </td>                                         
                        <?php else: ?>
                            <td class="LINIA"></td>
                        <?php endif; ?>
                                        
                    </tr>                      		                                
            <?php endforeach; ?>
            <tr><td colspan="5" style="text-align:center">
                 
            <?php if ($CICLES->haveToPaginate()): ?>
              <?php echo link_to('&laquo;', 'gestio/gCicles?PAGINA='.$CICLES->getFirstPage()) ?>
              <?php echo link_to('&lt;', 'gestio/gCicles?PAGINA='.$CICLES->getPreviousPage()) ?>
              <?php $links = $CICLES->getLinks(); foreach ($links as $page): ?>
                <?php echo ($page == $CICLES->getPage()) ? $page : link_to($page, 'gestio/gCicles?PAGINA='.$page) ?>
                <?php if ($page != $CICLES->getCurrentMaxLink()): ?> - <?php endif ?>
              <?php endforeach ?>
              <?php echo link_to('&gt;', 'gestio/gCicles?PAGINA='.$CICLES->getNextPage()) ?>
              <?php echo link_to('&raquo;', 'gestio/gCicles?PAGINA='.$CICLES->getLastPage()) ?>
            <?php endif; ?>        	
            
            </td></tr>
        <?php endif; ?>
  		</table>
  	</div>
  	  
  <?php endif; ?>
  
      <div style="height:40px;"></div>
                
    </td>    