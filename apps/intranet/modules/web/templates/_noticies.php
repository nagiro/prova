<?php use_helper('Form'); ?>

    <TD colspan="2" class="CONTINGUT">
    
    <?php include_partial('breadcumb',array('text'=>'NOTÍCIES')); ?>
    
    <?php 
    
    	if(!is_null($NOTICIA)):
    		mostraNoticia( $NOTICIA , $PAGINA );
    	else: 
    		mostraNoticies( $NOTICIES , $PAGINA );    	
    	endif; 
		    	
	?>
	
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    
    <?php 

    
	function mostraNoticia( $NOTICIA , $PAGINA )
    {
            	     							       											
     	$titol = '<b>'.$NOTICIA->getTitolnoticia().'</b>'; $imatge = $NOTICIA->getImatge(); $pdf = $NOTICIA->getAdjunt(); $descripcio = $NOTICIA->getTextnoticia();
        
        $WEBURL = OptionsPeer::getString('SF_WEBROOTURL',1).'images/noticies/';
        $SYSURL = OptionsPeer::getString('SF_WEBSYSROOT',1).'images/noticies/';
        
        $IMG_EXIST = (file_exists($SYSURL.$imatge) && !empty($imatge) );
        $PDF_EXIST = (file_exists($SYSURL.$pdf)  && !empty($pdf) );
     	
		if(!empty($titol)):
		?>                    																		
			<div class="titol_noticia"><?php echo $titol ?></div>									 
			<div style="margin-top:10px;">														
				<div class="text_noticia"><?php echo $descripcio ?></div>
				<div class="imatge_noticia">
                    <?php if($IMG_EXIST): ?> 
    					<img src="<?php echo $WEBURL.$imatge ?>" style="vertical-align:middle"> 
                    <?php endif; ?>					
				    <div style="padding-top:10px;" class="pdf_noticia">
                    <?php if($PDF_EXIST): ?>
                        <a href="<?php echo $WEBURL.$pdf ?>">Descarrega't el pdf</a>
                    <?php endif; ?>
                </div>
				</div>
			</div>
			<div style="clear:both; padding-top:10px;">
				<div class="llegir_mes">
                    <div>
                        <!-- AddThis Button BEGIN -->
                        <div class="addthis_toolbox addthis_default_style ">
                            <a class="addthis_button_facebook"></a>
                            <a class="addthis_button_twitter"></a>
                            <a class="addthis_button_myspace"></a>
                            <a class="addthis_button_email"></a>                                                                        
                            <a class="addthis_button_compact"></a>
                        </div>
                        <script type="text/javascript">var addthis_config = {"data_track_clickback":true};</script>
                        <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4d7614b11400555d"></script>
                        <!-- AddThis Button END -->                            
                    </div>                				
			</div>					
			
			<div style="clear:both;">&nbsp;</div>																						
						
            				
	    <?php
 		endif;

    }
    
    
    
    
	function mostraNoticies($NOTICIES, $PAGINA)
	{	    		
		
	    if($NOTICIES->getNbResults() == 0): 
	
			echo '<DIV>Actualment no hi ha cap notícia.<DIV>';
	
		else: 			    
				
			foreach($NOTICIES->getResults() as $ON):
															
				$imatge = $ON->getImatge();
				$pdf = $ON->getAdjunt();		
				$text = closetags($ON->getTextnoticia());	
				$nom_noticia = '<b>'.$ON->getTitolnoticia().'</b>';

                $WEBURL = OptionsPeer::getString('SF_WEBROOTURL',1).'images/noticies/';
                $SYSURL = OptionsPeer::getString('SF_WEBSYSROOT',1).'images/noticies/';
                
                $IMG_EXIST = (file_exists($SYSURL.$imatge) && !empty($imatge) );
                $PDF_EXIST = (file_exists($SYSURL.$pdf)  && !empty($pdf) );
                                
			?>
				<div style="border-bottom:2px solid #CADF86;">
																
					<div class="titol_noticia">
                        <a href="<?php echo url_for('web/index?idn='.$ON->getIdnoticia().'&p='.$PAGINA) ?>"><?php echo $nom_noticia ?></a>                                                
                    </div>									 
					<div style="margin-top:10px;">														
						<div class="text_noticia">                            
                            <?php echo substr($text,0,400) ?>...                                                    
                        </div>
						<div class="imatge_noticia">
                            <?php if($IMG_EXIST): ?> 
                                <img src="<?php echo $WEBURL.$imatge ?>" style="vertical-align:middle" /> 
                            <?php endif; ?>                            
							<div style="padding-top:10px;" class="pdf_noticia">
                                <?php if($PDF_EXIST): ?>
                                    <a href="<?php echo $WEBURL.$pdf ?>">Descarrega't el pdf</a>
                                <?php endif; ?>
                            </div>                            
						</div>
					</div>
					<div style="clear:both; padding-top:10px;">
						<div class="llegir_mes">                                                                    
                        </div>
					</div>					
					
					<div style="clear:both;">&nbsp;</div>					
																
				</div>
					
				<div style="clear:both; height:20px;"></div>
				
			<?php	
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