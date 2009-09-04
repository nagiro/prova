<script type="text/javascript">
	function visible(idA)
	{
			(DIV+idA).style.visibility = false;
	}
</script>

<style>
	a.tt3:hover span { display:block; }  
	a.tt3 span { display:none; }
</style>

    <TD colspan="2" class="CONTINGUT">
	<?php
    	echo '<TABLE class="BOX">';
		echo '  <TR>';  		    	 	 			
		echo '    <TD class="NOTICIA">';
		echo '      <DIV class="TITOL">Durant el mes '.generaMes($DATA).' hi ha '.$QUANTES.' activitats coincidents de les quals '.sizeof($ACTIVITATS_LLISTAT).' són consultables. </DIV>';
		echo '        <DIV class="TEXT">';
						foreach($ACTIVITATS_LLISTAT as $ACTIVITAT):
		echo ' 				<div class="TEXT">';								
							  $text = '<SPAN><BR />'.$ACTIVITAT['TEXT'].'<br /><br />'.implode(' - ',$ACTIVITAT['DIES']).'</SPAN>';
							  echo link_to($ACTIVITAT['TITOL'].$text,'web/index',array('onClick'=>'return false;','class'=>'tt2','anchor'=>true));
							  echo '</div><div style="margin-left:20px;">'.substr($ACTIVITAT['TEXT'],0,100).'...</div>';
						endforeach;
		echo '		</SPAN></DIV>';								
		echo '    </TD>';
		echo '  </TR>';
		echo '</TABLE>';
		   	      	
	?>
			         
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    
<?php  

	function generaMes($DATE)
	{
		$ret = "";
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
			
		return $ret;
		
	}
    
?>