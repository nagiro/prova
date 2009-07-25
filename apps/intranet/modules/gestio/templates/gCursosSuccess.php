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
    
      <?php echo nice_form_tag('gestio/gCursos',array('method'=>'post')); ?>

      <TABLE class="BOX">
        <TR><TD class="NOTICIA">        		
        		<div class="TITOL">Cerca cursos</DIV>                                                              
				<div class="CERCA"><?php echo input_tag('CERCA', $CERCA , array('class'=>'cinquanta')).' '.submit_tag('Cerca actius',array('name'=>'BCERCAACTIUS')).' '.submit_tag('Cerca inactius',array('name'=>'BCERCAINACTIUS')).' '.submit_tag('Nou curs',array('name'=>'BNOU')); ?></DIV>										 
            </TD>
        </TR>
      </TABLE>
          
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Llistat de cursos (<?=$CURSOS->getNbResults() ?>)</DIV>
                <TABLE class="DADES">
                <? if($CURSOS->getNbResults() == 0 ): ?> <TR><TD class="LINIA">No hi ha cursos disponibles.</TD></TR><? endif; ?>
				<? $CAT_ANT = ""; ?>                 									                           
                <? foreach($CURSOS->getResults() as $C): ?>
                <? if($CAT_ANT <> $C->getCategoria()): ?> <TR><TD colspan="4" class="TITOL"><?=$C->getCategoria()?></TD></TR> <? endif; ?>
                <? $SPAN = ""; $PLACES = CursosPeer::getPlaces($C->getIdcursos()); ?>                 	
				<TR>
					<TD class="LINIA"><?=link_to($C->getCodi().$SPAN , "gestio/gCursos".getParam( 'E' , $C->getIdcursos() , $CERCA ) , array('class' => 'tt2') )?></TD>
					<TD class="LINIA"><?=$C->getTitolcurs()?></TD>
					<TD class="LINIA"><?=$C->getPreu()?>€ </TD>
					<TD class="LINIA"><?=$PLACES['OCUPADES'].'/'.$PLACES['TOTAL']?></TD>							
					<TD class="LINIA"><?=$C->getDatainici('d-m-Y')?></TD>
					<TD class="LINIA"><?=link_to('L','gestio/gCursos'.getParam('L' , $C->getIdcursos() , $CERCA ))?></TD>
				</TR>                		                 										
					<? $CAT_ANT = $C->getCategoria(); ?>
				<? endforeach; ?>                
                <TR><TD colspan="3" class="TITOL"><?=gestorPagines($CERCA , $CURSOS , $ISACTIU);?></TD></TR> 
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>

  <?php IF( $NOU || $EDICIO ): ?>
            
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Gestor de cursos</DIV>				
  				<?php echo input_hidden_tag('IDC',$IDC); ?>
				<TABLE class="NOTICIA" width="100%">
                  	<TR>
    					<TD class="TITOL" colspan="2">CODI<br /><?php echo input_tag( 'D[CODI]' , $CURS->getCodi() , array( 'class' => 'cent' ) ); ?></TD>
                    	<TD class="TITOL" colspan="6">TITOL<br /><?php echo input_tag( 'D[TITOL]' , $CURS->getTitolcurs() , array( 'class' => 'cent' ) ); ?></TD>                    	
					</TR>                    					
					<TR>
						<TD class="TITOL" colspan="2">ACTIU<br /><?php echo select_tag( 'D[ACTIU]' , options_for_select(array(1=>'Sí',0=>'No'), $CURS->getIsactiu() ) , array( 'class' => 'cent' ) ); ?></TD>
						<TD class="TITOL" colspan="2">PLACES<br /><?php echo input_tag( 'D[PLACES]' , $CURS->getPlaces() , array('class'=>'cent') ); ?></TD>
						<TD class="TITOL" colspan="2">PREU<br /><?php echo input_tag( 'D[PREU]' , $CURS->getPreu() , array('class'=>'cent') ); ?></TD>
						<TD class="TITOL" colspan="2">PREU REDUIT<br /><?php echo input_tag( 'D[PREUR]' , $CURS->getPreur() , array('class'=>'cent') ); ?></TD>											                                       
	                </TR>                                    
                  	<TR>
    					<TD class="TITOL" colspan="4">HORARIS<br /><?php echo input_tag( 'D[HORARIS]' , $CURS->getHoraris() , array( 'class' => 'cent' ) ); ?></TD>
                    	<TD class="TITOL" colspan="4">CATEGORIA<br /><?php echo select_tag( 'D[CATEGORIA]' , options_for_select(CursosPeer::getSelectCategories() , $CURS->getCategoria() ) , array( 'class' => 'cent' ) ); ?></TD>                    	
					</TR>
					<TR>
    					<TD class="TITOL" colspan="2">DATA APARICIO<br /><?php echo input_date_tag( 'D[DATAAPARICIO]' , $CURS->getDataaparicio() , array( 'class' => 'setanta' , 'rich' => true ) ); ?></TD>
                    	<TD class="TITOL" colspan="2">DATA DESAPARICIO<br /><?php echo input_date_tag( 'D[DATADESAPARICIO]' , $CURS->getDatadesaparicio() , array( 'class' => 'setanta' , 'rich' => true ) ); ?></TD>                    	
                    	<TD class="TITOL" colspan="2">DATA FI MATRÍCULA<br /><?php echo input_date_tag( 'D[DATAFIMATRICULA]' , $CURS->getDatafimatricula() , array( 'class' => 'setanta' , 'rich' => true ) ); ?></TD>
                    	<TD class="TITOL" colspan="2">DATA INICI<br /><?php echo input_date_tag( 'D[DATAINICI]' , $CURS->getDatainici() , array( 'class' => 'setanta' , 'rich' => true ) ); ?></TD>
					</TR>
					<TR>
    					<TD class="TITOL" colspan="8">DESCRIPCIO<br /><?php echo textarea_tag( 'D[DESCRIPCIO]' , $CURS->getDescripcio() , array( 'class' => 'cent' ) ); ?></TD>                    	                    	
					</TR>                    										                    					
					<TR>
						<TD colspan="6"><?php echo submit_tag('Guarda',array( 'name'=>'BSAVE' , 'class'=>'cent' , 'onClick'=>'return ValidaFormulari(this);' )); ?></TD>
						<TD colspan="2"><?php echo submit_tag( 'Esborrar' , array(  'name' => 'BDELETE' , 'class' => 'cent' , 'onClick' => "return confirm('Segur que vols esborrar aquest registre?');" ));  ?> </TD>						
					</TR>
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>
      
    <?php ELSEIF( $LLISTAT ): ?>
            
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Llistat d'alumnes matriculats</DIV>
                <TABLE class="DADES">
                <? if( $CURS->countMatriculats() == 0 ): ?>
                <TR><TD class="LINIA">No hi ha cap alumne matriculat.</TD></TR>
                <? endif; ?>  
                 									                           
                <? foreach($CURS->getMatriculats() as $M): ?>                	 
                <?    $U = $M->getUsuaris(); $TEXT_REDUCCIO = ""; ?>
                <?    if($M->getTreduccio() == MatriculesPeer::REDUCCIO_CAP) { $PREU = $CURS->getPreu(); } else { $PREU = $CURS->getPreur(); $TEXT_REDUCCIO = ' |R'; } ?>
				<TR>
					<TD class="LINIA" width="15%"><?=$U->getDni()?></TD>
					<TD class="LINIA" width="40%"><?=$U->getNomComplet()?><BR /><?=$U->getTelefon()?> | <?=$M->getDatainscripcio()?></TD>
					<TD class="LINIA" width="45%"><?=$CURS->getCodi()?> <?=$CURS->getTitolcurs()?> (<?=$PREU.'€'.$TEXT_REDUCCIO?>) <br />
					                     		  <?=MatriculesPeer::getEstatText($M->getEstat())?> <?=$M->getComentari()?></TD>							
				</TR>                		                 															
				<? endforeach; ?>				           
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>

  <?php ENDIF; ?>
  
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    

<?php 

function getParam( $accio = "" , $IDC = "" , $CERCA = "" , $PAGINA = 1 )
{
    $opt = array();
    if(!empty($accio)) $opt[] = "accio=$accio";
    if(!empty($IDC)) $opt['IDC'] = "IDC=$IDC";
    if(!empty($CERCA)) $opt['CERCA'] = "CERCA=$CERCA";
    if(!empty($PAGINA)) $opt['PAGINA'] = "PAGINA=$PAGINA";
    
    RETURN "?".implode( "&" , $opt);
}

function gestorPagines($CERCA , $CURSOS , $ACTIU)
{
  if($CURSOS->haveToPaginate())
  {       
     echo link_to(image_tag('tango/16x16/actions/go-previous.png'), 'gestio/gCursos'.getParam(($ACTIU)?'CA':'CI',NULL,$CERCA , $CURSOS->getPreviousPage()));
     echo " ";
     echo link_to(image_tag('tango/16x16/actions/go-next.png'), 'gestio/gCursos'.getParam(($ACTIU)?'CA':'CI',NULL,$CERCA, $CURSOS->getNextPage()));
  }
}

?>