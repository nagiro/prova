<?php use_helper('Javascript')?> 	
 	
 	<script type="text/javascript">
	
	 $(document).ready(function() {				
		$('#APP_MENU').change(updatePage);
		$('#APP_PAGE').change(updateEntry);
		updatePage();
		updateEntry();
		$("#tabs").tabs();
		afegirArxiu();				
	 });

	function afegirArxiu()
	{
		var num = parseInt($('#comptador').val())+parseInt(1);
		$('#comptador').attr('value',num);
		$('#files').append('<br /><input type="file" name="arxiu[' + num + ']" /><input type="text" name="desc[' + num + ']" value="Entra una breu descripció..." />');		
		return false; 
	}
	
	function removeArxiu(id)
	{		
		$("#arxiu"+id).remove();
		return false; 		
	}
	 
	 function updatePage()
	 {
		 var MENU_ID = $('#APP_MENU option:selected').val();
		 
		 $.post(
				 '<?php echo url_for('gestio/gBlogs') ?>', 
				 { accio: "AJAX_MENU", APP_MENU: MENU_ID },
				   function(data){
					   $('#APP_PAGE').html(data);				     
				   });		 	 
	 }

	 function updateEntry()
	 {
		 var PAGE_ID = $('#APP_PAGE option:selected').val();
		 
		 $.post(
				 '<?php echo url_for('gestio/gBlogs') ?>', 
				 { accio: "AJAX_PAGE", APP_PAGE: PAGE_ID },
				   function(data){
					 $('#APP_ENTRY').html(data);				     
				   });
					 
	 }

	 function esborraImatge(id)
	 {
		
		 $.post(
				 '<?php echo url_for('gestio/gBlogs') ?>', 
				 { accio: "DELETE_IMAGE", APP_MULTIMEDIA: id },
				   function(data){
					   $("#img"+id).fadeOut(2000);				     
				   });
		   		 	 
	 }

	 
	
	</script>
 
    <TD colspan="3" class="CONTINGUT">
	                   	                   
     <form action="<?php echo url_for('gestio/gBlogs') ?>" method="POST">     	
	 	<div class="REQUADRE">		 	            
		 	<div class="titol">
		 		Tractament de blogs 
		 	</div>
		 	<div class="Desplegable">
		 		<select name="APP_BLOG">
		 			<?php echo $BLOGS_ARRAY ?>
		 		</select>	
		 	</div>
		 	<BR />
		 	<input type="submit" value="Veure contingut" class="BOTO_ACTIVITAT" name="B_VIEW_CONTENT">
		 	<input type="submit" value="Edita" class="BOTO_ACTIVITAT" name="B_EDIT_BLOG">
		 	<input type="submit" value="Nou" class="BOTO_ACTIVITAT" name="B_NEW_BLOG">
		 	<input type="submit" value="Veure estadístics" class="BOTO_ACTIVITAT" name="B_VIEW_STADISTICS">		 	
      	</div>
      	</form>

<?php if(isset($FORM_BLOG)): ?>

	<form action="<?php echo url_for('gestio/gBlogs') ?>" method="POST">
	 	<div class="REQUADRE">
	 	<div class="OPCIO_FINESTRA">
	 		<a href="<?php echo url_for('gestio/gBlogs?accio=VB') ?>"><?php echo image_tag('icons/Grey/PNG/action_delete.png') ?></a></div>            
	 	<div class="titol">
	 		Edició de blogs 
	 	</div>
	    	<table class="FORMULARI" width="600px">	    	                  			    
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <?php echo $FORM_BLOG ?>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<br>
	            		<button name="B_SAVE_BLOG" class="BOTO_ACTIVITAT">Guarda</button>
						<button name="B_DELETE_BLOG" class="BOTO_ACTIVITAT">Elimina</button>
	            	</td>
	            </tr>                	 
      		</table>      		
      	</div>
     </form>         
     
<?php ENDIF; ?>


