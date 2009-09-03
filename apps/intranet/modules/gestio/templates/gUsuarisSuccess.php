<?php use_helper('Form') ?>

    <TD colspan="3" class="CONTINGUT">
    
   	<form action="<?php echo url_for('gestio/gUsuaris') ?>" method="POST">
	    <DIV class="REQUADRE">
	    	<table class="FORMULARI">          
	            <?php echo $FCerca ?>
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="BCERCA" value="Prem per buscar" />
	            		<input type="submit" name="BNOU" value="Nou usuari" />
	            	</td>
	            </tr>
	        </table>
	     </DIV>
     </form>  

	<?php IF($MODE['CONSULTA']): ?>

     <DIV class="REQUADRE">
        <DIV class="TITOL">Llistat d'usuaris (<?php echo $PAGER_USUARIS->getNbResults()?>)</DIV>
      	<TABLE class="DADES">
      			<?php 
                	if($PAGER_USUARIS->getNbResults() == 0):
                  		echo '<TR><TD class="LINIA" colspan="4">No s\'ha trobat cap usuari.</TD></TR>';
                 	else:                 
	                 	foreach($PAGER_USUARIS->getResults() as $U):
		                 	echo '	<TR><TD class="LINIA">'.link_to($U->getDni(),'gestio/gUsuaris'.getPar($PAGINA,$U->getusuariid(),'E')).'</TD>
		                        		<TD class="LINIA">'.$U->getNomComplet().'</TD>
		                        		<TD class="LINIA">'.$U->getTelefon().'</TD> 
		                        		<TD class="OPCIONS">'.creaOpcions($PAGINA, $U->getusuariid(), NULL).'</TD>
		                    		</TR>';                                   
	                	endforeach;                    
	                	echo '<TR><TD>'.gestorPaginesUsuaris( $PAGER_USUARIS ).'</TD></TR>';
	            	endif;
	            ?> 
      	</TABLE>      
      </DIV>

  <?php ENDIF; ?>
  
  <?php IF($MODE['NOU'] || $MODE['EDICIO'] ): ?>
      
	<form action="<?php echo url_for('gestio/gUsuaris') ?>" method="post" enctype="multipart/form-data">            
	 	<DIV class="REQUADRE">
	    	<table class="FORMULARI" width="500px">
                <?php echo $FUsuari?>                								
                <tr>
                	<td width="100px"></td>               	
	            	<td class="dreta" width="400px">
	            		<br>
	            		<?php echo submit_image_tag('icons/Colored/PNG/action_check.png',array('name'=>'BSAVE'))?>
	            		<?php echo link_to(image_tag('icons/Colored/PNG/action_delete.png'),'gestio/gUsuaris',array('confirm'=>'Segur que vols esborrar-lo?'))?>
	            	</td>
	            </tr>                	 
      		</TABLE>
      	</DIV>
     </form>    
  
  <?php ENDIF;?>
  
  <?php IF($MODE['LLISTES']): ?>

	<form action="<?php echo url_for('gestio/gUsuaris') ?>" method="post">
     <DIV class="REQUADRE">
        <DIV class="TITOL">Llistes subscrites</DIV>
      	<TABLE class="DADES">
                <?php
                                                     
                  if($USUARI->countUsuarisllistess() == 0) echo '<TR><TD class="LINIA" colspan="5">L\'Usuari no està subscrit a cap llista.</TD></TR>';                                    
                  foreach($USUARI->getUsuarisllistess() as $L):                  
                      echo '<TR>
                       			<TD width="10px" class="LINIA">'.checkbox_tag('D[IDL][]',$L->getLlistesIdllistes(),false).'<TD class="LINIA">'.$L->getLlistes()->getNom().'</TD>                                                           
                            </TR>';                                   
                  endforeach;                                  
                  echo '<TR><TD colspan="2">'.submit_tag('DESVINCULA',array('name'=>'BDESVINCULA')).'</TD></TR>';
                                    
                ?>
      	</TABLE>      
      </DIV>
  
     <DIV class="REQUADRE">
        <DIV class="TITOL">Llistes disponibles</DIV>
      	<TABLE class="DADES">
                  <?php
                                                     
	                  if(empty($LLISTAT_LLISTES)) echo '<TR><TD class="LINIA" colspan="5">No s\'ha trobat cap llista disponible.</TD></TR>';                                    
	                  foreach($LLISTAT_LLISTES as $IDL => $L):                  
	                      echo '<TR>
	                       			<TD width="10px" class="LINIA">'.checkbox_tag('D[IDL][]',$IDL,false).'<TD class="LINIA">'.$L.'</TD>                                                           
	                            </TR>';                                   
	                  endforeach;                                  
	                  echo '<TR><TD colspan="2">'.submit_tag('VINCULA',array('name'=>'BVINCULA')).'</TD></TR>';
                                    
                ?>
      	</TABLE>      
      </DIV>
      </form>
    
  <?php ENDIF;?>
  
  <?php IF($MODE['CURSOS']): ?>

     <DIV class="REQUADRE">
        <DIV class="TITOL">Llistat de matrícules (<?php echo link_to('Nova matricula','gestio/gMatricules?accio=N&IDU='.$USUARI->getUsuariid()); ?>)</DIV>
      	<TABLE class="DADES">
                <?php                 
                  if($USUARI->countMatriculess() == 0) echo '<TR><TD class="LINIA" colspan="5">L\'Usuari no ha fet cap curs a la Casa de Cultura.</TD></TR>';                                    
                  foreach($USUARI->getMatriculess() as $M):
                      $CURSOS = $M->getCursos();                      
                      echo '<TR><TD class="LINIA">'.$CURSOS->getCodi().'</TD>
                                <TD class="LINIA">'.$CURSOS->getTitolCurs().'</TD>
                                <TD class="LINIA">'.$M->getEstat().'</TD>
                                <TD class="LINIA">'.$M->getDataInscripcio().'</TD>
                                <TD class="LINIA">'.$M->getDescompte().'</TD>
                                <TD class="LINIA">'.$M->getComentari().'</TD>                                                                                           
                            </TR>';                                   
                  endforeach;                                                    
                ?>
      	</TABLE>      
      </DIV>
  
  <?php ENDIF; ?>
  
  <?php IF($MODE['REGISTRES']): ?>

     <DIV class="REQUADRE">
        <DIV class="TITOL">Llistat de reserves</DIV>
      	<TABLE class="DADES">
                <?php
                                  
                  if($USUARI->countReservaespaiss() == 0) echo '<TR><TD class="LINIA" colspan="5">L\'Usuari no ha fet cap reserva.</TD></TR>';                                    
                  foreach($USUARI->getReservaespaiss() as $R):                                            
                      echo "<TR><TD class=\"LINIA\">".link_to($R->getNom(),'gestio/gReserves?accio=E&IDR='.$R->getReservaespaiid())."</TD><TD class=\"LINIA\">".$R->getUsuaris()->getNomComplet()."</TD><TD class=\"LINIA\">".$R->getDataactivitat()."</TD><TD class=\"LINIA\">".$R->getEstatText()."<TD></TR>";
                  endforeach;                                  

                ?>
      	</TABLE>      
      </DIV>

  <?php ENDIF; ?>
    
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
    
    
<!-- FI CONTINGUT -->
<!-- CALENDARI -->
 <!-- >
    <TD class="CALENDARI">          
      
    </TD>
