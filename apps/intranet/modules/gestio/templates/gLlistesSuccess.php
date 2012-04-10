<?php use_helper('Form')?>

    <td colspan="3" class="CONTINGUT_ADMIN">
    
    <?php include_partial('breadcumb',array('text'=>'LLISTES')); ?>


<?php if($MODE == 'EDITA_MISSATGE'): ?>

    
    <form action="<?php echo url_for('gestio/gLlistes') ?>" method="post" enctype="multipart/form-data">
  	    <div class="REQUADRE">
            <div class="TITOL">EDITA EL MISSATGE</div>
            <table class="DADES">
                <?php echo $FMissatge ?>
                <tr>
                	<td width="100px"></td>               	
	            	<td class="dreta" width="400px">
	            		<br />
                        <button class="BOTO_ACTIVITAT" name="BDELETE_MISSATGE">Esborra'l</button>	            			            		    			
	            		<button class="BOTO_ACTIVITAT" name="BSEGUEIX_LLISTES">Segueix enviant -->></button>	            			            	            		
	            	</td>
	            </tr>
	        </table>
        </div>
    </form>    

<?php elseif($MODE == 'ESCULL_LLISTA'): ?>

    
    <form action="<?php echo url_for('gestio/gLlistes') ?>" method="post" enctype="multipart/form-data">
  	    <div class="REQUADRE">
            <div class="TITOL">A QUINES LLISTES L'ENVIAREM</div>
            <table class="DADES">
                <tr>
                    <td class="titol" style="width:20px; ">SEL.</td>
                    <td class="titol" style="width: 400px;">NOM</td>                    
                </tr>
                                              
                <?php echo input_hidden_tag('idM',$IDM); ?>
                <?php foreach( $LLISTES as $OL ): //Per totes les llistes ?>
                    <?php $check = false; ?> 
                    <?php foreach( $LLISTES_ENV as $OL2 ): //Recorrem les que hem seleccionat i les marquem ?>
                    <?php   if($OL2->getIdllista() == $OL->getIdllista()) $check = true; ?>
                    <?php endforeach; ?>
                    <tr>
                        <td><?php echo checkbox_tag('llistes['.$OL->getIdllista().']',$OL->getIdllista(),$check) ?></td>
                        <td><?php echo $OL->getNom(); ?></a></td>                                                
                    </tr>                                        
                <?php endforeach; ?>
                <tr>
                	<td colspan="3" class="dreta" style="border-bottom: 0px solid white;">
	            		<br />	            			            		    			
	            		<button class="BOTO_ACTIVITAT" name="BSEGUEIX_ENVIAMENT">Segueix enviant -->></button>	            			            	            		
	            	</td>
	            </tr>                
	        </table>
        </div>
    </form>    

<?php elseif($MODE == 'EDITA_ENVIAMENT'): ?>

    
    <form action="<?php echo url_for('gestio/gLlistes') ?>" method="post" enctype="multipart/form-data">
  	    <div class="REQUADRE">
            <div class="TITOL">VALIDACIÓ DE MISSATGE</div>
            
                <?php echo input_hidden_tag('missatge',$MISSATGE->getIdmissatge()); ?>
                <div>
                    <div class="titol">TITOL (<?php echo link_to('Edita el titol','gestio/gLlistes?accio=EM&IDM='.$MISSATGE->getIdmissatge()); ?>)</div>
                    <div><?php echo $MISSATGE->getTitol(); ?></div>
                </div>
                
                <div style="margin-top: 10px;">
                    <div class="titol">MISSATGE (<?php echo link_to('Edita el missatge','gestio/gLlistes?accio=EM&IDM='.$MISSATGE->getIdmissatge()); ?>)</div>
                    <div><?php echo $MISSATGE->getText(); ?></div>
                </div>
                
                <div style="margin-top: 10px;">
                    <div class="titol">LLISTES ON S'ENVIARÀ (<?php echo link_to('Canvia les llistes','gestio/gLlistes?accio=EL&idM='.$MISSATGE->getIdmissatge()); ?>)</div>
                    <div>
                        
                        <?php foreach($LLISTES_ENV as $OL): ?>
                            <?php echo $OL->getNom(); ?><br />
                            <?php echo input_hidden_tag('llistes[]',$OL->getIdllista()); ?>
                        <?php endforeach; ?>
                        
                    </div>
                </div>
                
                <div style="margin-top: 10px;">
                    <div class="titol">EMAIL DE PROVA</div>
                    <div><?php echo input_tag('email','prova@prova.cat',array('style'=>'width:200px;')); ?></div>
                </div>
                
                <div style="margin-top: 10px; text-align:right;">
                    <button class="BOTO_ACTIVITAT" name="BSEND_PROVA">Envia prova</button>	                        		        		    			
            		<button class="BOTO_ACTIVITAT" name="BSEND_LLISTES">Genera dades d'enviament!!!</button>	            			            	            		
           	    </div>
        </div>
    </form>    

