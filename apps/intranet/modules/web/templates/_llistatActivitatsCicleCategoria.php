<STYLE>

	.FORMAT td { padding:5px; }
	.FORMAT th { padding:5px; background-color:#CCCCCC; }
	.FORMAT a { text-decoration: none; font-weight:bold; }
	
	
</STYLE>
    <TD colspan="2" class="CONTINGUT">

    <?php include_partial('breadcumb',array('text'=>$TITOL)); ?>

    <?php 

    if($LLISTAT_ACTIVITATS->getNbResults() == 0): 

		echo '<DIV>No s\'ha trobat cap activitat pública disponible per aquest cicle.<DIV>';

	else: 			    
			
		foreach($LLISTAT_ACTIVITATS->getResults() as $OA):
														
			$imatge = $OA->getImatge();
			$pdf = $OA->getPdf();			
			$nom_activitat = '<b>'.$OA->getTMig().'</b>';
			
				echo '<div style="clear:both;">';							
				echo '	<div style="width:480px; display:block; float:left; padding-bottom:5px;">'.$nom_activitat.'</div>';									 
				echo '</div>';
				
				echo '<div style="clear:both;">';
				if($imatge > 0 || $pdf > 0):
					echo '<div style="width:100px; display:block; float:left; ">';
					if($imatge > 0) echo image_tag(sfConfig::get('sf_webrooturl').'images/activitats/'.$imatge,array('style'=>'vertical-align:middle'));
					if($pdf > 0) echo '<br /><div style="padding-top:5px; text-align:center;"><a href="'.sfConfig::get('sf_webrooturl').'images/activitats/'.$pdf.'">Baixa\'t el pdf</a></div>';
					echo '</div>';					
					echo '<div style="width:380px; display:block; float:left; padding:5px; ">'.$OA->getDmig().'</div>';
					echo '<div style="clear:both;">';							
					echo '	<div style="width:100px; display:block; float:left; ">&nbsp;</div>';					
					echo '	<div style="width:380px; display:block; float:left; padding:5px;"><b>Horaris</b><br />'.generaHoraris($OA->getHorariss()).'</div>';									 
					echo '</div>';				
					
				else:					 				
					echo '<div style="width:480px; display:block; float:left;  padding:5px; ">'.$OA->getDmig().'</div>';
					echo '<div style="clear:both;">';												
					echo '	<div style="width:380px; display:block; float:left; padding:5px;"><b>Horaris</b><br />'.generaHoraris($OA->getHorariss()).'</div>';									 
					echo '</div>';									
				endif; 									 											
				echo '</div>';								

				
				echo '<div style="clear:both; height:40px;"></div>';
			
		endforeach;
	
	endif;

    ?>
    
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    

    <?php 
    
    function generaHoraris($LOH)
    {
    	$RET = array();
    	foreach($LOH as $OH):    		
    		$LOHE = $OH->getHorarisespaiss();
    		$Espai = $LOHE[0]->getEspais()->getNom();    		
    		$RET[$OH->getHorarisid()] = generaData($OH->getDia('Y-m-d')).' a '.$Espai.' a les '.$OH->getHorainici('H:i').' h.';    		
    	endforeach;
    	
    	return implode('<br />',$RET);    	
    }
    
	function generaData($DIA)
	{

		$ret = ""; list($ANY,$MES,$DIA) = explode("-",$DIA);
		$DATE = mktime(0,0,0,$MES,$DIA,$ANY);
		switch(date('N',$DATE)){
			case '1': $ret = "Dl, ".date('d',$DATE); break;  
			case '2': $ret = "Dm, ".date('d',$DATE); break;
			case '3': $ret = "Dc, ".date('d',$DATE); break;
			case '4': $ret = "Dj, ".date('d',$DATE); break;
			case '5': $ret = "Dv, ".date('d',$DATE); break;
			case '6': $ret = "Ds, ".date('d',$DATE); break;
			case '7': $ret = "Dg, ".date('d',$DATE); break;				
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
		
//		$ret .= " de ".date('Y',$DATE);
		
		return $ret;
		
	}


?>