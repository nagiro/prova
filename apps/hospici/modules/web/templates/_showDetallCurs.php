<div class="h_requadre_resultats">
    <div class="h_subtitle_gray c1">
        L'HOSPICI...
    </div>

    <div>
        
    <?php
     
    if($CURS instanceof Cursos)
    {
            
            //Carrego els identificadors bàsics
            $AUTEN = (isset($AUTH) && $AUTH > 0);
            
            $TNReserva =  ($CURS->getIsEntrada() == CursosPeer::HOSPICI_NO_RESERVA);
            $TReserva  =  ($CURS->getIsEntrada() == CursosPeer::HOSPICI_RESERVA);
            $TReservaT =  ($CURS->getIsEntrada() == CursosPeer::HOSPICI_RESERVA_TARGETA);
            $datai     =  $CURS->getDatainmatricula('U');
            
            $JaMat = (isset($CURSOS_MATRICULATS[$CURS->getIdcursos()]));
            $url = url_for('@hospici_detall_curs?idC='.$CURS->getIdcursos().'&titol='.$CURS->getNomForUrl());                        
                        
            //Carrego la imatge del site
            $imatge = SitesPeer::getSiteLogo($CURS->getSiteId());
                                                               
            //Si l'entitat té un pdf, l'hauríem de carregar.                                               
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
                        
                        <!-- Inici del marcador de curs -->
                        <div style="margin-top: 5px; margin-bottom:5px;">
                            <?php echo ph_getEtiquetaCursos($AUTEN, $JaMat, $TReserva, $TReservaT, $TNReserva, $url, $CURS->getSiteId(), $datai); ?>                                                                                                                                                    
                        </div>
                        <!-- Fi del marcador de curs -->  
                      
                    <div style="margin-top:20px;">
                        <?php echo ph_getAddThisDiv(); ?>
                    </div>
                    
				</div>
                                
				<div style="width:400px; float:left;">
					<div style="padding-left:50px; font-size:10px;">                                                           
						<?php echo $CURS->getDescripcio() ?>

                        <!-- Requadre de compra o reserva d'entrades  -->
                        
                        <div id="matricula" style="margin-top:30px;">                        
               				<div style="clear:both; color:#96BF0D; font-size:12px; padding-left:10px;">MATRICULA'T</div> 
            				<div style="clear:both; background-color:#DFECB6">					
            					<div style="padding:10px; font-size:10px;">
            
                                    <?php
                                                                                                                                                              
                                        //Fem visible les reserves si estem autentificats, i podem reservar o matricular-nos.
                                        if(isset($AUTH) && $AUTH > 0 && ( $TReserva || $TReservaT ) && (time() >= $datai) ){
                                                                                                                                        
                                            echo '<form method="post" action="'.url_for('@hospici_nova_matricula').'">';                                            
                                            
                                            //Guardem el codi del curs                                                               	                                                                                                         
                                            echo input_hidden_tag('idC',$CURS->getIdcursos());
                                            
                                    ?>
                                            <div class="taula_dades">
                                                <div style="padding-top:10px;">
                                                    <div style="float: left; width:120px;"><b>Pagament:</b></div>                                            
                                                    <div style="float: left;">
                                                    <?php
                                                        if($TReserva) echo 'Només reserva <span class="tipMy tip" title="A través del portal es fa la reserva de plaça, a cost 0, i posteriorment l\'entitat organitzadora es posarà en contacte amb vostè per finalitzar la matrícula.">?</span>';
                                                        elseif($TReservaT) echo 'Targeta de crèdit <span class="tipMy tip" title="A través del portal realitzarà i pagarà la matrícula del curs.">?</span>';
                                                    ?>
                                                    </div>
                                                </div>
                                                <div style="padding-top:5px; clear:both;">
                                                    <div style="float: left; width:120px;"><b>Descompte: </b></div>
                                                    <div style="float: left;">
                                                    <?php 
                                                        
                                                        $A_Descomptes = $CURS->h_getDescomptes();
                                                        //Si hi ha descompte al curs, el mostrem
                                                        if(empty($A_Descomptes)) echo 'Cap descompte disponible <span class="tipMy tip" title="Aquest curs té un preu únic.">?</span>';
                                                        else echo select_tag('idD',options_for_select($A_Descomptes,1)).' <span class="tipMy tip" title="Esculli, si s\'escau, el descompte que s\'adeqüi a la seva situació. Aquest haurà de ser demostrat a l\'entitat organitzadora a l\'inici de les classes.">?</span>';
                                                        
                                                    ?>
                                                    </div>
                                                </div>
                                                <div style="padding-top:5px; clear:both;">
                                                    <div style="float: left; width:120px;"><b>Preu: </b></div>
                                                    <div style="float: left;">
                                                    <?php
                                                      
                                                        //Si no hi ha descompte, no ensenyem el preu reduit.
                                                        if(empty($A_Descomptes)) echo "{$CURS->getPreu()} € <span class=\"tipMy tip\" title=\"Preu del curs que haurà d'abonar quan inici el curs o bé tot seguit si el pagament és amb targeta de crèdit.\">?</span>";
                                                        else echo "Estàndard: {$CURS->getPreu()} € / Reduït: {$CURS->getPreur()} € <span class=\"tipMy tip\" title=\"Preu del curs que haurà d'abonar quan l\'entitat organitzadora li reclami o bé tot seguit si el pagament és amb targeta de crèdit.\">?</span>";
                                                        
                                                    ?>
                                                    </div>
                                                </div>
                                                <div style="padding-top:10px; clear:both;">
                                                    <?php 
                                                         
                                                        if($TReserva) echo '<div style="margin-left:220px;"><input style="width: 100px;" type="submit" value="Reserva plaça!" /></div>';
                                                        elseif($TReservaT) echo '<div style="margin-left:220px;"><input style="width: 100px;" type="submit" value="Matricula\'m" /></div>';
                                                                                                                    
                                                    ?>
                                                </div>
                                            </div>
                                    <?php } else {
                                                                                 
                                            if($JaMat){
                                                $OS = SitesPeer::retrieveByPK($CURS->getSiteId());
                                                $tel = $OS->getTelefonString();
                                                $email = $OS->getEmailString();
                                                $nom = $OS->getNom();
                                                echo '<div>Vostè ja ha realitzat una reserva o matrícula a aquest curs.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b></div>';
                                            } elseif($TNReserva){
                                                $OS = SitesPeer::retrieveByPK($CURS->getSiteId());
                                                $tel = $OS->getTelefonString();
                                                $email = $OS->getEmailString();
                                                $nom = $OS->getNom();
                                                echo '<div>Aquest curs no disposa de matrícula en línia.<br /><br /> Per poder-s\'hi matricular, ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al telèfon <b>'.$tel.'</b>.<br /><br />Disculpi les molèsties</div>';
                                            } elseif(time() < $datai) {
                                                $OS = SitesPeer::retrieveByPK($CURS->getSiteId());
                                                $tel = $OS->getTelefonString();
                                                $email = $OS->getEmailString();
                                                $nom = $OS->getNom();
                                                echo '<div>Vostè podrà matricular-se a aquest curs per internet a partir del dia '.date('d/m/Y',$datai).'.<br /><br /> Per a més informació pot posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b></div>';                                                                                            
                                            } else {
                                                echo '<div>Per poder matricular-vos d\'un curs heu d\'autentificar-vos clicant <a href="#" class="auth" url="'.$url.'" >aquí</a>.</div>';
                                            }
                                         }
                                    ?>
            				    </div>
                            </div>
                        </div>
                        
                        <!-- Fi Requadre de compra o reserva d'entrades  -->													
                        
					</div>					
				</div>
				                                                
                <!-- Fi Requadre de compra o reserva d'entrades  -->													
			</div>
    <?php } ?>    					                                                                    
    </div>
</div>