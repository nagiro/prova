<STYLE>
.T1 { display:block; width:100px; float:left;  }
.T2 { display:block; width:200px; float:left; }
.T3	{ width:120px; font-size:10px; }
.content { padding:20px; }
.REQUADRE { margin:0px; }
</STYLE>

    <TD colspan="3" class="CONTINGUT_ADMIN">
        
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
			    	
			    	<?php $missatge = "Segueixi si vostè estar segur que: \\n 1.- No ha estat alumne de la Casa de Cultura. \\n 2.- Vostè no té cap usuari creat. \\n Si no n\'està segur, si us plau, cliqui cancel·lar i contacti amb la Casa de Cultura trucant al telèfon 972.20.20.13 o bé enviant un correu a informatica@casadecultura.org."; ?>
			    	
			    	<div style="clear:both; padding-top:20px;">
	            		<button type="submit" style="width: 120px;" name="BLOGIN" class="BOTO_ACTIVITAT">Cliqueu per accedir</button>	            			            		
                        <button type="submit" style="width: 120px;" name="BNEWUSER" class="BOTO_ACTIVITAT">Nou usuari</button>
	            		<button style="width: 120px;" type="submit" name="BREMEMBER" class="BOTO_ACTIVITAT">Recordar contrasenya</button>		            					    	
			    	</div>
			    	
			    </div>
		    	
		    </DIV>
		    			    	
	    </form>   
            
      <DIV STYLE="height:40px;"></DIV>
    
       
    </TD>