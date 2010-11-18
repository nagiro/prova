    <TD colspan="2" class="CONTINGUT">

    <?php include_partial('breadcumb',array('text'=>$TITOL)); ?>

    <?php
     
    if(empty($LLISTAT_ACTIVITATS)): echo '<DIV>Aquest dia no hi ha cap activitat pública.<DIV>'; endif;		
		
	foreach($LLISTAT_ACTIVITATS as $A):
			
		$C = CiclesPeer::retrieveByPK($A->getCiclescicleid());
		if($C instanceof Cicles && $C->getCicleID() > 1) $nom_cicle = '<b>'.$C->getTMig().'</b>'; else $nom_cicle = "";
		$imatge = $A->getImatge();
		$pdf = $A->getPdf();                        
						
        if(!empty($nom_cicle)):	
		?>
			<div style="clear:both;">											
				<div class="df titol_cicle" style="width:150px;">Activitat del cicle</div>
				<div class="df titol_cicle" style="color: #A73339; width:330px; padding-left:20px;"><?php echo $nom_cicle ?></div>									 
			</div>
		<?php endif; ?>
			<div style="border:2px solid #96BF0D; clear:both; padding:10px;">
				<div style="font-size:11px"><b><?php echo $A->getTMig() ?></b></div>
				<div style="font-size:10px"><?php echo generaHoraris($A->getHorarisOrdenats(HorarisPeer::DIA)); ?></div>
				<div style="height:30px;">&nbsp;</div>				
										
				<div class="df" style="width:150px;">
					<div><?php if($imatge > 0): ?> <img src="<?php echo sfConfig::get('sf_webrooturl').'images/activitats/'.$imatge ?>" style="vertical-align:middle"><?php endif; ?></div>
						<div style="margin-top:20px; font-size:10px"><?php echo getRetorn($A,$NODE); ?></div>
						<div class="pdf_cicle"><?php if($pdf > 0): ?> <br /><a href="<?php echo sfConfig::get('sf_webrooturl').'images/activitats/'.$pdf ?>">Baixa't el pdf</a><?php endif; ?></div>						
				</div>
				<div class="df" style="width:330px;">
					<div style="padding-left:10px; font-size:10px;">
						<?php echo $A->getDmig() ?>
					</div>					
				</div>
				
				<div style="margin-left:150px; padding-top:20px; width:330px; clear:both; color:#96BF0D; font-size:12px; padding-left:10px;">INFORMACIÓ PRÀCTICA</div> 
				<div style=" margin-left:150px; width:330px; clear:both; background-color:#DFECB6">					
					<div style="padding:10px; font-size:10px;">
						<?php echo $A->getInfoPractica(); ?>
					</div>
				</div>
				<div style="clear:both">&nbsp;</div>													
			</div>					
			
			<?php 
			
			echo '<div style="clear:both; height:40px;"></div>';
	     	             	      	                
	endforeach;
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
    
    function getRetorn($A,$NODE)
    {                
        return '<a href="javascript:history.back()">Torna al llistat d\'activitats</a>';                     
    } 

?>