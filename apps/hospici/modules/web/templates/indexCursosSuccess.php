<?php use_helper('Form') ?>
<?php use_helper('Presentation') ?>
 

<?php if($MODE  == 'CERCA')   include_partial('web/showCercadorCursos',array('CERCA'=>$CERCA,'VISIBLE'=>($MODE <> 'DETALL'),'DESPLEGABLES'=>$DESPLEGABLES)); ?>
<?php if(!$MODE == 'INICIAL') include_partial('web/showDestacats'); ?>                
<?php if($MODE  == 'DETALL')  include_partial('web/showDetallCurs',array('CURSOS_MATRICULATS' => $CURSOS_MATRICULATS , 'CURS'=>$CURS , 'AUTH'=>$AUTH, 'MISSATGE' => $MISSATGE, 'IDU' => $IDU )); ?>                
<?php if($MODE  == 'CERCA')   include_partial('web/showLlistatCursos',array('CURSOS_MATRICULATS' => $CURSOS_MATRICULATS, 'LLISTAT_CURSOS'=>$LLISTAT_CURSOS,"AUTH"=>$AUTH)); ?>    