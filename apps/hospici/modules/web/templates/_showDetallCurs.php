<script>

    $(document).ready(function(){
              
       //Si és un menor mostrem el requadre amb la info a omplir. 
       $('#matricula_menor').click(function(){       
        if($('#matricula_menor').attr('checked')) $('#FORM_MENOR_EDAT').show();
        else  $('#FORM_MENOR_EDAT').hide();
       });
        
       //Si és una domiciliació bancaria, mostrem el requadre amb la info a omplir. 
       
       $('#matricula_idP').change(function(){
            if($("#matricula_idP option:selected").val() == <?php echo TipusPeer::PAGAMENT_DOMICILIACIO ?>){
                $("#FORM_DOMICILIACIO").show();
            } else {
                $("#FORM_DOMICILIACIO").hide();
            }
                
       });
        
    });
    

    function validaCCC() {      
        if (!(obtenirCheck("00" + $('#ccc1').val() + $('#ccc2').val()) == parseInt($('#ccc3').val().charAt(0))) || !(obtenirCheck($('#ccc4').val()) == parseInt($('#ccc3').val().charAt(1))))
        { alert("El compte entrat és incorrecte."); return false; }    
        else { return true; }                  
    }
        
    function obtenirCheck(valor){
      valores = new Array(1, 2, 4, 8, 5, 10, 9, 7, 3, 6);
      control = 0;
      for (i=0; i<=9; i++)
        control += parseInt(valor.charAt(i)) * valores[i];
      control = 11 - (control % 11);
      if (control == 11) control = 0;
      else if (control == 10) control = 1;
      return control;
    }    
    
</script>

