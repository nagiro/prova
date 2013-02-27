<STYLE>
.cent { width:100%; }

.row { width:600px; } 
.row_field { width:80%; } 
.row_title { width:20%; }
 

</STYLE>


<?php use_helper('Form'); ?>

<script type="text/javascript">

    $(document).ready(function(){
        $("#cerca_select").change(function(){ $("#FORM_CERCA_RESERVES").submit(); });
    });

	function vacio(q){for(i=0;i<q.length;i++){if(q.charAt(i)!=" "){return true}}return false}  

	function ValidaReserves(){		
		if(vacio(D_NOM.value)== false){ alert('El nom d\'activitat no pot estar buit.'); return false; }
		if(vacio(D_DATAACTIVITAT.value)== false){ alert('La data d\'activitat no pot estar buit.'); return false; }
		if(vacio(D_HORARIACTIVITAT.value)== false){ alert('L\'hora d\'activitat no pot estar buida.'); return false; }
		if(D_ESPAIS.selectedIndex<0){ alert('Has d\'escollir com a mínim un espai on realitzar l\'acte'); return false; }		
	}	

</script>
   
    <TD colspan="3" class="CONTINGUT_ADMIN">
    
    <?php include_partial('breadcumb',array('text'=>'RESERVES')); ?>
    
    <form id="FORM_CERCA_RESERVES" action="<?php echo url_for('gestio/gReserves') ?>" method="POST">
    	<?php include_partial('cerca',array(
    										'TIPUS'=>'Select',
    										'FCerca'=>$FCerca,
    										'BOTONS'=>array(
    														array(
    																'name'=>'BCERCA',
    																'text'=>'Prem per buscar'),
    													)
    										)
    							); ?>    
     </form>   
      
  <?php IF( $MODE['NOU'] || $MODE['EDICIO'] ): ?>
      
	<form action="<?php echo url_for('gestio/gReserves') ?>" method="POST">
	
	 	<div class="REQUADRE fb">
	 	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gReserves?accio=C')) ?>
					 	 		
	 		<div class="FORMULARI fb">
	 			<?php $OUsuari = UsuarisPeer::retrieveByPK($FReserva->getObject()->getUsuarisusuariid());
	 					$qui = "No trobat";
	    				if($OUsuari instanceof Usuaris) $qui = $OUsuari->getDni().' - '.$OUsuari->getNomComplet(); ?>
	 			<?php include_partial('fieldSpan',array('label'=>'Qui sol·licita?','field'=>$qui)); ?>

				<?php echo $FReserva ?>
                
                <!-- Comença el formulari per entrar info sobre l'activitat -->
                
                <div class="clear row fb" style="background-color: #EEEEEE; font-weight:bold; margin-bottom:10px;">
                    <span style="padding: 5px; ">Dades per difusió WEB</span>                    
                </div>
                
                <div class="clear row fb">                    
                    <span class="title row_title fb"><label>Vol que fem difusió? </label></span>
                    <span class="row_field fb"><select id="reservaespais_sidifu" name="extres[sidifu]"><?php echo options_for_select(array(1=>'Sí',0=>'No'),$FReserva->getObject()->getHasDifusio()) ?></select></span>
                </div>
                
                <div class="clear row fb">                    
                    <span class="title row_title fb"><label>Text descriptiu</label></span>
                    <span class="row_field fb"><textarea id="reservaespais_descweb" name="extres[descweb]" cols="50" rows="10"><?php echo $FReserva->getObject()->getWebDescripcio() ?></textarea></span>
                </div>

                <div class="clear row fb">                    
                    <span class="title row_title fb"><label>Imatge</label></span>
                    <span class="row_field fb">
                    
                        <input type="file" id="reservaespais_img" name="img" /><br />                                                                        
                        <?php   
                                //Si existeix l'arxiu, el carreguem perquè poguem veure'l
                                $FILES = glob( getcwd().'/uploads/arxius/'.'RE-'.$FReserva->getObject()->getReservaespaiid().'-IMG-*' );                                
                                if( sizeof($FILES) > 0 ):
                                    $A = explode('/uploads/arxius/',$FILES[0]);
                                    $arxiu = array_pop($A);
                                    echo '<a target="_new" href="http://www.hospici.cat/uploads/arxius/'.$arxiu.'">Baixa\'t l\'arxiu</a>';
                                endif;                                                                       
                        ?>
                    
                    </span>
                </div>

                <div class="clear row fb">                    
                    <span class="title row_title fb"><label>PDF</label></span>
                    <span class="row_field fb">
                    
                        <input type="file" id="reservaespais_pdf" name="pdf" style="width:400px;" /><br />
                        <?php 
                                //Si existeix l'arxiu, el carreguem perquè poguem veure'l
                                $FILES = glob( getcwd().'/uploads/arxius/'.'RE-'.$FReserva->getObject()->getReservaespaiid().'-PDF-*' );                                
                                if( sizeof($FILES) > 0 ):
                                    $A = explode('/uploads/arxius/',$FILES[0]);
                                    $arxiu = array_pop($A);
                                    echo '<a target="_new" href="http://www.hospici.cat/uploads/arxius/'.$arxiu.'">Baixa\'t l\'arxiu</a>';
                                endif;                                                                                         
                        ?>
                    
                    </span>
                </div>

                <!-- Acaba el formulari per entrar info sobre l'activitat -->                                                 
	 			
                <div class="" style="text-align:right; padding-top:40px;">
                <?php if($FReserva->getObject()->getEstat() == ReservaespaisPeer::EN_ESPERA): ?>
                    <button type="submit" name="SEND_RESOLUTION" class="BOTO_ACTIVITAT">
                        <?php echo image_tag('template/email.png'); ?> Envia mail condicions
                    </button>
                <?php endif; ?>	 			
                    <button type="submit" name="BSAVE" class="BOTO_ACTIVITAT" onClick="return confirm('Segur que vols guardar els canvis?')">
    				    <?php echo image_tag('template/disk.png'); ?> Guardar i sortir 
                    </button>
                    
                </div>		
	 		</div>
	 			 	 	
      	</div>
		      	            
     </form>          

  <?php ELSE: ?>
    
      <DIV class="REQUADRE">
        <DIV class="TITOL">Llistat de reserves </DIV>
      	<TABLE class="DADES">
 			<?php 
				if( empty( $RESERVES ) ):
					echo '<TR><TD class="LINIA" colspan="3">No s\'ha trobat cap reserva amb aquestes dades.</TD></TR>';
				else: 
					$i = 0;
                    echo '<TR><TD class="titol" colspan="5">EN ESPERA</TD></TR>';
                    echo IteratorReserves($RESERVES->getResults(), ReservaespaisPeer::EN_ESPERA);
                    echo '<TR><TD class="titol" colspan="5">PENDENT CONFIRMACIÓ</TD></TR>';
                    echo IteratorReserves($RESERVES->getResults(), ReservaespaisPeer::PENDENT_CONFIRMACIO);
                    echo '<TR><TD class="titol" colspan="5">ANUL·LAT</TD></TR>';
                    echo IteratorReserves($RESERVES->getResults(), ReservaespaisPeer::ANULADA);
                    echo '<TR><TD class="titol" colspan="5">ACCEPTAT</TD></TR>';
                    echo IteratorReserves($RESERVES->getResults(), ReservaespaisPeer::ACCEPTADA);                    					
                 endif;                    
             ?>
              
              <?php echo gestorPagines($RESERVES);?>
                                	
      	</TABLE>      
      </DIV>

    
  <?php ENDIF; ?>
  
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>        
    
