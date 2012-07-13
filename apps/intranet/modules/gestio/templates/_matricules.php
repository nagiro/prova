<?php use_helper('Form')?>            
<script>
    $(document).ready(function(){
        $("#matricules_mode_pagament").change(function(){
            if($("#matricules_mode_pagament").val() == '33'){ $("#domiciliacio").show(); }
            else { $("#domiciliacio").hide(); }
        });
    });
</script>    
<div style="margin-top:20px; float:left; background-color:#CCC; color:#555; padding:5px; width:640px; ">PAGAMENT I EXTRES</div>
<div style="margin-top:10px; float:left; clear:both;">
    
    <?php if(!empty($ERROR)): ?>
    
        <div style="float: left; "> <div style="float: left; width:300px;"><b><?php echo $ERROR ?></b></div> </div>
        
    <?php else: ?>
        
        <!-- Si el curs no es ple, o bé es ple amb llista d'espera... -->
        <?php $PAGAMENTS = $OC->getSelectPagaments(true); $ACCEPTA_LLISTA_ESPERA = array_key_exists( TipusPeer::PAGAMENT_LLISTA_ESPERA , $PAGAMENTS ); ?>
        <?php if( $ACCEPTA_LLISTA_ESPERA && $OC->isPle() || !$OC->isPle() ): ?>        
        
            <!-- Preu i descomptes -->
            <div style="float: left; ">
                <div style="float: left; width:150px;"><b>Preu i descomptes: </b></div>
                <div style="float: left;"><?php echo select_tag('matricules[descompte]',options_for_select($RET),array('style'=>'width:300px','id'=>'DESCOMPTES')); ?></div>
            </div>
                                            
            <div id="compra" style="float: left; clear:both; margin-top:5px;">
                <div style="float: left; width:150px;"><b>Tipus de pagament? </b></div>
                <?php if( $OC->isPle() ): ?>
                    <div style="float: left;"><?php echo select_tag( 'matricules[mode_pagament]' , options_for_select( array( TipusPeer::PAGAMENT_LLISTA_ESPERA => $PAGAMENTS[TipusPeer::PAGAMENT_LLISTA_ESPERA] ) ) , array( 'style' => 'width:300px' ) ) ?></div>                                            
                <?php else: ?>
                    <div style="float: left;"><?php echo select_tag( 'matricules[mode_pagament]' , options_for_select( $OC->getSelectPagaments(true) ) , array( 'style' => 'width:300px' ) ) ?></div>
                <?php endif; ?>
            </div>
            <div id="domiciliacio" style="display:none; float: left; clear:both; margin-top:5px;">
                <div style="float: left; width:150px;"><b>Escull compte corrent: </b></div>
                <div style="float: left;">                    
                    <?php echo select_tag(  'matricules[idDadesBancaries]' , options_for_select( DadesBancariesPeer::getSelectBySelect( DadesBancariesPeer::getDadesUsuari($IDU) ) ) , array('style'=>'width:300px')); ?>
                    <?php echo '<br />'.link_to('Crea un compte corrent nou','gestio/gUsuaris?PAGINA=1&id_usuari='.$IDU.'&accio=CCC'); ?>
                </div>
            </div>                            
            
            <!-- Botons -->
            
            <div style="float: left; clear:both; margin-top:30px; ">
                <div style="float: left; width:100px;">&nbsp;</div>
                                                                            
                <div style="float: left;">
                    <button class="BOTO_ACTIVITAT" name="BSAVEMATRICULA">FINALITZA LA MATRICULA</button>
                </div>
                                        
            </div>
        <?php else: ?>
            <div>
                El curs és ple i no hi ha possiblitat de llista d'espera. Si vols matricular la persona activa la llista d'espera o augmenta la capacitat del curs.
            </div>
        <?php endif; ?>
    
    <?php endif; ?>
                                                                                    
</div>