<div class="h_requadre_resultats">
    <div class="h_subtitle_gray c1">
        L'HOSPICI...
    </div>    
        
    <?php
     
    if($CURS instanceof Cursos)
    {
        
            $url        = url_for('@hospici_detall_curs?idC='.$CURS->getIdcursos().'&titol='.$CURS->getNomForUrl());
            $ESTAT      = myUser::ph_EstatCurs($AUTH, $CURS, $url, $CURSOS_MATRICULATS);                         
            $OS         = SitesPeer::retrieveByPK($CURS->getSiteId());
            $nom        = $OS->getNom(); $email  = $OS->getEmailString(); $tel    = $OS->getTelefonString();
            
            
                        
            //Carrego la imatge del site
            $imatge = SitesPeer::getSiteLogo($CURS->getSiteId());            
                                                               
            //Si l'entitat té un pdf, l'hauríem de carregar.                                               
            if(empty($pdf)) $pdf = 0;             
            
    ?>
			<div style="border:0px solid #96BF0D; clear:both; padding:10px;">
				<div style="font-size:11px"><b><?php echo $CURS->getTitolcurs() ?></b><br /><span style="color: gray;"><?php echo $OS->getNom(); ?></span></div>
				<div style="font-size:10px"><?php // echo generaHoraris($ACTIVITAT->getHorarisOrdenats(HorarisPeer::DIA)); ?></div>
				<div style="height:30px;">&nbsp;</div>				
										
				<div style="width:150px; float:left">                    
					<div><img src="<?php echo $imatge ?>" style="width:150px; vertical-align:middle" /></div>
                        
						<div style="margin-top:20px; font-size:10px">
                            <div class="requadre_mini" style="background-color:#A2844A;">
                                <a href="javascript:history.back()">&lt; Torna al llistat de cursos</a>
                            </div>
                        </div>
                        
                        <?php if($pdf > 0): ?>
                            <div class="pdf_cicle" style="margin-top: 5px;">
                                <div class="requadre_mini" style="background-color: #D4A261;">
                                    <a href="/images/cursos/<?php echo $pdf ?>">Baixa't el pdf del curs</a>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Fi del marcador de curs -->  
                      
                    <div style="margin-top:20px;">
                        <?php echo ph_getAddThisDiv(); ?>
                    </div>
                    
				</div>
                                
				<div style="width:400px; float:left;">
					<div style="padding-left:50px; font-size:10px;">                                                           
						<?php echo $CURS->getDescripcio() ?>

                        <!-- Requadre de compra o reserva d'entrades  -->
                        
                        <div id="matricula" style="margin-top:30px;">                        
               				<div style="clear:both; color:#96BF0D; font-size:12px; padding-left:10px;">MATRICULA'T</div> 
            				<div style="clear:both; background-color:#DFECB6">					
            					<div style="padding:10px; font-size:10px;">
            
                                    <?php
                                    
                                        switch($ESTAT){
                                            case 'NO_AUTENTIFICAT'  : echo '<div>Per poder matricular-vos d\'un curs heu d\'autentificar-vos clicant <a class="auth" href="'.$url.'" >aquí</a>.</div>'; break;
                                            case 'MATRICULAT'       : echo '<div>Vostè ja ha realitzat una reserva o matrícula a aquest curs.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b></div>'; break;
                                            case 'RESERVAT'         : echo '<div>Vostè ja ha realitzat una reserva o matrícula a aquest curs.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b></div>'; break;
                                            case 'EN_ESPERA'        : echo '<div>Vostè està en espera de plaça per aquest curs.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b></div>'; break;
                                            case 'ANULADA'          : echo '<div>Vostè ha realitzat una matrícula en aquest curs, però no hi està matriculat.<br /><br /> Per a més informació ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b></div>'; break;
                                            case 'NO_HI_PLACES'     : echo '<div>Aquest curs ja no té places lliures.<br /><br /> Si vol pot matricular-s\'hi igualment i restarà en llista d\'espera. En el cas que s\'alliberi alguna plaça, que vostè pot ocupar, el trucarem el més aviat possible. Per a més informació, pot posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al telèfon <b>'.$tel.'</b>.<br /></div>'; break;                                            
                                            case 'NO_HI_HA_RESERVA_LINIA': echo '<div>Aquest curs no disposa de matrícula en línia.<br /><br /> Per poder-s\'hi matricular, ha de posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al telèfon <b>'.$tel.'</b>.<br /><br />Disculpi les molèsties</div>'; break;
                                            case 'ABANS_PERIODE_MATRICULA_AA_IDIOMES': echo '<div>Vostè podrà matricular-se a aquest curs per internet a partir del dia '.date('d/m/Y',$dataiA).' si vol continuar els estudis d\'idiomes.<br /><br /> Per a més informació pot posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b></div>'; break;
                                            case 'ABANS_PERIODE_MATRICULA': echo '<div>Vostè podrà matricular-se a aquest curs per internet a partir del dia '.$CURS->getDatainmatricula('d/m/Y').'.<br /><br /> Per a més informació pot posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b></div>'; break;
                                            case 'POT_MATRICULAR':  echo mostraFormulari( $OS->getNom() , $CURS , $MISSATGE , $ESTAT ); break;       
                                            case 'LLISTA_ESPERA':   echo mostraFormulari( $OS->getNom() , $CURS , $MISSATGE , $ESTAT ); break;                                            
                                        }                                                                        
                                        
                                                                                                            
                                    ?>                
            				    </div>
                            </div>
                        </div>
                        
                        <!-- Fi Requadre de compra o reserva d'entrades  -->	        													


					</div>					
				</div>
				                                                
                <!-- Fi Requadre de descripció  -->													
			</div>
           
           <!-- Fi de curs -->  
      
      <?php } ?>  
</div>



<?php 

