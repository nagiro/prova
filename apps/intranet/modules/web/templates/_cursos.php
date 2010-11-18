<?php use_helper('Form')?>
<style>
.LLEGENDA { font-size:12px; font-weight:bold; padding:10px 10px 10px 10px; }
FIELDSET .REQUADRE { border:1px solid #CCCCCC; padding:10px; margin-right:40px; }
.TITOL_CATEGORIA { background-color: #DD9D9A; color:black; font-weight:bold; padding:5px; font-size:10px; }
.TITOL { padding:5px; }
.LINIA { padding:4px; }
#MATRICULACIO { font-size:10px; } 
#VULLMATRICULARME {  }


</style>

<TD colspan="3" class="CONTINGUT">

   <FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Llistat de cursos</LEGEND>   
   <TABLE class="DADES">
           <TR>
        	<TD class="TITOL">Codi</TD>
        	<TD class="TITOL">Títol</TD>
        	<TD class="TITOL">Preu</TD>
        	<TD class="TITOL">Data d'inici</TD>
        	<TD class="TITOL">Vacants</TD>
        </TR>

   <?php $CAT_ANT = ""; ?>   
   <?php foreach(CursosPeer::getCursos(CursosPeer::ACTIU,1,"",$IDS)->getResults() as $C): ?>
   <?php if($C->getVisibleweb() == 1): ?>                      
   <?php    if($CAT_ANT <> $C->getCategoria()): ?>   
			<TR><TD colspan="5" class="TITOL_CATEGORIA"><?php echo $C->getCategoriaText()?></TD></TR>
   <?php    endif; ?>
    <?php       $PLACES = CursosPeer::getPlaces($C->getIdcursos(),$IDS); ?>                       	
   		<TR>
      		<TD class="LINIA">
                <div style="clear:both;">
          			<a href="#TB_inline?height=480&width=640&inlineId=hidden<?php echo $C->getIdcursos(); ?>&modal=false" class="thickbox">
          				<?php echo $C->getCodi()?>
          			</a>
          			<div style="display: none;" id="hidden<?php echo $C->getIdcursos() ?>">
                        <div id="TEXT_WEB">
          				  <?php echo $C->getDescripcio() ?>
                        </div>
          			</div>
                </div>
      		</TD>
      		<TD class="LINIA"><?php echo $C->getTitolcurs()?> ( <?php echo $C->getHoraris()?> ) </TD>
      		<TD class="LINIA"><?php echo $C->getPreu()?>€</TD>      							
      		<TD class="LINIA" width="70px"><?php echo $C->getDatainici('d-m-Y')?></TD>
      		<TD class="LINIA"><?php echo (intval($PLACES['TOTAL'])-intval($PLACES['OCUPADES'])) ?></TD>
      	</TR>                		                 										
   <?php $CAT_ANT = $C->getCategoria(); ?>
   <?php endif; ?>			   			   
   <?php endforeach; ?>                              
   </TABLE>         
   </FIELDSET>

	<FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Matricula't</LEGEND>
		<form method="post" action="<?php echo url_for('web/matriculat') ?>">
            <div>
               Per matricular-se, vostè ha de ser usuari registrat de l'Hospici.<br /> 		   			
               Per poder-hi accedir si us plau cliqui <a href="<?php echo url_for('gestio/uLogin?idS=1') ?>">aquí</a>.            
            </div>
		</form>
   </FIELDSET>
   
   
	<DIV id="VULLMATRICULARME"></DIV>

   <DIV id="MATRICULACIO"> </DIV>
   
   <DIV STYLE="height:40px;"></DIV>
   
</TD>