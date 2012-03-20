<?php use_helper('Form'); ?>
<?php use_javascript('/sfFormExtraPlugin/js/jquery.autocompleter.js') ?>
<?php use_stylesheet('/sfFormExtraPlugin/css/jquery.autocompleter.css') ?>


<style>
.cent { width:100%; }
.vuitanta { width:80%; }
.setanta { width:75%; }
.cinquanta { width:50%; }
.HTEXT { height:100px; }
.espai { padding-left:5px; padding-right:5px; }
#comentari { width:40%; }

	.row { width:600px; padding:10px; margin-top:5px;  }
    .row:hover { background-color:#EEE;  }
	.row_field { width:70%; }
	.row_title { width:30%;  }
	.row_field input { width:20px;}          

</style>
   
<script type="text/javascript">

	$(document).ready( function() { 
		$('#cerca_select').change( function() {
			$('#FCERCA').append('<input type="hidden" name="BCERCA"></input>').submit();			
		});

		$('#cursos_codi_Codi').change(CanviaCodiCurs);
		$('#FSAVECODICURS').submit(ValidaCodi);
		
	});
	
</script>

   
<script type="text/javascript">

	function vacio(q){for(i=0;i<q.length;i++){if(q.charAt(i)!=" "){return true}}return false}
	function validaData(q){		
		var userPattern = new RegExp("^[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}$");		
		if (userPattern.exec(q) == null) return false; else return true;
	}
	
	function validaCodi(q){
        return true;
	}

	function CanviaCodiCurs(){		
		if($('#cursos_codi_Codi').val() == 0){ $('#cursos_codi_CodiT').fadeIn(1000); }
		else { $('#cursos_codi_CodiT').fadeOut(1000); $('#cursos_codi_CodiT').val(""); }
	}
	
	function ValidaCodi(){		
		if( $('#cursos_codi_Codi').val() == 0 && $('#cursos_codi_CodiT').val().length == 0 ){ alert('Si entres un codi nou, has d\'escriure\'l.'); return false; }
		else 
		{
            return true;
		}				
	}
	
	function ValidaFormulari(){
				
		if($('#cursos_Codi').val().length == 0) { alert('Codi no pot estar en blanc.'); return false; }		
		if($('#cursos_TitolCurs').val().length == 0) { alert('TITOL no pot estar en blanc.'); return false; } 
		if($('#cursos_Places').val().length == 0) { alert('PLACES no pot estar en blanc.'); return false; }
		if($('#cursos_Preu').val().length == 0) { alert('PREU no pot estar en blanc.'); return false; }
		if($('#cursos_Preur').val().length == 0) { alert('PREU REDUIT no pot estar en blanc.'); return false; }
		if($('#cursos_Horaris').val().length == 0) { alert('HORARIS no pot estar en blanc.'); return false; }
		if($('#cursos_Categoria').val().length < 0){ alert('CATEGORIA no pot estar en blanc.'); return false; }
		if($('#cursos_DataInMatricula_day').val().length == 0) { alert('INICI MATRICULACIÓ no pot estar en blanc.'); return false; }		
		if($('#cursos_DataFiMatricula_day').val().length == 0) { alert('FI MATRICULACIÓ no pot estar en blanc.'); return false; }
		if($('#cursos_DataInici_day').val().length == 0) { alert('DATA INICI no pot estar en blanc.'); return false; }
		 
	}

</script>
   
   
   
    <td colspan="3" class="CONTINGUT_ADMIN">
    
    <?php include_partial('breadcumb',array('text'=>'CURSOS')); ?>
    
	<form action="<?php echo url_for('gestio/gCursos'); ?>" method="POST" id="FCERCA">
    	<?php include_partial('cerca',array(
    										'TIPUS'=>'Select',
    										'FCerca'=>$FCerca,
    										'BOTONS'=>array(
    														array(
    																'name'=>'BCERCA',
    																'text'=>'Prem per buscar'),
    														array(
    																'name'=>'BNOU',
    																'text'=>'Nou curs')    														
    													)
    										)
    							); ?>

     </form>  

  <?php IF( $MODE == 'NOU' || $MODE == 'EDICIO' ): ?>

   	<form id="FSAVECODICURS" action="<?php echo url_for('gestio/gCursos'); ?>" method="POST">
	
	 	<div class="REQUADRE fb">
	 	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gCursos?accio=CA')) ?>
					 	 		
	 		<div class="FORMULARI fb">
	 			<?php echo $FCursCodi ?>	 		
	 			<?php include_partial('botoneraDiv',array('tipus'=>'Blanc','nom'=>'BSAVECODICURS','id'=>'BSAVECODICURS', 'class'=>'BOTO_ACTIVITAT' ,'text'=>'Segueix amb detall...')); ?>		
	 		</div>
	 			 	 	
      	</div>
			   	            
     </form>         

  <?php ELSEIF( $MODE == 'EDICIO_CONTINGUT' ): ?>
            
   	<form onSubmit="return ValidaFormulari(this);" action="<?php echo url_for('gestio/gCursos'); ?>" method="POST"  enctype="multipart/form-data">
   	
	 	<div class="REQUADRE fb">
	 	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gCursos?accio=CA')) ?>
					 	 		
	 		<div class="FORMULARI fb">
	 			<?php echo $FCurs ?>
                
                
                <div class="clear" style="text-align:right; padding-top:40px;">                
                    <button type="submit" name="BGENERAACTIVITAT" class="BOTO_ACTIVITAT" >
                        <?php echo image_tag('template/application_form.png').' Edita activitat' ?>
        			</button>                                    
                	<button type="submit" name="BSAVE" class="BOTO_ACTIVITAT" onClick="return confirm('Segur que vols guardar els canvis?')">
                		<?php echo image_tag('template/disk.png').' Guardar i sortir' ?>
                	</button>
                	<button type="submit" name="BDELETE" class="BOTO_PERILL" onClick="return confirm('Segur que vols esborrar-ho? No ho podràs recuperar! ')">
                		<?php echo image_tag('tango/16x16/status/user-trash-full.png').' Eliminar' ?>
                	</button>                    		                 	 		
                </div>
	 		</div>
	 			 	 	
      	</div>
      	            
     </form>         
      
    <?php ELSEIF( $MODE == 'LLISTAT_ALUMNES' ): ?>

     <div class="REQUADRE">     
        <div class="TITOL">Llistat d'alumnes <a href="<?php echo url_for('gestio/gCursos?accio=IMPR_LLISTAT_ALUMNES_CURS&IDC='.$IDC) ?>"><img style="padding-left:10px;" src="/images/template/page_white_word.png" /></a></div>
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
                                                   			                        	
      	</table>      
      </div>
      
  <?php ELSE: ?>

     <div class="REQUADRE">     
        <div class="TITOL">Llistat de cursos </div>
      	<table class="DADES">
 			<?php 
 				                                
				if( $CURSOS->getNbResults() == 0 ){
					echo '<TR><TD class="LINIA" colspan="3">No s\'ha trobat cap curs amb aquestes dades.</TD></TR>';
				} else { 
					$i = 0;
					$CAT_ANT = "";
					foreach($CURSOS->getResults() as $C):
						if($CAT_ANT <> $C->getCategoria()) echo '<TR><TD colspan="6" class="TITOLCAT">'.$C->getCategoriaText().'</TD></TR>';
						$CAT_ANT = $C->getCategoria(); $SPAN = ""; 
						$PLACES = CursosPeer::getPlaces($C->getIdcursos(),$IDS);
                        $ple = ($PLACES['OCUPADES'] >= $PLACES['TOTAL'])?"style=\"background-color:#EDE765;\"":"";											
                      	$PAR = ParImpar($i++);	                      	
						echo '<TR>
								<TD '.$ple.' class="'.$PAR.'">'.link_to($C->getCodi().$SPAN , "gestio/gCursos?accio=EC&IDC=".$C->getIdcursos() , array('class' => 'tt2') ).'</TD>
								<TD '.$ple.' class="'.$PAR.'">'.$C->getTitolcurs().' ('.$C->getHoraris().')</TD>
								<TD '.$ple.' class="'.$PAR.'">'.$C->getPreu().'€ </TD>
								<TD '.$ple.' class="'.$PAR.'">'.$PLACES['OCUPADES'].'/'.$PLACES['TOTAL'].'</TD>							
								<TD '.$ple.' width="70px" class="'.$PAR.'">'.$C->getDatainici('d-m-Y').'</TD>
								<TD '.$ple.' class="'.$PAR.'">'.link_to(image_tag('template/user.png').'<span>Llistat d\'alumnes matriculats.</span>','gestio/gCursos?accio=L&IDC='.$C->getIdcursos() , array('class'=>'tt2') ).'</TD>
						</TR>';
					endforeach;

				}     
				               
             ?>      
              <tr><td colspan="6" class="TITOL"><?php echo gestorPagines($CURSOS,$MODE);?></td></tr>    	
      	</table>      
      </div>

  <?php ENDIF; ?>
  
      <div style="height:40px;"></div>
                
    </td>    

<?php 


function getParam( $accio = "" , $IDC = "" , $PAGINA = 1 )
{
    $opt = array();
    if(!empty($accio)) $opt[] = "accio=$accio";
    if(!empty($IDC)) $opt['IDC'] = "IDC=$IDC";
    if(!empty($PAGINA)) $opt['PAGINA'] = "PAGINA=$PAGINA";
    
    RETURN "?".implode( "&" , $opt);
}

function gestorPagines($CURSOS,$accio)
{
  if($CURSOS->haveToPaginate())
  {       
     echo link_to(image_tag('tango/16x16/actions/go-previous.png'), 'gestio/gCursos'.getParam($accio, NULL, $CURSOS->getPreviousPage()));
     echo " ";
     echo link_to(image_tag('tango/16x16/actions/go-next.png'), 'gestio/gCursos'.getParam($accio, NULL, $CURSOS->getNextPage()));
  }
}


function ParImpar($i)
{
	if($i % 2 == 0) return "PAR";
	else return "IPAR";
}


?>