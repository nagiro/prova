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

   <FIELDSET><LEGEND class="LEGEND">Cursos disponibles</LEGEND>   
   <TABLE class="DADES">
           <TR>
        	<TD class="TITOL">Codi</TD>
        	<TD class="TITOL">Títol</TD>
        	<TD class="TITOL">Preu</TD>
        	<TD class="TITOL">Data d'inici</TD>
        	<TD class="TITOL">Places</TD>
        </TR>

   <? $CAT_ANT = ""; ?>   
   <? foreach(CursosPeer::getCursos()->getResults() as $C): ?>                      
   <?    if($CAT_ANT <> $C->getCategoria()): ?>
   <?       $PLACES = CursosPeer::getPlaces($C->getIdcursos()); ?>
			<TR><TD colspan="5" class="TITOL_CATEGORIA"><?=$C->getCategoria()?></TD></TR>
   <?    endif; ?>
                       	
   		<TR>
      		<TD class="LINIA"><?=$C->getCodi()?></TD>
      		<TD class="LINIA"><?=$C->getTitolcurs()?> ( <?=$C->getHoraris()?> ) </TD>
      		<TD class="LINIA"><?=$C->getPreu()?></TD>      							
      		<TD class="LINIA"><?=$C->getDatainici('d-m-Y')?></TD>
      		<TD class="LINIA"><?=$PLACES['OCUPADES'].'/'.$PLACES['TOTAL']?></TD>
      	</TR>                		                 										
   <? $CAT_ANT = $C->getCategoria(); ?>			   
   <? endforeach; ?>                              
   </TABLE>         
   </FIELDSET>
   
   <FIELDSET><LEGEND class="LEGEND">Matricula't</LEGEND>
   <?=form_tag('web/matriculat',array('method'=>'POST')); ?>   
   <TABLE class="DADES">
   	<TR><TD><?=submit_tag('Sóc un nou usuari',array('name'=>'BNOUALUMNE'))?></TD><TD><?=submit_tag('Sóc usuari registrat',array('name'=>'BREGISTRAT'))?></TD></TR>           
   </TABLE>         
   </FIELDSET>
   </FORM>
   
	<DIV id="VULLMATRICULARME"></DIV>

   <DIV id="MATRICULACIO">Per matricular-se, vostè ha de ser usuari registrat del web de la Casa de Cultura. </DIV>
   
   <DIV STYLE="height:40px;"></DIV>
   
</TD>