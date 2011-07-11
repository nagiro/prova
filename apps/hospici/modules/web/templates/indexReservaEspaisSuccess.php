<?php use_helper('Form') ?>
<?php use_helper('Presentation') ?>
<?php $BASE = sfConfig::get('sf_webrooturl').'images/hospici'; ?>
 

<?php include_partial('web/showCercadorEspais',array('CERCA'=>$CERCA,'VISIBLE'=>($MODE <> 'DETALL'))); ?>
<?php if(!$MODE == 'INICIAL') include_partial('web/showDestacats'); ?>                
<?php if($MODE == 'DETALL') include_partial('web/showDetallEspai',array('ESPAI'=>$ESPAI)); ?>                
<?php if($MODE == 'CERCA') include_partial('web/showLlistatEspais',array('LLISTAT_ESPAIS'=>$LLISTAT_ESPAIS)); ?>