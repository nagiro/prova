<STYLE>
.BOX TD { PADDING:5PX; }
.CERCA { font-size:10px; }
#registra {  }
</STYLE>

    <TD colspan="2" class="CONTINGUT">
    
		<form action="<?php echo url_for('web/login') ?>" method="POST" name="form_login">    
		    <DIV class="REQUADRE">
		    	<table class="FORMULARI">          
		           <?php echo $FLogin ?>
		           <tr>
		            	<td colspan="2">
		            		<input type="submit" value="Clica per accedir" name="form_login" />
		            		<input type="submit" name="Clica per crear un compte" value="form_login_new" />
						</td>
		           </tr>
		       </table>
		    </DIV>
	    </form>   
            
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>
    
