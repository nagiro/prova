    <TD colspan="2" class="CONTINGUT">
    
      
    <?php 
		
    	$WEB = sfConfig::get('sf_web_dir').$PAGINA->getHtml();
    	if(file_exists($WEB)) include($WEB);
    	else echo "Encara no hi ha continguts..."; 
    	
    ?>
      
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    
