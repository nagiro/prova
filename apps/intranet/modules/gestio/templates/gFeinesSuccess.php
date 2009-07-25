
<STYLE>
.CALENDARI { font-size: 8px; }
.CALENDARI A { text-decoration:none; color:black; }
.CALENDARI A:hover { text-decoration:none; color:black; font-weight: bolder; }
.CALENDARI A:visited {text-decoration:none; color:black; } 
</STYLE>
    
    <TD colspan="3" class="CONTINGUT">
    
      <?php echo nice_form_tag('gestio/gActivitats',array('method'=>'post')); ?>
    

      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                                                              
                <DIV class="TITOL">Cerca a les activitats </DIV>                
                <DIV class="CERCA"><?php echo input_tag('CERCA',$CERCA, array('size'=>'50%')).submit_tag('Cerca',array('name'=>'BCERCA')).' '.submit_tag('Nova activitat',array('name'=>'BNOU')); ?></DIV>                                                                 
              </TD>
        </TR>
      </TABLE>
      

      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Calendari d'activitats</DIV>
                <TABLE class="CALENDARI">
                <?php                 
                  
                  $DATA = explode("-",$DATAI);
                  $MES = intval($DATA[1]); 
                  $ANY = intval($DATA[0]);
                  echo llistaCalendariH($MES, $ANY , $CERCA , $CALENDARI , $VARIAMES , $VARIAANY , $PAGINA , $IDA , $ACCIO);

                ?>
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>

  <?php IF( $NOU || $EDICIO ): ?>
      
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Dades activitat</DIV>
                <?php echo input_hidden_tag('accio','S'); ?>
                <?php echo input_hidden_tag('idA',$ACTIVITAT->getActivitatid()); ?>
                <TABLE class="DADES">
                  <TR><TD class="ERRORS" colspan="2"><?php if(isset($ERRORS)) echo implode("<br />",$ERRORS); ?></TD>
                  <TR><TD class="LINIA"> Nom </TD><TD> <?php echo input_tag('NOM',$ACTIVITAT->getNom()); ?> </TD>
                  <TR><TD class="LINIA"> Estat </TD><TD><?php echo select_tag('ESTAT',options_for_select(array('P'=>'PreReserva','A'=>'Activa')),$ACTIVITAT->getEstat()); ?></TD>
                  <TR><TD class="LINIA"> Cicle </TD><TD><?php echo select_tag('CICLE',options_for_select(CiclesPeer::getSelect()),$ACTIVITAT->getCiclesCicleid()); ?></TD>
                  <TR><TD class="LINIA"> Tipus </TD><TD><?php echo select_tag('TIPUS',options_for_select(TipusactivitatPeer::getSelect(),$ACTIVITAT->getTipusactivitatIdtipusactivitat())); ?></TD>                  
                  <TR><TD class="LINIA"> Preu </TD><TD> <?php echo input_tag('PREU',$ACTIVITAT->getPreu()); ?> </TD>
                  <TR><TD class="LINIA"> Preu reduït </TD><TD> <?php echo input_tag('PREUREDUIT',$ACTIVITAT->getPreureduit()); ?> </TD>
                  <TR><TD class="LINIA"> Publicable </TD><TD> <?php echo checkbox_tag('PUBLICABLE',true,$ACTIVITAT->getPublicable()); ?> </TD>                                   
                  <TR><TD class="LINIA"></TD><TD><?php echo submit_tag('GUARDA',array('name'=>'BGUARDA')); ?> </TD>                  
                  <?php IF($EDICIO): ?>
                    <TR><TD class="LINIA" colspan="2">ACCIONS</TD>
                    <TR><TD class="LINIA"></TD><TD><?php echo link_to('HORARIS','gestio/gHoraris',array('target'=>'new')); ?> </TD> 
                    <TR><TD class="LINIA"></TD><TD><?php echo link_to('MATERIAL','gestio/gMaterial',array('target'=>'new')); ?> </TD>
                    <TR><TD class="LINIA"></TD><TD><?php echo link_to('FEINES','gestio/gFeines',array('target'=>'new')); ?> </TD>
                    <TR><TD class="LINIA"></TD><TD><?php echo link_to('DESCRIPCIONS','gestio/gDescripcions',array('target'=>'new')); ?> </TD>                              
                    <TR><TD class="LINIA">  </TD>
                  <?php ENDIF; ?>                  
                  
                </TABLE>                                          
              </TD>
        </TR>
      </TABLE>
    
  <?php ELSEIF( $LLISTA ): ?>

      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Llistat d'activitats</DIV>
                <TABLE class="DADES">
                <?php                 

                  if(sizeof($ACTIVITATS) == 0):
                    echo '<TR><TD class="LINIA" colspan="5">No s\'ha trobat cap activitat.</TD></TR>'; 
                  endif;
                  foreach($ACTIVITATS as $A):
                    $H = $A->getHorariss();
                    $E = $H[0]->getHorarisespaiss();
                    echo '<TR><TD class="LINIA">'.link_to($A->getNom(),'calendari/gActivitats').'</TD>';
                    echo '<TD class="LINIA">'.$H[0]->getHoraInici().'</TD>';
                    echo '<TD class="LINIA">'.$E[0]->getEspais()->getNom().'</TD>';
                    echo '<TD class="OPCIONS">'.creaOpcions( $CERCA , $A->getActivitatid() , NULL , $PAGINA , $VARIAMES , $VARIAANY ).'</TD>';                                      
                    echo '</TR>';                                  
                  endforeach;   
                  
                ?>
                </TABLE>                                                                  
            </TD>
        </TR>
      </TABLE>

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

