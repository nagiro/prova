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
        	<TD class="TITOL">Places</TD>
        </TR>

   <?php $CAT_ANT = ""; ?>   
   <?php foreach(CursosPeer::getCursos()->getResults() as $C): ?>
   <?php if($C->getVisibleweb() == 1): ?>                      
   <?php    if($CAT_ANT <> $C->getCategoria()): ?>
   <?php       $PLACES = CursosPeer::getPlaces($C->getIdcursos()); ?>
			<TR><TD colspan="5" class="TITOL_CATEGORIA"><?php echo $C->getCategoriaText()?></TD></TR>
   <?php    endif; ?>
                       	
   		<TR>
      		<TD class="LINIA">
      			<a href="#TB_inline?height=480&width=640&inlineId=hidden<?php echo $C->getIdcursos(); ?>&modal=false" class="thickbox">
      				<?php echo $C->getCodi()?>
      			</a>
      			<div style="display: none;" id="hidden<?php echo $C->getIdcursos() ?>">
      				<?php echo $C->getDescripcio() ?>
      			</div>
      		</TD>
      		<TD class="LINIA"><?php echo $C->getTitolcurs()?> ( <?php echo $C->getHoraris()?> ) </TD>
      		<TD class="LINIA"><?php echo $C->getPreu()?>€</TD>      							
      		<TD class="LINIA"><?php echo $C->getDatainici('d-m-Y')?></TD>
      		<TD class="LINIA"><?php echo $PLACES['OCUPADES'].'/'.$PLACES['TOTAL']?></TD>
      	</TR>                		                 										
   <?php $CAT_ANT = $C->getCategoria(); ?>
   <?php endif; ?>			   			   
   <?php endforeach; ?>                              
   </TABLE>         
   </FIELDSET>

	<FIELDSET class="REQUADRE"><LEGEND class="LLEGENDA">Matricula't</LEGEND>
		<form method="post" action="<?php echo url_for('web/matriculat') ?>">
            <div>
               Per matricular-se, vostè ha de ser usuari registrat del web de la Casa de Cultura.<br /> 		   			
               Si necessita més informació sobre el nou sistema de matrícules, si us plau, cliqui <a href="<?php echo url_for('web/index?accio=mc&node=35'); ?>">aquí</a>.            
            </div>
            <div style="margin-top:20px;">         
    		   	<?php $missatge = "Segueixi si vostè estar segur que: \\n 1.- No ha estat alumne de la Casa de Cultura. \\n 2.- Vostè no té cap usuari creat. \\n Si no n\'està segur, si us plau, cliqui cancel·lar i contacti amb la Casa de Cultura trucant al telèfon 972.20.20.13 o bé enviant un correu a informatica@casadecultura.org."; ?>
    		   	<button type="submit" onClick="return confirm('<?php echo $missatge ?>')" name="BNOUALUMNE" class="BOTO_ACTIVITAT">Sóc un nou alumne</button>
    		   	<button type="submit" name="BREGISTRAT" class="BOTO_ACTIVITAT">Sóc antic alumne o usuari registrat</button>		   			
            </div>       
		</form>
   </FIELDSET>
   
   
	<DIV id="VULLMATRICULARME"></DIV>

   <DIV id="MATRICULACIO"> </DIV>
   
   <DIV STYLE="height:40px;"></DIV>
   
</TD>