<?php use_helper('Form') ?>
<?php use_helper('Presentation') ?>
 

<?php if($MODE == 'CERCA' || $MODE == 'INICIAL') include_partial('web/showCercadorActivitats',array('CERCA'=>$CERCA,'VISIBLE'=>($MODE <> 'DETALL'),'DESPLEGABLES'=>$DESPLEGABLES)); ?>
<?php if(!$MODE == 'INICIAL') include_partial('web/showDestacats'); ?>                
<?php if($MODE == 'DETALL') include_partial('web/showDetallActivitat',array('ACTIVITAT'=>$ACTIVITAT, 'HORARIS_AMB_ENTRADES' => $HORARIS_AMB_ENTRADES, 'AUTENTIFICAT'=>$AUTENTIFICAT, 'HORARIS' => $HORARIS)); ?>                
<?php if($MODE == 'CERCA') include_partial('web/showLlistatActivitats',array('LLISTAT_ACTIVITATS'=>$LLISTAT_ACTIVITATS, 'ACTIVITATS_AMB_ENTRADES' => $ACTIVITATS_AMB_ENTRADES, 'AUTENTIFICAT'=>$AUTENTIFICAT, 'CERCA' => $CERCA)); ?>    