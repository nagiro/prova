<?php


    /**
     * getRetorn()
     *
     * retorna un history back 
     *       
     * @return string
     */
    function getRetorn($atributs = "")
    {                
        return '<a '.$atributs.' href="javascript:history.back()">Torna al llistat d\'activitats</a>';                     
    } 


    /**
     * generaHorarisCompactat()
     * 
     * Funció que retorna el rang temporal de dates (27/gen a 3/mar)
     * 
     * @param mixed $LOH (Llista Objectes Horaris)
     * @return string 
     */
    function generaHorarisCompactat($LOH)
    {
    	$RET = array();
        $ESP = array();                
        
        $first_day = 0;
        $last_day = 0;
        
        foreach($LOH as $OH):
            $dia = strtotime($OH->getDia());
            if($first_day == 0 || $dia < $first_day) $first_day = $dia;
            if($last_day == 0 || $dia > $last_day ) $last_day = $dia;                    		    		        		                    		
    	endforeach;                                       
        
        if($first_day == $last_day):
            return date('d',$first_day).'/'.generaMes(date('m',$first_day),true);
        else: 
            return date('d',$first_day).'/'.generaMes(date('m',$first_day),true).' - '.date('d',$last_day).'/'.generaMes(date('m',$last_day),true); 
        endif;
                                                     	        
    }

    function generaHoraris($LOH)
    {
    	$RET = array();
        $ESP = array();
        if(sizeof($LOH) > 4):

            foreach($LOH as $OH):    		
        		$LOHE = $OH->getHorarisespaiss();
                $ESP[$LOHE[0]->getNomEspai()][$OH->getHorainici('H:i')][$OH->getDia('m')][$OH->getDia('d')] = $OH->getDia('d');        		    		        		                    		
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
        		$Espai = $LOHE[0]->getNomEspai();    		
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

    function generaMes($M,$comp = false)
    {
        $ret = "";
        if($comp):
            switch($M){
    			case '01': $ret .= "gener"; break;
    			case '02': $ret .= "febrer"; break;
    			case '03': $ret .= "març"; break;
    			case '04': $ret .= "abril"; break;
    			case '05': $ret .= "maig"; break;
    			case '06': $ret .= "juny"; break;
    			case '07': $ret .= "juliol"; break;
    			case '08': $ret .= "agost"; break;
    			case '09': $ret .= "setembre"; break;
    			case '10': $ret .= "octubre"; break;
    			case '11': $ret .= "novembre"; break;
    			case '12': $ret .= "desembre"; break;
    		}               
        else:         
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
        endif; 
        return $ret;
    }
        
    
	function generaData($DIA)
	{

		$ret = ""; list($ANY,$MES,$DIA) = explode("-",$DIA);
		$DATE = mktime(0,0,0,$MES,$DIA,$ANY);
		switch(date('N',$DATE)){
			case '1': $ret = "Dll, ".date('d',$DATE); break;  
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
		
		// $ret .= " de ".date('Y',$DATE);
		
		return $ret;
		
	}
    
?>