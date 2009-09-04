<?php use_helper('Form')?>
<style>
.LEGEND { font-size:12px; font-weight:bold; padding:10px 10px 10px 10px; }
FIELDSET { border:1px solid #CCCCCC; padding:10px; margin-right:40px; }
.TITOL_CATEGORIA { background-color: #FFF4F4; color:black; font-weight:bold; padding:5px; font-size:10px; }
.TITOL { padding:5px; }
.LINIA { padding:4px; }
#MATRICULACIO { font-size:10px; } 
#VULLMATRICULARME {  }
</style>

<TD colspan="3" class="CONTINGUT">

   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Cursos disponibles</LEGEND>   
   <TABLE class="DADES">
           <TR>
        	<TD class="TITOL">Codi</TD>
        	<TD class="TITOL">Títol</TD>
        	<TD class="TITOL">Preu</TD>
        	<TD class="TITOL">Data d'inici</TD>
        	<TD class="TITOL">Places</TD>
        </TR>

   <?php $CAT_ANT = ""; ?>   
   <?php foreach(CursosPeer::getCursos()->getResults() as $C): ?>                      
   <?php    if($CAT_ANT <> $C->getCategoria()): ?>
   <?php       $PLACES = CursosPeer::getPlaces($C->getIdcursos()); ?>
			<TR><TD colspan="5" class="TITOL_CATEGORIA"><?php echo $C->getCategoria()?></TD></TR>
   <?php    endif; ?>
                       	
   		<TR>
      		<TD class="LINIA"><?php echo $C->getCodi()?></TD>
      		<TD class="LINIA"><?php echo $C->getTitolcurs()?> ( <?php echo $C->getHoraris()?> ) </TD>
      		<TD class="LINIA"><?php echo $C->getPreu()?></TD>      							
      		<TD class="LINIA"><?php echo $C->getDatainici('d-m-Y')?></TD>
      		<TD class="LINIA"><?php echo $PLACES['OCUPADES'].'/'.$PLACES['TOTAL']?></TD>
      	</TR>                		                 										
   <?php $CAT_ANT = $C->getCategoria(); ?>			   
   <?php endforeach; ?>                              
   </TABLE>         
   </FIELDSET>

	<FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Matricula't</LEGEND>
		<form method="post" action="<?php echo url_for('web/matriculat') ?>">         
		   <TABLE class="DADES">
		   	<TR><TD>Per matricular-se, vostè ha de ser usuari registrat del web de la Casa de Cultura. Si no n'és cliqui a "Sóc un nou usuari"</TD></TR>
		   	<TR><TD><?php echo submit_tag('Sóc un nou usuari',array('name'=>'BNOUALUMNE')); echo submit_tag('Sóc usuari registrat',array('name'=>'BREGISTRAT'))?></TD></TR>           
		   </TABLE>         
		</form>
   </FIELDSET>
   
   
	<DIV id="VULLMATRICULARME"></DIV>

   <DIV id="MATRICULACIO"> </DIV>
   
   <DIV STYLE="height:40px;"></DIV>
   
</TD>