<?php elseif($MODE == 'CARREGA_DADES'): ?>

    <div class="REQUADRE">
        <div class="TITOL">DADES PER ENVIAR</div>
                            
            <div>
                <div class="titol">TITOL</div>                                
                <div><a target="_blank" href="/web/mailing/<?php echo $IDS ?>-titol.csv">Baixa't el fitxer</a></div>
                <div><a target="_blank" href="/web/images/f.jpg">Baixa't el fitxer</a></div>
            </div>
            
            <div style="margin-top: 10px;">
                <div class="titol">MISSATGE</div>
                <div><a target="_blank" href="/web/mailing/<?php echo $IDS ?>-missatge.csv">Baixa't el fitxer</a></div>
            </div>
            
            <div style="margin-top: 10px;">
                <div class="titol">EMAILS DE LES LLISTES</div>                                                        
                <div><a target="_blank" href="/web/mailing/<?php echo $IDS ?>-mails.csv">Baixa't el fitxer</a></div>                       
            </div>
            
            <div style="margin-top: 10px;">
                <div class="titol">BASH O EXECUTABLE</div>                                                        
                <div><a target="_blank" href="/web/mailing/<?php echo $IDS ?>-bash.sh">Baixa't el fitxer</a></div>                       
            </div>            
    </div>
    

<?php elseif($MODE == 'EDIT_LIST'): ?>
    
    <form action="<?php echo url_for('gestio/gLlistes') ?>" method="post" enctype="multipart/form-data">
  	    <div class="REQUADRE">
            <div class="TITOL">DADES LLISTA</div>
            <table class="DADES">
                <tr>
                    <td class="titol" style="width:20px; ">NOM LLISTA </td>
                    <td style="width: 400px;">
                        <input type="text" name="nom_llista" value="<?php echo $LLISTA->getNom(); ?>" />
                        <input type="hidden" name="IDL" value="<?php echo $LLISTA->getIdllista() ?>" />
                    </td>                    
                </tr>
                <tr>
                    <td class="titol" style="width:20px; ">MAILS PER AFEGIR</td>
                    <td style="width: 400px;">
                        <?php if(!empty($INPUTS['ERRORS'])): ?>
                            <div style="padding:10px; color:white; background-color: red;"><?php echo implode('<br />',$INPUTS['ERRORS']); ?></div>
                        <?php endif; ?>                    
                                        
                        <textarea name="llistat_mails"></textarea>                        
                    </td>                    
                </tr>    
                <tr>
                    <td class="titol"></td>
                	<td class="dreta" style="border-bottom: 0px solid white;">            		
	            		<button class="BOTO_ACTIVITAT" name="BSAVELIST">Guardar o afegir</button>	            		    				            			            			            	            		
	            	</td>
	            </tr>                                                            
                <tr>
                    <td class="titol" style="width:20px; ">MAILS</td>
                    <td style="width: 400px;">
                        <table>
                            <tr><td class="titol" style="width: 400px;">EMAIL</td><td class="titol">ACCIONS</td></tr>                            
                            <?php foreach($EMAILS->getResults() as $OM): ?>
                            <?php $class = ($OM->isListActiu($LLISTA->getIdllista()))?'actiu':'tatxat'; ?>
                            <tr><td class="<?php echo $class ?>"><?php echo $OM->getEmail() ?></td>
                                <td>
                                    <?php if($OM->isListActiu($LLISTA->getIdllista())): ?>
                                        <?php echo link_to('Baixa','gestio/gLlistes?accio=BML&IDL='.$LLISTA->getIdllista().'&IDE='.$OM->getIdemail()); ?>
                                    <?php else: ?>                                    
                                        <?php echo link_to('Reactiva','gestio/gLlistes?accio=BML&IDL='.$LLISTA->getIdllista().'&IDE='.$OM->getIdemail()); ?>
                                    <?php endif; ?>                                    
                                </td></tr>                            
                            <?php endforeach; ?>
                            <tr>
                            <td colspan="2">
                                <?php echo myUser::Paginacio($EMAILS,'gestio/gLlistes?accio=EDITLIST&IDL='.$LLISTA->getIdllista()); ?>
                            </td>
                            </tr>                                                    
                        </table>                        
                    </td>                    
                </tr>                                                              
	        </table>
        </div>
    </form>    