<?php 

function IteratorReserves($RESERVES,$ESTAT)
{
    $RET = "";
    foreach($RESERVES as $R):
        if($R->getEstat() == $ESTAT):            	                        
            $OU = $R->getUsuaris();
            if(!($OU instanceof Usuaris)){ $OU = new Usuaris(); $OU->setNom('Error'); }
                                         							
          	$RET .= '<TR><TD>'.link_to($R->getCodi(),'gestio/gReserves?accio=E&IDR='.$R->getReservaespaiid()).'</td>
                      <TD>'.$R->getNom().'</TD>
          	    	  <TD><a href="#" class="tt2"><span>'.$OU->getDades().'</span>'.$OU->getNomComplet().'</a></TD>
          	          <TD>'.$R->getDataalta('d/m/Y H:i').'</TD>
          	          <TD>'.$R->getEstatText().'<TD>
          	      </TR>';
        endif; 
    endforeach;
    return $RET;    
}


function gestorPagines($MODEL)
{
  if($MODEL->haveToPaginate())
  {       
  	 echo '<TR><TD colspan="5" class="TITOL">';  	 
     echo link_to(image_tag('tango/16x16/actions/go-previous.png'), 'gestio/gReserves?P='.$MODEL->getPreviousPage());
     echo " ".$MODEL->getPage()."/".$MODEL->getLastPage()." ";
     echo link_to(image_tag('tango/16x16/actions/go-next.png'), 'gestio/gReserves?P='.$MODEL->getNextPage());
     echo '</TD></TR>';
  }
}

function ParImpar($i)
{
	if($i % 2 == 0) return "PAR";
	else return "IPAR";
}


?>
