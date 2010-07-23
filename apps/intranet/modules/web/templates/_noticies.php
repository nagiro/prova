
    <TD colspan="2" class="CONTINGUT">
    
    <?php include_partial('breadcumb',array('text'=>'NOTÍCIES')); ?>
    
    <?php 
    
    	if(!is_null($NOTICIA)):
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
	     
	    if($NOTICIES->getNbResults() == 0): 
	
			echo '<DIV>Actualment no hi ha cap notícia.<DIV>';
	
		else: 			    
				
			foreach($NOTICIES->getResults() as $ON):
															
				$imatge = $ON->getImatge();
				$pdf = $ON->getAdjunt();			
				$nom_noticia = '<b>'.$ON->getTitolnoticia().'</b>';

//				echo '<div style="border:3px solid #CCCCCC; padding:10px;">';
				
					echo '<div style="clear:both;">';							
					echo '	<div style="width:480px; display:block; float:left; padding-bottom:5px;">'.$nom_noticia.'</div>';									 
					echo '</div>';
					
					echo '<div style="clear:both;">';
					if($imatge > 0 || $pdf > 0):
						echo '<div style="width:100px; display:block; float:left; ">';
						if($imatge > 0) echo image_tag(sfConfig::get('sf_webrooturl').'images/noticies/'.$imatge,array('style'=>'vertical-align:middle'));
						if($pdf > 0) echo '<br /><div style="padding-top:5px; text-align:center;"><a href="'.sfConfig::get('sf_webrooturl').'images/noticies/'.$pdf.'">Baixa\'t el pdf</a></div>';						
						echo '<div style="padding-top:4px; text-align:center;"><a href="'.url_for('web/index?accio=no&idn='.$ON->getIdnoticia()).'">Llegir més</a></div>';
						echo '</div>';					
						echo '<div style="width:380px; display:block; float:left; padding:5px; ">'.$ON->getTextnoticia().'</div>';
						echo '<div style="clear:both;">';							
						echo '	<div style="width:100px; display:block; float:left; ">&nbsp;</div>';														 
						echo '</div>';				
						
					else:					 				
						echo '<div style="width:480px; display:block; float:left;  padding:5px; ">'.$ON->getTextnoticia().'</div>';
						echo '<div style="clear:both;">';																											 
						echo '</div>';									
					endif; 									 											
					echo '</div>';								
				
//				echo '</div>';
					
					echo '<div style="clear:both; height:40px;"></div>';
				
			endforeach;
		
		endif;
				
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