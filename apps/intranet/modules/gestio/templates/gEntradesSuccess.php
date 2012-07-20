<?php use_helper('Form'); ?>

<?php $BASE = OptionsPeer::getString('SF_WEBROOT',$IDS); ?>
<script type="text/javascript" src="<?php echo $BASE.'js/jquery.autocompleter.js'; ?>"></script>

<style>
    .row_title { width:100px; }
    .row_field { width:300px; }
</style>

<script>
    
    $(document).ready(function(){
        if($('#entrades_reserva_nom_reserva').val().length == 0 ){
            $('#entrades_reserva_email_reserva').hide(); $('[for="entrades_reserva_email_reserva"]').hide();
            $('#entrades_reserva_telefon_reserva').hide(); $('[for="entrades_reserva_telefon_reserva"]').hide();
        }
                        
        $('#entrades_reserva_nom_reserva').blur(function(){
            
            if($('#entrades_reserva_nom_reserva').val().length == 0 ){
                $('#entrades_reserva_email_reserva').hide(); $('[for="entrades_reserva_email_reserva"]').hide();
                $('#entrades_reserva_telefon_reserva').hide(); $('[for="entrades_reserva_telefon_reserva"]').hide();
            } else { 
                $('#entrades_reserva_email_reserva').show(); $('[for="entrades_reserva_email_reserva"]').show();
                $('#entrades_reserva_telefon_reserva').show(); $('[for="entrades_reserva_telefon_reserva"]').show();
            }
        }); 
    });

</script>
 
 <td colspan="3" class="CONTINGUT_ADMIN">
    
    <?php 
        
        //Inicialitzem el missatge per si de cas
        if(!isset($MISSATGE)) $MISSATGE = "";
        
        include_partial('breadcumb',array('text'=>'RESERVES D\'ENTRADES'));
    
        if($MODE == 'LLISTA_ACTIVITATS') Entrades_LlistaActivitats( $LLISTAT_ENTRADES_PREUS , $P );        
        elseif($MODE == 'LLISTA_ENTRADES') Entrades_LlistaEntrades( $LLISTAT_ENTRADES , $P );
        elseif($MODE == 'EDITA_ENTRADA') Entrades_EditaReserva( $FReserva , $MISSATGE );
        elseif($MODE == 'MISSATGE') Entrades_Missatge( $MISSATGE , $idER );                                    
    
    ?>
               
    <div style="height:40px;"></div>
                
 </td>
    
    
    
<?php function Entrades_Missatge($MISSATGE,$idER){ ?>

    <div class="REQUADRE">        
    
        <?php 
        
            switch($MISSATGE){
                case 'ENTRADA_OK':
                        echo 'Entrada venuda correctament.<br />Per imprimir-la, clica '.link_to('aquí','gestio/gEntrades?accio=PRINT&idER='.$idER).'.';
                    break;
                case 'ENTRADA_METALIC':
                        echo 'Entrada venuda correctament. Recordeu que l\'entrada encara s\'ha de pagar i cal fer-ho abans d\'una setmana. En cas contrari, s\'anul·larà la reserva.<br />Per imprimir-la, clica '.link_to('aquí','gestio/gEntrades?accio=PRINT&idER='.$idER).'.';
                    break;
                case 'ENTRADA_LLISTA_ESPERA':
                            echo 'Usuari afegit a la llista d\'espera.<br />Si hi ha alguna baixa se l\'avisarà.';
                        break;    
                case 'ENTRADA_DOMICILIACIO':
                            echo 'Entrada venuda correctament.<br />Per imprimir-la, clica '.link_to('aquí','gestio/gEntrades?accio=PRINT&idER='.$idER).'.';
                        break;                                    
                case 'ENTRADA_NO_TROBADA':
                        echo 'Hi ha hagut algun problema. No he trobat l\'entrada.';
                    break;
                case 'PROBLEMA_PAGANT':
                        echo 'Hi ha hagut algun problema fent el pagament.';
                    break; 
            }            
            
        ?>    
        
  	</div>

<?php } ?>
    
