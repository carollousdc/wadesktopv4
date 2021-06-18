 $(function () {
 	var where = {
 		kontak: $("#kontak").val()
 	};
 	showDataTable(2, "720", "70", where);
 	send_message();

 	$("#tombol-reset").click(function () {
 		ResetMessage($("#kontak").val());
 	});
 	$("#kontak").change(function () {
 		$("#filter-index").submit();
 	});
 });

 function send_message() {
 	$('#form-send').on('submit', function (e) {
 		e.preventDefault();
 		Swal.fire({
 			title: 'Kamu yakin ingin mengirim pesan?',
 			text: "Pesan tidak dapat dibatalkan setelah menekan tombol kirim sekarang.",
 			icon: 'success',
 			showCancelButton: true,
 			confirmButtonColor: '#3085d6',
 			cancelButtonColor: 'Crimson',
 			background: '#2d2d2d',
 			confirmButtonText: 'Kirim sekarang',
 		}).then((result) => {
 			if (result.isConfirmed) {
 				var data = $("#form-send").serialize();
 				$.ajax({
 					type: "POST",
 					url: link + "/send_message",
 					data: data,
 					dataType: 'json',
 					success: function (response) {
 						Swal.fire(response.send, response.message);
 						$("#name").val("");
 						$("#tbl_data").DataTable().ajax.reload(null, false);
 					},
 				});
 			}
 		})
 	});
 };

 function ResetMessage(id) {
 	var data = $("#form-send").serialize();
 	$.ajax({
 		type: "POST",
 		url: link + "/reset_message",
 		data: data,
 		dataType: 'json',
 		success: function (response) {
 			console.log(response.ping);
 			$("#tbl_data").DataTable().ajax.reload(null, false);
 		},
 	});
 }
