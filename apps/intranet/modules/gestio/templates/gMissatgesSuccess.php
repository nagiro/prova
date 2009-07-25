<STYLE>
.cent { width:100%; }
.noranta { width:90%; }
.cinquanta { width:50%; }
.gray { background-color: #DDDDDD; }
.NOM { width:20%; } 

</STYLE>
   
    <TD colspan="3" class="CONTINGUT">
    
	<form action="<?php echo url_for('gestio/gMissatges') ?>" method="POST">
	    <DIV class="REQUADRE">
	    	<table class="FORMULARI">          
	            <?php echo $FCerca ?>
	            <tr>
	            	<td colspan="2">
	            		<input type="submit" name="BCERCA" value="Prem per buscar" />
	            		<input type="submit" name="BNOU" value="Nou missatge" />
	            	</td>
	            </tr>
	        </table>
	     </DIV>
     </form>  
      

  <?php IF( $NOU || $EDICIO ): ?>
      
	<form action="<?php echo url_for('gestio/gMissatges') ?>" method="POST">      
		<DIV class="REQUADRE">
			<table class="FORMULARI">
				<?php echo $FMissatge ?>
        		<tr>
	            	<td colspan="2">
	            		<input type="submit" name="BSAVE" value="Prem per guardar" />	            		
	            	</td>
	            </tr>				
			</table>				
		</DIV>
		
	</form>      
      
  <?php ELSE: ?>
  
  	<DIV class="REQUADRE">
  	<DIV class="TITOL">Llistat contactes</DIV>
  		<table class="DADES">
                <?php 
                    if( empty( $MISSATGES ) ) echo '<TR><TD colspan="3">No s\'ha trobat cap resultat d\'entre '.MissatgesPeer::doCount(new Criteria()).' disponibles.</TD></TR>';
                    else { 
                       $dif = "";
                      	foreach($MISSATGES as $M) {
                      	    if($dif != $M->getPublicacio('d/m/Y')) echo '<TR><TD class="gray" colspan="2"><b>'.$M->getPublicacio('d-m-Y').'</b></TD></TR>';
                      		$SPAN  = '<span>'.$M->getText().'</span>';
                      		echo "<TR><TD>".link_to($M->getTitol().$SPAN,'gestio/gMissatges'.getParam( 'E' , $M->getMissatgeid() , $CERCA ) , array('class'=>'tt2') )."</TD><TD class=\"NOM\">".$M->getUsuaris()->getNom().' '.$M->getUsuaris()->getCog1()."</TD></TR>";
                      		$dif = $M->getPublicacio('d/m/Y');  
                      	}                    	
                    }
                ?>     			
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

?>
