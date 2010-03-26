<STYLE>
.T1 { display:block; width:100px; float:left;  }
.T2 { display:block; width:200px; float:left; }
.T3	{ width:120px; }
.content { padding:20px; }
.REQUADRE { margin:0px; }
</STYLE>

    <TD colspan="3" class="CONTINGUT">
    
    
		<form action="<?php echo url_for('web/login') ?>" method="POST" name="form_login">    
		    <DIV class="REQUADRE" style="width:440px">
		    	<div class="FORMULARI">
		    	<?php if($ERROR != ""): ?><div class="error" style="padding-bottom:10px;"><?php echo $ERROR?></div><?php endif; ?>          		    	
			    	<div>	
			    			<span class="T1"><b>DNI: </b></span>
			    			<span><?php echo $FLogin['nick']->render(); ?></span>
			    	</div>
			    	<div style="clear:both;">	
			    			<span class="T1"><b>Contrasenya: </b></span>
			    			<span><?php echo $FLogin['password']->render(); ?></span>
			    	</div>
			    	
			    	<div style="clear:both; padding-top:20px;">
	            		<button type="submit" class="T3" name="form_login" class="web">Cliqueu per accedir</button>		            		
	            		<button type="submit" class="T3" name="form_login_new" class="web">Creeu un compte nou</button>
	            		<button type="submit" class="T3" name="form_login_remember" class="web">Recordar contrasenya</button>		            					    	
			    	</div>
			    </div>
		    	
		    </DIV>
		    			    	
	    </form>   
            
      <DIV STYLE="height:40px;"></DIV>
    
       
    </TD>