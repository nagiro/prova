<div class="h_requadre_resultats">
    <div class="h_subtitle_gray c1">
        L'HOSPICI...
    </div>

    <div>
        
    <?php if($ACTIVITAT instanceof Activitats):
            $imatge = $ACTIVITAT->getImatge();
            $pdf = $ACTIVITAT->getPdf();                          
     ?>
			<div style="border:0px solid #96BF0D; clear:both; padding:10px;">
				<div style="font-size:11px"><b><?php echo $ACTIVITAT->getTMig() ?></b></div>
				<div style="font-size:10px"><?php echo generaHoraris($ACTIVITAT->getHorarisOrdenats(HorarisPeer::DIA)); ?></div>
				<div style="height:30px;">&nbsp;</div>				
										
				<div class="df" style="width:150px;">
					<div><?php if($imatge > 0): ?> <img src="<?php echo sfConfig::get('sf_webrooturl').'images/activitats/'.$imatge ?>" style="vertical-align:middle"><?php endif; ?></div>
						<div style="margin-top:20px; font-size:10px"><?php echo getRetorn(); ?></div>
						<div class="pdf_cicle"><?php if($pdf > 0): ?> <br /><a href="<?php echo sfConfig::get('sf_webrooturl').'images/activitats/'.$pdf ?>">Baixa't el pdf</a><?php endif; ?></div>
                    <div style="margin-top:20px;">
                        <?php echo ph_getAddThisDiv(); ?>
                    </div>
                        						
				</div>
				<div class="df" style="width:330px;">
					<div style="padding-left:10px; font-size:10px;">
						<?php echo $ACTIVITAT->getDmig() ?>
					</div>					
				</div>
				
				<div style="margin-left:150px; padding-top:20px; width:330px; clear:both; color:#96BF0D; font-size:12px; padding-left:10px;">INFORMACIÓ PRÀCTICA</div> 
				<div style=" margin-left:150px; width:330px; clear:both; background-color:#DFECB6">					
					<div style="padding:10px; font-size:10px;">
						<?php echo $ACTIVITAT->getInfoPractica(); ?>
					</div>
				</div>
				<div style="clear:both">&nbsp;</div>													
			</div>
    <?php endif; ?>					                                                                    
    </div>
</div>