function mostraFormulari( $nom , $CURS , $MISSATGE , $visible )
{

    echo '<form method="post" action="'.url_for('@hospici_nova_matricula').'">';                                            
    
    //Guardem el codi del curs        
    echo input_hidden_tag('matricula[idC]',$CURS->getIdcursos());
    $A_Descomptes = $CURS->h_getDescomptes();

     ?>
    
    <div class="taula_dades" style="width:330px;">    
        <?php if(isset($MISSATGE) && $MISSATGE != ""): echo '<div style="background-color:red; color:white; width:95%; padding:5px;">'.$MISSATGE.'</div>'; endif; ?>
                
        <div style="padding-top:10px; clear:both;">
            <div style="float: left; width:120px;"><b>Preu: </b></div>
            <div style="float: left;">
                <?php echo $CURS->getPreu() ?> € <span class="tipMy tip" title="Preu del curs que haurà d'abonar quan inici el curs o bé tot seguit si el pagament és amb targeta de crèdit.">?</span>                                
            </div>
        </div>

        <div style="padding-top:5px; clear:both;">
            <div style="float: left; width:120px;"> <b>Organitza: </b> </div>
            <div style="float: left;"> <?php echo $nom ?> </div>
        </div>

        <div style="padding-top:5px; clear: both;">
            <div style="float: left; width:120px;"><b>Pagament:</b></div>
            <div style="float: left;"> 
            <?php   
            
                //Aquí podem escollir el tipus de pagament que farem pel curs.
                
                $PAGAMENTS = $CURS->getSelectPagaments();
                
                if( $CURS->isPle() && $CURS->getIsLlistaEspera(false) ):
                
                    echo select_tag( 'matricula[idP]' , options_for_select( array( TipusPeer::PAGAMENT_LLISTA_ESPERA => $PAGAMENTS[TipusPeer::PAGAMENT_LLISTA_ESPERA] ) ) );
                    echo ' <span class="tipMy tip" title="El curs és ple i però si vol pot afegir-se a la llista d\'espera del curs. Si en un futur hi ha places ens posarem en contacte amb vostè.">?</span>';
                    
                else:
                
                    echo select_tag( 'matricula[idP]' , options_for_select($CURS->getSelectPagaments() ) );
                    
                endif; 
                
            ?>
            </div>
        </div>

        <div style="padding-top:5px; clear:both;">
            <div style="float: left; width:120px;"><b>Descompte: </b></div>
            <div style="float: left;">
            <?php 
                                
                //Si hi ha descompte al curs, el mostrem
                if(empty($A_Descomptes)){
                    
                    echo 'Cap descompte disponible <span class="tipMy tip" title="Aquest curs té un preu únic.">?</span>';
                    
                } else {
                    
                    echo select_tag('matricula[idD]',options_for_select($A_Descomptes,1)).' <span class="tipMy tip" title="Esculli, si s\'escau, el descompte que s\'adeqüi a la seva situació. Aquest haurà de ser demostrat a l\'entitat organitzadora a l\'inici de les classes.">?</span>';
                    
                }
                
            ?>
            </div>
        </div>


        <!-- Formulari que hauria d'aparèixer si hi ha domiciliació bancaria -->
        <div style="padding-top:5px; clear:both;">
        
            <div id="FORM_DOMICILIACIO" style="padding-top:10px; display:none;">
                <div style="margin-bottom:5px;"><b>Dades bancàries</b></div>
                <div style="float: left; width:120px;">Titular:</div>
                <div style="float: left; "><?php echo input_tag('matricula[titular]',null,array('style'=>'width:190px;')); ?></div>                            
                <div style="float: left; width:120px;">Compte corrent:</div>
                <div style="float: left;">                                                                    
                    <div style="clear:both; float:left; "><?php echo input_tag('matricula[ccc1]',null,array('style'=>'width:30px;','maxlength'=>'4')); ?></div>
                    <div style="float:left; "><?php echo input_tag('matricula[ccc2]',null,array('style'=>'width:30px;','maxlength'=>'4')); ?></div>
                    <div style="float:left; "><?php echo input_tag('matricula[ccc3]',null,array('style'=>'width:20px;','maxlength'=>'2')); ?></div>
                    <div style="float:left; "><?php echo input_tag('matricula[ccc4]',null,array('style'=>'width:70px;','maxlength'=>'10')); ?></div>
                </div>
                                    
            </div>    
    
            <div style="clear:both; padding-top:10px;">
                <div style="float: left; width:120px;"><b>Alumne menor d'edat?</b></div>                                            
                <div style="float: left;">
                    <?php echo checkbox_tag('matricula[menor]',false) ?>                
                </div>
            </div>    
    
            <div style="padding-top:10px; clear:both; display:none;" id="FORM_MENOR_EDAT">
                <div style="float: left; width:120px;"><b>Tutor legal: </b></div>
                <div style="clear:both; font-size:10px; color:gray;">Si l'alumne és menor d'edat, entri el DNI i nom del seu tutor legal</div>
                <div style="clear:both; float: left;">
                    <div style="float: left;">DNI: <?php echo input_tag('matricula[dni_tutor]',null); ?></div>
                    <div style="float: left;">Nom: <?php echo input_tag('matricula[nom_tutor]',null); ?></div>                                                
                </div>            
            </div>                        
        </div>
                
        <div style="padding-top:10px; clear:both;">
            <div style="margin-left:180px;">
                <?php if( $CURS->isPle() && $CURS->getIsLlistaEspera(false) ): ?>
                    <input style="width: 150px;" type="submit" value="Posar-me en llista d'espera" />
                <?php else: ?>
                    <input style="width: 100px;" type="submit" value="Matricula't!" />
                <?php endif; ?>
            </div>
        </div>
    </div>
    
<?php } ?>
