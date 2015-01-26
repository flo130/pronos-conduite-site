$(function () {
	"use strict";
	var url = "/upload";
	$("#fileupload").fileupload({
		url: url,
		dataType: "json",
		done: function (e, data) {
			$.each(data.result.files, function (index, file) {
				if (file.name && (file.name != "")) {
					$("#user-avatar").attr("src", file.url);
					$('<p/>').html("<span class=\"text-primary\">Avatar changé.</span>").appendTo('#files');
					$("#progress").toggleClass("hide");
				} else {
					$('<p/>').text("Erreur lors du téléchargement de l'image").appendTo('#files');
				}
			});
		},
		progressall: function (e, data) {
			$("#progress").toggleClass("hide");
			var progress = parseInt(data.loaded / data.total * 100, 10);
			$("#progress .progress-bar").css(
				"width",
				progress + "%"
			);
		}
	}).prop('disabled', !$.support.fileInput)
		.parent().addClass($.support.fileInput ? undefined : "disabled");
});