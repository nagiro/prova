<?php use_helper('Form')?>
 

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
        
    <form action="<?php echo url_for('gestio/gMatricules') ?>" method="POST">
	    <DIV class="REQUADRE">
	    	<table class="FORMULARI">          
	            <?php echo $FCerca ?>
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="BCERCA" value="Prem per buscar" />
	            		<input type="submit" name="BNOU" value="Nova matrícula" />
	            	</td>
	            </tr>
	        </table>
	     </DIV>
     </form>   

	<?php IF($MODE['CONSULTA']): ?>      
        
    	<?php IF($SELECT == 2): ?>

	      <DIV class="REQUADRE">
	        <DIV class="TITOL">Llistat d'alumnes</DIV>
	      	<TABLE class="DADES">
	 			<?php 
					if( $ALUMNES->getNbResults() == 0 ):					
						echo '<TR><TD class="LINIA" colspan="3">No hi ha cap alumne amb aquests paràmetres.</TD></TR>';						
					else:					 
						echo '<TR><TD class="TITOL">DNI</TD><TD class="TITOL">Nom</TD></TR>';
						
						$i = 0;						
						foreach($ALUMNES->getResults() as $A):						
	                      	$PAR = ParImpar($i++);                	
	                    	echo '<TR>							
									<TD class="LINIA">'.link_to($A->getDni(),'gestio/gMatricules?accio=LMA&IDA='.$A->getUsuariid()).'</TD>
								    <TD class="LINIA">'.$A->getNomComplet().'</TD>
							      </TR>';
							                		                 															                		                 															
	                    endforeach;
	                  
	                 endif;                     
	             ?>      
	              <TR><TD colspan="3" class="TITOL"><?php echo gestorPagines($ALUMNES);?></TD></TR>    	
	      	</TABLE>      
	      </DIV>

	     <?php else: ?>

	      <DIV class="REQUADRE">
	        <DIV class="TITOL">Llistat de cursos </DIV>
	      	<TABLE class="DADES">
	 			<?php 
					if( $CURSOS->getNbResults() == 0 ):
						echo '<TR><TD class="LINIA" colspan="3">No hi ha cap curs amb aquests paràmetres.</TD></TR>';
					else: 
						echo '<TR><TD class="TITOL">CODI</TD><TD class="TITOL">NOM</TD><TD class="TITOL">DATA INICI</TD></TR>';
						$i = 0;
						foreach($CURSOS->getResults() as $C):
	                      	$PAR = ParImpar($i++);
	                      	echo '<TR>							
									<TD class="LINIA">'.link_to($C->getCodi(),'gestio/gMatricules?accio=LMC&IDC='.$C->getIdcursos()).'</TD>
									<TD class="LINIA">'.$C->getTitolcurs().'</TD>
									<TD class="LINIA">'.$C->getDatainici('d/m/Y').'</TD>
								  </TR>';                		                 															                		                 															
	                    endforeach;
	                 endif;                     
	             ?>      
	              <TR><TD colspan="3" class="TITOL"><?php echo gestorPagines($CURSOS);?></TD></TR>    	
	      	</TABLE>      
	      </DIV>

	     <?php endif; ?>

  <?php ELSEIF( $MODE['NOU'] || $MODE['EDICIO'] ):  ?>

	 <form action="<?php echo url_for('gestio/gMatricules') ?>" method="POST">
	    <DIV class="REQUADRE">	    
	    	<table class="FORMULARI">
	    		<tr><td width="100px"></td><td></td></tr>	    			    		        
	            <?php echo $FMatricula ?>	            
	            <tr>
	            	<td colspan="2" class="dreta">
	            		<br>	            	
	            			<?php echo submit_image_tag('icons/Colored/PNG/action_check.png',array('value'=>'SAVE','name'=>'BSUBMIT'))?>
	            			<?php echo link_to(image_tag('icons/Colored/PNG/action_delete.png'),'gestio/gCursos',array('name'=>'BDELETE','confirm'=>'Segur que vols esborrar-lo?'))?>	            		
	            	</td>
	            </tr>
	        </table>
	     </DIV>
     </form>
        
  <?php ELSEIF( $MODE['LMATRICULES']): ?>
  
  	     <DIV class="REQUADRE">
	        <DIV class="TITOL">Llistat de matriculats </DIV>
	      	<TABLE class="DADES">
	 			<?php 
					if( sizeof($MATRICULES) == 0):
						echo '<TR><TD class="LINIA" colspan="3">No hi ha cap matrícula amb aquests paràmetres.</TD></TR>';
					else: 
						echo '<TR><TD class="TITOL">DNI</TD><TD class="TITOL">NOM</TD><TD class="TITOL">DATA INICI</TD></TR>';
						$i = 0;
						foreach($MATRICULES as $M):
				            $C = $M->getCursos();
				            $U = $M->getUsuaris();
				            $TEXT_REDUCCIO ="";
				            if($M->getTreduccio() == MatriculesPeer::REDUCCIO_CAP) { $PREU = $C->getPreu(); } else { $PREU = $C->getPreur(); $TEXT_REDUCCIO = ' |R'; }
				            echo '<TR>
									<TD class="LINIA" width="15%">'.link_to($U->getDni(),'gestio/gMatricules?accio=E&IDM='.$M->getIdmatricules()).'</TD>
									<TD class="LINIA" width="40%">'.$U->getNomComplet().'<BR />'.$U->getTelefon().' | '.$M->getDatainscripcio().'</TD>
									<TD class="LINIA" width="45%">'.$C->getCodi().' '.$C->getTitolcurs().' ('.$PREU.'€'.$TEXT_REDUCCIO.') <br />
								                     		       '.MatriculesPeer::getEstatText($M->getEstat()).' '.$M->getComentari().'</TD>							
								  </TR>';                		                 															                		                 															
	                   endforeach; 	                  
	                 endif;       
	            ?>
	      	</TABLE>      
	      </DIV>
  
  
  <?php ELSEIF( $MODE['VERIFICA'] ):

     //Si hem fet una matrícula amb targeta, haurem de pagar per TPV i hem de canviar el form. 

     if($FMatricula->getValue('tPagament') == MatriculesPeer::PAGAMENT_TARGETA || $FMatricula->getValue('tPagament') == MatriculesPeer::PAGAMENT_TELEFON ):
     	 
         echo '<FORM name="COMPRA" action="https://sis-t.sermepa.es:25443/sis/realizarPago" method="POST" target="TPV">';
//         echo '<FORM name="COMPRA" action="https://sis.sermepa.es/sis/realizarPago" method="POST" target="TPV">';
                  
         foreach($TPV as $K => $T) echo input_hidden_tag($K,$T);
         
     else:
     
     	 echo '<form action="'.url_for('gestio/gMatricules').'" method="POST">';         
         
     endif;
	   
	?>	
	 <form action="<?php echo url_for('gestio/gMatricules') ?>" method="POST">
	    <DIV class="REQUADRE">
	    	<DIV class="TITOL">Verificació de matrícula</DIV>	    
	    	<table class="FORMULARI">
	    		<tr><td width="100px"></td><td></td></tr>	    			    		        
	            <?php echo $FMatricula ?>	            
	            <tr>
	            	<td colspan="2" class="dreta">
	            		<br>	            	
	            			<?php echo submit_tag('Pagar',array('name'=>'BPAGAR'))?>	            				            		
	            	</td>
	            </tr>
	        </table>
	     </DIV>
     </form>
      
  <?php ENDIF; ?>
  
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    

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
