<script>

    $(document).ready(function(){
       
       $('#BMATRICULADOMICILIACIO').click(function(){
            $('#matricula_domiciliacio').show();
            $('#matricula').hide();
            $('#DETALL_DESCOMPTE').val($('#idD').val());                        
            return false;
       });
       
       $('#menor').click(function(){       
        if($('#menor').attr('checked')) $('#FORM_MENOR_EDAT').show();
        else  $('#FORM_MENOR_EDAT').hide();
       });

        $('#BOTO_SUBMIT_DOMICILIACIO').click(function(){
           //Validem que el compte corrent sigui correcte.
           return validaCCC();             
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
                                                            
            $datai      = $CURS->getDatainmatricula('U');            
            $url        = url_for('@hospici_detall_curs?idC='.$CURS->getIdcursos().'&titol='.$CURS->getNomForUrl());
            $MatAntIdi  = CursosPeer::IsAnticAlumne($CURS->getIdcursos(),$CURSOS_MATRICULATS);
            $dataiA     = mktime(0,0,0,9,12,2011);
            $OS         = SitesPeer::retrieveByPK($CURS->getSiteId());
            $nom        = $OS->getNom(); $email = $OS->getEmailString(); $tel = $OS->getTelefonString();
            $ESTAT      = myUser::ph_EstatCurs($AUTH, $CURS, $url, $CURSOS_MATRICULATS);                         
                        
            //Carrego la imatge del site
            $imatge = SitesPeer::getSiteLogo($CURS->getSiteId());            
                                                               
            //Si l'entitat té un pdf, l'hauríem de carregar.                                               
            if(empty($pdf)) $pdf = 0;             
            
    ?>
			<div style="border:0px solid #96BF0D; clear:both; padding:10px;">
				<div style="font-size:11px"><b><?php echo $CURS->getTitolcurs() ?></b><br /><span style="color: gray;"><?php echo $nom; ?></span></div>
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
                        
                        <!-- Inici del marcador de curs -->
                        <div style="margin-top: 5px; margin-bottom:5px;">
                            <?php echo myUser::ph_getEtiquetaCursos($AUTH, $CURS, $url, $CURSOS_MATRICULATS); ?>                                                                                                                                                    
                        </div>
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
                                            case 'ABANS_PERIODE_MATRICULA': echo '<div>Vostè podrà matricular-se a aquest curs per internet a partir del dia '.date('d/m/Y',$datai).'.<br /><br /> Per a més informació pot posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b></div>'; break;
                                            case 'POT_MATRICULAR': 
                                                echo mostraFormulari( $nom , $CURS , $MISSATGE , $ESTAT );
                                             break;         
                                        }                                                                        
                                        
                                                                                                            
                                    ?>                
            				    </div>
                            </div>
                        </div>
                        
                        <!-- Fi Requadre de compra o reserva d'entrades  -->	        													



                        <!-- Requadre detall matrícula domiciliació  -->
                        <?php if($CURS->getIsentrada() == CursosPeer::TIPUS_PAGAMENT_DOMICILIACIO): ?>
                        
                        <div id="matricula_domiciliacio" style="margin-top:30px; display:none; ">                        
               				<div style="clear:both; color:#96BF0D; font-size:12px; padding-left:10px;">DADES DE MATRÍCULA</div> 
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
                                            case 'ABANS_PERIODE_MATRICULA': echo '<div>Vostè podrà matricular-se a aquest curs per internet a partir del dia '.date('d/m/Y',$datai).'.<br /><br /> Per a més informació pot posar-se en contacte amb <b>'.$nom.'</b> enviant un correu electrònic a <b>'.$email.'</b> o bé trucant al <b>'.$tel.'</b></div>'; break;
                                            case 'POT_MATRICULAR':                                      
                                                    echo mostraFormulariMatricula( $nom , $CURS , $MISSATGE , $IDU );                                                
                                            break;         
                                        }                                                                        
                                        
                                                                                                            
                                    ?>
                                                    
            				    </div>
                            </div>
                        </div>
                        
                        <?php endif; ?>  
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
    echo input_hidden_tag('idC',$CURS->getIdcursos());
    $A_Descomptes = $CURS->h_getDescomptes();

     ?>
    
    <div class="taula_dades" style="width:330px;">    
        <?php if(isset($MISSATGE) && $MISSATGE != ""): echo '<div style="background-color:red; color:white; width:95%; padding:5px;">'.$MISSATGE.'</div>'; endif; ?>
                
        <div style="padding-top:10px;">
            <div style="float: left; width:120px;"><b>Pagament:</b></div>
            <div style="float: left;">
            <?php                                
                if( $CURS->getIsEntrada() == CursosPeer::TIPUS_PAGAMENT_RESERVA ):
                    echo 'Només reserva <span class="tipMy tip" title="A través del portal es fa la reserva de plaça, a cost 0, i posteriorment l\'entitat organitzadora es posarà en contacte amb vostè per finalitzar la matrícula.">?</span>';
                    echo input_hidden_tag('idMP',MatriculesPeer::RESERVAT);
                elseif( $CURS->getIsentrada() == CursosPeer::TIPUS_PAGAMENT_TARGETA ):
                    echo 'Targeta de crèdit <span class="tipMy tip" title="A través del portal realitzarà i pagarà la matrícula del curs.">?</span>';
                    echo input_hidden_tag('idMP',MatriculesPeer::PAGAMENT_TARGETA);
                elseif( $CURS->getIsentrada() == CursosPeer::TIPUS_PAGAMENT_DOMICILIACIO ):
                    echo 'Domiciliació bancària <span class="tipMy tip" title="A través del portal es fa la reserva de plaça i es dóna el compte corrent on es faran els càrrecs. Aquest s\'ha de validar al centre on realitzarà el curs per poder fer els cobraments.">?</span>';
                    echo input_hidden_tag('idMP',MatriculesPeer::PAGAMENT_DOMICILIACIO);                    
                endif;
            ?>
            </div>
        </div>

        <div style="padding-top:5px; clear:both;">
            <div style="float: left; width:120px;"><b>Preu: </b></div>
            <div style="float: left;">
            <?php
              
                $mes = "";
                if( $CURS->getIsentrada() == CursosPeer::TIPUS_PAGAMENT_DOMICILIACIO ) $mes = '/mes';
                //Si no hi ha descompte, no ensenyem el preu reduit.
                if(empty($A_Descomptes)) echo "{$CURS->getPreu()}€{$mes} <span class=\"tipMy tip\" title=\"Preu del curs que haurà d'abonar quan inici el curs o bé tot seguit si el pagament és amb targeta de crèdit.\">?</span>";
                else echo "{$CURS->getPreu()} €{$mes} <span class=\"tipMy tip\" title=\"Preu del curs que haurà d'abonar quan l'entitat organitzadora li reclami o bé tot seguit si el pagament és amb targeta de crèdit.\">?</span>";
                
            ?>
            </div>
        </div>

        <div style="padding-top:5px; clear:both;">
            <div style="float: left; width:120px;"><b>Organitza: </b></div>
            <div style="float: left;">                 
                <?php echo $nom ?>                              
            </div>
        </div>

        <div style="padding-top:5px; clear:both;">
            <div style="float: left; width:120px;"><b>Descompte: </b></div>
            <div style="float: left;">
            <?php 
                                
                //Si hi ha descompte al curs, el mostrem
                if(empty($A_Descomptes)) echo 'Cap descompte disponible <span class="tipMy tip" title="Aquest curs té un preu únic.">?</span>';
                else echo select_tag('idD',options_for_select($A_Descomptes,1)).' <span class="tipMy tip" title="Esculli, si s\'escau, el descompte que s\'adeqüi a la seva situació. Aquest haurà de ser demostrat a l\'entitat organitzadora a l\'inici de les classes.">?</span>';
                
            ?>
            </div>
        </div>
        
        <div style="padding-top:10px; clear:both;">
            <?php 
                 
                if( $CURS->getIsEntrada() == CursosPeer::TIPUS_PAGAMENT_RESERVA ) echo '<div style="margin-left:220px;"><input style="width: 100px;" type="submit" value="Reserva plaça!" /></div>';
                elseif( $CURS->getIsEntrada() == CursosPeer::TIPUS_PAGAMENT_TARGETA ) echo '<div style="margin-left:220px;"><input style="width: 100px;" type="submit" value="Matricula\'m" /></div>';
                elseif( $CURS->getIsEntrada() == CursosPeer::TIPUS_PAGAMENT_DOMICILIACIO ) echo '<div style="margin-left:220px;"><input id="BMATRICULADOMICILIACIO" style="width: 100px;" type="button" value="Reserva plaça!" /></div>';
                                                                            
            ?>
        </div>
    </div>
    
<?php }


/**
 * Aquesta funció mostra les dades extres per omplir a l'hora de fer una matrícula.
 * 
 * */
function mostraFormulariMatricula( $nom , $CURS , $MISSATGE , $idU )
{

    echo '<form method="post" action="'.url_for('@hospici_nova_matricula').'" id="FORMULARI_DOMICILIACIO">';                                            
    
    //Guardem el codi del curs
    echo input_hidden_tag('idC',$CURS->getIdcursos());
    echo input_hidden_tag('idD',null,array('id'=>'DETALL_DESCOMPTE')); //Aquí hi entra el valor per javascript des del que s'ha escollit.
    echo input_hidden_tag('idMP',MatriculesPeer::PAGAMENT_DOMICILIACIO);
    $descomptes = $CURS->h_getDescomptes();    
    
     ?>
    
    <div class="taula_dades" style="width:330px;">
    
        <?php if(isset($MISSATGE) && $MISSATGE != ""): echo '<div style="background-color:red; color:white; width:95%; padding:5px;">'.$MISSATGE.'</div>'; endif; ?>
                
        <div style="padding-top:10px;">
            <div><b>Dades bancàries</b></div>
            <div>Titular: <?php echo input_tag('titular',null,array('style'=>'width:150px;')); ?></div>                            
            <div>Compte corrent:<br />                                                                    
                <div style="clear:both; float:left; "><?php echo input_tag('ccc1',null,array('style'=>'width:30px;','maxlength'=>'4')); ?></div>
                <div style="float:left; "><?php echo input_tag('ccc2',null,array('style'=>'width:30px;','maxlength'=>'4')); ?></div>
                <div style="float:left; "><?php echo input_tag('ccc3',null,array('style'=>'width:20px;','maxlength'=>'2')); ?></div>
                <div style="float:left; "><?php echo input_tag('ccc4',null,array('style'=>'width:70px;','maxlength'=>'10')); ?></div>
            </div>
                                
        </div>    

        <div style="clear:both; padding-top:10px;">
            <div style="float: left; width:120px;"><b>Alumne menor d'edat?</b></div>                                            
            <div style="float: left;">
                <?php echo checkbox_tag('menor',false) ?>                
            </div>
        </div>    

        <div style="padding-top:10px; clear:both; display:none;" id="FORM_MENOR_EDAT">
            <div style="float: left; width:120px;"><b>Tutor legal: </b></div>
            <div style="clear:both; font-size:10px; color:gray;">Si l'alumne és menor d'edat, entri el DNI i nom del seu tutor legal</div>
            <div style="clear:both; float: left;">
                <div style="float: left;">DNI: <?php echo input_tag('dni_tutor',null); ?></div>
                <div style="float: left;">Nom: <?php echo input_tag('nom_tutor',null); ?></div>                                                
            </div>            
        </div>
                
        <div style="padding-top:10px; clear:both;">
            <div style="margin-left:220px;"><input id="BOTO_SUBMIT_DOMICILIACIO" style="width: 100px;" type="submit" value="Acaba la matrícula" /></div>
        </div>
    </div>
<?php } ?>