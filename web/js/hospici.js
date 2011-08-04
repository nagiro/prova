$(document).ready(function(){
    
    var url = '';
    
    $("#LOGINSUBMIT").click(function(){ $("#FLOGIN").submit(); });
    
	$( "#dialog-form" ).dialog({
		autoOpen: false,
		height: 310,
		width: 350,
		modal: true,
		buttons: {
			"Entra >>": function() {    					                        
                    $.post(
                        h_cursos_loginAjax,
                        { 'login':$("#login").val() , 'pass':$('#password').val() },
                         function(data) {                                                     
                            if(data == 'OK'){ $('#dialog-form').dialog( "close" ); $(location).attr('href',url); }
                            else { alert('Incorrecte'); }                                                           
                         }   
                        );                        
				}				
		},
		close: function() {
			//allFields.val( "" ).removeClass( "ui-state-error" );
		}
	});


	$( ".auth" )
		.click(function() {
            url = $(this).attr('url');
			$( "#dialog-form" ).dialog( "open" );
		});        
    

    /* Activem els ToolTip a la classe tip */    
    $(function(){
        $(".tip").tipTip();
    });
    
});