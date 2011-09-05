<?php use_helper('Form') ?>
<?php use_helper('Presentation') ?>
<?php $BASE = sfConfig::get('sf_webrooturl').'images/hospici'; ?> 

<?php if($MODE == 'CERCA') include_partial('web/showCercadorFormularis',array('CERCA'=>$CERCA,'VISIBLE'=>($MODE <> 'DETALL'),'DESPLEGABLES'=>$DESPLEGABLES)); ?>                
<?php if($MODE == 'DETALL') include_partial('web/showDetallFormularis',array('FORM'=>$FORM , 'AUTH'=>$AUTH)); ?>                
<?php if($MODE == 'CERCA') include_partial('web/showLlistatFormularis',array('LLISTAT_FORMS'=>$LLISTAT_FORMS,'AUTH'=>$AUTH)); ?>