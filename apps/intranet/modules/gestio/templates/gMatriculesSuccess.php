<STYLE>
.cent { width:100%; }
.noranta { width:90%; }
.vuitanta  { width:80%; }
.setanta { width:75%; }
.cinquanta { width:50%; }
.HTEXT { height:100px; }
.espai { padding-left:5px; padding-right:5px; }

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
        
      <?php echo nice_form_tag('gestio/gMatricules',array('method'=>'post')); ?>

      <TABLE class="BOX">
        <TR><TD class="NOTICIA">        		
        		<div class="TITOL">Cerca matricules</DIV>                                                              
				<div class="CERCA">
				   <?php 
				   echo input_tag('CERCA', $CERCA , array('class'=>'cinquanta'));
				   echo " ";
				   echo select_tag('CERCA_TIPUS',options_for_select(array('cursos'=>'Cursos','alumnes'=>'Alumnes'),$CERCA_TIPUS));
				   echo " ";
				   echo submit_tag('Cerca',array('name'=>'BCERCA'));
				   echo ' ';
				   echo submit_tag('Nova matrícula',array('name'=>'BNOU')); 
				   ?>				  
				 </DIV>										 
            </TD>
        </TR>
      </TABLE>

	<?php IF($LMATRICULATS): ?>      
        
	      <TABLE class="BOX">
	        <TR><TD class="NOTICIA">                
	                <DIV class="TITOL">Llistat de matrícules (<?=sizeof($MATRICULATS)?>)</DIV>
	                <TABLE class="DADES">
		                <? if(sizeof($MATRICULATS) == 0): ?> <TR><TD class="LINIA">No s'ha trobat cap matrícula.</TD></TR>	                    
	                    <? endif; ?>   	                                          									                         
		                <? foreach($MATRICULATS as $M): //$M = new Matricules(); ?>
                    	<? $U = $M->getUsuaris(); $CURS = $M->getCursos(); $TEXT_REDUCCIO = ""; ?>
                    	<? if($M->getTreduccio() == MatriculesPeer::REDUCCIO_CAP) { $PREU = $CURS->getPreu(); } else { $PREU = $CURS->getPreur(); $TEXT_REDUCCIO = ' |R'; } ?>				                    
						<TR>
							<TD class="LINIA" width="15%"><?=link_to($U->getDni(),'gestio/gMatricules'.getParamMatricula( $M->getIdmatricules() ))?></TD>
							<TD class="LINIA" width="40%"><?=$U->getNomComplet()?></TD>
							<TD class="LINIA" width="45%"><?=$CURS->getCodi()?> <?=MatriculesPeer::getEstatText($M->getEstat())?> (<?=$PREU?>€ <?=$TEXT_REDUCCIO?>) <br />
							</TD>							
						  </TR>                		                 															                		                 															
						<?php endforeach; ?>						 	               
	                </TABLE>                                                                  
	            </TD>
	        </TR>
	      </TABLE>

	<?php ENDIF; ?>
	<?php IF($EDITA_MATRICULA): ?>      
        
	      <TABLE class="BOX">
	        <TR><TD class="NOTICIA">                
	                <DIV class="TITOL">Edició de matrícula </DIV> <? //  $OMATRICULA = new Matricules(); ?>
	                <TABLE class="DADES">
		                <TR><TD class="LINIA">DNI : </TD><TD class="LINIA"><?=$OMATRICULA->getUsuaris()->getDni()?></TD></TR>
		                <TR><TD class="LINIA">DATA MATRÍCULA : </TD><TD class="LINIA"><?=$OMATRICULA->getDatainscripcio('d/m/Y') ?></TD></TR>
  		                <TR><TD class="LINIA">IMPORT : </TD><TD class="LINIA"><?=($OMATRICULA->getTreduccio() == MatriculesPeer::REDUCCIO_CAP)?$OMATRICULA->getCursos()->getPreu().'€':$OMATRICULA->getCursos()->getPreur().'€'; ?></TD></TR>
		                <TR><TD class="LINIA">CURS : </TD><TD class="LINIA"><?=$OMATRICULA->getCursos()->getCodi()." ".$OMATRICULA->getCursos()->getTitolcurs() ?></TD></TR>  		                
		                <TR><TD class="LINIA">PAGAMENT : </TD><TD class="LINIA"><?=select_tag('PAGAMENT',options_for_select(MatriculesPeer::selectPagament(),$OMATRICULA->getTpagament()))?></TD></TR>
		                <TR><TD class="LINIA">DESCOMPTE : </TD><TD class="LINIA"><?=select_tag('DESCOMPTE',options_for_select(MatriculesPeer::selectDescomptes(),$OMATRICULA->getTreduccio()))?></TD></TR>
		                <TR><TD class="LINIA">ESTAT : </TD><TD class="LINIA"><?=select_tag('ESTAT',options_for_select(MatriculesPeer::getEstatsSelect(),$OMATRICULA->getEstat()))?></TD></TR>
		                <TR><TD class="LINIA">COMENTARI: </TD><TD class="LINIA"><?=input_tag('COMENTARI',$OMATRICULA->getComentari()) ?></TD></TR>		                         
	                </TABLE>                                                                  
	            </TD>
	        </TR>
	      </TABLE>
	      
	      <TABLE class="BOX">
	        <TR><TD class="NOTICIA">                
	                <DIV class="TITOL">Cursos disponibles</DIV>
	                <TABLE class="DADES">                        									                        
		                <? foreach($LCURSOS->getResults() as $C): ?>                    					                    
						<TR>
							<TD class="LINIA" width="10%"><?=radiobutton_tag('CURS',$C->getIdcursos(),($C->getIdcursos()==$OMATRICULA->getCursosIdcursos()))?></TD>							
							<TD class="LINIA" width="70%"><?=$C->getCodi().' '.$C->getTitolcurs()?></TD>
							<TD class="LINIA" width="20%"><?=$C->getDatainici('d/m/Y')?></TD>							
							</TD>							
						  </TR>                		                 															                		                 															
						<?php endforeach; ?>	
						<TR><TD colspan="3" class="TITOL"><?=gestorPaginesEdicioMatricula($IDM , $LCURSOS);?></TD></TR>					 	               
	                </TABLE>                                                                  
	            </TD>
	        </TR>
	      </TABLE>
	      	      

	<?php ENDIF; ?>
	<?php IF($CONSULTA): ?>      
        
    	<?php IF($CERCA_TIPUS == 'alumnes'): ?>
	      <TABLE class="BOX">
	        <TR><TD class="NOTICIA">                
	                <DIV class="TITOL">Llistat d'alumnes (<?=$ALUMNES->getNbResults()?>)</DIV>
	                <TABLE class="DADES">
		                <?php if($ALUMNES->getNbResults() == 0): ?> <TR><TD class="LINIA">No hi ha cap alumne amb aquests paràmetres.</TD></TR>
	                    <? else:  ?><TR><TD class="TITOL">DNI</TD><TD class="TITOL">Nom</TD></TR>
	                    <? endif; ?>                         									                          
		                <?php foreach($ALUMNES->getResults() as $A): ?>
							<TR>							
								<TD class="LINIA"><?=link_to($A->getDni(),'gestio/gMatricules?accio=LMA&IDA='.$A->getUsuariid())?></TD>
								<TD class="LINIA"><?=$A->getNomComplet()?></TD>
							</TR>                		                 															
						<?php endforeach; ?>
						 	<TR><TD colspan="2" class="TITOL"><?=gesorPaginesCerca($CERCA, $CERCA_TIPUS, $ALUMNES);?></TD></TR>						 	               
	                </TABLE>                                                                  
	            </TD>
	        </TR>
	      </TABLE>
	     <?php else: ?>
	      <TABLE class="BOX">
	        <TR><TD class="NOTICIA">                
	                <DIV class="TITOL">Llistat de cursos (<?=$CURSOS->getNbResults()?>)</DIV>
	                <TABLE class="DADES">
		                <? if($CURSOS->getNbResults() == 0): ?> <TR><TD class="LINIA">No hi ha cap curs amb aquests paràmetres.</TD></TR>
	                    <? else: ?><TR><TD class="TITOL">CODI</TD><TD class="TITOL">NOM</TD><TD class="TITOL">DATA INICI</TD></TR>
	                    <? endif; ?>                         									                          
		                <? foreach($CURSOS->getResults() as $C): ?>
							<TR>							
								<TD class="LINIA"><?=link_to($C->getCodi(),'gestio/gMatricules?accio=LMC&IDC='.$C->getIdcursos())?></TD>
								<TD class="LINIA"><?=$C->getTitolcurs()?></TD>
								<TD class="LINIA"><?=$C->getDatainici('d/m/Y')?></TD>
							</TR>                		                 															
						<? endforeach; ?>
							<TR><TD colspan="3" class="TITOL"><?=gesorPaginesCerca($CERCA, $CERCA_TIPUS, $CURSOS);?></TD></TR>		                
	                </TABLE>                                                                  
	            </TD>
	        </TR>
	      </TABLE>	     	     
	     <?php endif; ?>

  <?php ENDIF; ?>
  <?php IF( $NOU || $EDICIO ): ?>
            
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Formulari de matrícula</DIV>				
  				<?php echo input_hidden_tag('IDM',$IDM); ?>  				
  				<?php echo input_hidden_tag('D[IDU]',$USUARI_MATRICULA->getUsuariid()); ?>
				<TABLE class="DADES" width="100%">
                  	<TR>
                  		<TD width="50%"><span class="TITOL">DNI </span><BR /><?php echo input_tag('D[DNI]',$USUARI_MATRICULA->getDni(), array('DISABLED'=>true, 'class'=>'vuitanta')); ?></TD>
                  		<TD width="50%"><span class="TITOL">NOM</span><BR /><?php echo input_tag('D[NOM]',$USUARI_MATRICULA->getNomcomplet(), array('DISABLED'=>true, 'class'=>'vuitanta')); ?></TD>              
                  	</TR>
                  	<TR>
                  		<TD><BR /><span class="TITOL">DESCOMPTE </span><BR /><?php echo select_tag('D[DESCOMPTE]', options_for_select(MatriculesPeer::selectDescomptes(),0),array('class'=>'noranta')); ?></TD>
                  		<TD><BR /><span class="TITOL">MODALITAT PAGAMENT</span><BR /><?php echo select_tag('D[MODALITAT]', options_for_select(MatriculesPeer::selectPagament(),0),array('class'=>'noranta')); ?></TD>              
                  	</TR>
                  	<TR>
                  		<TD COLSPAN="2"><BR /><span class="TITOL">COMENTARI</span><BR /><?php echo input_tag('D[COMENTARI]', NULL , array('class'=>'cent')); ?></TD>                  		              
                  	</TR>
                </TABLE>
                <Br /><Br />
                <TABLE class="DADES" width="100%">
                  	         	
                  		<?php                   		   
                  		   if(empty($CURSOS)) echo '<TR><TD colspan="2" class="LINIA">No hi ha cap curs disponible actualment.</TD></TR>';                  		
                  		   else {
/*                  		      echo '<TR>
                  		      			<TD class="TITOL">              </TD>
                  		      			<TD class="TITOL">CODI          </TD>
                  		      			<TD class="TITOL">NOM CURS      </TD>
                  		      			<TD class="TITOL">HORARIS       </TD>
                  		      			<TD class="TITOL">PREU          </TD>
                  		      			<TD class="TITOL">DATA D\'INICI </TD>
                  		      		</TR>';*/
                              $CATANT = "";
                  		      foreach($CURSOS as $C):
//	                  		      $C = new Cursos();
                                  
                                  if($CATANT <> $C->getCategoria()) echo '<TR><TD colspan="6" class="TITOL">'.$C->getCategoria().'</TD></TR>';
                                  echo '<TR>'; 
                                  echo '<TD class="LINIA">'.checkbox_tag('D[CURSOS][]',$C->getIdcursos(),false).'</TD>';
                  		          echo '<TD class="LINIA">'.$C->getCodi().'</TD>';
	                  		      echo '<TD class="LINIA">'.$C->getTitolcurs().'</TD>';
	                  		      echo '<TD class="LINIA">'.$C->getHoraris().'</TD>';
                                  echo '<TD class="LINIA">'.$C->getPreu().' €</TD>';
	                  		      echo '<TD class="LINIA">'.$C->getDatainici('d/m/Y').'</TD>';	                  		      
	                  		      echo '<TD class="LINIA">'.$C->getMatriculats().'/'.$C->getPlaces().'</TD>';
	                  		      echo '</TR>';
	                  		      
	                  		      $CATANT = $C->getCategoria();
                  		   
                  		      endforeach;
                  		   }

                  		?>
                  		<TR><TD colspan="6"><?php echo submit_tag('Matricular',array('name'=>'BVERIFICACIO')); ?></TD></TR>                  	                  	
                </TABLE>
						                                                                 
            </TD>
        </TR>
      </TABLE>
	</form>
  <?php ENDIF; IF( $VERIFICACIO ):

  
     //Si la matricula es paga amb Targeta de crèdit, passem al TPV, altrament mostrem el comprovant
     echo '</form>';
     if($DADES_MATRICULA['MODALITAT'] == MatriculesPeer::PAGAMENT_TARGETA || $DADES_MATRICULA['MODALITAT'] == MatriculesPeer::PAGAMENT_TELEFON ):
     	 
         echo '<FORM name="COMPRA" action="https://sis-t.sermepa.es:25443/sis/realizarPago" method="POST" target="TPV">';
