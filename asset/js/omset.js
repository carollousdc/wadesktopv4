$(function () {
	getOmset();
});

function getOmset() {
	$.ajax({
		url: link + "/omset",
		type: "POST",
		dataType: 'json',
		beforeSend: function () {
			$("#loading").show();
			$(".error-page").hide();
		},
		success: function (response) {
			console.log(response);
			if ($("#call-player-winner").html(response.html_view)) {
				download_omset();
			}
			if (response.html_view.length < 10) {
				$(".error-page").show();
			} else $(".error-page").hide();
		},
		complete: function (data) {
			$("#loading").hide();
		},
		error: function (data) {
			$("#loading").show();
			$(".error-page").show();
		},
	});
}

function download_omset() {
	$(".mailbox-attachment-name").on("click", function (e) {
		e.preventDefault();
		$.ajax({
			url: link + "/downloadomset",
			type: "POST",
			dataType: 'json',
			success: function (response) {},
		});
	});
}
