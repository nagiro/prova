<?php use_helper('Form')?>
<?php $BASE = OptionsPeer::getString('SF_WEBROOT',$IDS); ?>
<script type="text/javascript" src="<?php echo $BASE.'js/jquery.autocompleter.js'; ?>"></script>

<style type="text/css" >
    
    @import url('<?php echo $BASE.'css/jquery.autocompleter.css'; ?>');
	.cent { width:100%; }
	.noranta { width:90%; }
	.vuitanta  { width:80%; }
	.setanta { width:75%; }
	.cinquanta { width:50%; }
	.HTEXT { height:100px; }
	.espai { padding-left:5px; padding-right:5px; }
    .MAtrICULES th { font-size:12px; font-weight:bold; }    
    .linia_curs:hover { background-color: #CCC; }

 </style>



<script type="text/javascript">

	$(document).ready( function() {


        /******************************************************/
        /* Selecció de curs i càrrega de formulari amb extres */    
        /******************************************************/
        
        $('#autocomplete_usuari_id').change(function(){ $('#LLISTAT_CURSOS').show(); });
        $('#autocomplete_usuari_id').focus(function(){ $(this).val(''); });                
                                
        $('.matricula').click(function(){                
            $.post( "<?php echo url_for('gestio/gMatricules?accio=EXTRES') ?>", 
                    { IDC: this.value , IDU: $('#autocomplete_usuari_id_hidden').val()  }, 
                    function(data) { $("#EXTRES").html(data); }
                ); 
        });
                        
	            
        /******************************/
        /* Autocompletat de l'usuari  */    
        /******************************/
        
        jQuery("#autocomplete_usuari_id")
        .autocomplete('/index.php/gestio/ajaxUsuaris', jQuery.extend({}, {
          dataType: 'json',
          parse:    function(data) {
            var parsed = [];        
            for (key in data) { parsed[parsed.length] = { data: [ data[key]['text'], data[key]['clau'] ], value: data[key]['text'], result: data[key]['clau'] }; }
            return parsed;
          }
        }, { }))
        .result(function(event, data) { $("#autocomplete_usuari_id").val(data[0]); $("#autocomplete_usuari_id_hidden").val(data[1]); });      
    
        /* CERCA */
           
		$('#cerca_select').change( function() {
			$('#FCERCA').append('<input type="hidden" name="BCERCA"></input>').submit(); 			
		});        

        /* Validació dels formularis de matrícula */

        $('#form_new_matricula').validate({
                rules:{
                    "matricules[idU]": { required: true },
                    "matricules[idC]": { required: true },
                },
                messages: {
                    "matricules[idU]": { required: "<br />Escriu un DNI o nom i escull-lo del llistat. Si no apareix, prem a crea un usuari nou." },
                    "matricules[idC]": { required: "<br />Has d'escollir algun curs per poder-te matricular." }
                }            
        });

        /* Validació de nou usuari */

        $('#form_usuari').validate({            
                rules:{
                    "usuaris[DNI]": { required: true, rangelength: [9, 9] },
                    "usuaris[Passwd]": { required: true },
                    "usuaris[Nom]": { required: true },
                    "usuaris[Cog1]": { required: true },
                    "usuaris[Cog2]": { required: false },
                    "usuaris[Email]": { required: true , email: true },
                    "usuaris[Adreca]": { required: true },
                    "usuaris[CodiPostal]": { required: true , number: true },
                    "usuaris[Poblacio]": { required: true },
                    "usuaris[Poblaciotext]": { required: function(){ return ($('#usuaris_Poblacio option:selected').val() == 227); } },
                    "usuaris[Telefon]": { required: false },
                    "usuaris[Mobil]": { required: function(){ return ($('#usuaris_Telefon').val().length == 0); }},
                    "usuaris[captcha2]": { required: true }                                        
                },
                messages: {
                    "usuaris[DNI]": { rangelength: "<br />Format: 00000000A o X0000000A." }
                }
        });    
              
	});
	
</script>
   
    <td colspan="3" class="CONTINGUT_ADMIN">
        
    <?php include_partial('breadcumb',array('text'=>'MATRICULES')); ?>
        
    <form action="<?php echo url_for('gestio/gMatricules') ?>" method="POST" id="FCERCA">
	    <div class="REQUADRE">
	    	<table class="FORMULARI">          
	            <?php echo $FCerca ?>
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="BCERCA" value="Prem per buscar" />
	            		<input type="submit" name="BNOU" value="Nova matrícula" />
	            	</td>
	            </tr>
	        </table>
	     </div>
     </form>   

	<?php IF( $MODE == 'CONSULTA' ): ?>      
        
    	<?php IF($SELECT == 2): ?>

	      <div class="REQUADRE">
	        <div class="TITOL">Llistat d'alumnes</div>
	      	<table class="DADES">
	 			<?php 
					if( $ALUMNES->getNbResults() == 0 ):					
						echo '<tr><td class="LINIA" colspan="3">No hi ha cap alumne amb aquests paràmetres.</td></tr>';						
					else:					 
						echo '<tr><td class="TITOL">DNI</td><td class="TITOL">Nom</td></tr>';
						
						$i = 0; $ant = "";						
						foreach($ALUMNES->getresults() as $A):						
	                      	$PAR = ParImpar($i++);                                              	
	                    	echo '<tr>							
									<td class="LINIA">'.link_to($A->getdni(),'gestio/gMatricules?accio=LMA&IDA='.$A->getUsuariid()).'</td>
								    <td class="LINIA">'.$A->getNomComplet().'</td>
							      </tr>';
							                		                 															                		                 															
	                    endforeach;
	                  
	                 endif;                     
	             ?>      
	              <tr><td colspan="3" class="TITOL"><?php echo gestorPagines($ALUMNES);?></td></tr>    	
	      	</table>      
	      </div>

	     <?php else: ?>

	      <div class="REQUADRE">
	        <div class="TITOL">Llistat de cursos </div>
	      	<table class="DADES">
	 			<?php 
					if( $CURSOS->getNbResults() == 0 ):
						echo '<tr><td class="LINIA" colspan="3">No hi ha cap curs amb aquests paràmetres.</td></tr>';
					else: 
						echo '<tr><td class="TITOL">CODI</td><td class="TITOL">NOM</td><td class="TITOL">DATA INICI</td><td class="TITOL">PLACES</td></tr>';
						$i = 0;
						foreach($CURSOS->getresults() as $C):
	                      	$PAR = ParImpar($i++);
	                      	echo '<tr>							
									<td class="LINIA">'.link_to($C->getCodi(),'gestio/gMatricules?accio=LMC&IDC='.$C->getIdcursos()).'</td>
									<td class="LINIA">'.$C->getTitolcurs().'</td>
									<td class="LINIA">'.$C->getdatainici('d/m/Y').'</td>
									<td class="LINIA">'.$C->countMatriculats($IDS).'/'.$C->getPlaces().'</td>
								  </tr>';                		                 															                		                 															
	                    endforeach;
	                 endif;                     
	             ?>      
	              <tr><td colspan="4" class="TITOL"><?php echo gestorPagines($CURSOS);?></td></tr>    	
	      	</table>      
	      </div>

	     <?php endif; ?>

  <?php ELSEIF( $MODE == 'MAT_USUARI' ):  ?>

 	<form action="<?php echo url_for('gestio/gMatricules') ?>" method="POST" id="form_new_matricula">
	    <div class="REQUADRE">
            <div style="width: 650px;" class="FORMULARI">
                <div style="float:left; background-color:#CCC; color:#555; padding:5px; width:640px; ">ALUMNE</div>
                <div style="margin-top:10px; float:left; clear:both;">
                    <div>
                        <div style="float: left; width:100px;"><b>Usuari: </b></div>
                        <div style="float: left; ">
                            <input style="float:left; width:300px;" name="matricules[U]" id="autocomplete_usuari_id" type="text" value="Entra el DNI o nom" />
                            <input name="matricules[idU]" id="autocomplete_usuari_id_hidden" value="0" type="hidden" style="width: 300px;" />
                            <a target="_blank" style="margin-left:20px; float:left;" href="<?php echo url_for('gestio/gUsuaris?accio=N'); ?>">Crea un nou usuari</a>                            
                        </div>                        
                    </div>
                </div>

<!-- Mostrem el llistat de cursos -->
                <div style="display: none;" id="LLISTAT_CURSOS">
                <div style="margin-top:20px; float:left; background-color:#CCC; color:#555; padding:5px; width:640px; ">CURS</div>
                <div style="margin-top:10px; float:left; clear:both;">
                    <?php foreach($CURSOS as $OC): ?>
                    <?php $places = $OC->getPlacesArray(); ?>
                    <?php if($OC->isPle()) $style=" background-color: #FFC4C4; "; else $style=""; ?>                        
                    <div style="margin-top:3px; clear: both; <?php echo $style ?>" class="linia_curs">
                        <div style="float: left;">                            
                            <?php echo radiobutton_tag('matricules[idC]',$OC->getIdcursos(),false,array('class'=>'matricula')); ?>
                        </div>
                        <div style="padding-left:5px; float: left; width:100px;">
                            <b><?php echo $OC->getCodi(); ?></b><br />
                            <div style="font-size:8px; color:gray;"><?php echo $OC->getDatainici('d/m/Y'); ?></div>
                        </div>
                        <div style="padding-left:5px; float: left; width:400px;">
                            <?php echo $OC->getTitolcurs(). '<span style="color:gray; font-size:8px;"> | '.$OC->getHoraris().' </span> '; ?>
                        </div>
                        <div style="padding-left:5px; float: left; width:50px;">
                            <?php echo $OC->getPreu(); ?>€
                        </div>                        
                        <div style="padding-left:5px; float: left; width:50px;">
                            <?php echo $places['OCUPADES'].' / '.$places['TOTAL']; ?>
                        </div>
                        <div style="clear: both;"></div>
                    </div>                                                                                                
                    <?php endforeach; ?>
                </div>
                </div>

                <!-- Apareix el _matricules.php a partir d'un ajax que ha cridat el curs "action:EXTRES" -->
                <div id="EXTRES"></div>
                
            
            <div style="clear: both;"></div>
            </div>	    
	     </div>
     </form>	

 <?php elseif( $MODE == 'PAGAMENT' ):  ?>  
 	
 	<div class="REQUADRE">	    
        <div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gMatricules?accio=CA'); ?></div>
            <?php  
                switch($MISSATGE){
                    case 'PAGAMENT_TPV': echo "La matrícula s'ha realitzat correctament.<br /> Prem ".link_to('aquí','gestio/gMatricules?accio=PRINT_PAGAMENT&IDM='.$IDM)." per veure el reguard."; break;
                    case 'RESERVA_OK': echo "La matrícula s'ha realitzat correctament.<br /> Prem ".link_to('aquí','gestio/gMatricules?accio=PRINT_PAGAMENT&IDM='.$IDM)." per veure el reguard."; break; 
                    case 'MATRICULA_METALIC_OK': echo "La matrícula s'ha realitzat correctament.<br /> Prem ".link_to('aquí','gestio/gMatricules?accio=PRINT_PAGAMENT&IDM='.$IDM)." per veure el reguard."; break;                    
                    case 'PAGAMENT_TPV_KO': echo "Hi ha hagut algun problema fent el pagament de la matrícula a través del TPV. Si us plau, torna-ho a intentar."; break;
                    case 'MATRICULA_FINAL_KO': echo "Hi ha hagut algun problema generant el resguard de la matrícula. Si us plau, posa't en contacte amb informatica@casadecultura.org."; break;
                    case 'ERR_USUARI': echo "Hi ha hagut algun problema amb el codi d'usuari. Si us plau, torna-ho a intentar."; break;
                    case 'ERR_CURS': echo "Hi ha hagut algun problema amb el codi del curs. Si us plau, torna-ho a intentar."; break;
                    case 'ERR_JA_TE_UNA_MATRICULA': echo "Aquest usuari ja té una matrícula a aquest curs. La nova matrícula no s'ha efectuat."; break;
                    case 'CURS_PLE': echo "El curs ja està ple i l'usuari ha quedat en llista d'espera correctament. Quan hi hagi places lliures s'haurà d'avisar. "; break;
                    case 'MATRICULA_DOMICILIACIO_OK': echo "La matrícula s'ha realitzat correctament.<br /> Prem ".link_to('aquí','gestio/gMatricules?accio=PRINT_PAGAMENT&IDM='.$IDM)." per veure el reguard."; break;
                                                             
                } 
            ?>
    </div>
 	 	  
  <?php elseif( $MODE == 'EDICIO' ): ?>

 	<form action="<?php echo url_for('gestio/gMatricules') ?>" method="POST">
	    <div class="REQUADRE">
	    <div class="OPCIO_FINESTRA"><?php echo link_to(image_tag('icons/Grey/PNG/action_delete.png'),'gestio/gMatricules'); ?></div>	    
	    	<table class="FORMULARI" width="100%">
                <tr><th width="200px">&nbsp;</th><td>&nbsp;</td></tr>
	 			<?php echo $FMATRICULA; ?>
                <tr>      
	 			<td colspan="2" class="dreta"><br />
					<?php include_partial('botonera',array('element'=>'la matrícula'))?>	            			            	
	            </td>
                </tr>
	        </table>
	     </div>
     </form>
 
  <?php ELSEIF( $MODE == 'LMATRICULES' ): ?>
  
  	     <div class="REQUADRE">
	        <div class="TITOL">Llistat de matriculats </div>                
          	<table class="DADES">
                      
     			<?php if( sizeof($MATRICULES) == 0 ): echo '<tr><td class="LINIA">No hi ha cap alumne matriculat.</td></tr>'; endif; ?>                        
                <?php echo '<tr><td class="TITOL" colspan="3">RESERVATS</td></tr>'.$RET; ?>
                <?php include_partial('cursosCommon',array('MATRICULES'=>$MATRICULES,'estat'=>MatriculesPeer::RESERVAT,'MODE'=>'LLISTAT_ALUMNES')); ?>                         
                <?php echo '<tr><td class="TITOL" colspan="3">ACCEPTAT I PAGAT</td></tr>'.$RET; ?>
                <?php include_partial('cursosCommon',array('MATRICULES'=>$MATRICULES,'estat'=>MatriculesPeer::ACCEPTAT_PAGAT,'MODE'=>'LLISTAT_ALUMNES')); ?>            
                <?php echo '<tr><td class="TITOL" colspan="3">ACCEPTAT I NO PAGAT</td></tr>'.$RET; ?>
                <?php include_partial('cursosCommon',array('MATRICULES'=>$MATRICULES,'estat'=>MatriculesPeer::ACCEPTAT_NO_PAGAT,'MODE'=>'LLISTAT_ALUMNES')); ?>            
                <?php echo '<tr><td class="TITOL" colspan="3">EN ESPERA</td></tr>'.$RET; ?>
                <?php include_partial('cursosCommon',array('MATRICULES'=>$MATRICULES,'estat'=>MatriculesPeer::EN_ESPERA,'MODE'=>'LLISTAT_ALUMNES')); ?>            
                <?php echo '<tr><td class="TITOL" colspan="3">BAIXA</td></tr>'.$RET; ?>
                <?php include_partial('cursosCommon',array('MATRICULES'=>$MATRICULES,'estat'=>MatriculesPeer::BAIXA,'MODE'=>'LLISTAT_ALUMNES')); ?>
                <?php echo '<tr><td class="TITOL" colspan="3">DEVOLUCIÓ</td></tr>'.$RET; ?>
                <?php include_partial('cursosCommon',array('MATRICULES'=>$MATRICULES,'estat'=>MatriculesPeer::DEVOLUCIO,'MODE'=>'LLISTAT_ALUMNES')); ?>
                                                       			                        	
          	</table>      
        </div>
        
  <?php ENDIF; ?>
  
      <div style="height:40px;"></div>
                
    </td>    

<?php 

	function ParImpar($i)
	{
		if($i % 2 == 0) return "PAR";
		else return "IPAR";
	}
	
	
	function gestorPagines($O)
	{
	  if($O->haveToPaginate())
	  {       
	     echo link_to(image_tag('tango/16x16/actions/go-previous.png'), 'gestio/gMatricules?PAGINA='.$O->getPreviousPage());
	     echo " ";
	     echo link_to(image_tag('tango/16x16/actions/go-next.png'), 'gestio/gMatricules?PAGINA='.$O->getNextPage());
	  }
	}

?>