//         echo '<FORM name="COMPRA" action="https://sis.sermepa.es/sis/realizarPago" method="POST" target="TPV">';
                  
         foreach($TPV as $K => $T) echo input_hidden_tag($K,$T);
         
     else:
     
         echo nice_form_tag('gestio/gMatricules',array('method'=>'POST'));
         
         
     endif;

     //Carreguem totes les dades de matrícula
     foreach($DADES_MATRICULA as $K => $V) { $str = "DADES_MATRICULA[".$K."]"; echo input_hidden_tag($str,$V); }
     
		   
	?>	
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Verificació de la matrícula</DIV>				
				<TABLE class="DADES" width="100%">
					<?php  ?>
                  	<TR><TD class="LINIA"><span class="TITOL">DNI </span></TD>     <TD class="LINIA"><?php echo $DADES_MATRICULA['DNI']; ?></TD></TR>
                  	<TR><TD class="LINIA"><span class="TITOL">NOM </span></TD>     <TD class="LINIA"><?php echo $DADES_MATRICULA['NOM']; ?></TD></TR>
                  	<TR><TD class="LINIA"><span class="TITOL">PAGAMENT </span></TD><TD class="LINIA"><?php echo MatriculesPeer::textPagament($DADES_MATRICULA['MODALITAT']); ?></TD></TR>
                  	<TR><TD class="LINIA"><span class="TITOL">IMPORT </span></TD>  <TD class="LINIA"><?php echo $DADES_MATRICULA['PREU'].'€'; ?></TD></TR>
                  	<TR><TD class="LINIA"><span class="TITOL">DATA </span></TD>    <TD class="LINIA"><?php echo $DADES_MATRICULA['DATA']; ?></TD></TR>
                  	<TR><TD class="LINIA"><span class="TITOL">DESCOMPTE </span></TD>  <TD class="LINIA"><?php echo MatriculesPeer::textDescomptes($DADES_MATRICULA['DESCOMPTE']); ?></TD></TR>
                  	<TR><TD class="LINIA"><span class="TITOL">CURSOS </span></TD>  <TD class="LINIA">
                  								<TABLE width="100%">
                  								<?php foreach(explode('@',$DADES_MATRICULA['CURSOS']) as $C): ?>
                  								<?php $CURS = CursosPeer::retrieveByPK($C);      ?>                  								
	                  								<TR>
	                  									<TD class="LINIA"><?php echo $CURS->getCodi(); ?></TD>
	                  									<TD class="LINIA"><?php echo $CURS->getTitolcurs(); ?></TD>
	                  									<TD class="LINIA"><?php echo CursosPeer::CalculaPreu($C , $DADES_MATRICULA['DESCOMPTE']).'€'; ?></TD>
	                  								</TR>                  								                  								
                  	                           <?php endforeach; ?>
                  	                           </TABLE>
                  	                           </TD></TR>
                  		<TR><TD colspan="6"><?php echo submit_tag('Matricular',array('NAME'=>'BSAVE')); ?></TD></TR>                  	                                             	
                </TABLE>			                                  
            </TD>
        </TR>
      </TABLE>
      
	</FORM>
      
  <?php ENDIF; ?>
  
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    

