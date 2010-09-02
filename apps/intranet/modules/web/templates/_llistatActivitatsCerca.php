<?php use_helper('Form'); ?>

    <TD colspan="2" class="CONTINGUT">
    
    <?php include_partial('breadcumb',array('text'=>$TITOL)); ?>
    
    <?php 
        
    if($LLISTAT_ACTIVITATS->getNbResults() == 0): 
    	if($MODE == 'CERCA'):
    		echo '<DIV>No s\'ha trobat cap resultat amb aquestes paraules.<DIV>';
    	else: 
    		echo '<DIV>Aquest dia no hi ha cap activitat pública.<DIV>';
    	endif; 		
	else: 
	
		echo '<TABLE id="llistat_activitats_dia">';
    	echo '<tr>
    				<th style="text-align:left">Activitat</th>    				    				
    				<th style="text-align:left">Primer dia</th>    				
    		  </tr>';
	
		foreach($LLISTAT_ACTIVITATS->getResults() as $A):								
		
			$OA 		= $A->getActivitats();
			$OC 		= $OA->getCicles();			
			$nom_act    = $OA->getTMig();			
			
			if(!empty($nom_act)):
		    	echo '<tr>';
		    	
		    	echo '<td>';
		    	echo 	link_to($OA->getNom(),'web/index?accio=caa&idA='.$OA->getActivitatid().'&PARAM='.$PARAM);
		    			if($OC->getCicleid() > 1) echo '('.link_to($OC->getNom(),'web/index?accio=cc&idC='.$OC->getCicleid()).')';		    			
		    	echo   '</td>';
		    	echo '<td>';
		    		echo GiraData($OA->getPrimeraData());
		    	echo '</td>';
		    			    	
		    	echo '</tr>';
		    endif; 
	    			 		 	    				                  
		endforeach;
		
		echo '<tr><td colspan="3" style="text-align:center">'.setPager($LLISTAT_ACTIVITATS,'web/index?accio=c',$PAGINA).'</td></tr>';				
 		
    	echo '</TABLE>';
	endif;

    ?>
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    

    <?php 
    
    function GiraData($d)
    {
    	list($y,$m,$d) = explode('-',$d);
    	return $d.'-'.$m.'-'.$y;
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