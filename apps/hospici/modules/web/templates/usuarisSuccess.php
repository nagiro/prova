<?php use_helper('Form') ?>
<?php use_helper('Presentation') ?>
<?php $BASE = '/images/hospici'; ?>
  
<script type="text/javascript">

    <?php   $ext = "";                        
            switch($SECCIO){                
                case 'INICI': $ext = ', selected: 0'; break;
                case 'USUARI': $ext = ', selected: 1'; break;
                case 'MATRICULA': $ext = ', selected: 2'; break;
                case 'RESERVA': $ext = ', selected: 3'; break;
                case 'COMPRA_ENTRADA': $ext = ', selected: 4'; break;
                case 'FORMULARIS': $ext = ', selected: 5'; break;                
                default: $ext = ', selected: 0'; break;
            }              
    
    ?>
    
    $(document).ready(function() {                                                   
            $( "#tabs" ).tabs({ cookie: { expires: 30 } <?php echo $ext ?> });
        });
        
</script>

<style>
    .taula_dades { width:600px;  }
    .taula_dades input { border:1px solid #DDDDDD; padding:3px; }
    .taula_dades input:focus { background-color:#EEEEEE; }
    .taula_dades select { border:1px solid #DDDDDD; width:200px; }
    .taula_dades select:focus { background-color:#EEEEEE;  }
    .taula_dades th { text-align:right; width:150px; padding-right:5px; }
    .taula_dades td { padding:3px;  }

    .taula_llistat { width:600px; border-collapse:collapse;  }
    .taula_llistat th { text-align:left; padding:3px;  }
    .taula_llistat td { text-align:left; padding:3px; }
    .taula_llistat tr:hover { background-color: #EEEEEE;  }    

</style>

<div class="h_subtitle_gray">
    ZONA PRIVADA
</div>

<div id="tabs">
	<ul>
		<li><a href="#tabs-1">Benvinguda</a></li>
		<li><a href="#tabs-2">Dades personals</a></li>			
        <li><a href="#tabs-3">Matrícules</a></li>
        <li><a href="#tabs-4">Reserves d'espais</a></li>
        <li><a href="#tabs-5">Entrades</a></li>
        <li><a href="#tabs-6">Formularis</a></li>        
	</ul>
    
    <div id="tabs-1">        
        Benvingut a la zona privada de l'Hospici.<br /><br /> 
        Si està veient aquesta pàgina és perquè vostè ja és un usuari registrat de l'Hospici i ha entrat el seu DNI i contrassenya correctament.<br /> 
        Sota el títol <b>Què desitges fer?</b>, al requadre de la dreta, li apareixeran totes les accions que pot realitzar com a usuari registrat. Per altra banda clicant clicant les pestanyes superiors veurà tot allò que vostè ha fet amb l'Hospici.<br />
        Moltes gràcies per utilitzar l'Hospici. 
        
        <br /><br />                    
    </div>
    <div id="tabs-2">
        
        <?php             
            if(isset($MISSATGE1)){
                if($MISSATGE1 == 'OK') show_missatge("Les seves dades han estat actualitzades amb èxit.");
            }
            
            echo Usuari_Formulari($FUsuari);
        
        ?>
        
    </div>
    
    <div id="tabs-3">
    
        <?php

            if(isset($MISSATGE3)){                                                                              

                //No sé d'on venen aquests missatges. Caldrà mirar-ho. 
                            
                if($MISSATGE3 == 'OK') show_missatge("La matrícula s'ha efectuat correctament.<br /> Si només ha realitzat una reserva, aviat ens posarem en contacte amb vostè per finalitzar-la.");
                if($MISSATGE3 == 'KO') show_missatge("Hi ha hagut algun problema guardant la seva matrícula. <br />Torni-ho a provar o bé envii un missatge a informatica@casadecultura.org per informar de la incidència. <br /><br />Moltes gràcies i perdoni les molèsties.");
                if($MISSATGE3 == 'ESPERA')  show_missatge("El curs és ple i vostè ha estat afegit a la llista d'espera.<br /> Si s'alliberen places, ens posarem en contacte amb vostè per saber si encara hi està interessat. <br />Moltes gràcies i perdoni les molèsties.");                
                if($MISSATGE3 == 'JA_EXISTEIX')  show_missatge("A la nostra base de dades ja existeix una matrícula seva a aquest curs.<br /> Si us plau, posi's en contacte amb l'entitat per solventar-ho. <br />Moltes gràcies i perdoni les molèsties.");
                if($MISSATGE3 == 'CURS_PLE_LLISTA_ESPERA') show_missatge("Vostè ha estat incorporat a la llista d'espera del curs. Si en un futur hi ha places lliures ens posarem en contacte amb vostè.  <br />Moltes gràcies i perdoni les molèsties.");                
            }
         
            if(isset($LMatricules)) Matricules_Llista($LMatricules);            
                                            
         ?> 
                
    </div>
            
    <div id="tabs-4">

        <?php
        
            //Si hi ha algun missatge el mostrem 
            if(isset($MISSATGE4)){
                if($MISSATGE4 == 'OK') show_missatge("Les seves dades han estat actualitzades i guardades amb èxit.");                
                if($MISSATGE4 == 'ERROR_SAVE') show_missatge("Hi ha alguna dada errònia. Si us plau, correixi-la.");                
                if($MISSATGE4 == 'RESERVA_ACCEPTADA') show_missatge("La seva reserva ha estat acceptada.<br />Sempre que ho desitgi podrà consultar les seves reserves accedint a la seva zona privada del web.");
                if($MISSATGE4 == 'RESERVA_ANULADA') show_missatge("La seva reserva ha estat anul·lada degut a què vostè no ha acceptat les condicions. <br />Sempre que ho desitgi podrà consultar les seves reserves accedint a la serva zona privada del web.");
                if($MISSATGE4 == 'ERROR_TECNIC') show_missatge("Hi ha hagut un error tècnic en l'acceptació.<br />Si us plau posis en contacte amb l'Hospici trucant al 972.20.20.13 o bé per correu a informatica@casadecultura.org<br />Perdoni les molèsties.");
            }                                                                                                                                                                                
               
            //Si tenim un formulari de reserva carregat, el mostrem
            if(isset($FReserva) && $FReserva instanceof HospiciReservesForm){
                if($FReserva->getObject()->getEstat() == ReservaespaisPeer::PENDENT_CONFIRMACIO){
                    echo ReservaEspais_RespostaCondicions($FReserva);     
                } else {
                    echo ReservaEspais_VisualitzaFormulari($FReserva);
                }
            }                                         
            else{
                echo ReservaEspais_LlistaReserves($LReserves);
            }
        ?>
        
    </div>
    <div id="tabs-5">

        <?php 
        
            if(isset($MISSATGE2)){
                
                if($MISSATGE2 == 'HORARI_INCORRECTE') show_missatge("Hi ha hagut algun error en l'horari escollit. Si us plau contacti amb informatica@casadecultura.org o bé trucant al telèfon 972.20.20.13 (Albert Johé)");
                if($MISSATGE2 == 'ACTIVITAT_INCORRECTE') show_missatge("Hi ha hagut algun error en l'activitat escollida. Si us plau contacti amb informatica@casadecultura.org o bé trucant al telèfon 972.20.20.13 (Albert Johé)");
                if($MISSATGE2 == 'PREU_INCORRECTE') show_missatge("Hi ha hagut algun error en el preu escollit. Si us plau contacti amb informatica@casadecultura.org o bé trucant al telèfon 972.20.20.13 (Albert Johé)");
                if($MISSATGE2 == 'ENTRADA_REPE') show_missatge("Vostè ja ha reservat entrades per aquest espectacle. <br /> Si vol fer canvis, primer anul·li la seva reserva prèvia i torni-ho a reservar.");
                if($MISSATGE2 == 'NO_QUEDEN_PROU_ENTRADES') show_missatge("Entrades exhaurides per aquesta activitat o nombre màxim d'entrades superat. <br /> Per a més informació si us plau contacti amb informatica@casadecultura.org o bé trucant al telèfon 972.20.20.13 (Albert Johé). ");
                if($MISSATGE2 == 'ERROR_TPV') show_missatge("Hi ha hagut un error reservant les entrades. <br />Si us plau, posis en contacte amb informatica@casadecultura.org o bé truqui al telèfon 972.20.20.13.");                                
                if($MISSATGE2 == 'ERROR_MINIM_ENTRADES') show_missatge("Ha intentat reservar o comprar un número d'entrades incorrecte. <br />Recordi que en pot comprar entre 1 i 8.");
                
                if($MISSATGE2 == 'COMPRA_OK') show_missatge("La seva reserva s'ha efectuat correctament.<br />Ha escollit el pagament en metàl·lic o amb codi de barres. Per finalitzar la reserva, haurà de fer el pagament d'aquesta compra abans d'una setmana o bé quedarà anul·lada. <br /> Pot imprimir el seu full de pagament clicant ".link_to('aquí','@hospici_entrada_factura?idER='.$IDER).". ");
                if($MISSATGE2 == 'RESERVA_OK') show_missatge("La seva reserva s'ha efectuat correctament.<br />Pot imprimir el seu full de reserva clicant ".link_to('aquí','@hospici_entrada_factura?idER='.$IDER).". ");
                if($MISSATGE2 == 'LLISTA_ESPERA_OK') show_missatge("Vostè ha estat afegit correctament a la llista d'espera. Si en un futur s'alliberen places, ens posarem en contacte amb vostè per si encara hi està interessat.");
                if($MISSATGE2 == 'DOMICILIACIO_OK') show_missatge("La seva reserva s'ha efectuat correctament.<br />Per finalitzar el pagament haurà de posar-se en contacte amb l'entitat organitzadora per cedir-li el seu compte corrent en cas que ja no el tinguin.");                                                            
            }

            echo Entrades_Llista($LEntrades);    
    
        ?>
    
    </div>
    <div id="tabs-6">
        <?php 
        
            if(isset($MISSATGE6)){
                if($MISSATGE6 == 'ALTA_OK') show_missatge("El seu formulari s'ha enregistrat correctament.");                
            }

            echo Formularis_Llista($LFormularis);    
    
        ?>    
    </div>	
</div>



<?php function Usuari_Formulari($FUsuari){ ?>

        <form action="<?php echo url_for('@hospici_usuaris_modifica'); ?>" method="POST">
            <table class="taula_dades">                
                <?php echo $FUsuari; ?>
                <tr>
                    <td></td>
                    <td style="text-align: right;">
                        <br />
                        <input type="submit" value="Guarda els canvis" />
                    </td>
                </tr>
            </table>
        </form>

<?php } ?>



<?php function show_missatge($mis){ ?>

        <div class="requadre_missatge"><?php echo $mis ?></div>
        <br />
            
<?php } ?>


<?php function Matricules_Llista($LMatricules){ ?>

        <table class="taula_llistat">
            <tr>
                <th>Data</th>
                <th>Codi</th>
                <th>Curs</th>
                <th>Entitat</th>
                <th>Estat</th>
            </tr>            
            <?php                                           
                if(empty($LMatricules)): echo '<tr><td colspan="4">No s\'han trobat matrícules.</td></tr>';
                else:                           
                    foreach($LMatricules as $OM):                    
                    
                        $nom = SitesPeer::getNom($OM->getSiteId());
                        $OC = $OM->getCursos();
                        if($OC instanceof Cursos):
                            $idC = $OC->getIdcursos(); $titol = $OC->getNomForUrl();                        
                            echo '<tr>
                                    <td>'.$OM->getDatainscripcio('m/Y').'</td>
                                    <td>'.$OM->getCursos()->getCodi().'</td>
                                    <td>'.link_to($OM->getCursos()->getTitolcurs(),"@hospici_detall_curs?idC=$idC&titol=$titol",array('target'=>'new')).'</td>
                                    <td>'.$nom.'</td>
                                    <td>'.$OM->getEstatString().'</td>
                                 </tr>';
                        endif;                                                                                 
                    endforeach;
                endif;
            ?>                        
        </table>                        

<?php } ?> 
    
    
    
<?php function ReservaEspais_RespostaCondicions($FReserva){ ?>
        
        <?php $OR = $FReserva->getObject(); ?>

        <form action="<?php echo url_for('@hospici_reserva_espai_condicions'); ?>" method="POST">            
            <div style="background-color:#EEEEEE; padding:5px; font-weight:bold; text-align:center;">ACCEPTACIÓ DE CONDICIONS</div>

            <table class="taula_dades">
                <tr>
                    <td>
                        <?php echo $OR->getCondicionsccg(); ?>
                        <?php echo input_hidden_tag('idR',$OR->getReservaespaiid()); ?>
                    </td>
                </tr>                
                <tr>            
                    <td style="text-align: right;">
                        <br />
                        <input style="float:right; margin-left:20px;" type="submit" name="B_NO_ACCEPTO" value="No accepto les condicions" />
                        <input style="float:right" type="submit" name="B_ACCEPTO" value="Accepto les condicions" />
                    </td>
                </tr>
            </table>
                    
            <div style="background-color:#EEEEEE; padding:5px; margin-top:20px; font-weight:bold; text-align:center;">RESERVA D'ESPAI SOL·LICITADA</div>                    
                                                
            <table class="taula_dades">
                <?php echo $FReserva; ?>                
            </table>
        </form>
            
<?php } ?>
    
    
<?php function ReservaEspais_VisualitzaFormulari($FReserva){ ?>
    
        <form action="<?php echo url_for('@hospici_nova_reserva_espai_save'); ?>" method="POST" enctype="multipart/form-data">            
            <div style="background-color:#EEEEEE; padding:5px; font-weight:bold; text-align:center;">FORMULARI DE RESERVA D'ESPAI</div>                                    
            <table class="taula_dades">
                <?php echo $FReserva; ?>
                <tr><td style="background-color: #EEEEEE; font-weight:bold;" colspan="2">Dades per difusió WEB <span style="font-weight: normal;"> | Aquesta informació s'utilitzarà per a fer la difusió de la seva activitat <br />En el cas que no disposi encara de la difusió, marqui que vol difusió i enviï-la a <?php echo OptionsPeer::getString( 'MAIL_SECRETARIA' , $FReserva->getObject()->getSiteId() )?>.</span></td></tr>
                <tr>
                    <th><label for="reservaespais_TipusActe">Vol que fem difusió?</label></th>
                    <td><select id="reservaespais_sidifu" name="extres[sidifu]">
                            <?php echo options_for_select(array(1=>'Sí',0=>'No'),$FReserva->getObject()->getHasDifusio()) ?>                            
                        </select></td>
                </tr>
                <tr>
                    <th><label for="reservaespais_TipusActe">Text descriptiu</label></th>
                    <td><textarea id="reservaespais_descweb" name="extres[descweb]" style="width:400px; height:200px;"><?php echo $FReserva->getObject()->getWebDescripcio() ?></textarea></td>
                </tr>
                <tr>
                    <th><label for="reservaespais_TipusActe">Imatge</label></th>
                    <td><input type="file" id="reservaespais_img" name="img" style="width:400px;" />                                                                        
                        <?php   
                                //Si existeix l'arxiu, el carreguem perquè poguem veure'l
                                $FILES = glob( getcwd().'/uploads/arxius/'.'RE-'.$FReserva->getObject()->getReservaespaiid().'-IMG-*' );                                
                                if( sizeof($FILES) > 0 ):
                                    $A = explode('/uploads/arxius/',$FILES[0]);
                                    $arxiu = array_pop($A);
                                    echo '<a target="_new" href="http://www.hospici.cat/uploads/arxius/'.$arxiu.'">Baixa\'t l\'arxiu</a>';
                                endif;                                                                       
                        ?> 
                    </td>
                </tr>
                <tr>
                    <th><label for="reservaespais_TipusActe">PDF</label></th>
                    <td><input type="file" id="reservaespais_pdf" name="pdf" style="width:400px;" />
                    <?php 
                            //Si existeix l'arxiu, el carreguem perquè poguem veure'l
                            $FILES = glob( getcwd().'/uploads/arxius/'.'RE-'.$FReserva->getObject()->getReservaespaiid().'-PDF-*' );                                
                            if( sizeof($FILES) > 0 ):
                                $A = explode('/uploads/arxius/',$FILES[0]);
                                $arxiu = array_pop($A);
                                echo '<a target="_new" href="http://www.hospici.cat/uploads/arxius/'.$arxiu.'">Baixa\'t l\'arxiu</a>';
                            endif;                                                                                         
                    ?>
                        
                    </td>
                </tr>                
                <tr>
                    <td></td>
                    <td style="text-align: right;">
                        <br />
                        <?php
                        
                            if(!$FReserva->isNew()) { echo link_to('Torna al llistat','@hospici_llista_reserves'); 
                            } else { echo '<input type="submit" value="Sol·licita la reserva" />'; }
                             
                        ?> 
                    </td>
                </tr>
            </table>
        </form>
        
<?php } ?>


<?php function ReservaEspais_LlistaReserves($LReserves){ ?>
    
        <table class="taula_llistat">
            <tr>
                <th>Referència</th>
                <th>Nom reserva</th>
                <th>Data alta</th>
                <th>Estat</th>
            </tr>            
            <?php
                if(empty($LReserves)): echo '<tr><td colspan="4">No s\'han trobat reserves d\'espais.</td></tr>';
                else:                           
                    foreach($LReserves as $OR):
                        echo '<tr>
                                <td>'.link_to($OR->getCodi(),'@hospici_reserva_espai?idR='.$OR->getReservaespaiid()).'</td>
                                <td>'.$OR->getNom().'</td>
                                <td>'.$OR->getDataalta('d/m/Y').'</td>
                                <td>'.$OR->getEstatText().'</td>
                             </tr>';
                    endforeach;
                endif;
            ?>                                    
        </table> 
        
<?php } ?>    
    




<?php function Entrades_Llista($LEntrades){ ?>

        <table class="taula_llistat">
            <tr>
                <th>Quan</th>
                <th>Hora</th>
                <th>Titol</th>
                <th>On</th>
                <th>Entrades</th>
                <th>Estat</th>
            </tr>            
            <?php       
                         
                if(empty($LEntrades)): echo '<tr><td colspan="4">No s\'ha trobat cap entrada comprada.</td></tr>';
                else:                           
                    foreach($LEntrades as $OER):                                                
                        $OA = ActivitatsPeer::retrieveByPK($OER->getEntradesPreusActivitatId());
                        $OH = HorarisPeer::retrieveByPK($OER->getEntradesPreusHorariId());
                        if($OA instanceof Activitats && $OH instanceof Horaris)                        
                        {
                            $SiteName = SitesPeer::getNom($OA->getSiteId());
                            $class = "";
                            if($OER->getEstat() == EntradesReservaPeer::ESTAT_ENTRADA_ANULADA) $class="class=\"tatxat\"";
                            echo "<tr>
                                    <td $class>{$OH->getDia('d-m-Y')}</td>
                                    <td $class>{$OH->getHorainici('H:i')}</td>
                                    <td $class>{$OA->getTmig()}</td>
                                    <td $class>{$SiteName}</td>
                                    <td $class>{$OER->getQuantitat()}</td>
                                    <td $class>{$OER->getEstatString()}</td>";
                            //if($OER->getEstat() != EntradesReservaPeer::ESTAT_ENTRADA_ANULADA) echo "<td><a href=\"".url_for('@hospici_anula_entrada?idER='.$OER->getIdentrada())."\">Anul·lar</a></td>";
                            echo "</tr>";                                                                            
                        }
                    endforeach;
                endif;
            ?>                                    
        </table>
         
<?php } ?>

<?php function Formularis_Llista($LFormularis){ ?>

        <table class="taula_llistat">
            <tr>
                <th>Formulari</th>
                <th>Entitat</th>
                <th>Registrat</th>                
            </tr>            
            <?php                 
                                                  
                if(empty($LFormularis)): echo '<tr><td colspan="4">No s\'ha trobat cap formulari.</td></tr>';
                else:                           
                    foreach($LFormularis as $OFR):                                        
                        $nom = SitesPeer::getNom($OFR->getSiteId());
                        $OF = $OFR->getFormulariss();
                        $OF = $OF[0];                                                
                        $url = url_for('@hospici_formularis_detall?idF='.$OF->getIdformularis().'&titol='.$OF->getNomForUrl());
                                                                                                                                                
                        echo '<tr>
                                <td><a href="'.$url.'">'.$OF->getNom().'</a></td>
                                <td>'.$nom.'</td>                                                                
                                <td>'.$OFR->getRegistrat().'</td>
                             </tr>';                                                                                                         
                    endforeach;
                endif;
            ?>                        
        </table>                        

<?php } ?> 

    