<?php use_helper('Form'); ?>

<STYLE>
.cent { width:100%; }
.noranta { width:90%; }
.cinquanta { width:50%; }
.gray { background-color: #EEEEEE; }
.NOM { width:20%; } 

	.row { width:500px; } 
	.row_field { width:80%; } 
	.row_title { width:20%; }
	.row_field input { width:100%; } 


</STYLE>
   
    <TD colspan="3" class="CONTINGUT">
      
    <?php include_partial('breadcumb',array('text'=>'TAULELL')); ?>
    
    <form action="<?php echo url_for('gestio/gMissatges') ?>" method="POST" id="FCERCA">
    	<?php include_partial('cerca',array(
    										'TIPUS'=>'Simple',
    										'FCerca'=>$FCerca,
    										'BOTONS'=>array(
    														array(
    																'name'=>'BCERCA',
    																'text'=>'Prem per buscar'),
    														array(
    																'name'=>'BNOU',
    																'text'=>'Nou missatge')    														
    													)
    										)
    							); ?>
     </form>
            
          

  <?php IF( isset($MODE['NOU']) || isset($MODE['EDICIO']) ): ?>
      
	<form action="<?php echo url_for('gestio/gMissatges') ?>" method="POST">
	
	 	<div class="REQUADRE fb">
	 	<?php include_partial('botonera',array('tipus'=>'Tancar','url'=>'gestio/gMissatges?accio=C')) ?>
					 	 		
	 		<div class="FORMULARI fb">
	 			<?php echo $FMissatge ?>
	 			<?php if($FMissatge->getObject()->getUsuarisUsuariid() == $IDU || $NOU)	include_partial('botoneraDiv',array('element'=>'el missatge')); ?>		
	 		</div>
	 			 	 	
      	</div>
			
	</form>      
      
  <?php ELSE: ?>
  
  	<DIV class="REQUADRE">
  	<DIV class="TITOL">Llistat de missatges (<a href="<?php echo url_for('gestio/gMissatges?accio=SF'); ?>">Veure missatges futurs</a>)</DIV>
  		<table class="DADES">
                <?php  
                    if( $MISSATGES->getNbResults() == 0 ) echo '<TR><TD colspan="3">No s\'ha trobat cap resultat d\'entre '.MissatgesPeer::doCount(new Criteria()).' disponibles.</TD></TR>';
                    else { 
                       $dif = "";
                      	foreach($MISSATGES->getResults() as $M) {
                      	    if($dif != $M->getPublicacio('d/m/Y')):
                      	    	echo '<TR><TD class="LINIA" style="height:20px" colspan="3"></TD></TR>';
                      	    	echo '<TR><TD class="gray" colspan="3"><b>'.diaSetmanaText($M->getPublicacio('Y-m-d')).' </b></TD></TR>';                      	    	
                      	    endif; 
                      		$SPAN  = '<span>'.$M->getText().'</span>';
                      		echo "<TR>                      				
                      				<TD>".link_to(image_tag('intranet/Submenu2.png').' '.$M->getTitol().$SPAN,'gestio/gMissatges'.getParam( 'E' , $M->getMissatgeid() , $CERCA ) , array('class'=>'tt2') )."</TD>
                      				<TD class=\"LINIA\">".$M->getUsuaris()->getNom().' '.$M->getUsuaris()->getCog1()."</TD>
                      			  </TR>";
                      		$dif = $M->getPublicacio('d/m/Y');  
                      	}                    	
                    }
                ?>     			
        <tr><td colspan="2" style="text-align:center">
        	<?php echo setPager($MISSATGES,'gestio/gMissatges?a=a',$PAGINA); ?>         
        </td></tr>
  		</table>
  	</DIV>
  	  
  <?php ENDIF; ?>
  
      <DIV STYLE="height:40px;"></DIV>
                
<!--    </TD> -->    
    
    

<?php 
  
  function getParam( $accio , $IDM , $CERCA )
  {
      $opt = array();
      if(isset($accio)) $opt[] = "accio=$accio";
      if(isset($IDM)) $opt['IDM'] = "IDM=$IDM";
      if(isset($CERCA)) $opt['CERCA'] = "CERCA=$CERCA";
      
      RETURN "?".implode( "&" , $opt);
  }
  
 
  function diaSetmanaText($DIA){
  		
		$ret = ""; list($ANY,$MES,$DIA) = explode("-",$DIA);		
		$DATE = mktime(0,0,0,$MES,$DIA,$ANY);
		switch(date('N',$DATE)){
			case '1': $ret = "Dilluns, ".date('d',$DATE); break;  
			case '2': $ret = "Dimarts, ".date('d',$DATE); break;
			case '3': $ret = "Dimecres, ".date('d',$DATE); break;
			case '4': $ret = "Dijous, ".date('d',$DATE); break;
			case '5': $ret = "Divendres, ".date('d',$DATE); break;
			case '6': $ret = "Dissabte, ".date('d',$DATE); break;
			case '7': $ret = "Diumenge, ".date('d',$DATE); break;				
		}
				
		switch(date('m',$DATE)){
			case '01': $ret .= " de gener"; break;
			case '02': $ret .= " de febrer"; break;
			case '03': $ret .= " de març"; break;
			case '04': $ret .= " d'abril"; break;
			case '05': $ret .= " de maig"; break;
			case '06': $ret .= " de juny"; break;
			case '07': $ret .= " de juliol"; break;
			case '08': $ret .= " d'agost"; break;
			case '09': $ret .= " de setembre"; break;
			case '10': $ret .= " d'octubre"; break;
			case '11': $ret .= " de novembre"; break;
			case '12': $ret .= " de desembre"; break;
		}
		
		$ret .= " de ".date('Y',$DATE);
		
		return $ret;
  
	}
  
  
  function diaSetmana($date)
  {
  	
  	list($d,$m,$Y) = explode("-",$date);
  	$dia = date('N',mktime(0,0,0,$m,$d,$Y));
  	
  	switch($dia){
  		case 1: return 'DILLUNS';   break;
  		case 2:	return 'DIMARTS';   break;
  		case 3:	return 'DIMECRES';  break;
  		case 4:	return 'DIJOUS';    break;
  		case 5:	return 'DIVENDRES'; break;
  		case 6:	return 'DISSABTE';  break;
  		case 7:	return 'DIUMENGE';  break;
  	}
  	
  }

?>
