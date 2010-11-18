<TD colspan="2" class="CONTINGUT">

    <?php include_partial('breadcumb',array('text'=>$TITOL)); ?>

    <?php 

    if(sizeof($LLISTAT_ACTIVITATS) == 0): 

		echo '<DIV>No s\'ha trobat cap activitat pública disponible per aquest cicle.<DIV>';

	else: 			    
	
		$C = CiclesPeer::retrieveByPK($IDC);
		$NA = CiclesPeer::getActivitatsCicle($C->getCicleID());						
		$PA = CiclesPeer::getDataPrimeraActivitat($C->getCicleID());
		$PF = CiclesPeer::getDataUltimaActivitat($C->getCicleID());		
		$imatge = $C->getImatge();
		$pdf = $C->getPdf();		
		
		?>
							
		<div style="border:2px solid #96BF0D; clear:both; padding:10px;">					
			<div class="df" style="width:150px;">
				<div><?php if($imatge > 0): ?> <img src="<?php echo sfConfig::get('sf_webrooturl').'images/cicles/'.$imatge ?>" style="vertical-align:middle"><?php endif; ?></div>						
				<div style="margin-top:20px;font-size:11px;">Del <?php echo $PA ?> al <?php echo $PF ?></div>
				<div style="margin-top:20px;font-size:11px;">Activitats del cicle: <?php echo $NA ?></div>						
				<div style="margin-top:0px; font-size:10px"><a href="javascript:history.back()">Torna al llistat de cicles</a></div>
				<div class="pdf_cicle"><?php if($pdf > 0): ?> <br /><a href="<?php echo sfConfig::get('sf_webrooturl').'images/cicles/'.$pdf ?>">Baixa't el pdf</a><?php endif; ?></div>						
			</div>
			<div class="df" style="width:330px;">
				<div style="padding-left:10px; font-size:11px;">                    							
					<?php foreach($LLISTAT_ACTIVITATS as $OA): ?>								
							<b><a href="<?php echo url_for('web/index?accio=caa&idA='.$OA->getActivitatid()) ?>"><?php echo $OA->getTMig(); ?></a></b><br />
							<?php echo generaHoraris($OA->getHorariss()); ?><br /><br />
					<?php endforeach; ?>
																	
				</div>
			</div>
			<div style="clear:both">&nbsp;</div>													
		</div>					
				
		<?php 					
	
	endif;

    ?>
    
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    

    <?php 
    
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
    
    
    function generaHoraris($LOH)
    {
    	$RET = array();
        $ESP = array();
        if(sizeof($LOH) > 4):

            foreach($LOH as $OH):    		
        		$LOHE = $OH->getHorarisespaiss();
                $ESP[$LOHE[0]->getEspais()->getNom()][$OH->getHorainici('H:i')][$OH->getDia('m')][$OH->getDia('m')] = $OH->getDia('d');        		    		        		                    		
        	endforeach;                       
            
            foreach($ESP as $Espai => $D1):                                            
                foreach($D1 as $Hi => $D2):                    
                    foreach($D2 as $m => $D3):
                        $RET[] = implode(', ',$D3).generaMes($m).'a les '.$Hi.' a '.$Espai;
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


/*
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
*/    
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