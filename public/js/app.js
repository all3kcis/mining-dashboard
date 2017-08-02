

$('#miner_select').submit(function(e){
	e.preventDefault();
	val = $(this).find('#miner_id').val()
	if (val > 0){
		var url = $('base').attr('href')+'/miner/'+ val;
    	window.location = url;
	}    
});