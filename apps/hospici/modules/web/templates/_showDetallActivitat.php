<div class="h_requadre_resultats">
    <div class="h_subtitle_gray c1">
        L'HOSPICI...
    </div>

    <div>
        
    <?php if($ACTIVITAT instanceof Activitats){
    
            $i = $ACTIVITAT->getImatge();            
            $imatge = '/images/activitats/'.$i;
            
            if(!($i > 0)) $imatge = SitesPeer::getSiteLogo($ACTIVITAT->getSiteId());                                     
            
            $pdf = $ACTIVITAT->getPdf();                          
     ?>
			<div style="border:0px solid #96BF0D; clear:both; padding:10px;">
				<div style="font-size:11px"><b><?php echo $ACTIVITAT->getTMig() ?></b></div>
				<div style="font-size:10px"><?php echo generaHoraris($ACTIVITAT->getHorarisOrdenats(HorarisPeer::DIA)); ?></div>
				<div style="height:30px;">&nbsp;</div>				
										                                        
                <!-- Columna esquerra -->
                                        
				<div style="width:150px; float:left">
                
					<div><img src="<?php echo $imatge ?>" style="width:150px; vertical-align:middle;" /></div>
                    
                    <div style="margin-top:20px; font-size:10px">
                        <div class="requadre_mini" style="background-color:#A2844A;">
                            <a href="javascript:history.back()">&lt; Torna al llistat d'activitats</a>
                        </div>
                    </div>
                    
                    <?php if($pdf > 0): ?>
                    <div class="pdf_cicle" style="margin-top: 5px;">
                        <div class="requadre_mini" style="background-color: #D4A261;">
                            <a href="/images/activitats/<?php echo $pdf ?>">Baixa't el pdf</a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div style="margin-top:5px;">
                        <?php //echo myUser::ph_getEtiquetaActivitats($AUTENTIFICAT, $ACTIVITAT, $HORARIS_AMB_ENTRADES); ?>
                    </div>
                    												
                    <div style="margin-top:20px;">
                        <?php echo ph_getAddThisDiv(); ?>
                    </div>   
                                         						
				</div>
                
                <!-- Fi columna esquerra -->
                <!-- Text central -->
                
				<div style="width:400px; float:left; ">
					<div style="padding-left:10px; font-size:10px;">
						<?php echo $ACTIVITAT->getDmig() ?>
					</div>					
				</div>
				
                <!-- Fi text central -->
                <!-- Requadre d'informació pràctica  -->
                
                <?php $ip = $ACTIVITAT->getInfopractica(); if(!empty($ip)): ?>
				<div style="margin-left:150px; padding-top:20px; width:330px; clear:both; color:#96BF0D; font-size:12px; padding-left:10px;">INFORMACIÓ PRÀCTICA</div> 
				<div style=" margin-left:150px; width:330px; clear:both; background-color:#DFECB6">					
					<div style="padding:10px; font-size:10px;">
						<?php echo $ip; ?>
					</div>
				</div>
                <?php endif; ?>
				<div style="clear:both">&nbsp;</div>
                
                <!-- Fi Requadre d'informació pràctica  -->
                <!-- Requadre de compra o reserva d'entrades  -->
                
   				<div style="margin-left:160px; padding-top:20px; width:330px; clear:both; color:#96BF0D; font-size:12px; padding-left:10px;">COMPRA O RESERVA D'ENTRADES</div> 
				<div style="margin-left:160px; width:400px; clear:both; background-color:#DFECB6">					
					<div style="padding:10px; font-size:10px;">
                        <div>                                                                                        
                            <?php 
                                foreach($HORARIS as $OH):
                                
                                    //Busquem el detall de la venta de tiquets                                
                                    $OEP = EntradesPreusPeer::getByActivitatOHorari($ACTIVITAT->getActivitatid(), $OH->getHorarisid());
                                                                    
                                    //Només mostrem aquells que tenen disponibilitat de comprar o reservar entrades.                                 
                                    if($OEP instanceof EntradesPreus):
                                        echo '  <form action="'.url_for('@hospici_compra_entrada').'" method="post">';                                
                                        echo '      <div style="float:left; width:100px"><b>Sessió</b><br/>'.$OH->getDia('d/m/Y').'</div>
                                                    <div style="float:left; width:50px"><b>Hora</b><br/>'.$OH->getHorainici('H:i').'</div>
                                                    <div style="float:left; width:50px; "><b>Preu</b><br/>'.$OEP->getPreu().'€</div>
                                                    <div style="float:left; width:100px; text-align:center;"><br />'.myUser::ph_getEtiquetaActivitats($AUTENTIFICAT, $ACTIVITAT, $HORARIS_AMB_ENTRADES, $OH, $OEP).'</div>';
                                                    
                                        echo '      <div style="float:left; width:100px; clear:both; "><b>Descompte</b><br/></div>                                                            
                                                    <div style="float:left; width:100px;"><b>Entrades</b><br/></div>';                                                                                                        

                                    foreach($OEP->getDescomptesArrayStrings() as $idD => $NomDescompte):                                                                                                                                                            
                                        echo '      <div style="float:left; width:100px; clear:both;">'.$NomDescompte.input_hidden_tag('entrades['.$ACTIVITAT->getActivitatid().']['.$OH->getHorarisid().']['.$idD.'][descompte]',$idD).'</div>';
                                        echo '      <div style="float:left; width:100px; ">'.select_tag('entrades['.$ACTIVITAT->getActivitatid().']['.$OH->getHorarisid().']['.$idD.'][num]',options_for_select(array(0=>'0',1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8'))).'</div>';                                                                                                                                                            
                                    endforeach;
                                    echo '          <div style="clear:both; border-bottom:1px solid black; ">&nbsp;</div>                                                    
                                                </form>';                                                                                                                                                    
                                    endif;
                                                                        
                                endforeach;                                
                                                                                        
                            ?>
                        </div>
                                                                      
                    </div>
                </div>                
                
                <!-- Fi Requadre de compra o reserva d'entrades  -->													
			</div>
    <?php } ?>					                                                                    
    </div>
</div>