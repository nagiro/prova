<?php use_helper('Form') ?>
<STYLE>
.cent { width:100%; }
.vuitanta { width:80%; }
.setanta { width:75%; }
.cinquanta { width:50%; }
.HTEXT { height:100px; }
.espai { padding-left:5px; padding-right:5px; }
#comentari { width:40%; }
</STYLE>
   
<script type="text/javascript">

	function vacio(q){for(i=0;i<q.length;i++){if(q.charAt(i)!=" "){return true}}return false}
	function validaData(q){		
		var userPattern = new RegExp("^[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}$");		
		if (userPattern.exec(q) == null) return false; else return true;
	}
	
	function validaCodi(q){
		var userPattern = new RegExp("^[A-Za-z]{3}[0-9]{3}\.[0-9]{2}$");		
		if (userPattern.exec(q) == null) return false; else return true;
	}
	

	function ValidaFormulari(){
		if(vacio(D_CODI.value) == false) { alert('Codi no pot estar en blanc.'); return false; }		
		if(vacio(D_TITOL.value) == false) { alert('TITOL no pot estar en blanc.'); return false; } 
		if(vacio(D_PLACES.value) == false) { alert('PLACES no pot estar en blanc.'); return false; }
		if(vacio(D_PREU.value) == false) { alert('PREU no pot estar en blanc.'); return false; }
		if(vacio(D_PREUR.value) == false) { alert('PREU REDUIT no pot estar en blanc.'); return false; }
		if(vacio(D_HORARIS.value) == false) { alert('HORARIS no pot estar en blanc.'); return false; }
		if(D_CATEGORIA.selectedIndex<0){ alert('CATEGORIA no pot estar en blanc.'); return false; }
		if(vacio(D_DATAAPARICIO.value) == false) { alert('DATA APARICIÓ no pot estar en blanc.'); return false; }
		if(vacio(D_DATADESAPARICIO.value) == false) { alert('DATA DESAPARICIÓ no pot estar en blanc.'); return false; }
		if(vacio(D_DATAFIMATRICULA.value) == false) { alert('DATA FI MATRÍCULA no pot estar en blanc.'); return false; }
		if(vacio(D_DATAINICI.value) == false) { alert('DATA INICI no pot estar en blanc.'); return false; }
		 
		if(validaData(D_DATAAPARICIO.value) == false ) { alert('DATA APRICIÓ té un format incorrecte.'); } 
		if(validaData(D_DATADESAPARICIO.value) == false ) { alert('DATA DESAPRICIÓ té un format incorrecte.'); }
		if(validaData(D_DATAFIMATRICULA.value) == false ) { alert('DATA FI MATRÍCULA té un format incorrecte.'); }
		if(validaData(D_DATAINICI.value) == false ) { alert('DATA INICI té un format incorrecte.'); }
		
		if(validaCodi(D_CODI.value) == false ) { alert('CODI té un format incorrecte.'); }
		 
	}

