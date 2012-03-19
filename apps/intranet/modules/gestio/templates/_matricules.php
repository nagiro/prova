<?php use_helper('Form')?>                
<div style="margin-top:20px; float:left; background-color:#CCC; color:#555; padding:5px; width:640px; ">PAGAMENT I EXTRES</div>
<div style="margin-top:10px; float:left; clear:both;">
    
    <?php if(!empty($ERROR)): ?>
    
        <div style="float: left; "> <div style="float: left; width:300px;"><b><?php echo $ERROR ?></b></div> </div>
        
    <?php else: ?>
        
        <!-- Preu i descomptes -->                                    
        <div style="float: left; ">
            <div style="float: left; width:150px;"><b>Preu i descomptes: </b></div>
            <div style="float: left;"><?php echo select_tag('matricules[descompte]',options_for_select($RET),array('style'=>'width:300px','id'=>'DESCOMPTES')); ?></div>
        </div>
        
        <?php if($OC->isCompra()): ?>
            <div style="float: left; clear:both; margin-top:5px;">
                <div style="float: left; width:150px;"><b>Com ha pagat? </b></div>
                <div style="float: left;"><?php echo select_tag( 'matricules[mode_pagament]' , options_for_select( MatriculesPeer::selectPagament() ) , array( 'style' => 'width:300px' ) ) ?></div>
            </div>
        <?php elseif( $OC->isDomiciliacio() ): ?>
            <div style="float: left; clear:both; margin-top:5px;">
                <div style="float: left; width:150px;"><b>Escull compte corrent: </b></div>
                <div style="float: left;">                    
                    <?php echo select_tag(  'matricules[idDadesBancaries]' , options_for_select( DadesBancariesPeer::getSelectBySelect( DadesBancariesPeer::getDadesUsuari($IDU) ) ) , array('style'=>'width:300px')); ?>
                    <?php echo '<br />'.link_to('Crea un compte corrent nou','gestio/gUsuaris?PAGINA=1&id_usuari='.$IDU.'&accio=CCC'); ?>
                </div>
            </div>            
        <?php endif; ?>
        
        
        <!-- Botons -->
        
        <div style="float: left; clear:both; margin-top:30px; ">
            <div style="float: left; width:100px;">&nbsp;</div>
                                                            
            <?php                         
                $TEXT_BOTO = "";
                if($OC->isPle()) $TEXT_BOTO = "POSAR EN LLISTA D'ESPERA";
                elseif($OC->isCompra())  $TEXT_BOTO = "PAGA I FINALITZA LA MATRÍCULA";
                elseif($OC->isReserva()) $TEXT_BOTO = "RESERVA LA MATRÍCULA";                    
                elseif($OC->isDomiciliacio()) $TEXT_BOTO = "FES MATRÍCULA";
            ?>
            
            <div style="float: left;">
                <button class="BOTO_ACTIVITAT" name="BSAVEMATRICULA"><?php echo $TEXT_BOTO ?></button>
            </div>
                                    
        </div>
    
    <?php endif; ?>
                                                                                    
</div>