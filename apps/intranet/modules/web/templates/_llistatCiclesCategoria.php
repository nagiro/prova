<STYLE>

	.FORMAT td { padding:5px; }
	.FORMAT th { padding:5px; background-color:#CCCCCC; }
	.FORMAT a { text-decoration: none; font-weight:bold; }


</STYLE>
    <TD colspan="2" class="CONTINGUT">

    <?php include_partial('breadcumb',array('text'=>$TITOL)); ?>

    <?php 

    if($LLISTAT_CICLES->getNbResults() == 0): 

		echo '<DIV>No s\'ha trobat cap cicle o activitat pública disponible.<DIV>';

	else: 			    
			
		foreach($LLISTAT_CICLES->getResults() as $C):
		
			$nom_cicle = $C->getTMig();
			$NA = ActivitatsPeer::countActivitatsCiclesCategoria($CAT,$C->getCicleID());						
			$PA = CiclesPeer::getDataPrimeraActivitat($C->getCicleID());
			$imatge = $C->getImatge();
			$pdf = $C->getPdf();
			$nom_cicle = '<b><a href="'.url_for('web/index?accio=aca&idc='.$C->getCicleID().'&cat='.$CAT).'">'.$nom_cicle.'</a></b>';
			
				echo '<div style="clear:both;">';
			
				if($C->getCicleID() == 1): 
					echo '<div style="width:480px; display:inline; padding:5px;">'.$nom_cicle.'</div>';
				else:
					echo '<div style="width:280px; display:block; float:left; padding-bottom:5px;">'.$nom_cicle.'</div>';
					echo '<div style="width:80px; display:block; float:left;">Activitats: <b>'.$NA.'</b></div>';
					echo '<div style="width:120px; display:block; float:left;">Inici: <b>'.$PA.'</b></div>';
				endif; 
				echo '</div>';
				echo '<div style="clear:both;">';
				if($imatge > 0 || $pdf > 0):
					echo '<div style="width:100px; display:block; float:left; ">';
					if($imatge > 0) echo image_tag(sfConfig::get('sf_webrooturl').'images/cicles/'.$imatge,array('style'=>'vertical-align:middle'));
					if($pdf > 0) echo '<br /><div style="padding-top:5px; text-align:center;"><a href="'.sfConfig::get('sf_webrooturl').'images/cicles/'.$pdf.'">Baixa\'t el pdf</a></div>';
					echo '</div>';					
					echo '<div style="width:380px; display:block; float:left; padding:5px; ">'.$C->getDmig().'</div>';
				else:					 				
					echo '<div style="width:480px; display:block; float:left;  padding:5px; ">'.$C->getDmig().'</div>';
				endif; 									 											
				echo '</div>';
				
				echo '<div style="clear:both; height:40px;"></div>';
			
		endforeach;
	
	endif;

    ?>
      <DIV STYLE="height:40px;"></DIV>

    </TD>
    

    <?php 
    
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