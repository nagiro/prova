<STYLE>
.BOX TD { PADDING:5PX; }
.CERCA { font-size:10px; }
#registra {  }
</STYLE>

    <TD colspan="3" class="CONTINGUT">
    
		<form action="<?php echo url_for('web/login') ?>" method="POST" name="form_login">    
		    <DIV class="REQUADRE" style="width:400px">
		    	<table class="FORMULARI">
		    	<?php if($ERROR != ""): ?><tr><td class="error" colspan="2"><?php echo $ERROR?></td></td><?php endif; ?>          
		           <?php echo $FLogin ?>
		           <tr>
		            	<td colspan="2">
		            		<input type="submit" value="Cliqui per accedir" name="form_login" />
		            		<input type="submit" value="Cliqui per crear un compte nou" name="form_login_new" />
						</td>
		           </tr>
		       </table>
		    </DIV>
	    </form>   
            
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    