function creaOpcions($CERCA , $IDA , $ACCIO , $PAGINA , $VARIAMES , $VARIAANY )
{  

  //Opció de veure i modificar si té múltiples horaris
  //Opció per editar l'activitat
  //Opció per veure les tasques assignades (Amb Data)
   
  
  $R  = link_to(image_tag('tango/32x32/actions/edit-find-replace.png', array('size'=>'16x16','alt'=>'Edita o visualitza una activitat')),'gestio/gUsuaris'.getPar($CERCA,$PAGINA,$IDA,'E',NULL,NULL,NULL,$VARIAMES,$VARIAANY));  
  $R .= link_to(image_tag('tango/32x32/actions/mail-forward.png', array('size'=>'16x16','alt'=>'Edita o visualitza les dades')),'gestio/gUsuaris'.getPar($CERCA,$PAGINA,$IDA,'L',NULL,NULL,NULL,$VARIAMES,$VARIAANY));
  $R .= link_to(image_tag('tango/32x32/categories/applications-accessories.png', array('size'=>'16x16','alt'=>'Edita o visualitza les dades')),'gestio/gUsuaris'.getPar($CERCA,$PAGINA,$IDA,'C',NULL,NULL,NULL,$VARIAMES,$VARIAANY));  
  
  return $R;
}


function getPar($CERCA = NULL, $PAGINA = NULL, $IDA = NULL, $ACCIO = NULL , $ANY = NULL , $MES = NULL , $DIA = NULL , $VARIAMES = NULL , $VARIAANY = NULL )
{
    $A = "";
    if(!is_null($CERCA))    $A[] = 'CERCA='.$CERCA;
    if(!is_null($PAGINA))   $A[] = 'PAGINA='.$PAGINA;
    if(!is_null($IDA))      $A[] = 'IDA='.$IDA;
    if(!is_null($ACCIO))    $A[] = 'ACCIO='.$ACCIO;
    if(!is_null($ANY))      $A[] = 'ANY='.$ANY;
    if(!is_null($MES))      $A[] = 'MES='.$PAGINA;
    if(!is_null($DIA))      $A[] = 'DIA='.$DIA;    
    if(!is_null($VARIAMES)) $A[] = 'VARIAMES='.$VARIAMES;
    if(!is_null($VARIAANY)) $A[] = 'VARIAANY='.$VARIAANY;
    if(!empty($A)) return '?'.implode('&',$A); 
    else return '';
    
}


  function llistaCalendariH($mes = null, $year = null, $CERCA = NULL, $CALENDARI = NULL, $VARIAMES = NULL, $VARIAANY = NULL, $PAGINA , $IDA , $ACCIO )
  {
    
    //Agafo un mes... marco els dies blanc i començo a escriure
    if($mes==null) $mes = date("m",time());
    if($year == NULL) $year = date('Y',time());        
    $mesI = $mes; $any = $year;
    $mesF = $mesI+3;                    //De moment només sumem 3 mesos
    if($mesF > 12) $mesF = $mesF-12;      
         
    $RET = "<TR><TD></TD>";
    for($i = 6; $i>0; $i--):
      $RET .= "<TD>Dll</TD><TD>Dm</TD><TD>Dc</TD><TD>Dj</TD><TD>Dv</TD><TD>Ds</TD><TD>Dg</TD>";
    endfor;
    $RET .= "</TR>";
    
    for($mes = $mesI; $mes < $mesF; $mes++):
      
      $dies = cal_days_in_month(CAL_GREGORIAN, $mes, $any );                            //Mirem quants dies té el mes      
      $diaSetmana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mes , 1 , $any) , 0 );       //Marquem quants blancs volem tenir      
      if($diaSetmana == 0) $blancs = 6-1; else  $blancs = $diaSetmana-2;
      
      if($mes % 2) $background = "beige"; else $background = "white";                   //Mirem el color del fons
      $RET .= "<TR><TD>".mesos($mes)."</TD>";
      
      for($dia = 0; $dia < 40; $dia++):                                             //Generem el calendari
        $diaA = $dia-$blancs;
        if($dia <= $blancs || $diaA > $dies):                                        //Si és blanc el marquem com a tal i si el dia ha passat el màxim de dies del mes no el marquem
          $RET .= "<TD></TD>";
        else:                                  
          $diaSetmana = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mes , $diaA , $any) , 0 );
          if( $diaSetmana == 6 || $diaSetmana == 0) $background="beige"; else $background = "white"; 
          if(isset($CALENDARI[intval($any)][intval($mes)][intval($diaA)])) $background = "RED";
          
          $RET .= '<TD class="DIES" style="background-color:'.$background.'">'.link_to($diaA,"gestio/gActivitats".getPar($CERCA , $PAGINA , $IDA , 'C' , $any , $mes , $diaA , $VARIAMES , $VARIAANY )).'</TD>';
                              
        endif;    
      endfor;
      $RET .= "</TR>";
      if($mes == 12) $any = $any+1;
    endfor;
          
    return $RET;
      
  }

