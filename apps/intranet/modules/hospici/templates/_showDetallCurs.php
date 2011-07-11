<div class="h_requadre_resultats">
    <div class="h_subtitle_gray c1">
        L'HOSPICI...
    </div>

    <div>
        
    <?php if($CURS instanceof Cursos):
            
            //Carrego el Site
            $OS = SitesPeer::retrieveByPK($CURS->getSiteId());
            
            $imatge = '/images/sites/'.$OS->getLogourl();
            if($OS->getLogourl() == "") $imatge = "/images/hospici/hospici100_100.jpg";            
                                                    
            //Si l'entitat té imatge, l'hauríem de carregar, sinó la de l'hospici.                                              
            if(empty($pdf)) $pdf = 0;             
    ?>
			<div style="border:0px solid #96BF0D; clear:both; padding:10px;">
				<div style="font-size:11px"><b><?php echo $CURS->getTitolcurs() ?></b></div>
				<div style="font-size:10px"><?php // echo generaHoraris($ACTIVITAT->getHorarisOrdenats(HorarisPeer::DIA)); ?></div>
				<div style="height:30px;">&nbsp;</div>				
										
				<div style="width:150px; float:left">                    
					<div><img width="150px" src="<?php echo $imatge ?>" style="vertical-align:middle" /></div>
                        
						<div style="margin-top:20px; font-size:10px">
                            <div class="requadre_mini" style="background-color:#A2844A;">
                                <a href="javascript:history.back()">< Torna al llistat de cursos</a>
                            </div>
                        </div>
                        
                        <?php if($pdf > 0): ?>
                            <div class="pdf_cicle" style="margin-top: 5px;">
                                <div class="requadre_mini" style="background-color: #D4A261;">
                                    <a href="/images/cursos/<?php echo $pdf ?>">Baixa't el pdf del curs</a>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if( isset($AUTH) && $AUTH > 0 ): ?>
                            <?php if($CURS->getIsEntrada()): ?>
                                <?php if(!isset($CURSOS_MATRICULATS[$CURS->getIdcursos()])): ?>
                                        <div style="margin-top: 5px;">
                                            <div class="requadre_mini" style="background-color: #FFCC00;">
                                                <a href="<?php echo url_for('@hospici_nova_matricula?idC='.$CURS->getIdcursos()); ?>">MATRICULA'T</a>
                                            </div>
                                        </div>                                        
                                <?php else: ?>
                                        <div style="margin-top: 5px;">
                                            <div class="requadre_mini" style="background-color: #29A729; color:white;">
                                                Ja estàs matriculat
                                            </div>
                                        </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div style="margin-top: 5px;">
                                    <div class="requadre_mini" style="background-color: #FF0000;">
                                        <a href="images/cursos/<?php echo $pdf ?>">Matrícula tancada</a>
                                    </div>
                                </div>                            
                            <?php endif; ?>
                        <?php else: ?>
                            <div style="margin-top: 5px">
                                <div class="requadre_mini" style="background-color: #FFCC00;">
                                    <a href="javascript:alert('Per poder matricular-se, primer ha d\'entrar al seu compte d\'usuari i tornar a buscar aquest curs.');">Autentifica't i matricula't</a>
                                </div>
                            </div>
                        <?php endif; ?>                        
                        
                    <div style="margin-top:20px;">
                        <?php echo ph_getAddThisDiv(); ?>
                    </div>
				</div>
                                
				<div style="width:330px; float:left;">
					<div style="padding-left:10px; font-size:10px;">
						<?php echo $CURS->getDescripcio() ?>
					</div>					
				</div>
				                                                
                <!-- Fi Requadre de compra o reserva d'entrades  -->													
			</div>
    <?php endif; ?>					                                                                    
    </div>
</div>