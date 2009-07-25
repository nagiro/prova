<STYLE>
.cent { width:100%; }
.vuitanta { width:80%; }
.cinquanta { width:50%; }
.HTEXT { height:100px; }
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
		if(vacio(D_IDENTIFICADOR.value) == false) { alert('L\'identificador no pot estar buit.'); return false; }
		if(vacio(D_NUMSERIE.value) == false) { alert('El número de sèrie no pot estar buit.'); return false; }		
		if(vacio(D_NOM.value) == false) { alert('El nom no pot estar buit.'); return false; } 		 
		if(vacio(D_UBICACIO.value) == false) { alert('La localització no pot estar buit.'); return false; }
		
		if(vacio(D_DATACOMPRA.value) && !validaData(D_DATACOMPRA.value)) { alert('La data compra té un format incorrecte.'); return false; } 
		if(vacio(D_DATAGARANTIA.value) && !validaData(D_DATAGARANTIA.value)) { alert('La data de garantia té un format incorrecte.'); return false; }
		if(vacio(D_DATAREVISIO.value) && !validaData(D_DATAREVISIO.value)) { alert('La data de propera revisió té un format incorrecte.'); return false; }
		if(vacio(D_DATACESSIO.value) && !validaData(D_DATACESSIO.value)) { alert('La data de cessió té un format incorrecte.'); return false; }
		if(vacio(D_DATARETORN.value) && !validaData(D_DATARETORN.value)) { alert('La data de retorn té un format incorrecte.'); return false; }
		if(vacio(D_DATABAIXA.value) && !validaData(D_DATABAIXA.value)) { alert('La data de baixa té un format incorrecte.'); return false; }
		if(vacio(D_DATAREPARACIO.value) && !validaData(D_DATAREPARACIO.value)) { alert('La data de reparació té un format incorrecte.'); return false; }
				 
	}

</script>
   
    <TD colspan="3" class="CONTINGUT">
    
      
    <form action="<?php echo url_for('gestio/gMaterial') ?>" method="POST">
	    <DIV class="REQUADRE">
	    	<table class="FORMULARI">          
	            <?php echo $FCerca ?>
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="BCERCA" value="Prem per buscar" />
	            		<input type="submit" name="BNOU" value="Nou contacte" />
	            	</td>
	            </tr>
	        </table>
	     </DIV>
     </form>   
  
  
        <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Llistat de material (<?=$MATERIALS->getNbResults() ?>)</DIV>
                <TABLE class="DADES">
                <? if($MATERIALS->getNbResults() == 0): ?><TR><TD colspan = "2" class="LINIA">No s'ha trobat material disponible.</TD></TR><? endif; ?> 				
                <? foreach($MATERIALS->getResults() as $M): ?>
					<TR><TD class="LINIA"><?=link_to($M->getIdentificador(),'gestio/gMaterial'.getParam('E',$M->getIdmaterial(),$TIPUS,$PAGINA))?></TD>
					    <TD class="LINIA"><?=$M->getNom()?></TD></TR>                                	
                <? endforeach; ?>                
                <TR><TD colspan="3" class="TITOL"><?=gestorPagines($TIPUS , $MATERIALS);?></TD></TR>
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>
  
  
      
<?php IF( $NOU || $EDICIO ): ?>
      
