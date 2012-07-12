function InitTinyMCE( element ){
            
    tinyMCE.init({
        mode:                              "exact",
        elements:                          element,
        plugins:                           "media,table,paste,fullscreen",        
        extended_valid_elements :          "input[name|size|type|value|onclick],iframe[height|width|src]",
        theme:                             "advanced",
        language:                          "ca",        
        paste_auto_cleanup_on_paste:       true,
        paste_strip_class_attributes:      "all",
        theme_advanced_toolbar_location:   "top",
        theme_advanced_toolbar_align:      "left",
        theme_advanced_statusbar_location: "bottom",
        theme_advanced_resizing:           true,
    	theme_advanced_blockformats :      "p,div,h1,h2,h3,h4,h5,h6,blockquote,dt,dd,code,samp",
    	theme_advanced_buttons1 :          "fullscreen,bold,italic,underline,separator,justifycenter,justifyfull,bullist,indent,separator,table,separator,undo,redo,separator,link,unlink,image,media,separator,formatselect,separator,code",
    	theme_advanced_buttons2 :          "",
    	theme_advanced_buttons3 :          "",
    	file_browser_callback:             'ajaxfilemanager2',
    	relative_urls:  				   false,
        convert_urls:                      false,
        valid_children :                   "+body[style]",	    
        
    })    
}

function ajaxfilemanager2(field_name, url, type, win) {
    var ajaxfilemanagerurl = "../../../tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php";
    switch (type) { 
        case "image": break;
        case "media": break;
        case "flash": break;
        case "file": break;
        default: return false;
    }
      
    tinyMCE.activeEditor.windowManager.open({
        url: "../../../tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php",        
        width: 720,
        height: 440,
        inline : "yes",
        close_previous : "no"
    },{
        window : win,
        input : field_name
    });
}