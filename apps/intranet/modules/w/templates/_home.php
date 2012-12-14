<script>
        
    $(document).ready(function(){
        $('#email_info').focus(function(){ $('#email_info').val(""); });        
        $('#enviat-1').show(); $('#enviat-2').hide(); $('#enviat-3').hide();
        $('#formulari').submit(function(){                         
            $.post("<?php echo url_for('w/AjaxGetEmailMailing')?>", { EMAIL: $('#email_info').val() , CAPTCHA: $('#email_catpcha').val() },
            function(data) {                 
                if(data=='ok') { $('#enviat-1').hide(); $('#enviat-2').show(); }
                else { $('#enviat-1').hide(); $('#enviat-3').show(); } 
            });
            return false;             
        });         
    });    
    
</script>
              
                <div id="contingut_text">

                    <div style="margin-bottom: 20px; overflow:hidden; ">
                        <div id="franja_superior">
                            <div style="width:610px; height:70px; margin-top:20px; margin-left:0px; background-color: #817D74;">&nbsp;</div>
                        </div>
                    </div>
                
                    <div style="overflow: hidden;">
                        <div onclick="segueix_url('<?php echo url_for('@web_menu_click?node=58&titol=Exposicio') ?>')" class="requadre_doble" style="margin-right:20px; background-image: url('/images/front/Expo.jpg');">
                            <div class="requadre_doble_titol">EXPOSICIÓ</div>
                        </div>
                        <div onclick="segueix_url('<?php echo url_for('@web_menu_click?node=59&titol=LaCasa') ?>')" class="requadre_doble" style="background-image:  url('/images/front/Casa.jpg');">
                            <div class="requadre_doble_titol">LA CASA</div>
                        </div>
                    </div>
                    <div style="margin-top: 20px; overflow:hidden;">
                        <div onclick="segueix_url('<?php echo url_for('@web_menu_click_noticies?idNoticia=0&titol=Noticies') ?>')" class="requadre_individual" style="margin-right:24px; background-color: #A0C3CB;">
                            <div class="requadre_individual_titol">NOTÍCIES</div>
                        </div>
                        
                        <div onclick="segueix_url('<?php echo url_for('@web_menu_click?node=61&titol=Activitats') ?>')" class="requadre_individual" style="margin-right:20px; background-color: #9599AF;">
                            <div class="requadre_individual_titol">ACTIVITATS</div>
                        </div>
                        <div onclick="segueix_url('<?php echo url_for('@web_menu_click?node=62&titol=Coneixement') ?>')" class="requadre_individual" style="margin-right:24px; background-color: #B78485;">
                            <div class="requadre_individual_titol">CURSOS I CONEIXEMENT</div>
                        </div>
                        <div onclick="segueix_url('<?php echo url_for('@web_menu_click?node=63&titol=Municipis') ?>')" class="requadre_individual" style="background-color: #E8D131;">
                            <div class="requadre_individual_titol">MUNICIPIS</div>
                        </div>
                    </div>
                    <div style="margin-top: 20px; overflow:hidden;">
                        <span style="font-weight: bold; font-size:13px; ">AFEGIR-ME A LA LLISTA DE DISTRIBUCIÓ</span>
                        
                        <!-- Enviament de l'usuari del web -->
                        <div id="enviat-1" style="margin-top: 10px;">
                            <form action="#" name="formulari" id="formulari">
                                <div style="float: left;"><input id="email_info" name="email_info" type="text" style="padding-left:10px; width:285px; height:30px; color: #E1D9CB" value="Introdueixi la seva adreça electrònica..."/></div>
                                <div style="float: left;"><input id="email_catpcha" name="email_captcha" type="text" style="padding-left:10px; margin-left:20px; width:125px; height:30px; color: #E1D9CB" value="<?php echo $CAPTCHA ?>"/></div>
                                <div style="float: left;"><input id="boto_email_info" type="submit" value="Apunta'm" style=" margin-left:20px; height: 32px; width: 130px" /></div>
                                <div style="clear: both;"></div>
                            </form>                            
                        </div>
                        
                        <div id="enviat-2" style=" font-size:12px; margin-top:5px; color:green;">
                            El seu correu electrònic ha estat afegit a la nostra llista de distribució correctament.    
                        </div>
                        <div id="enviat-3" style=" font-size:12px; margin-top:5px; color:red;">
                            Les dades que ha entrat no són correctes. O el correu o la suma són incorrectes. Si té cap consulta pot trucar a la Casa de Cultura al 972.20.20.13.    
                        </div>                        
                        <!-- Enviament de l'usuari del web -->
                        <div style="margin-top: 10px; font-size:12px; color:#534741;"><b>Política de privadesa de dades:</b> 
                        En virtut de les lleis vigents en matèria de protecció de dades (LOPD) us informem que l'adreça electrònica serà incorporada al nostre arxiu d'usuaris. Teniu dret a sol·licitar l'accés, la modificació o la cancel·lació de les vostres dades, incloent-hi l'adreça de correu electrònic, del nostre arxiu enviant un correu a informatica@casadecultura.org o bé a la secretaria de la Casa de Cultura de Girona. 
                        </div> 
                    </div>                      
                </div>
                <div style="clear: both;"></div>