<?php else: ?>

    <form action="<?php echo url_for('gestio/gLlistes') ?>" method="post" enctype="multipart/form-data">
  	    <div class="REQUADRE">
            <div class="TITOL">Missatges enviats ( <a href="<?php echo url_for('gestio/gLlistes?accio=NM'); ?>">Nou missatge</a> )</div>
            <table class="DADES">
                <tr>
                    <td class="titol" style="width:500px">TITOL</td>
                    <td class="titol">DATA ENV.</td>
                </tr>
                                              
                <?php foreach($MISSATGES->getResults() as $OM): ?>
                    <tr>
                        <td><?php echo link_to($OM->getTitol(),'gestio/gLlistes?accio=EM&IDM='.$OM->getIdmissatge()); ?></td>
                        <td><?php echo $OM->getDataEnviament('d/m/Y'); ?></td>                        
                    </tr>
                <?php endforeach; ?>
                <tr><td colspan="2"><?php echo myUser::Paginacio($MISSATGES,'gestio/gLlistes?1=1'); ?></td></tr>
	        </table>
        </div>
    </form>    

    <form action="<?php echo url_for('gestio/gLlistes') ?>" method="post" enctype="multipart/form-data">
  	    <div class="REQUADRE">
            <div class="TITOL">Llistes ( <a href="<?php echo url_for('gestio/gLlistes?accio=NEWLIST'); ?>">Nova llista</a> )</div>
            <table class="DADES">
                <tr>
                    <td class="titol" style="width:400px">TITOL</td>
                    <td class="titol" style="width:100px">SUBSCRITS</td>                                        
                </tr>
                
                                                            
                
                                              
                <?php foreach($LLISTES as $OL): ?>
                    <tr>
                        <td><?php echo link_to($OL->getNom(),'gestio/gLlistes?accio=EDITLIST&IDL='.$OL->getIdllista()); ?></td>                                                
                        <td><?php echo $OL->getInscrits(); ?></td>
                    </tr>
                <?php endforeach; ?>
	        </table>
        </div>
    </form>
    
    <form action="<?php echo url_for('gestio/gLlistes') ?>" method="post" enctype="multipart/form-data">
  	    <div class="REQUADRE">
            <div class="TITOL">Emails</div>            
            <table class="DADES">
                <tr>
                    <td style="width: 50px; font-weight: bold;">Email: </td>                                        
                    <td style="width:250px;"><input style="width:200px" type="text" name="email" /></td>
                    <td><button class="BOTO_ACTIVITAT" name="BCERCAMAIL">Cercar</button></td>
                </tr>                                                             
                <tr>
                    <td style="width: 50px; font-weight: bold;">DNI: </td>                                        
                    <td style="width:250px;"><input style="width:200px" type="text" name="dni" /></td>
                    <td><button class="BOTO_ACTIVITAT" name="BCERCAMAILDNI">Cercar</button></td>
                </tr>                
                <tr>
                    <td style="width: 50px; font-weight: bold;">Veure Baixes: </td>
                    <td style="width: 250px; ">&nbsp;</td>
                    <td ><button class="BOTO_ACTIVITAT" name="BCERCABAIXES">Mostra-me-les</button></td>
                </tr>                
	        </table>
            <table>
                <tr>
                    <td style="width: 50px;" class="titol">Email: </td>                                        
                    <td style="width:250px;" class="titol">Usuari rel.</td>
                    <td style="width:250px;" class="titol">Llistes</td>                    
                    <td style="width:250px;" class="titol">Estat</td>                    
                </tr>            
            <?php foreach($LLISTAT_EMAILS AS $OE): ?>            
            <?php   $A_U = array();
                    $LOU = LlistesEmailsPeer::getUsuari($OE->getEmail());
                    foreach($LOU as $OU): 
                        if($OU instanceof Usuaris) $A_U[$OU->getUsuariId()] = $OU->getDni().' - '.$OU->getNomComplet();
                    endforeach;
                    if(empty($LOU)) $A_U = array(0 => "No s'ha trobat cap coincidència");
                    
                    $A_L = array();
                    
                    foreach(LlistesEmailsPeer::getLlistes($OE->getEmail()) as $O): 
                        $A_L[$O->getIdllista()] = $O->getNom();
                        if($OE->getActiu()) $A_L[$O->getIdllista()] .= (LlistesEmailsPeer::isActiuEmailALlista($OE->getIdemail(), $O->getIdllista()))?'(A)':'(B)';
                        else $A_L[$O->getIdllista()] .= '(B)';                          
                    endforeach;                
                    if($OE->getActiu()) $text = "Alta del dia ".$OE->getAlta('d-m-Y').'<br />'.link_to('Donar-lo de baixa','gestio/gLlistes?accio=BAIXA_GENERAL&idM='.$OE->getIdemail());
                    else $text = "Alta del dia ".$OE->getAlta('d-m-Y').'<br />Baixa del dia '.$OE->getBaixa('d-m-Y');                           
                                        
            ?>                     
                <tr>
                    <td style="width: 50px;"><?php echo $OE->getEmail(); ?></td>                                        
                    <td style="width:250px;"><?php echo implode('<br />',$A_U); ?></td>
                    <td style="width:250px;"><?php echo implode('<br />',$A_L); ?></td>
                    <td style="width:250px;"><?php echo $text; ?></td>                                                            
                </tr>
            <?php endforeach; ?>                 
            </table>
        </div>
    </form>    
        
<?php endif; ?>