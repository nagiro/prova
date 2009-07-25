<STYLE>
.cent { width:100%; }
.vuitanta { width:80%; }
.cinquanta { width:50%; }
.HTEXT { height:100px; }

</STYLE>
   
    <TD colspan="3" class="CONTINGUT">
    
      <?php echo nice_form_tag('gestio/gIncidencies',array('method'=>'post','onSubmit'=>'return ValidaFormulari(this)')); ?>

      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                                                              
                <DIV class="TITOL">Cerca incidències</DIV>                
                <DIV class="CERCA"><?php echo input_tag('CERCA', $CERCA , array('class'=>'cinquanta')).submit_tag('Cerca',array('name'=>'BCERCA')).' '.submit_tag('Nova incidència',array('name'=>'BNOU')); ?></DIV>                                                                 
              </TD>
        </TR>
      </TABLE>
  
        <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Llistat d'incidències (<?=$INCIDENCIES->getNbResults() ?>)</DIV>
                <TABLE class="DADES">
                <? if($INCIDENCIES->getNbResults() == 0): ?><TR><TD colspan = "2" class="LINIA">No s'ha trobat cap incidència.</TD></TR><? endif; ?> 				
                <? foreach($INCIDENCIES->getResults() as $I):  ?>
					<TR><TD class="LINIA"><?=link_to($I->getTitol(),'gestio/gIncidencies'.getParam( 'E' , $CERCA , $I->getIdincidencia() , $PAGINA ))?></TD>
					    <TD class="LINIA"><?=$I->getEstatText()?></TD></TR>                                	
                <? endforeach; ?>                
                <TR><TD colspan="3" class="TITOL"><?=gestorPagines($CERCA , $INCIDENCIES);?></TD></TR>
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>
  
  
      
  <?php IF( $NOU || $EDICIO ): ?>
      
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Gestor d'incidències</DIV>
                <TABLE class="DADES" width="100%">                  
                  <?php If(!$NOU) echo input_hidden_tag( 'IDI' , $IDI ); else  echo input_hidden_tag( 'IDI' , 0 );  ?>                                      
                  <TR><TD class="LINIA" >Qui informa?</td><td><?=select_tag( 'D[QUIINFORMA]' , options_for_select( UsuarisPeer::selectTreballadors(), $INCIDENCIA->getQuiinforma() ) , array( 'class' => 'cent' ) ); ?></TD></TR>
                  <TR><TD class="LINIA" >Qui resol?</td><td><?=select_tag( 'D[QUIRESOL]' , options_for_select( UsuarisPeer::selectTreballadors(), $INCIDENCIA->getQuiresol() ) , array( 'class' => 'cent' ) ); ?></TD></TR>
				  <TR><TD class="LINIA" >Estat</td><td><?=select_tag( 'D[ESTAT]' , options_for_select( IncidenciesPeer::getEstatSelect(), $INCIDENCIA->getEstat() ) , array( 'class' => 'cent' ) ); ?></TD></TR>
                  <TR><TD class="LINIA" >Titol</td><td><?=input_tag( 'D[TITOL]' , $INCIDENCIA->getTitol() , array( 'class' => 'cent' ) ); ?></TD></TR>
                  <TR><TD class="LINIA" >Descripció</td><td><?=textarea_tag( 'D[DESCRIPCIO]' , $INCIDENCIA->getDescripcio() , array( 'class' => 'cent' ) ); ?></TD></TR>				  			  
                  <TR><TD class="LINIA" ></TD><TD><?php echo submit_tag( 'Guarda' , array(  'name' => 'BSAVE' , 'class' => 'cent' ) );  ?> </TD></TR>
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>
    

  <?php ENDIF; ?>
  
    
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
    

  <?php 
  
function getParam( $accio = "" , $CERCA = "" , $IDI = "" , $PAGINA = 1)
{
    $opt = array();
    if(!empty($accio)) $opt[] = "accio=$accio";
    if(!empty($IDI)) $opt['IDI'] = "IDI=$IDI";
    if(!empty($CERCA)) $opt['CERCA'] = "CERCA=$CERCA";
    if(!empty($PAGINA)) $opt['PAGINA'] = "PAGINA=$PAGINA";
    
    RETURN "?".implode( "&" , $opt);
}

function gestorPagines($CERCA , $INCIDENCIES)
{
  if($INCIDENCIES->haveToPaginate())
  {       
     echo link_to(image_tag('tango/16x16/actions/go-previous.png'), 'gestio/gIncidencies'.getParam( null , $CERCA , null , $INCIDENCIES->getPreviousPage() ));
     echo " ";
     echo link_to(image_tag('tango/16x16/actions/go-next.png'), 'gestio/gIncidencies'.getParam( null , $CERCA , null , $INCIDENCIES->getNextPage()));
  }
}

?>
 