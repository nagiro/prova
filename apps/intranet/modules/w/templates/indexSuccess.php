<div id="marc">        

    <div id="contingut">
                        
        <!-- CONTINGUTS -->            
        <div style="margin-bottom:40px; ">
        
            <!-- MENÚ ESQUERRA -->
                <?php include_partial('menu', array( 'MODE' => $mode , 'A_MENU' => $A_MENU , 'A_ACTIVITATS_AVUI' => $A_ACTIVITATS_AVUI , 'A_ACTIVITATS_FUTURES' => $A_ACTIVITATS_FUTURES , 'PAGE' => $PAGE , 'SUBMENU' => $A_NODE )); ?>
            <!-- MENÚ ESQUERRA -->                
            
            <!-- CONTINGUT -->                    
                <?php 
                switch($mode){                        
                    case 'llista': include_partial( 'llista' , array( 'A_LLISTA' => $A_LLISTA ) ); break;
                    case 'detall': include_partial( 'detall' , array( 'CONTINGUT' => $CONTINGUT , 'HORARIS' => $HORARIS , 'TITOL' => $TITOL , 'INFO_PRACTICA' => $INFO_PRACTICA , 'IMG' => $IMG , 'A_LLISTA' => $A_LLISTA ) ); break;
                    default: include_partial( 'home' , array( 'CAPTCHA' => $CAPTCHA ) ); break;                        
                } 
                ?>
            <!-- FI CONTINGUT -->
                          
        </div>            
        <!-- FI CONTINGUTS -->
        
        <!-- FOOTER -->            
            <?php include_partial('footer'); ?>            
        <!-- FI FOOTER -->
                        
    </div>                        
</div>