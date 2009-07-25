    <TD colspan="2" class="CONTINGUT">

	<?php  
	

		if(empty($ACTIVITATS_LLISTAT)):
			echo "<DIV>NO S'HAN TROBAT ACTIVITATS<DIV>";
		endif;
	
		foreach($ACTIVITATS_LLISTAT as $ACTIVITAT):		
			if(isset($ACTIVITAT['DESCRIPCIO'])):
			  echo '<TABLE class="BOX"><TR><TD class="NOTICIA">';	      	      
		      echo '<DIV class="DATA">'.generaData($ACTIVITAT['DIA']).' a '.implode(" i ",$ACTIVITAT['ESPAIS']).'</DIV>';
		      echo '<DIV class="TITOL">'.$ACTIVITAT['DESCRIPCIO']['TITOL'].'</DIV>';	      	     
		      echo '<DIV class="TEXT">'.$ACTIVITAT['DESCRIPCIO']['COS'].'</DIV>';	      
			  echo '</TD></TR></TABLE>'; 
			endif;							
		endforeach;
		
	?>
   
      
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    
    
<?php 

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