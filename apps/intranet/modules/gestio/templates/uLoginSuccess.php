<STYLE>

.T1 { display:block; width:100px; float:left;  }
.T2 { display:block; width:200px; float:left; }
.T3	{ width:120px; font-size:10px; }
.content { padding:20px; }
.REQUADRE { margin:0px; }
LEGEND { font-weight:bold; padding-left:10px; padding-right:10px; font-size:12px;  }

</STYLE>

    <TD colspan="3" class="CONTINGUT_ADMIN">
    
    <?php if(!isset($FUSUARI)): ?>    
        
		<form action="<?php echo url_for('gestio/uLogin') ?>" method="POST">    
		    <DIV class="REQUADRE" style="width:500px">            
		    	<div class="FORMULARI" style="width:500px;">
		    	<?php if($ERROR != ""): ?><div class="error" style="padding-bottom:10px;"><?php echo $ERROR?></div><?php endif; ?>
			    	<div>	
			    			<span class="T1"><b>DNI: </b></span>
			    			<span><?php echo $FLogin['nick']->render(); ?></span>
			    	</div>
			    	<div style="clear:both;">	
			    			<span class="T1"><b>Contrasenya: </b></span>
			    			<span><?php echo $FLogin['password']->render(); ?></span>
			    	</div>
                    <div style="clear:both; margin-top:10px;">	
			    			<span class="T1"><b>Entitat: </b></span>
			    			<span><?php echo $FLogin['site']->render(); ?></span>
			    	</div>
			    	
			    	<?php $missatge = "Segueixi si vost� estar segur que: \\n 1.- No ha estat alumne de la Casa de Cultura. \\n 2.- Vost� no t� cap usuari creat. \\n Si no n\'est� segur, si us plau, cliqui cancel�lar i contacti amb la Casa de Cultura trucant al tel�fon 972.20.20.13 o b� enviant un correu a informatica@casadecultura.org."; ?>
			    	
			    	<div style="clear:both; padding-top:20px;">
	            		<button type="submit" style="width: 120px;" name="BLOGIN" class="BOTO_ACTIVITAT" value="Cliqueu per accedir" />Cliqueu per accedir </button>	            			            		
                        <button type="submit" style="width: 120px;" name="BNEWUSER" class="BOTO_ACTIVITAT" value="Nou usuari" />Nou usuari</button>
	            		<button type="submit" style="width: 120px;" name="BREMEMBER" class="BOTO_ACTIVITAT" value="Recordar contrasenya" />Recordar contrasenya</button>		            					    	
			    	</div>
			    	
			    </div>
		    	
		    </DIV>
		    			    	
	    </form>   
            
      <DIV STYLE="height:40px;"></DIV>
    
    
    <?php else: ?>

		<form action="<?php echo url_for('gestio/uLogin') ?>" method="POST">    
		                		    			    	
        	   <FIELDSET class="REQUADRE" style="width:500px;">
                <LEGEND class="LLEGENDA">Nou usuari</LEGEND>
        	                               	 	                                    
                    <table class="FORMULARI">                    
                        <?php echo $FUSUARI ?>
                    </table>
                    <div style="text-align:right">
                        <button type="submit" name="BSAVENEWUSER" class="BOTO_ACTIVITAT" onClick="return confirm(\'Segur que vols guardar els canvis?\')">
                            <?php echo image_tag('template/accept.png').' Vull ser usuari/a' ?>
                        </button>                        
                        
                    </div>
                    <?php echo link_to(image_tag('template/arrow_left.png').' Tornar','gestio/uLogin') ?>
                </FIELDSET>                                                                                                            
		    			    	
	    </form>   
            
      <DIV STYLE="height:40px;"></DIV>

    <?php endif; ?>
       
    </TD>