-->
<!-- FI CALENDARI -->

<?php 

	function creaOpcions($PAGINA, $IDU, $ACCIO)
	{  
	
	  $R  = link_to('L','gestio/gUsuaris'.getPar($PAGINA,$IDU,'L')).' ';
	  $R .= link_to('C','gestio/gUsuaris'.getPar($PAGINA,$IDU,'C')).' ';  
	  $R .= link_to('R','gestio/gUsuaris'.getPar($PAGINA,$IDU,'R')).' ';
	   
	  return $R;
	}
	
	
	function fletxeta()
	{
	  return image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE'));
	}
	
	
	function getPar($PAGINA = "", $IDU = "", $ACCIO = "")
	{
	   
	    $A = ""; 
	    if(!empty($PAGINA)) $A[] = 'PAGINA='.$PAGINA;
	    if(!empty($IDU)) $A[] = 'IDU='.$IDU;
	    if(!empty($ACCIO)) $A[] = 'accio='.$ACCIO;
	    if(!empty($A)) return '?'.implode('&',$A); 
	    else return '';
	    
	}
	
	
	function gestorPaginesUsuaris( $USUARIS )
	{
	   if($USUARIS->haveToPaginate())
	   {       
	      echo link_to(image_tag('tango/16x16/actions/go-previous.png'), "gestio/gUsuaris".getPar($USUARIS->getPreviousPage()));
		  echo " ";
		  echo link_to(image_tag('tango/16x16/actions/go-next.png'), "gestio/gUsuaris".getPar($USUARIS->getNextPage()));
	   }
	}

?>