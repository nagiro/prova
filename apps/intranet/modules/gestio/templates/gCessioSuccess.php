<STYLE>
.cent { width:100%; }
.vuitanta { width:80%; }
.cinquanta { width:50%; }
.HTEXT { height:100px; }

</STYLE>
   
    <TD colspan="3" class="CONTINGUT">
    
<?php use_helper('ModalBox') ?>
<?php echo link_to('Add Comment', 'gestio/gCessio', array('title'=>'Add Personal Note','onclick'=>'Modalbox.show(this.href, {title: this.title, width: 500}); return false;')); ?>
                             
      <?php echo nice_form_tag('gestio/gCessio',array('method'=>'post','onSubmit'=>'return ValidaFormulari(this)')) ?>
  
        <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL"><?=link_to(image_tag('tango/16x16/actions/document-new.png'),'gestio/gCessio'.getParam('N',null,null)) ?> Llistat de cessions (<?=$CESSIONS->getNbResults() ?>)</DIV>
                <TABLE class="DADES">
                <? if($CESSIONS->getNbResults() == 0): ?><TR><TD colspan = "2" class="LINIA">No s'ha trobat cap cessió.</TD></TR><? endif; ?> 				
                <? foreach($CESSIONS->getResults() as $C):  ?>
					<TR>
						<TD class="LINIA"><?=link_to($C->getTitol(),'gestio/gCessions'.getParam( 'E' , $I->getIdcessiomaterial() , $PAGINA ))?></TD>
					    <TD class="LINIA"><?=$I->getEstatText()?></TD></TR>                                	
                <? endforeach; ?>                
                <TR><TD colspan="3" class="TITOL"><?=gestorPagines($CESSIONS);?></TD></TR>
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>
  
  
      
  <?php IF( $NOU || $EDICIO ): ?>
      
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Gestor de cessions</DIV>
                <TABLE class="DADES" width="100%">                  
                  <?php echo input_hidden_tag( 'IDC' , $CESSIO->getIdcessiomaterial() ); ?>
                  <?php echo input_hidden_tag( 'NOU' , $NOU ); ?>                                      
                  <TR><TD class="LINIA" >Què es cedeix</TD><td><?=select_tag( 'D[MATERIAL]' , options_for_select(MaterialPeer::select() , $CESSIO->getMaterialIdmaterial()) ); ?></TD></TR>
                  <TR><TD class="LINIA" >A qui es cedeix</td><td><?=input_tag( 'D[CEDITA]' , $CESSIO->getCedita() ); ?></TD></TR>
                  <TR><TD class="LINIA" >Data de cessió</td><td><?=input_date_tag('D[DATACESSIO]',$CESSIO->getDatacessio() , array('rich'=>true,'class'=>'cinquanta')); ?></TD></TR>
                  <TR><TD class="LINIA" >Data de retorn</td><td><?=input_date_tag('D[DATARETORN]',$CESSIO->getDataretorn() , array('rich'=>true,'class'=>'cinquanta')); ?></TD></TR>
                  <TR><TD class="LINIA" >Notes d'estat</td><td><?=input_tag( 'D[ESTAT]' , $CESSIO->getEstat() ); ?></TD></TR>
                  <TR><TD class="LINIA" >Retornat?</td><td><?=select_tag('D[RETORNAT]', options_for_select(array(1=>'Sí',0=>'No'),$CESSIO->getRetornat() ) ); ?></TD></TR>                                                      
                </TABLE>                                                                  
                
                <div class="BOTONS">
                	<?=submit_image_tag('template/accept.png',array('name'=>'BSAVE')); ?>
                	<?=submit_image_tag('template/cancel.png',array('name'=>'RETURN')); ?>
    			</div>            
                                
            </TD>
        </TR>
      </TABLE>
    

  <?php ENDIF; ?>
  
    
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
    

  <?php 
  
function getParam( $accio = "" , $IDC = "" , $PAGINA = 1)
{
    $opt = array();
    if(!empty($accio)) $opt[] = "accio=$accio";
    if(!empty($IDC)) $opt['IDC'] = "IDC=$IDC";    
    if(!empty($PAGINA)) $opt['PAGINA'] = "PAGINA=$PAGINA";
    
    RETURN "?".implode( "&" , $opt);
}

function gestorPagines($CESSIONS)
{
  if($CESSIONS->haveToPaginate())
  {       
     echo link_to(image_tag('tango/16x16/actions/go-previous.png'), 'gestio/gCessio'.getParam( null , null , $INCIDENCIES->getPreviousPage() ));
     echo " ";
     echo link_to(image_tag('tango/16x16/actions/go-next.png'), 'gestio/gIncidencies'.getParam( null , null , $INCIDENCIES->getNextPage()));
  }
}

?>
 