</script>
   
   
   
    <TD colspan="3" class="CONTINGUT">
    
	<form action="<?php echo url_for('gestio/gCursos') ?>" method="POST">
	    <DIV class="REQUADRE">
	    	<table class="FORMULARI">          
	            <?php echo $FCerca ?>
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="BCERCA" value="Prem per buscar" />
	            		<input type="submit" name="BNOU" value="Nou curs" />
	            	</td>
	            </tr>
	        </table>
	     </DIV>
     </form>  

  <?php IF( $MODE['NOU'] || $MODE['EDICIO'] ): ?>
            
   	<form action="<?php echo url_for('gestio/gCursos') ?>" method="POST">            
	 	<DIV class="REQUADRE">
	    	<table class="FORMULARI" width="550px">
	    	<tr><td width="100px"></td><td width="500px"></td></tr>
                <?=$FCurs?>                								
                <tr>
                	<td></td>
	            	<td colspan="2" class="dreta">
	            		<br>
	            		<?=submit_image_tag('icons/Colored/PNG/action_check.png',array('value'=>'SAVE','name'=>'BSAVE'))?>
	            		<?=link_to(image_tag('icons/Colored/PNG/action_delete.png'),'gestio/gCursos',array('name'=>'BDELETE','confirm'=>'Segur que vols esborrar-lo?'))?>
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
     </form>         
      
    <?php ELSEIF( $MODE['LLISTAT_ALUMNES'] ): ?>

     <DIV class="REQUADRE">
        <DIV class="TITOL">Llistat d'alumnes </DIV>
      	<TABLE class="DADES">
 			<? if( sizeof($MATRICULES) == 0 ): echo '<TR><TD class="LINIA">No hi ha cap alumne matriculat.</TD></TR>'; endif; ?>  
			<? foreach($MATRICULES as $M): ?>
			<? $C = $M->getCursos(); ?>
			<? $U = $M->getUsuaris(); ?>
			<? $TEXT_REDUCCIO ="";    ?>
			<? if($M->getTreduccio() == MatriculesPeer::REDUCCIO_CAP) { $PREU = $C->getPreu(); } else { $PREU = $C->getPreur(); $TEXT_REDUCCIO = ' |R'; } ?>
				<TR>
					<TD class="LINIA" width="15%"><?=$U->getDni()?></TD>
					<TD class="LINIA" width="40%"><?=$U->getNomComplet()?><BR /><?=$U->getTelefon()?> | <?=$M->getDatainscripcio()?></TD>
					<TD class="LINIA" width="45%"><?=$C->getCodi()?> <?=$C->getTitolcurs()?> (<?=$PREU.'€'.$TEXT_REDUCCIO?>) <br />
					                     		  <?=MatriculesPeer::getEstatText($M->getEstat())?> <?=$M->getComentari()?></TD>							
				</TR>
			<? endforeach; ?>                        	
      	</TABLE>      
      </DIV>
      
  <?php ELSE: ?>

     <DIV class="REQUADRE">
        <DIV class="TITOL">Llistat de cursos </DIV>
      	<TABLE class="DADES">
 			<?php 
				if( empty( $CURSOS ) ){
					echo '<TR><TD class="LINIA" colspan="3">No s\'ha trobat cap curs amb aquestes dades.</TD></TR>';
				} else { 
					$i = 0;
					$CAT_ANT = "";
					foreach($CURSOS->getResults() as $C):
						if($CAT_ANT <> $C->getCategoria()): ?> <TR><TD colspan="6" class="TITOLCAT"><?=$C->getCategoria()?></TD></TR> <? endif;
						$CAT_ANT = $C->getCategoria(); $SPAN = ""; $PLACES = CursosPeer::getPlaces($C->getIdcursos());											
                      	$PAR = ParImpar($i++); ?>	                      	
						<TR>
							<TD class="<?=$PAR?>"><?=link_to($C->getCodi().$SPAN , "gestio/gCursos".getParam( 'E' , $C->getIdcursos() , $CERCA ) , array('class' => 'tt2') )?></TD>
							<TD class="<?=$PAR?>"><?=$C->getTitolcurs()?></TD>
							<TD class="<?=$PAR?>"><?=$C->getPreu()?>€ </TD>
							<TD class="<?=$PAR?>"><?=$PLACES['OCUPADES'].'/'.$PLACES['TOTAL']?></TD>							
							<TD class="<?=$PAR?>"><?=$C->getDatainici('d-m-Y')?></TD>
							<TD class="<?=$PAR?>"><?=link_to('L','gestio/gCursos'.getParam('L' , $C->getIdcursos() ))?></TD>
						</TR>
				<? endforeach;
				}                    
             ?>      
              <TR><TD colspan="6" class="TITOL"><?=gestorPagines($CURSOS);?></TD></TR>    	
      	</TABLE>      
      </DIV>

  <?php ENDIF; ?>
  
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    

<?php 

function getParam( $accio = "" , $IDC = "" , $PAGINA = 1 )
{
    $opt = array();
    if(!empty($accio)) $opt[] = "accio=$accio";
    if(!empty($IDC)) $opt['IDC'] = "IDC=$IDC";
    if(!empty($PAGINA)) $opt['PAGINA'] = "PAGINA=$PAGINA";
    
    RETURN "?".implode( "&" , $opt);
}

function gestorPagines($CURSOS)
{
  if($CURSOS->haveToPaginate())
  {       
     echo link_to(image_tag('tango/16x16/actions/go-previous.png'), 'gestio/gCursos'.getParam(NULL, NULL, $CURSOS->getPreviousPage()));
     echo " ";
     echo link_to(image_tag('tango/16x16/actions/go-next.png'), 'gestio/gCursos'.getParam(NULL, NULL, $CURSOS->getNextPage()));
  }
}


function ParImpar($i)
{
	if($i % 2 == 0) return "PAR";
	else return "IPAR";
}


?>