<?php if(isset($MENUS_ARRAY)): ?>    

     <form action="<?php echo url_for('gestio/gBlogs') ?>" method="POST">     	
	 	<div class="REQUADRE">
		 	<div class="OPCIO_FINESTRA">
		 		<a href="<?php echo url_for('gestio/gBlogs?accio=VB') ?>"><?php echo image_tag('icons/Grey/PNG/action_delete.png') ?></a></div>            
		 	<div class="titol">
		 		Edició de blogs 
		 	</div>
		 	<div class="Desplegable">
		 		<table>
			 		<tr>
			 			<td>
			 				<select id="APP_MENU" style="width:300px;" name="APP_MENU"><?php echo $MENUS_ARRAY ?></select>
			 			</td>
			 			<td>
			 				<button class="BOTO_ACTIVITAT" name="B_EDIT_MENU">Edita</button>	 				 			 			 		      				 	
			 				<button class="BOTO_ACTIVITAT" name="B_NEW_MENU">Afegeix</button>		 						
			 			</td>
			 		</tr>	
				 	<tr>
				 		<td><select id="APP_PAGE" style="width:300px;" name="APP_PAGE"><?php echo $PAGES_ARRAY ?></select></td>
				 		<td>				 							 					 			
			 				<button class="BOTO_ACTIVITAT" name="B_EDIT_PAGE">Edita</button>	 				 			 			 		      				 	
			 				<button class="BOTO_ACTIVITAT" name="B_NEW_PAGE">Afegeix</button>
			 						 						
				 		</td>
				 	</tr>
				 	<tr>
					 	<td><select id="APP_ENTRY" style="width:300px;" name="APP_ENTRY"><?php echo $ENTRIES_ARRAY ?></select></td>
					 	<td>					 		
			 				<button class="BOTO_ACTIVITAT" name="B_EDIT_ENTRY">Edita</button>
			 				<button class="BOTO_ACTIVITAT" name="B_NEW_ENTRY">Afegeix</button>	 				 			 			 		      				 				 						 									 			
					 	</td>
					</tr>
			 	</table>
		 	</div>
		 		 
      	</div>
      	</form>

<?php ENDIF; ?>
<?php if(isset($FORM_MENU)): ?>    

	<form action="<?php echo url_for('gestio/gBlogs') ?>" method="POST">
	 	<div class="REQUADRE">
	 	<div class="OPCIO_FINESTRA">
	 		<a href="<?php echo url_for('gestio/gBlogs?accio=VIEW_CONTENT') ?>"><?php echo image_tag('icons/Grey/PNG/action_delete.png') ?></a></div>            
	 	<div class="titol">
	 		Editant el menú:  
	 	</div>
	    	<table class="FORMULARI" width="600px">	    	                  			    
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <?php echo $FORM_MENU ?>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<br>
	            		<button name="B_SAVE_MENU" class="BOTO_ACTIVITAT">Guarda</button>
						<button name="B_DELETE_MENU" class="BOTO_ACTIVITAT">Elimina</button>
	            	</td>
	            </tr>                	 
      		</table>      		
      	</div>
     </form>         

              
<?php ENDIF; ?>
<?php if(isset($FORM_PAGE)): ?>    

	<form action="<?php echo url_for('gestio/gBlogs') ?>" method="POST">
	 	<div class="REQUADRE">
	 	<div class="OPCIO_FINESTRA">
	 		<a href="<?php echo url_for('gestio/gBlogs?accio=VIEW_CONTENT') ?>"><?php echo image_tag('icons/Grey/PNG/action_delete.png') ?></a></div>            
	 	<div class="titol">
	 		Editant la pàgina:  
	 	</div>
	    	<table class="FORMULARI" width="600px">	    	                  			    
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <?php echo $FORM_PAGE ?>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<br>
	            		<button name="B_SAVE_PAGE" class="BOTO_ACTIVITAT">Guarda</button>
						<button name="B_DELETE_PAGE" class="BOTO_ACTIVITAT">Elimina</button>
	            	</td>
	            </tr>                	 
      		</table>      		
      	</div>
     </form>         

              
<?php ENDIF; ?>

