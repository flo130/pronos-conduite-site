(function($) {
	//gestion de la recherche et des tris sur les tableaux 
	var table_1 = $('#table-1').dataTable ({
		"aoColumns": [
			{ "mData": "browser" },
			{ "mData": "engine" },
			{ "mData": "eag" },
		],
		"fnInitComplete": function(oSettings, json) {
			$(this).parents ('.dataTables_wrapper').find ('.dataTables_filter input').prop ('placeholder', 'Rechercher...').addClass ('form-control input-sm')
		}
	});
	
	//tous les boutons valider ont le meme comportement :
	//	1- Se rend disable
	//	2- Montre un spinner
	$('.normal-loader').click(function() {
		$(this).addClass('disabled');
		$(this).children('.fa-spin').removeClass('hide');
	});
})(jQuery);