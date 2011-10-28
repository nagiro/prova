<script type="text/javascript" src="/js/lightbox/js/jquery.lightbox-0.5.js"></script>
<script type="text/javascript">

    $(document).ready(function(){
   	    $('a.lightbox').lightBox(); 
    });    

</script>
<div class="h_requadre_resultats">
    <div class="h_subtitle_gray c1">
        L'HOSPICI...
    </div>

    <div>
        
    <?php   $cat_ant = ""; 
            if(!$LLISTAT_ESPAIS->getNbResults()): ?>
            <div>                                
                <div class="h_llistat_activitat_titol">No hem trobat cap resultat amb aquests paràmetres.</div>
            </div>
            <div style="margin-top:10px; clear:both;"></div>                                                                                                                                                                    
    <?php else: ?>                        
        <?php foreach($LLISTAT_ESPAIS->getResults() as $OE): ?>                                
            <div style="margin-top:10px; margin-bottom:10px;">                                
                <?php   if($cat_ant <> $OE->getSiteId()):  //Si la categoria és diferent a l'anterior la mostrem ?>
                    <div class="h_llistat_activitat_tipus_titol"><?php echo $OE->getSiteName()?></div>
                <?php   endif; ?>                    
                <div class="h_llistat_acivitat_titol">
                    <div style="float:left">
                        <a style="font-size:14px;" href="<?php echo url_for('@hospici_espai_detall?idE='.$OE->getEspaiid().'&titol='.$OE->getNomForUrl()) ?>"><?php echo $OE->getNom() ?></a>
                    </div>
                </div>
                                            
                <?php $url = url_for('@hospici_espai_detall?idE='.$OE->getEspaiid().'&titol='.$OE->getNomForUrl()); ?>
                <div style="float:right;">                     
                    <?php echo myUser::ph_getEtiquetaReservaEspais($AUTH, $url); ?>
                </div>                                                            
                
                <div style="clear:both">
                    <?php foreach($OE->getFotos() as $OM): ?>
                        <a class="lightbox" href="/images/multimedia/<?php echo $OM->getLargeImage() ?>">
                            <img src="/images/multimedia/<?php echo $OM->getUrl() ?>" height="30" alt="" />
                        </a>                        
                    <?php endforeach; ?>                     
                </div>                                                   
                <div style="clear:both"></div>
            </div>
            <div style="height:1px; background-color:#CCCCCC; clear:both;"></div>
            <?php $cat_ant = $OE->getSiteId(); ?>                                                                                               
        <?php endforeach; ?> 
    <?php endif; ?>
		
    <?php if($LLISTAT_ESPAIS->getLastPage() > $LLISTAT_ESPAIS->getPage()): ?>
        <div class="pagerE"><?php echo setPagerN($LLISTAT_ESPAIS,'@hospici_cercador_espais',false) ?></div>
    <?php else: ?>      
        <div class="pagerE"><?php echo setPagerN($LLISTAT_ESPAIS,'@hospici_cercador_espais',true) ?></div>
    <?php endif; ?>                    
                        
    </div>
</div>