<?php 

function gestorPaginesEdicioMatricula($IDM , $CURSOS)
{
  if($CURSOS->haveToPaginate())
  {       
     echo link_to(image_tag('tango/16x16/actions/go-previous.png'), 'gestio/gMatricules'.getParamPagina('EM',NULL,NULL,$CURSOS->getPreviousPage(),$IDM));
     echo " ";
     echo link_to(image_tag('tango/16x16/actions/go-next.png'), 'gestio/gMatricules'.getParamPagina('EM',NULL,NULL,$CURSOS->getNextPage(),$IDM));
  }
}

function gesorPaginesCerca($CERCA, $CERCA_TIPUS, $ALUMNES)
{
  if($ALUMNES->haveToPaginate())
  {       
     echo link_to(image_tag('tango/16x16/actions/go-previous.png'), 'gestio/gMatricules'.getParamPagina('C',$CERCA,$CERCA_TIPUS,$ALUMNES->getPreviousPage()));
     echo " ";
     echo link_to(image_tag('tango/16x16/actions/go-next.png'), 'gestio/gMatricules'.getParamPagina('C',$CERCA,$CERCA_TIPUS,$ALUMNES->getNextPage()));
  }
}

function getParamPagina( $accio , $CERCA , $CERCA_TIPUS , $PAGINA , $IDM = "" )
{
    $opt = array();
    if(!empty($accio)) $opt[] = "accio=$accio";
    if(!empty($CERCA)) $opt['CERCA'] = "CERCA=$CERCA";
    if(!empty($CERCA_TIPUS)) $opt['CERCA_TIPUS'] = "CERCA_TIPUS=$CERCA_TIPUS";
    if(!empty($PAGINA)) $opt['PAGINA'] = "PAGINA=$PAGINA";
    if(!empty($IDM)) $opt['IDM'] = "IDM=$IDM";
    
    RETURN "?".implode( "&" , $opt);   
}

function getParamMatricula( $IDM )
{
    $opt = array();
    $opt[] = "accio=EM";      
    if(!empty($IDM)) $opt['IDM'] = "IDM=$IDM";
    
    RETURN "?".implode( "&" , $opt);
}

function getParam( $accio , $IDC , $CERCA )
{
    $opt = array();
    if(isset($accio)) $opt[] = "accio=$accio";
    if(isset($IDC)) $opt['IDC'] = "IDC=$IDC";
    if(isset($CERCA)) $opt['CERCA'] = "CERCA=$CERCA";
    
    RETURN "?".implode( "&" , $opt);
}

?>