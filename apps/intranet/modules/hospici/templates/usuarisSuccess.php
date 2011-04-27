<?php use_helper('Form') ?>
<?php use_helper('Presentation') ?>
<?php $BASE = sfConfig::get('sf_webrooturl').'images/hospici'; ?>
 
<script type="text/javascript">

    $(document).ready(function() {                                                   
            $( "#tabs" ).tabs({ cookie: { expires: 30 } });                                         
        });
        
</script>

<style>
    .taula_dades { width:500px;  }
    .taula_dades input { border:1px solid #DDDDDD; padding:3px; }
    .taula_dades input:focus { background-color:#EEEEEE; }
    .taula_dades select { border:1px solid #DDDDDD; width:200px; }
    .taula_dades select:focus { background-color:#EEEEEE;  }
    .taula_dades th { text-align:right; width:100px; padding-right:5px; }

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
        <li><a href="#tabs-6">Missatgeria</a></li>        
	</ul>
    
    <div id="tabs-1">        
        Benvingut a la zona privada de l'Hospici.<br /><br /> 
        Si està veient aquesta pàgina és perquè vostè ja és un usuari registrat de l'Hospici i ha entrat el seu DNI i contrassenya correctament.<br /> 
        Sota el títol <b>Què pots fer?</b>, al requadre de la dreta, li apareixeran totes les accions que pot realitzar com a usuari registrat. Per altra banda clicant clicant les pestanyes superiors veurà tot allò que vostè ha fet amb l'Hospici.<br />
        Moltes gràcies per utilitzar l'Hospici. 
        
        <br /><br />                    
    </div>
    <div id="tabs-2">
        <form action="<?php echo url_for('@hospici_usuaris_modifica'); ?>" method="POST">
            <?php if(isset($MISSATGE) && $MISSATGE == 'OK') echo '<div style="margin-bottom:20px;"><div class="missatge">Les seves dades han estat actualitzades amb èxit.</div></div>'; ?>
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
    </div>
    <div id="tabs-3">                 
        <table class="taula_llistat">
            <tr>
                <th>Data</th>
                <th>Codi</th>
                <th>Curs</th>
                <th>Entitat</th>
            </tr>            
            <?php               
                if(empty($LMatricules)): echo '<tr><td colspan="4">No s\'han trobat matrícules.</td></tr>';
                else:                           
                    foreach($LMatricules as $OM):
                        echo '<tr>
                                <td>'.$OM->getDatainscripcio('m/Y').'</td>
                                <td>'.$OM->getCursos()->getCodi().'</td>
                                <td>'.$OM->getCursos()->getTitolcurs().'</td>
                                <td>'.SitesPeer::initialize($OM->getSiteId())->getObject()->getNom().'</td>
                             </tr>';                                                            
                    endforeach;
                endif;
            ?>                        
        </table>
    </div>
    <div id="tabs-4">

        <table class="taula_llistat">
            <tr>
                <th>Data</th>
                <th>Codi</th>
                <th>Curs</th>
                <th>Entitat</th>
            </tr>            
            <?php
                if(empty($LReserves)): echo '<tr><td colspan="4">No s\'han trobat reserves d\'espais.</td></tr>';
                else:                           
                    foreach($LReserves as $OR):
                        echo '<tr>
                                <td>'.$OR->getCodi().'</td>
                                <td>'.$OR->getNom().'</td>
                                <td>'.$OR->getDataalta('d/m/Y').'</td>
                                <td>'.$OR->getEstatText().'</td>
                             </tr>';                                                            
                    endforeach;
                endif;
            ?>                                    
        </table> 
        
    </div>
    <div id="tabs-5">
    
        <table class="taula_llistat">
            <tr>
                <th>Data</th>
                <th>Codi</th>
                <th>Espectacle</th>
                <th>Entitat</th>
            </tr>            
            <?php
                if(empty($LReserves)): echo '<tr><td colspan="4">No s\'han trobat reserves d\'espais.</td></tr>';
                else:                           
                    foreach($LReserves as $OR):
                        echo '<tr>
                                <td>'.$OR->getCodi().'</td>
                                <td>'.$OR->getNom().'</td>
                                <td>'.$OR->getDataalta('d/m/Y').'</td>
                                <td>'.$OR->getEstatText().'</td>
                             </tr>';                                                            
                    endforeach;
                endif;
            ?>                                    
        </table> 
    
    </div>
    <div id="tabs-6"></div>	
</div>