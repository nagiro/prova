<STYLE>

#FDATA { width:80px; }
#CALEN TABLE { border-collapse: collapse; }
#CALEN TD { font-size: 9px; }
.COLOR { background-color:rgb(252,236,182); }
#TITOL_TAULA { font-weight: bold; background-color: #EEEEEE; }

</STYLE>
   
    <TD colspan="3" class="CONTINGUT">
    
      <?php echo nice_form_tag('gestio/gEspais',array('method'=>'post')); ?>
    
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                                                              
                <DIV class="TITOL">Cerca espais</DIV>                
                <DIV class="CERCA">
	            	<?php echo select_tag('CERCA_ANY',options_for_select( selectAnys() , $CERCA_ANY ) , array('class'=>'cinquanta')); ?>                	
                	<?php echo select_tag('CERCA_ESPAI',options_for_select( EspaisPeer::select() , $CERCA_ESPAI , array('include_custom'=>'Tots els espais') ) , array('class'=>'cinquanta')); ?>
                	<?php echo select_tag('CERCA_MES',options_for_select( selectMesos() , $CERCA_MES , array('include_custom'=>'Tots els mesos')  ) , array('class'=>'cinquanta')); ?>
                	<?php echo submit_tag('Cerca'); ?>                	                                                                 
                </DIV>
              </TD>
        </TR>
      </TABLE>
    
<?php if(isset($DADES_MESOS_DIES)): ?>
      
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Calendari d'activitats</DIV>
        		<table class="DADES">
        		<?php
        		
        		//Linia d'espais
        		echo '<TR><TD class="LINIA" id="TITOL_TAULA">DIES/MESOS</TD>'; foreach($MESOS as $K=>$M) echo '<TD class="LINIA" id="TITOL_TAULA">'.$K.'</TD>'; echo '</TR>';
        		
        		//Iniciem la taula
        		foreach($DIES as $KD=>$D):
        		   echo '<TR><TD class="LINIA" id="TITOL_TAULA">'.$D.'</TD>';
        		   foreach($MESOS as $KM=>$M){
        		      if(isset($DADES_MESOS_DIES[$KM][$KD]))
        		         echo '<TD class="LINIA">'.sizeof($DADES_MESOS_DIES[$KM][$KD]).'</TD>';
        		      else
        		         echo '<TD class="LINIA">-</TD>';
        		   }
        		   echo '</TR>';              		     		   
        		endforeach;
        		echo '<TR><TD class="LINIA" id="TITOL_TAULA">TOTALS</TD>';
                foreach($MESOS as $KM=>$M):
                   $SOL = 0;        		   
        		   foreach($DIES as $KD=>$D) if(isset($DADES_MESOS_DIES[$KM][$KD])) $SOL += sizeof($DADES_MESOS_DIES[$KM][$KD]);
        		   echo '<TD class="LINIA">'.$SOL.'</TD>';                            		           		           		      		     		   
        		endforeach;
        		echo '</TR>';                   		
        		?>
                 </TABLE>
                 </DIV>
         </TD>
         </TR>
         </TABLE>                                                                                                                                            

<?php elseif(isset($DADES_MESOS_ESPAIS)): ?>

      <TABLE class="BOX">
        <TR><TD class="NOTICIA">                
                <DIV class="TITOL">Calendari d'activitats</DIV>
        		<table class="DADES">
        		<?php
        		
        		//Linia d'espais
        		echo '<TR><TD class="LINIA" id="TITOL_TAULA">MESOS/ESPAIS</TD>'; foreach($MESOS as $K=>$M) echo '<TD class="LINIA" id="TITOL_TAULA">'.$K.'</TD>'; echo '</TR>';
        		
        		//Iniciem la taula
        		foreach($ESPAIS as $KE=>$E):
        		   echo '<TR><TD class="LINIA" id="TITOL_TAULA">'.$E.'</TD>';
        		   foreach($MESOS as $KM=>$M){
        		      if(isset($DADES_MESOS_ESPAIS[$KM][$KE]))
        		         echo '<TD class="LINIA">'.sizeof($DADES_MESOS_ESPAIS[$KM][$KE]).'</TD>';
        		      else
        		         echo '<TD class="LINIA">-</TD>';
        		   }
        		   echo '</TR>';              		     		   
        		endforeach;
        		echo '<TR><TD class="LINIA" id="TITOL_TAULA">TOTALS</TD>';
                foreach($MESOS as $KM=>$M):
                   $SOL = 0;        		   
        		   foreach($ESPAIS as $KE=>$E) if(isset($DADES_MESOS_ESPAIS[$KM][$KE])) $SOL += sizeof($DADES_MESOS_ESPAIS[$KM][$KE]);
        		   echo '<TD class="LINIA">'.$SOL.'</TD>';                            		           		           		      		     		   
        		endforeach;
        		echo '</TR>';                   		
        		?>
                 </TABLE>
                 </DIV>
         </TD>
         </TR>
         </TABLE>

<?php endif; ?>    
  
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
    
<?php
 

  function selectMesos()
  {
    $RET = array();
  	for($i = 1; $i < 13; $i++) $RET[$i] = mesos($i);              
    return $RET;          
  }
  
  function selectAnys()
  {
	$RET = array();
	$any = date('Y',time());
	for($i = $any-10 ; $i < $any+4; $i++) $RET[$i] = $i;              
	return $RET;          
  }
  
  
  
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
    
    return $text;
  
  }
  

?>