<?php function Entrades_LlistaActivitats( $LEP , $P ){ ?>
  	        
        <div class="REQUADRE">
        <div class="TITOL">Activitats amb reserva d'entrades</div>
        <div class="DADIV">
            <div class="titol" style=" width:290px; "> Nom activitat </div> 
            <div class="titol" style=" text-align:right; width:100px; ">Data</div>
            <div class="titol" style=" text-align:right; width:75px; ">Hora</div>
            <div class="titol" style=" text-align:right; width:75px; ">Entrades</div>            
            <div class="titol" style=" text-align:right; width:60px; ">Llistat</div>            
            
            <?php if( $LEP->getNbResults() == 0 ){ ?>
                                 
                <div>No hi ha cap més activitat amb reserva per internet.</div>
                                    
            <?php } else { ?>
                                
                <?php foreach($LEP->getResults() as $OEP ): ?>
                    
                    <?php $OA = $OEP->getActivitat(); ?>
                    <?php $OH = $OEP->getHorari(); ?>                    
                                                                                                              
                    <?php $EntradesVenudes = $OEP->countEntradesVenudes(); //Mirem quantes places lliures hi ha ?>
                                                                                                             
                    <div style="border-bottom: 1px solid #CCCCCC;">                                                                                
                        <div class="colo" style="width:290px;">
                            <?php echo link_to( $OA->getNom() , 'gestio/gActivitats?accio=ACTIVITAT&IDA='.$OA->getActivitatid() ) ?>
                        </div>                        
                        <div class="colo" style="text-align:right; width:100px;"><?php echo $OH->getDia('d/m/Y') ?></div>                                    
                        <div class="colo" style="text-align:right; width:75px;"><?php echo $OH->getHorainici('H:i') ?></div>
                        <div class="colo" style="text-align:right; width:75px;"><?php echo $EntradesVenudes.'/'.$OEP->getPlaces() ?></div>
                        <div class="colo" style="text-align:right; width:60px;">
                            <?php echo link_to(image_tag('template/user.png',array('style'=>'height:13px;')).'<span>Llistat de persones que han fet una reserva.</span>','gestio/gEntrades?accio=LR&IDH='.$OH->getHorarisId().'&IDA='.$OA->getActivitatid() , array('class'=>'tt2') ) ?>
                            <?php echo link_to(image_tag('template/money.png',array('style'=>'height:13px;')).'<span>Vendre o reservar una entrada.</span>','gestio/gEntrades?accio=VE&IDH='.$OH->getHorarisId().'&IDA='.$OA->getActivitatid(),  array('class'=>'tt2') ) ?>
                            <?php echo link_to(image_tag('template/printer.png',array('style'=>'height:13px;')).'<span>Treu llistat d\'assistents a una activitat. </span>','gestio/gEntrades?accio=PRINT_LLISTAT&IDH='.$OH->getHorarisId().'&IDA='.$OA->getActivitatid(),  array('class'=>'tt2','target'=>'_BLANK') ) ?>
                        </div>
                        
                        <div style="clear: both;"></div>                                                                                
                    </div>
                
                                                                                                                                                                    
                <?php endforeach; ?>
            <?php } ?>
                        
        </div>
        <div style="clear: both;">&nbsp;</div>  		                 
        
  	</div>
    
<?php } ?>
    
            
<?php function Entrades_LlistaEntrades( $LLISTAT_ENTRADES , $P ){ ?>

    <style>
        .col1 { float:left; width:350px; clear:both; }
        .col2 { float:left; width:100px; }
        .col3 { float:left; width:80px; }
        .col4 { float:left; width:100px; }        
        .titolb { background-color: rgb(204, 204, 204); font-weight:bold; padding-top:4px; padding-bottom:4px; }                
    </style>

        <div class="REQUADRE">
        <div class="TITOL">Entrades venudes per a una activitat</div>
        <div class="DADIV">
            <div class="titolb col1 no_pad">Nom</div>             
            <div class="titolb col2 no_pad">Estat</div>            
            <div class="titolb col3 no_pad">#Reser.</div>
            <div class="titolb col4 no_pad">Accions</div>
            <?php 
                
                if( sizeof($LLISTAT_ENTRADES) == 0 ){ 
                    
                    echo '<div style="clear:both">No hi ha cap reserva a aquesta activitat.</div>';
                    
                } else {
                    $total = 0;
                    foreach($LLISTAT_ENTRADES as $OR):
                                                
                        try{
                            $OU = UsuarisPeer::retrieveByPK($OR->getUsuariId());
                            echo '<div class="col">';
                                if($OU instanceof Usuaris) echo '<div class="col1" style="clear:both;"><b>'.$OU->getNomComplet().'</b> ('.$OU->getDni().')<br />Comentari: '.$OR->getComentari().'<br />'.$OU->getEmail().'<br />'.$OU->getTelefonString().'</div>';
                                else echo '<div class="col1" style="clear:both;"><b>'.$OR->getNomUsuari().'</b><br />Comentari: '.$OR->getComentari().'<br />'.$OR->getEmailReserva().'<br />'.$OR->getTelefonReserva().'</div>';                                                        
                                                                                                                    
                                echo '<div class="col2">'.$OR->getEstatString().'</div>';
                                echo '<div class="col3"><b>'.$OR->getQuantitat().'</b></div>';                            
                                echo '<div class="col4">'.
                                        link_to(image_tag('template/application_edit.png').'<span>Modificar la reserva</span>','gestio/gEntrades?accio=VE&IDA='.$OR->getEntradesPreusActivitatId().'&IDH='.$OR->getEntradesPreusHorariId().'&IDR='.$OR->getIdentrada(),array('class'=>'tt2')).' '.
                                        link_to(image_tag('template/cross.png').'<span>Anul·lar la reserva</span>','gestio/gEntrades?accio=AR&IDR='.$OR->getIdentrada(),array('class'=>'tt2')).' '.                                                                        
                                        link_to(image_tag('template/printer.png').'<span>Imprimir una entrada</span>','gestio/gEntrades?accio=PRINT&idER='.$OR->getIdentrada(),array('class'=>'tt2')).' '
                                    .'</div>';
                            echo '</div>';
                            $total += $OR->getQuantitat();
                        } catch(Exception $e) { echo $e->getMessage(); }                        
                        
                    endforeach;
                    echo '<div class="col">';
                            echo '<div class="col1"><b>TOTAL</b></div>';
                            echo '<div class="col2">&nbsp;</div>';
                            echo '<div class="col3"><b>'.$total.'</b></div>';                            
                            echo '<div class="col4">&nbsp;</div>';
                    echo '</div>';
                }
            ?>
            
        </div>
        <div style="clear: both;">&nbsp;</div>  		                         
  	</div>
        
<?php } ?>                                    

<?php function Entrades_EditaReserva( $FReserva , $MISSATGE ){ ?>
  	
        <div class="REQUADRE">
        <div class="TITOL">Activitats amb reserva o compra d'entrades</div>
        
        <form action="<?php echo url_for('gestio/gEntrades?accio=VE') ?>" method="POST">
        
            <div class="DADES">
            <?php if(isset($MISSATGE) && !empty($MISSATGE)) echo '<div class="error" style="padding: 10px; background-color:yellow; margin-bottom: 10px;">'.$MISSATGE.'</div>'; ?>       
                <?php echo $FReserva ?>            
            </div>
            
            <div style="clear: both; float:left;">
                <button type="submit" name="BRESERVASAVE" class="BOTO_ACTIVITAT">
                    <?php echo image_tag('template/disk.png').' Guarda ' ?>
            	</button>                       
            </div>
            
            <div style="clear: both;">&nbsp;</div>
            
        </form>
  		                 
  	</div>
    
<?php } ?>        