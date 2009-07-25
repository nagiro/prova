    <TD colspan="2" class="CONTINGUT">
    
    <? if(empty($ACTIVITATS_LLISTAT)): ?> <DIV>No hi ha cap activitat pública.<DIV> <? endif; ?>		
		
	<? foreach($ACTIVITATS_LLISTAT as $A): ?>
     
    		<TABLE class="BOX">
		    <TR>  
	 <? if(!empty($A['DADES']['IMATGE'])): ?>	    
	 			<TD class="FOTO"><?=image_tag('noticies/'.$A['DADES']['IMATGE'], array('class'=>'IMG_FOTO'))?></TD>
	 <? endif; ?>
		        <TD class="NOTICIA">
		        <DIV class="DATA">
		        	   <?php 
		        	      foreach($A['HORARIS'] as $H): 
		        	         echo implode(',',$H['ESPAIS']);
		        	         echo ' a les '.$H['HORAI']; 
		        	      endforeach; 
		        	      
		        	   ?>		                   
				</DIV>
				<DIV class="TITOL"><?=$A['DADES']['TITOL']?></DIV>
		    	<DIV class="TEXT"><?=substr( $A['DADES']['TEXT'] , 0 , 100 )?><SPAN id="DIV<?$A['DADES']['ID']?>" class="AMAGAT"><?=substr( $A['DADES']['TEXT'] , 100 )?></SPAN></DIV>
	 <? if(sizeof($A['DADES']['TEXT']) > 100): ?>		    	
		    	<DIV class="PEU"><?=link_to(image_tag('intranet/llegirmes.png', array('style'=>'float:left')),'#',array('onClick'=>'visible('.$A['DADES']['ID'].')'))?>
	 <? endif; ?>
	 <? if(!empty($A['DADES']['PDF'])): ?> 
	 			<?=link_to(image_tag('intranet/pdf.png', array('style'=>'float:right')),image_path('noticies/'.$A['DADES']['PDF'] , true) , array('target'=>'_NEW'))?>
	 <? endif; ?>
				</DIV>
		     	</TD>
		    </TR>
		    </TABLE>	      	                
	<? endforeach; ?>
      
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    

    <?php 

    function agrupaespais($ESPAIS)
    {
       
       $ANT = ""; $RET = array();
       foreach($ESPAIS as $EID => $E):
          if($ANT <> $E) $RET[] = $E;
          $ANT = $E;                 
       endforeach;

       return $RET;
       
    }
    
	function generaData($DIA)
	{

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


?>