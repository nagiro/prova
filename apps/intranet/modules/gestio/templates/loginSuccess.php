    <TD colspan="2" class="CONTINGUT">
    
      <?php echo form_tag('gestio/login',array('method'=>'post')); ?>
    
      <TABLE class="BOX">
        <TR><TD class="NOTICIA">
                <DIV class="TITOL">Escriu el teu DNI i contrasenya</DIV>
                <TABLE width="100%">
                  <TR><TD><DIV class="TEXT">DNI <br /> <?php echo input_tag('DNI',''); ?></DIV></TD>
                      <TD><DIV class="TEXT">CONTRASENYA <br /><?php echo input_password_tag('PASSWD',''); ?></DIV></TD>
                      <TD><DIV class="TEXT"><br /><?php echo submit_tag("Identifica'm",'OK'); ?></DIV></TD>
                  </TR>
                </TABLE>                                  
                                
              </TD>
        </TR>
      </TABLE>
      
      <DIV STYLE="height:40px;"></DIV>
                
    </TD>    
    
    
<!-- FI CONTINGUT -->
<!-- CALENDARI -->
    
    <TD class="CALENDARI">          
    
    </TD>
    
<!-- FI CALENDARI -->
