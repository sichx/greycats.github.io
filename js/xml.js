(function($){
	$.get('/js/response.xml', function(resp){
		xmlDoc = $.parseXML(resp);
		console.log($(resp).find('BusinessOpportunity'));
	})
})(jQuery);