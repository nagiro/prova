<STYLE>
.cent { width:100%; }
</STYLE>

<?php use_helper('Javascript'); ?>


<script type="text/javascript">

	function vacio(q){for(i=0;i<q.length;i++){if(q.charAt(i)!=" "){return true}}return false}  

	function ValidaReserves(){		
		if(vacio(D_NOM.value)== false){ alert('El nom d\'activitat no pot estar buit.'); return false; }
		if(vacio(D_DATAACTIVITAT.value)== false){ alert('La data d\'activitat no pot estar buit.'); return false; }
		if(vacio(D_HORARIACTIVITAT.value)== false){ alert('L\'hora d\'activitat no pot estar buida.'); return false; }
		if(D_ESPAIS.selectedIndex<0){ alert('Has d\'escollir com a mínim un espai on realitzar l\'acte'); return false; }		
	}

</script>
   
    <TD colspan="3" class="CONTINGUT">
    
      <?php echo nice_form_tag('gestio/gReserves',array('method'=>'post')); ?>

      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                                                              
                <DIV class="TITOL">Cerca reserves</DIV>                
                <DIV class="CERCA"><?php echo input_tag('CERCA' , NULL , array('size'=>'50%')).submit_tag('Cerca',array('name'=>'BCERCA')).' '.submit_tag('Nova reserva',array('name'=>'BNOU')); ?></DIV>				
              </TD>
        </TR>
      </TABLE>
      
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Llistat reserves (<?=sizeof( $RESERVES )?>)</DIV>
                <TABLE class="DADES">
                  <? if( sizeof( $RESERVES ) == 0 ): ?>
                     	<TR><TD class="LINIA" colspan="3">No hi ha cap reserva per confirmar.</TD></TR>
                  <? endif; ?> 
                  <? foreach($RESERVES as $R): ?>                                                                    
                      	<TR><TD class="LINIA"><?=link_to($R->getNom(),'gestio/gReserves?accio=E&IDR='.$R->getReservaespaiid())?></TD>
                      	    <TD class="LINIA"><?=$R->getUsuaris()->getNomComplet()?></TD>
                      	    <TD class="LINIA"><?=$R->getDataactivitat()?></TD>
                      	    <TD class="LINIA"><?=$R->getEstatText()?><TD></TR>
                  <? endforeach; ?>                                                          
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>

  <?php IF( $NOU || $EDICIO ): ?>
      
  <?php 
  
     echo input_hidden_tag( 'IDR' , $IDR );
     $ESPAIS = explode('@',$RESERVA->getEspaissolicitats());
     $MATERIAL= explode('@',$RESERVA->getMaterialsolicitat());  
       
  ?>            
            
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Gestor de reserves</DIV>
                <TABLE class="DADES" width="100%">
