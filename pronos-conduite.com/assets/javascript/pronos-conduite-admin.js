(function($) {
	$(document).ready(function() {
		$("#inputAdminMatch").bind("change", function() {
			var value = $(this).val();
			value = value.split("|");
			
			$("#inputScoreOne").attr("placeholder", value[1]);
			$("#inputScoreTwo").attr("placeholder", value[2]);
		});
		
		$("#inputAdminMeeting").bind("change", function() {
			var value = $(this).val();
			value = value.split("|");
			
			$("#inputScoreOne").attr("placeholder", value[1]);
			$("#inputScoreTwo").attr("placeholder", value[2]);
		});
	});
})(jQuery);