    <TD colspan="2" class="CONTINGUT">
    
     <div id="TEXT_WEB">
    <?php 
		
	    if(!$NODE->getIscategoria()):
	    	$WEB = sfConfig::get('sf_web_dir').$NODE->getHtml();
	    	$P = $NODE->getHtml();    	
	    	if(!empty($P) && file_exists($WEB)) include($WEB); 
	    	else echo "Encara no hi ha continguts...";
	    else: 
            //Carregar els nodes que depenen de mi 
            //I dibuixar estructura d'arbre
            print_r($NODE);
	    	echo "Això és un node categoria";
	    endif;  
    	
    ?>
      </div>
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    
