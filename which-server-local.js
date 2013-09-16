jQuery(function($){
	$('#wpadminbar').addClass('is-local');
	
	if( wsp_vars.no_admin_bar ){
		var $whichserver = $('<div id="whichserver" />');
		var l_or_r = ( wsp_vars.server_ip == '127.0.0.1' ) ? 'L' : 'R';
		var $local = $('<a href="'+ wsp_vars.options_page +'" />').html( l_or_r ).attr('title', wsp_vars.server_ip);
		
		$whichserver.append($local);
		
		$('body').append($whichserver);
	}
});