/*
  function llistaCalendariV($mes = null, $year = null, $CERCA = NULL, $CALENDARI = NULL, $VARIAMES = NULL, $VARIAANY = NULL)
  {
    if(is_null($mes)) $mes = date('m');
    if(is_null($year)) $year = date('Y');
    $RET = "";        
    
    $blancs = jddayofweek(cal_to_jd(CAL_GREGORIAN, $mes , 1 , $year) , 0 ) - 1 ;
    if( $blancs +1 == 0) $blancs = 6;
    for($i = $blancs + 1 ; $i > 0; $i--) $RET .= "<TD></TD>";
    
    $diaSetmana = $blancs + 1;
    
    for($i = 0; $i<5; $i++):       
      $mesA = (($mes+$i)>12)?($mes+$i-12):($mes+$i);      
      if(($mes+$i)>12 && $mesA == 1) { $year++; }
      $dies[$mesA]['DIES'] = cal_days_in_month(CAL_GREGORIAN, $mesA , $year );
      $dies[$mesA]['ANY'] = $year;            
    endfor;    
  
    foreach($dies as $MES => $DADES):            
      for($dia = 1; $dia <= $DADES['DIES']; $dia++):
        if($MES % 2) $background = "beige"; else $background = "white";                        
        if(isset($CALENDARI[intval($DADES['ANY'])][intval($MES)][intval($dia)])) $background = "RED";
        $RET .= '<TD class="DIES" style="background-color:'.$background.'">'.link_to($dia,"calendari/index".generaLINK($DADES['ANY'],$MES,$dia,$CERCA,$VARIAMES,$VARIAANY)).'</TD>';
        if($diaSetmana == 7) { 
          $RET .= "</TR><TR>"; $diaSetmana = 0; 
          if($dia < 8) $RET .= "<TD>".mesos($MES).'<BR />'.$DADES['ANY']."</TD>"; else $RET .= "<TD></TD>";  //Si hi ha un canvi de mes  
        }
        $diaSetmana++;
      endfor;    
    endforeach;
  
    return $RET;
  
  }
*/

  function mesos($mes)  
  {
    switch($mes){
      case 1: $text = "Gener"; break;
      case 2: $text = "Febrer"; break;
      case 3: $text = "Març"; break;
      case 4: $text = "Abril"; break;
      case 5: $text = "Maig"; break;
      case 6: $text = "Juny"; break;
      case 7: $text = "Juliol"; break;
      case 8: $text = "Agost"; break;
      case 9: $text = "Setembre"; break;
      case 10: $text = "Octubre"; break;
      case 11: $text = "Novembre"; break;
      case 12: $text = "Desembre"; break;
    }
    
    return utf8_encode($text);
  
  }

  function fletxeta()
  {
    return image_tag('intranet/fletxeta.png',array('align'=>'ABSMIDDLE'));
  }


?>
