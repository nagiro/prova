<script type="text/javascript">

	$(document).ready(function() {	
		$('[id*=MOSTRA]').each(function(index){ $(this).fadeOut(0); });
		$('#MOSTRA1').fadeIn(0);
		
	});

	function Mostra(id)
	{
				
		var act = parseInt(id);
		var seg = parseInt(id)+1;
		
		$('#MOSTRA'+act).fadeOut(0);
		$('#MOSTRA'+seg).fadeIn(2000);
		
	}

	function visible(idA)
	{
				
		$('[id*=DIV]').each(function(index){ $(this).fadeOut(2500); })
		$('[id*=CUR]').each(function(index){ $(this).fadeIn(2500); })
		$('[id*=MES]').each(function(index){ $(this).fadeIn(2500); })
		
		$('#DIV'+idA).fadeIn(2500);
		$('#CUR'+idA).fadeOut(0);
		$('#MES'+idA).fadeOut(2500);			
			
	}
	
</script>

    <TD colspan="2" class="CONTINGUT">
    <?php 
    
    	if(isset($NOTICIA)):
    		mostraNoticia($NOTICIA);
    	else: 
    		mostraNoticies($NOTICIES);    	
    	endif; 
		    	
	?>
	
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    
    <?php 

    
	function mostraNoticia($NOTICIA)
    {
    	     							       											
     	$titol = $NOTICIA->getTitolnoticia(); $imatge = $NOTICIA->getImatge(); $pdf = $NOTICIA->getAdjunt(); $descripcio = $NOTICIA->getTextnoticia();
		if(!empty($titol)):
    		echo '<TABLE class="BOX">';
	    	echo '<TR>';  
 			if(!empty($imatge)):	    
 				echo '<TD class="FOTO">'.image_tag('noticies/'.$NOTICIA->getImatge(), array('class'=>'IMG_FOTO')).'</TD>';
 			endif;
	        echo '<TD class="NOTICIA">';			    
			echo '<DIV class="TITOL">'.$titol.'</DIV>';
	    	echo '<DIV>'.$descripcio.'</DIV>';			    	 					    	
	    	echo '<DIV class="PEU">';
	    	echo 	'<br />';
	    	echo 	link_to('Tornar', url_for('web/index?accio=no'), array('class'=>'verd','style'=>'float:left; font-weight:bold;'));
 			if(!empty($pdf)): 				 
 				echo link_to(image_tag('intranet/pdf.png', array('style'=>'float:right')),image_path('noticies/'.$pdf , true) , array('target'=>'_NEW')); 				
 			endif;
 			echo '</DIV>';			
			echo '</TD>';
	    	echo '</TR>';		    			    			    			    			    	
	    	echo '</TABLE>';
 		endif;

    }
    
    
    
    
    function mostraNoticies($NOTICIES)
    {
    	if($NOTICIES->getNbResults() == 0): echo '<DIV>No hi ha cap notícia activa.<DIV>'; endif;     							
        
		$i = 1;
		
		echo '<div id="MOSTRA1">';
		
		foreach($NOTICIES->getResults() as $N):
				
     		$titol = $N->getTitolnoticia(); $imatge = $N->getImatge(); $pdf = $N->getAdjunt(); $descripcio = $N->getTextnoticia();
			if(!empty($titol)):               	        	        	       	       	       	    	       	       	       	       	       	       	       	      	   	          	           	   	      		
    			echo '<TABLE class="BOX">';
		    	echo '<TR>';  
	 			if(!empty($imatge)):	    
	 				echo '<TD class="FOTO">'.image_tag('noticies/'.$N->getImatge(), array('class'=>'IMG_FOTO')).'</TD>';
	 			endif;
		        echo '<TD class="NOTICIA">';			    
				echo '<DIV class="TITOL">'.$titol.'</DIV>';
				$dim = 250;
				echo '<DIV class="TEXT" name="CUR" id="CUR'.$N->getIdnoticia().'" >'.substr( $descripcio , 0 , $dim).'...</div>';
		    	echo '<DIV class="TEXT AMAGAT" name="DIV" id="DIV'.$N->getIdnoticia().'" >'.$descripcio.'</DIV>';			    	
	 			if(strlen($descripcio) > $dim):		    	
		    		echo '<DIV class="PEU"><a href="'.url_for('web/index?accio=no&idN='.$N->getIdnoticia()).'")">'.image_tag('intranet/llegirmes.png', array('style'=>'float:left','id'=>'MES'.$N->getIdnoticia(),'name'=>'MES')).'</a>';
	 			endif;
	 			if(!empty($pdf)): 
	 				echo link_to(image_tag('intranet/pdf.png', array('style'=>'float:right')),image_path('noticies/'.$pdf , true) , array('target'=>'_NEW'));
	 			endif;
				echo '</DIV>';
				echo '</TD>';
		    	echo '</TR>';		    			    			    			    			    	
		    	echo '</TABLE>';
	 		endif;	 			 				
	 	
		endforeach;
		
			if($NOTICIES->haveToPaginate()):
				echo '<TABLE class="BOX">';
		   		echo '<TR>';   		
		        echo '<TD class="NOTICIA" style="text-align:center">';
				if($NOTICIES->getPage() < $NOTICIES->getLastPage()):		 					    
					echo '<a class="MES_NOTICIES" href="'.url_for('web/index?accio=no&pagina='.$NOTICIES->getNextPage()).'">Veure més notícies</a>';
				else: 
					echo '<a class="MES_NOTICIES" href="'.url_for('web/index?accio=no&pagina=1').'"> Tornar al principi</a>';										 				
		    	endif;
		    	echo '</TD>';
		    	echo '</TR>';		    			    			    			    			    	
		    	echo '</TABLE>';
		    endif;

		echo '</div>';
    }
    
    
    function agrupaespais($ESPAIS)
    {
       
       $ANT = ""; $RET = array();
       foreach($ESPAIS as $EID => $E):
          if($ANT <> $E) $RET[] = $E;
          $ANT = $E;                 
       endforeach;

       return $RET;
       
    }
    
	function generaData($DIA)
	{

		$ret = ""; list($ANY,$MES,$DIA) = explode("-",$DIA);
		$DATE = mktime(0,0,0,$MES,$DIA,$ANY);
		switch(date('N',$DATE)){
			case '1': $ret = "Dilluns, ".date('d',$DATE); break;  
			case '2': $ret = "Dimarts, ".date('d',$DATE); break;
			case '3': $ret = "Dimecres, ".date('d',$DATE); break;
			case '4': $ret = "Dijous, ".date('d',$DATE); break;
			case '5': $ret = "Divendres, ".date('d',$DATE); break;
			case '6': $ret = "Dissabte, ".date('d',$DATE); break;
			case '7': $ret = "Diumenge, ".date('d',$DATE); break;				
		}
				
		switch(date('m',$DATE)){
			case '01': $ret .= " de gener"; break;
			case '02': $ret .= " de febrer"; break;
			case '03': $ret .= " de març"; break;
			case '04': $ret .= " d'abril"; break;
			case '05': $ret .= " de maig"; break;
			case '06': $ret .= " de juny"; break;
			case '07': $ret .= " de juliol"; break;
			case '08': $ret .= " d'agost"; break;
			case '09': $ret .= " de setembre"; break;
			case '10': $ret .= " d'octubre"; break;
			case '11': $ret .= " de novembre"; break;
			case '12': $ret .= " de desembre"; break;
		}
		
		$ret .= " de ".date('Y',$DATE);
		
		return $ret;
		
	}


?>