<TABLE class="BOX">
  <TR>
    <TD class="NOTICIA">
      <TR>
        <TD class="NOTICIA">
          <TABLE width="100%">
            <TR>
              <?php IF(!$NOU) ECHO input_hidden_tag( 'IDM' , $MATERIAL->getIdmaterial() , $EDICIO ); ELSE  ECHO input_hidden_tag( 'IDM' , 0 );  ?>
              <TD class="TITOL" colspan="3">                CATEGORIA GLOBAL
                <BR />
                <?php ECHO select_tag('D[MATERIALGENERIC]',options_for_select(MaterialgenericPeer::select() , $MATERIAL->getMaterialgenericIdmaterialgeneric() ) , ARRAY( 'class' => 'cent' ) ); ?>
              </TD>
            </TR>
            <TR>
              <TD class="TITOL" >                IDENTIFICADOR
                <BR />
                <?php ECHO input_tag( 'D[IDENTIFICADOR]' , $MATERIAL->getIdentificador() , ARRAY( 'class' => 'cent' ) ); ?>
              </TD>
              <TD class="TITOL" >                NO SERIE
                <BR />
                <?php ECHO input_tag( 'D[NUMSERIE]' , $MATERIAL->getNumserie() , ARRAY( 'class' => 'cent' ) ); ?>
              </TD>
              <TD class="TITOL" >                NOM
                <BR />
                <?php ECHO input_tag( 'D[NOM]' , $MATERIAL->getNom() , ARRAY( 'class' => 'cent' ) ); ?>
              </TD>
            </TR>
            <TR>
              <TD class="TITOL" colspan="3" >                LOCALITZACIÓ
                <BR />
                <?php ECHO input_tag( 'D[UBICACIO]' , $MATERIAL->getUbicacio() , ARRAY( 'rich'=>TRUE, 'class' => 'cent' ) ); ?>
              </TD>
            </TR>
            <TR>
              <TD class="TITOL" >                DATA COMPRA
                <BR />
                <?php ECHO input_date_tag( 'D[DATACOMPRA]' , $MATERIAL->getDatacompra() , ARRAY( 'rich'=>TRUE, 'class' => 'vuitanta' ) ); ?>
              </TD>
              <TD class="TITOL" >                DATA FI GARANTIA
                <BR />
                <?php ECHO input_date_tag( 'D[DATAGARANTIA]' , $MATERIAL->getDatagarantia() , ARRAY( 'rich'=>TRUE, 'class' => 'vuitanta' ) ); ?>
              </TD>
              <TD class="TITOL" >                DATA PRÒXIMA REVISIÓ
                <BR />
                <?php ECHO input_date_tag( 'D[DATAREVISIO]' , $MATERIAL->getDatarevisio() , ARRAY( 'rich'=>TRUE, 'class' => 'vuitanta' ) ); ?>
              </TD>
            </TR>
            <TR>
              <TD class="TITOL" >                NUM. FACTURA
                <BR />
                <?php ECHO input_tag( 'D[NUMFACTURA]' , $MATERIAL->getNumfactura() , ARRAY( 'class' => 'cent' ) ); ?>
              </TD>
              <TD class="TITOL" >                PREU
                <BR />
                <?php ECHO input_tag( 'D[PREU]' , $MATERIAL->getPreu() , ARRAY( 'class' => 'cent' ) ); ?>
              </TD>
              <TD class="TITOL" >                NOTES MANTENIMENT
                <BR />
                <?php ECHO input_tag( 'D[NOTESMANTENIMENT]' , $MATERIAL->getNotesmanteniment() , ARRAY( 'class' => 'cent' ) ); ?>
              </TD>
            </TR>
            <TR>
              <TD class="TITOL" >                CEDIT A
                <BR />
                <?php ECHO input_tag( 'D[CEDIT]' , $MATERIAL->getCedit() , ARRAY( 'rich'=>TRUE, 'class' => 'cent' ) ); ?>
              </TD>
              <TD class="TITOL" >                DATA CESSIÓ
                <BR />
                <?php ECHO input_date_tag( 'D[DATACESSIO]' , $MATERIAL->getDatacessio() , ARRAY( 'rich'=>TRUE, 'class' => 'vuitanta' ) ); ?>
              </TD>
              <TD class="TITOL" >                DATA RETORN
                <BR />
                <?php ECHO input_date_tag( 'D[DATARETORN]' , $MATERIAL->getDataretorn() , ARRAY( 'rich'=>TRUE, 'class' => 'vuitanta' ) ); ?>
              </TD>
            </TR>
            <TR>
              <TD class="TITOL" >                DATA BAIXA
                <BR />
                <?php ECHO input_date_tag( 'D[DATABAIXA]' , $MATERIAL->getDatabaixa() , ARRAY( 'rich'=>TRUE, 'class' => 'vuitanta' ) ); ?>
              </TD>
              <TD class="TITOL" >                EN REPARACIO FINS
                <BR />
                <?php ECHO input_date_tag( 'D[DATAREPARACIO]' , $MATERIAL->getDatareparacio() , ARRAY( 'rich'=>TRUE, 'class' => 'vuitanta' ) ); ?>
              </TD>
              <TD class="TITOL" >                DISPONIBLE
                <BR />
                <?php ECHO checkbox_tag( 'D[DISPONIBLE]' , TRUE , $MATERIAL->getDisponible() ); ?>
              </TD>
            </TR>
            <TR>
              <TD class="TITOL" colspan="3">                DESCRIPCIÓ
                <BR />
                <?php ECHO textarea_tag( 'D[DESCRIPCIO]' , $MATERIAL->getDescripcio() , ARRAY( 'class' => 'cent HTEXT' ) ); ?>
              </TD>
            </TR>
            <TR>
              <TD class="TITOL" colspan="2">
                <?php ECHO submit_tag( 'Guarda' , ARRAY(  'name' => 'BSAVE' , 'class' => 'cent' ) );  ?>
              </TD>
              <TD class="TITOL">
                <?php ECHO submit_tag( 'Esborrar' , ARRAY(  'name' => 'BDELETE' , 'class' => 'cent' , 'onClick' => "return confirm('Segur que vols esborrar aquest registre?');" ));  ?>
              </TD>
            </TR>
          </TABLE>
        </TD>
      </TR>
</TABLE>

<?php ENDIF; ?>
    
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
    

  <?php 

function getParam( $accio = "" , $IDM = "" , $TIPUS = "" , $PAGINA = 1)
{
    $opt = array();
    if(!empty($accio)) $opt[] = "accio=$accio";
    if(!empty($IDM)) $opt['IDM'] = "IDM=$IDM";
    if(!empty($TIPUS)) $opt['TIPUS'] = "TIPUS=$TIPUS";
    if(!empty($PAGINA)) $opt['PAGINA'] = "PAGINA=$PAGINA";
    
    RETURN "?".implode( "&" , $opt);
}

function gestorPagines($TIPUS , $MATERIALS)
{
  if($MATERIALS->haveToPaginate())
  {       
     echo link_to(image_tag('tango/16x16/actions/go-previous.png'), 'gestio/gMaterial'.getParam(null,null,$TIPUS,$MATERIALS->getPreviousPage()));
     echo " ";
     echo link_to(image_tag('tango/16x16/actions/go-next.png'), 'gestio/gMaterial'.getParam(null,null,$TIPUS,$MATERIALS->getNextPage()));
  }
}

?>
 