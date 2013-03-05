<?php use_helper('Form'); 
        
    $OPTIONS_DESCOMPTES = DescomptesPeer::getDescomptesArray( $OP->getSiteId() , false );
    $OPTIONS_PAG_EXTERN = TipusPeer::getTipusPagamentArray();
    $OPTIONS_PAG_INTERN = TipusPeer::getTipusPagamentArray();
          
?>

<form class="FORMULARI" id="FORM_PREU" name="FORM_PREU" action="/gestio/gActivitats" method="post">
    
    <input name="entrades_preus[horari_id]" value="<?php echo $OP->getHorariId() ?>" id="entrades_preus_horari_id" type="hidden" />
    <input name="entrades_preus[activitat_id]" value="<?php echo $OP->getActivitatid() ?>" id="entrades_preus_activitat_id" type="hidden" />
    <input name="entrades_preus[site_id]" value="<?php echo $OP->getSiteid() ?>" id="entrades_preus_site_id" type="hidden" />
    
    <div>
        <div style="float:left;">
            <div style="font-weight:bold">Actiu</div>
            <div >
                <?php echo select_tag('entrades_preus[actiu]', options_for_select(array(0=>'No',1=>'Sí'), $OP->getActiu() ) ); ?>
            </div>
        </div>
        
        <div style="float:left; margin-left:10px;">
            <div style="font-weight:bold">Preu</div>
            <div >
                <?php echo input_tag( 'entrades_preus[Preu]' , $OP->getPreu() , array('style'=>'width:100px;') ); ?>
            </div>
        </div>
        
        <div style="float: left; margin-left: 10px;">
            <div style="font-weight:bold">Places</div>
            <div >
                <?php echo input_tag( 'entrades_preus[Places]' , $OP->getPlaces() , array('style'=>'width:100px;') ); ?>
            </div>
        </div>
            
        <div style="clear: both; float:left; margin-left:10px;  margin-top:10px;">
            <div style="font-weight:bold; margin-bottom:10px;">Pagament Hospici</div>
            <div >
                <?php 
                    foreach($OPTIONS_PAG_EXTERN AS $id=>$P):
                        $SELECTED = explode( '@' , $OP->getPagamentExtern() );                                
                        $CHECK = ( array_search( $id , $SELECTED ) > -1 )?true:false;                        
                        echo checkbox_tag( 'entrades_preus[PagamentExtern][]' , $id , $CHECK , array() ).$P.'<br />';
                    endforeach;
                ?>
            </div>
        </div>
        
        <div style="float: left; margin-left:10px;  margin-top:10px;">
            <div style="font-weight:bold; margin-bottom:10px;">Pagament Intern</div>
            <div >
                <?php 
                    foreach($OPTIONS_PAG_INTERN AS $id=>$P):
                        $SELECTED = explode( '@' , $OP->getPagamentIntern() );
                        $CHECK = ( array_search( $id , $SELECTED ) > -1 )?true:false;
                        echo checkbox_tag('entrades_preus[PagamentIntern][]' , $id , $CHECK , array() ).$P.'<br />';
                    endforeach;
                ?>
            </div>
        </div>
        
        <div style="float:left; margin-top:10px;">
            <div style="font-weight:bold; margin-bottom:10px;">Descomptes</div>
            <div >
                <?php 
                    foreach($OPTIONS_DESCOMPTES AS $id=>$P):
                        $SELECTED = explode( '@' , $OP->getDescomptes() );
                        $CHECK = ( array_search( $id , $SELECTED ) > -1 )?true:false;
                        echo checkbox_tag('entrades_preus[Descomptes][]' , $id , $CHECK , array() ).$P.'<br />';
                    endforeach;
                ?>
            </div>
        </div>
        
    </div>        
                                        
</form>