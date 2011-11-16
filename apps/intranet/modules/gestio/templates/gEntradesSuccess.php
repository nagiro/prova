<?php use_helper('Form'); ?>
<style>
    .row_title { width:100px; }
    .row_field { width:300px; }
</style>
 
 <td colspan="3" class="CONTINGUT_ADMIN">
    
    <?php 
    
        include_partial('breadcumb',array('text'=>'RESERVES D\'ENTRADES'));
    
        if($MODE == 'LLISTA_ACTIVITATS') Entrades_LlistaActivitats( $LLISTAT_ACTIVITATS , $P );        
        elseif($MODE == 'LLISTA_ENTRADES') Entrades_LlistaEntrades( $LLISTAT_ENTRADES , $P );
        elseif($MODE == 'EDITA_ENTRADA') Entrades_EditaReserva( $FReserva );                                    
    
    ?>
               
    <div style="height:40px;"></div>
                
 </td>
    
    
    
    
<?php function Entrades_LlistaActivitats( $LLISTAT_ACTIVITATS , $P ){ ?>
  	
        <div class="REQUADRE">
        <div class="TITOL">Activitats amb reserva d'entrades</div>
        <div class="DADIV">
            <div class="titol" style=" width:310px; "> Nom activitat </div> 
            <div class="titol" style=" text-align:right; width:100px; ">Data</div>
            <div class="titol" style=" text-align:right; width:75px; ">Hora</div>
            <div class="titol" style=" text-align:right; width:75px; ">Entrades</div>            
            <div class="titol" style=" text-align:right; width:50px; ">Llistat</div>
            
            <?php if( sizeof($LLISTAT_ACTIVITATS) == 0 ){ ?>
                                 
                <div>No hi ha cap més activitat amb reserva per internet.</div>
                                    
            <?php } else { ?>
                                
                <?php foreach($LLISTAT_ACTIVITATS as $idA => $D ): ?>
                
                    <?php try{ ?>
                                                                            
                        <?php $NE = EntradesReservaPeer::countEntradesActivitatConf($idA); ?>                            
                        <?php $L_HORARIS = EntradesPreusPeer::getEntradesHorarisByActivitat($idA); ?>
                        <?php if(empty($L_HORARIS)): ?>
                            <div style="border-bottom: 1px solid #CCCCCC;">                                                                                
                                <div class="colo" style="width:250px;"><?php echo link_to($D['nom'],'gestio/gActivitats?accio=ACTIVITAT&IDA='.$idA) ?></div>
                                <div class="colo" style="text-align:right; width:100px;"><?php echo $D['dia'] ?></div>
                                <div class="colo" style="text-align:right; width:75px;"><?php echo $D['hora'] ?></div>
                                <div class="colo" style="text-align:right; width:75px;"><?php echo $NE.'/'.$D['places'] ?></div>
                                <div class="colo" style="text-align:right; width:50px;"></div>
                                <div style="clear: both;">&nbsp;</div>
                            </div>
                        <?php else : ?>
                            <div style="border-bottom: 1px solid #CCCCCC;">                                                                                
                                <div class="colo" style="width:290px;"><?php echo link_to($D['nom'],'gestio/gActivitats?accio=ACTIVITAT&IDA='.$idA) ?></div>
                                <div class="colo">                                
                                <?php foreach($L_HORARIS as $OH): ?>                                                                                                        
                                    <?php $OEP = EntradesPreusPeer::retrieveByPK($OH->getHorarisId(), $idA);  ?>                                                                        
                                    <?php $NE = $OEP->countEntradesVenudes();  ?>                                    
                                    <div class="colo" style="text-align:right; width:100px;"><?php echo $OH->getDia('d/m/Y') ?></div>                                    
                                    <div class="colo" style="text-align:right; width:75px;"><?php echo $OH->getHorainici('H:i') ?></div>
                                    <div class="colo" style="text-align:right; width:75px;"><?php echo $NE.'/'.$OEP->getPlaces() ?></div>
                                    <div class="colo" style="text-align:right; width:50px;"><?php echo link_to(image_tag('template/user.png',array('style'=>'height:13px;')).'<span>Llistat de persones que han fet una reserva.</span>','gestio/gEntrades?accio=LR&IDA='.$idA , array('class'=>'tt2') ) ?></div>
                                    <div class="colo" style="text-align:right; width:50px;"><?php echo link_to(image_tag('template/user.png',array('style'=>'height:13px;')).'<span>Vendre o reservar una entrada.</span>','gestio/gEntrades?accio=VE&IDH='.$OH->getHorarisId().'&IDA='.$idA , array('class'=>'tt2') ) ?></div>
                                    <div style="clear: both;"></div>                                    
                                <?php endforeach; ?>
                                </div>
                            </div>
                                                                                
                        <?php endif; ?>
                                                    
                    <?php } catch(Exception $e) { echo $e; } ?>
                <?php endforeach; ?>
            <?php } ?>
                        
        </div>
        <div style="clear: both;">&nbsp;</div>
  		         
        <?php
        	
    		if($P > 1) echo link_to('<-- Veure activitats anteriors', 'gestio/gEntrades?P='.($P-1));
            if(sizeof($LLISTAT_ACTIVITATS) == 20):                
    			echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                if(sizeof($LLISTAT_ACTIVITATS) > 0) echo link_to('Veure activitats següents -->', 'gestio/gEntrades?P='.($P+1));  
            endif;
		 
		?>
        
  	</div>
    
<?php } ?>
    
            
<?php function Entrades_LlistaEntrades( $LLISTAT_ENTRADES , $P ){ ?>

        <div class="REQUADRE">
        <div class="TITOL">Activitats amb reserva d'entrades</div>
        <div class="DADIV">
            <div class="titol" style=" width:350px; "> Nom </div>             
            <div class="titol" style=" width:100px; "> Estat </div>            
            <div class="titol" style=" width:50px; "> #Reser. </div>
            <div class="titol" style=" width:100px; "> Accions </div>
            <?php 
                
                if( sizeof($LLISTAT_ENTRADES) == 0 ){ 
                    
                    echo '<div style="clear:both">No hi ha cap reserva a aquesta activitat.</div>';
                    
                } else {
                    $total = 0;
                    foreach($LLISTAT_ENTRADES as $OR):                        
                        try{
                            $OU = UsuarisPeer::retrieveByPK($OR->getUsuariId());                            
                                                                                
                            echo '<div class="col" style="width:350px; height:45px; clear:both;"><b>'.$OU->getNomComplet().'</b> ('.$OU->getDni().')<br />'.$OU->getEmail().'<br />'.$OU->getTelefonString().'</div>';
                            echo '<div class="col" style="width:100px; height:45px;">'.$OR->getEstatString().'</div>';
                            echo '<div class="col" style="width:50px; height:45px;"><b>'.$OR->getQuantes().'</b></div>';                            
                            echo '<div class="col" style="width:100px; height:45px;">'.
                                    link_to(image_tag('template/application_edit.png').'<span>Modificar la reserva</span>','gestio/gEntrades?accio=ER&IDR='.$OR->getEntradesReservaId(),array('class'=>'tt2')).' '.
                                    link_to(image_tag('template/cross.png').'<span>Anul·lar la reserva</span>','gestio/gEntrades?accio=AR&IDR='.$OR->getEntradesReservaId(),array('class'=>'tt2')).' '                                                                        
                                .'</div>';
                            $total += $OR->getQuantes();
                        } catch(Exception $e) { var_dump($e); }                        
                    endforeach;
                    echo '<div class="col" style="width:350px; clear:both;"><b>TOTAL</b></div>';
                            echo '<div class="col" style="width:100px;">&nbsp;</div>';
                            echo '<div class="col" style="width:50px;"><b>'.$total.'</b></div>';                            
                            echo '<div class="col" style="width:100px;">&nbsp;</div>';
                }
            ?>
            
        </div>
        <div style="clear: both;">&nbsp;</div>  		                         
  	</div>
        
<?php } ?>                                    

<?php function Entrades_EditaReserva( $FReserva ){ ?>
  	
        <div class="REQUADRE">
        <div class="TITOL">Activitats amb reserva d'entrades</div>
        <div class="DADIV">            
            <?php echo $FReserva->Render(); ?>
        </div>
        <div style="clear: both; float:left;">
            <button type="submit" name="BRESERVASAVE" class="BOTO_ACTIVITAT">
                <?php echo image_tag('template/disk.png').' Guarda ' ?>
        	</button>
            <?php //echo link_to('Tornar','gestio/gEntrades?accio=LR&IDA='.$FReserva->getObject()->getActivitatsid()); ?>       
        </div>
        <div style="clear: both;">&nbsp;</div>
  		                 
  	</div>
    
<?php } ?>        