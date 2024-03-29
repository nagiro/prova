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

<td colspan="3" class="CONTINGUT">
   
    <?php if($CURSOS->getNbResults() == 0): ?>
        <fieldset class="REQUADRE"><legend class="LLEGENDA">Llistat de cursos</legend>
            Actualment no hi ha oberta la matrícula per a cap curs a través d'internet.<br />
            Per a més informació, contacti amb la Casa de Cultura de Girona.
        </fieldset>  
        <?php else: ?>
             
    	<fieldset class="REQUADRE"><legend class="LLEGENDA">Matricula't</legend>
    		<form method="post" action="<?php echo url_for('web/matriculat') ?>">
                <div>
                   El període de matriculació s'obre el 19 de setembre i es tancarà el mateix dia d'inici de cadascun dels cursos o quan s'hagin exhaurit les places, tret d'indicacions específiques en sentit contrari.
                   <br /><br />Els alumnes matriculats a idiomes el curs anterior podran inscriure's a partir del 12 de setembre. Els altres alumnes hauran de realitzar proves de nivell per saber a quin curs inscriure's. Les proves de llengua anglesa seran el <b>dimecres 12 a les 19:00</b> i les proves de llengua francesa seran el <b>dijous 13 a les 19:00</b> a la Casa de Cultura de Girona. En cas de no haver realitzat prova de nivell, només es podrà matricular a primer. 
                   <br /><br />La casa de Cultura de Girona es reserva el dret de modificar els horaris i dates anunciats o d'anul·lar un curs tant per raons organitzatives com si no hi ha un nombre suficient d'alumnes.                    		   			
                   <br /><br />Les matrícules realitzades a través del portal web s'hauran de pagar mitjançant targeta de crèdit. Les matrícules realitzades presencialment podran pagar-se també mitjançant targeta de crèdit o bé amb codi de barres a qualsevol caixer de CaixaBank. 
                   <br /><br />Per matricular-vos per internet, cliqueu aquest <a href="http://www.hospici.cat/cursos_entitat/1">enllaç</a>. Per accedir-hi heu de ser usuari de l'Hospici o bé crear-ne un de nou si no en sou. 
                   <!-- Per matricular-se, vostè ha de ser usuari registrat de l'Hospici.
                        Per poder-hi accedir si us plau cliqui <a href="<?php echo url_for('gestio/uLogin?idS=1') ?>">aquí</a>. -->            
                </div>
    		</form>
       </fieldset>
      
        <?php echo mostraCursos($CURSOS,true); ?>  
             
       <?php // echo mostraCursos($CURSOS_TANCATS,false); ?>
   
   <?php endif; ?>
      
   <div style="height:40px;"></div>
   
</td>




<?php function mostraCursos($CURSOS,$is_actiu){ ?>

    <fieldset class="REQUADRE">
        <?php if($is_actiu): ?> <legend class="LLEGENDA">MATRÍCULA OBERTA</legend>
        <?php else: ?> <legend class="LLEGENDA">MATRÍCULA TANCADA</legend>
        <?php endif; ?>
       <table class="DADES">
               <tr>
            	<td class="TITOL">Codi</td>
            	<td class="TITOL">Títol</td>
            	<td class="TITOL">Preu</td>
            	<td class="TITOL">Data d'inici</td>
            	<td class="TITOL">Vacants</td>
            </tr>
    
       <?php $CAT_ANT = ""; ?>   
       <?php foreach($CURSOS->getResults() as $C): ?>
       <?php if($C->getVisibleweb() == 1 && $C->getIsactiu() == $is_actiu): ?>                      
       <?php    if($CAT_ANT <> $C->getCategoria()): ?>   
    			<tr><td colspan="5" class="TITOL_CATEGORIA"><?php echo $C->getCategoriaText()?></td></tr>
       <?php    endif; ?>
        <?php       $PLACES = CursosPeer::getPlaces($C->getIdcursos(),$IDS); ?>                       	
       		<tr>
          		<td class="LINIA">
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
          		</td>
          		<td class="LINIA"><?php echo $C->getTitolcurs()?> ( <?php echo $C->getHoraris()?> ) </td>
          		<td class="LINIA"><?php echo $C->getPreu()?>€</td>      							
          		<td class="LINIA" width="70px"><?php echo $C->getDatainici('d-m-Y')?></td>
          		<td class="LINIA">
                    <?php if($is_actiu): ?> <?php echo (intval($PLACES['TOTAL'])-intval($PLACES['OCUPADES'])) ?>
                    <?php else: ?> Tancat
                    <?php endif; ?>                    
                </td>
          	</tr>                		                 										
       <?php $CAT_ANT = $C->getCategoria(); ?>
       <?php endif; ?>			   			   
       <?php endforeach; ?>                              
       </table>         
       </fieldset>
       
<?php } ?>