<?php if(isset($FORM_ENTRY)): ?>    

	<form action="<?php echo url_for('gestio/gBlogs') ?>" method="POST" enctype="multipart/form-data">
	 	<div class="REQUADRE">
	 	<div class="OPCIO_FINESTRA">
	 		<a href="<?php echo url_for('gestio/gBlogs?accio=VIEW_CONTENT') ?>"><?php echo image_tag('icons/Grey/PNG/action_delete.png') ?></a></div>            
	 	<div class="titol">
	 		Editant una entrada:  
	 	</div>
	    	<table class="FORMULARI" width="600px">	    	                  			    
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <?php echo $FORM_ENTRY ?>
                <tr>
                	<th>Galeria: </th>
                	<td>
                		<?php echo DibuixaGaleria($GALLERY); ?>                		
                	</td>
                </tr>                								
                
                <tr>
                	<th>Afegir arxius: </th>
                	<td id="files">
                		<input type="hidden" id="comptador" value="1">
                		<span onClick="afegirArxiu();">+</span>
                	</td>
                </tr>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<br>
	            		<button name="B_SAVE_ENTRY" class="BOTO_ACTIVITAT">Guarda</button>
						<button name="B_DELETE_ENTRY" class="BOTO_ACTIVITAT">Elimina</button>
	            	</td>
	            </tr>                	 
      		</table>      		
      	</div>
     </form>         

              
<?php ENDIF; ?>
<?php if(isset($PAGES_WITHOUT_CONTENT)): ?>    

	<div id="tabs">
	    <ul>
	        <li><a href="#tab-1"><span>Menús</span></a></li>
	        <li><a href="#tab-2"><span>Pàgines</span></a></li>
	        <li><a href="#tab-3"><span>Arbre</span></a></li>
	    </ul>
	    <div id="tab-1">
	        <table class="DADES">
	    	<tr>
	    		<th>ID</th>
	        	<th>NOM</th>
	        	<th>TÉ PAGINA?</th>
	        </tr>
	        <?php 	        
	        	foreach($MENUS_WITHOUT_PAGES as $K=>$OO):
	        		$TE_PAGINA = ($OO['COUNT'])?'Sí':'No';
	        		echo '<tr>
	        				<td>'.$K.'</td>
	        				<td>'.$OO['NAME'].'</td>
	        				<td>'.$TE_PAGINA.'</td>
	        			  </tr>';
	        	endforeach;	        
	        ?>
	        </table>
	    </div>
	    <div id="tab-2">
	    	<table class="DADES">
	    	<tr>
	    		<th>ID</th>
	        	<th>NOM</th>
	        	<th>#ENTRADES</th>
	        </tr>
	        <?php 	        
	        	foreach($PAGES_WITHOUT_CONTENT as $K=>$OO):
	        		echo '<tr>
	        				<td>'.$K.'</td>
	        				<td>'.$OO['NAME'].'</td>
	        				<td>'.$OO['COUNT'].'</td>
	        			  </tr>';
	        	endforeach;	        
	        ?>
	        </table>
	    </div>
	    <div id="tab-3">
	    	<table width="100%" class="DADES">
	        	<?php DibuixaArbre($TREE); ?>
	        </table>
	    </div>
	</div>

<?php ENDIF; ?>

<?php 

	function DibuixaArbre($TREE,$nivell = "") 
	{			
		foreach($TREE as $K => $OO):
			echo '<tr>
					<td width="50px">'.$K.'</td>
					<td>'.$nivell.$OO['NOM'].'</td>
					<td width="150px">Opcions</td></tr>';
			DibuixaArbre($OO['TREE'],$nivell.'&nbsp;&nbsp;&nbsp;');
		endforeach;				
	}


	function DibuixaGaleria($GALLERY)
	{
		
		$RET  = "<table>";
		$RET .= "<tr>";
		
		foreach($GALLERY as $OO):
			$RET .= '<td>
					<a href="#" onClick="esborraImatge('.$OO->getId().')">						
						<img id="img'.$OO->getId().'" width="100px" src="'.sfConfig::get('sf_webroot').'/images/blogs/'.$OO->getUrl().'">
					</a>												
					</td>';
		endforeach;
		
		$RET .= "</tr></table>";
		
		return $RET;
                		
	}
	
?>