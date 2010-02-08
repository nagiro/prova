    <TD colspan="2" class="CONTINGUT">
    <?php 

    if(empty($ACTIVITATS_LLISTAT)): echo '<DIV>Aquest dia no hi ha cap activitat pública.<DIV>'; endif;		
		
	foreach($ACTIVITATS_LLISTAT as $A):
     	$titol = $A['DADES']['TITOL']; $imatge = $A['DADES']['IMATGE']; $pdf = $A['DADES']['PDF']; $descripcio = $A['DADES']['TEXT'];
		if(!empty($titol)):               	        	        	       	       	       	    	       	       	       	       	       	       	       	      	   	          	           	   	      		
    		echo '<TABLE class="BOX">';
	    	echo '<TR>';  
 			if(!empty($imatge)):	    
 				echo '<TD class="FOTO">'.image_tag('noticies/'.$imatge, array('class'=>'IMG_FOTO')).'</TD>';
 			endif;
	        echo '<TD class="NOTICIA">';
			echo '	<DIV class="DATA">';
					foreach($A['HORARIS'] as $H): echo implode(',',$H['ESPAIS']).' a les '.$H['HORAI']; endforeach; 		        	      		        			                   
			echo '  </DIV>';			        
			echo '<DIV class="TITOL">'.$titol.'</DIV>';
			$dim = 250;
			echo '<DIV class="TEXT" id="CUR'.$A['DADES']['ID'].'" >'.substr( $descripcio , 0 , $dim).'...</div>';
	    	echo '<DIV class="TEXT AMAGAT" id="DIV'.$A['DADES']['ID'].'" >'.$descripcio.'</DIV>';			    	
 			if(strlen($descripcio) > $dim):		    	
	    		echo '<DIV class="PEU"><a href="#" onClick="visible('.$A['DADES']['ID'].')">'.image_tag('intranet/llegirmes.png', array('style'=>'float:left')).'</a>';
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
    ?>
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    

    <?php 

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