<?php if($EDICIO): ?> <TR><TD class="LINIA">ERRORS</TD>     		    <TD class="ERRORS"><?php echo implode(',',$RESERVA->check()); ?></TD></TR> <? endif; ?>                  
  	              <TR><TD class="LINIA">Estat</TD>     			    <TD class="LINIA"><?php echo select_tag('D[ESTAT]', options_for_select(ReservaespaisPeer::selectEstat(), $RESERVA->getEstat()) ); ?></TD></TR>
  	              <TR><TD class="LINIA">Nom de l'activitat</TD>     <TD class="LINIA"><?php echo input_tag('D[NOM]',$RESERVA->getNom()); ?></TD></TR>
				  <TR><TD class="LINIA">Data de l'activitat</TD>    <TD class="LINIA"><?php echo input_tag('D[DATAACTIVITAT]',$RESERVA->getDataactivitat()); ?></TD></TR>
				  <TR><TD class="LINIA">Horari de l'activitat</TD>  <TD class="LINIA"><?php echo input_tag('D[HORARIACTIVITAT]',$RESERVA->getHorariactivitat()); ?></TD></TR>
				  <TR><TD class="LINIA">Espais</TD>                 <TD class="LINIA"><?php echo select_tag('D[ESPAIS][]',options_for_select(EspaisPeer::select(),$ESPAIS),  array('multiple'=>true,'size'=>'3')); ?></TD></TR>
				  <TR><TD class="LINIA">Material</TD>               <TD class="LINIA"><?php echo select_tag('D[MATERIAL][]',options_for_select(MaterialgenericPeer::select(),$MATERIAL),  array('multiple'=>true,'size'=>'3')); ?></TD></TR>
				  <TR><TD class="LINIA">Tipus d'acte</TD>           <TD class="LINIA"><?php echo input_tag('D[TIPUSACTE]',$RESERVA->getTipusacte()); ?></TD></TR>
				  <TR><TD class="LINIA">Es enregistrable?</TD>      <TD class="LINIA"><?php echo select_tag('D[ISENREGISTRABLE]',options_for_select(array('0'=>'No','1'=>'Sí'),$RESERVA->getIsenregistrable())); ?></TD></TR>
				  <TR><TD class="LINIA">En representació de </TD>   <TD class="LINIA"><?php echo input_tag('D[REPRESENTACIO]',$RESERVA->getRepresentacio()); ?></TD></TR>      
				  <TR><TD class="LINIA">Responsable</TD>            <TD class="LINIA"><?php echo input_tag('D[RESPONSABLE]',$RESERVA->getResponsable()); ?></TD></TR>
				  <TR><TD class="LINIA">Organitzadors</TD>          <TD class="LINIA"><?php echo input_tag('D[ORGANITZADORS]',$RESERVA->getOrganitzadors()); ?></TD></TR>
				  <TR><TD class="LINIA">Personal autoritzat</TD>    <TD class="LINIA"><?php echo input_tag('D[PERSONALAUTORITZAT]',$RESERVA->getPersonalautoritzat()); ?></TD></TR>
				  <TR><TD class="LINIA">Previsió assistents</TD>    <TD class="LINIA"><?php echo input_tag('D[PREVISIOASSISTENTS]',$RESERVA->getPrevisioassistents()); ?></TD></TR>
				  <TR><TD class="LINIA">Es un cicle?</TD>           <TD class="LINIA"><?php echo select_tag('D[ESCICLE]',options_for_select(array('0'=>'No','1'=>'Sí'),$RESERVA->getEscicle())); ?></TD></TR>
				  <TR><TD class="LINIA">Exempció de pagament</TD>   <TD class="LINIA"><?php echo select_tag('D[EXEMPCIO]',options_for_select(array('0'=>'No','1'=>'Sí'),$RESERVA->getExempcio())); ?></TD></TR>
				  <TR><TD class="LINIA">Necessiteu pressupost?</TD> <TD class="LINIA"><?php echo select_tag('D[PRESSUPOST]',options_for_select(array('0'=>'No','1'=>'Sí'),$RESERVA->getPressupost())); ?></TD></TR>
				  <TR><TD class="LINIA">Col·laboració CCG?</TD>     <TD class="LINIA"><?php echo select_tag('D[COLLABORACIO]',options_for_select(array('0'=>'No','1'=>'Sí'),$RESERVA->getColaboracioccg())); ?></TD></TR>
				  <TR><TD class="LINIA">Comentaris</TD>             <TD class="LINIA"><?php echo textarea_tag('D[COMENTARIS]',$RESERVA->getComentaris()); ?></TD></TR>            
				  <TR><TD class="LINIA">  </TD>                     <TD class="LINIA"><?php echo submit_tag('Guarda' , array('name' => 'BSAVE' , 'onClick'=>'return ValidaReserves(this);')); ?> </TD>                                                            
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>    
    
  <?php ENDIF; ?>
  
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>        
    
<?php 

function getParam( $accio , $AID , $CERCA )
{
    $opt = array();
    if(isset($accio)) $opt[] = "accio=$accio";
    if(isset($AID)) $opt['AID'] = "AID=$AID";
    if(isset($CERCA)) $opt['CERCA'] = "CERCA=$CERCA";
    
    RETURN "?".implode( "&" , $opt);
}

?>
