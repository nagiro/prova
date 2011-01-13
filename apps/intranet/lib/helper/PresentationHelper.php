<?php

    function generaHoraris($LOH)
    {
    	$RET = array();
        $ESP = array();
        if(sizeof($LOH) > 4):

            foreach($LOH as $OH):    		
        		$LOHE = $OH->getHorarisespaiss();
                $ESP[$LOHE[0]->getEspais()->getNom()][$OH->getHorainici('H:i')][$OH->getDia('m')][$OH->getDia('d')] = $OH->getDia('d');        		    		        		                    		
        	endforeach;                       
            
            foreach($ESP as $Espai => $D1):                                            
                foreach($D1 as $Hi => $D2):                    
                    foreach($D2 as $m => $D3):
                        $RET[] = $Espai.' a les '.$Hi.' els dies '.implode(', ',$D3).generaMes($m);
                    endforeach;
                endforeach;
            endforeach;
            
            return implode('<br />',$RET);
            
        else: 
         
        	foreach($LOH as $OH):    		
        		$LOHE = $OH->getHorarisespaiss();
        		$Espai = $LOHE[0]->getEspais()->getNom();    		
        		$RET[$OH->getHorarisid()] = generaData($OH->getDia('Y-m-d')).' a '.$Espai.' a les '.$OH->getHorainici('H:i').' h.';    		
        	endforeach;
    	
    	    return implode('<br />',$RET);
           
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

    function generaMes($M)
    {
        $ret = "";
        switch($M){
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
        return $ret;
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