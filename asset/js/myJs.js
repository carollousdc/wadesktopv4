var url = window.location.pathname;
var parts = url.split("/");
var link = parts[parts.length - 1];
getSidebar();

function getSidebar() {
	$.ajax({
		url: "dashboard" + "/getSidebar",
		type: 'POST',
		dataType: 'json',
		success: function (response) {
			$("#nav").html(response.data);
			$("#title").text(response.title);
			$("#callnavtop").html(response.navbar);
			getLink();
		},
	});
};
// function getNotificationCount() {
//     $.ajax({
//         url: link + "/getNotifMessage",
//         type: 'POST',
//         dataType: 'json',
//         success: function(response) {
//             $(".nav-notif-message").html(response.value);
//         },
//     });
// };
function getLink() {
	$.ajax({
		url: link + "/getRootLink",
		type: 'POST',
		dataType: 'json',
		success: function (result) {
			$("#nav").find("#" + link).each(function () {
				$(this).addClass("nav-link active", $(this).attr("href") == url);
			});
			$("#nav").find("#" + result.data).each(function () {
				$(this).addClass("nav-link active", $(this).attr("href") == url);
			});
			$("#nav").find("#" + result.data + "1").each(function () {
				$(this).addClass("nav-item has-treeview menu-open", $(this).attr("href") == url);
			});
		}
	});
};
$(function () {
	$(".select2-purple").select2();
	$(".select2bs4").select2({
		theme: "bootstrap4",
	});
});

function myFunction() {
	// Declare variables
	var input, filter, table, tr, td, i, txtValue;
	input = document.getElementById("myInput");
	filter = input.value.toUpperCase();
	table = document.getElementById("viewModal");
	tr = table.getElementsByTagName("tr");
	// Loop through all table rows, and hide those who don't match the search query
	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[1];
		if (td) {
			txtValue = td.textContent || td.innerText;
			if (txtValue.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} else {
				tr[i].style.display = "none";
			}
		}
	}
}

function showMsg(msg, tipe_msg) {
	var msg_tipe = "alert-danger";
	var msg_name = "Error";
	switch (tipe_msg) {
		case 1:
			msg_tipe = "alert-primary";
			msg_name = "Info";
			break;
		default:
			break;
	}
	$msg_view = `<div class="alert ` + msg_tipe + ` alert-dismissible fade show" role="alert">
            <strong>` + msg_name + `:</strong><br/>` + msg + `<button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>`;
	$("#pesan").append($msg_view);
}
$('#form-submit').on('submit', function (e) {
	e.preventDefault();
	Swal.fire({
		title: 'Are you sure?',
		text: "You won't be able to revert this!",
		icon: 'success',
		showCancelButton: true,
		confirmButtonColor: '#007bff',
		cancelButtonColor: 'Crimson',
		background: '#2d2d2d',
		confirmButtonText: 'Yes, create it!'
	}).then((result) => {
		if (result.isConfirmed) {
			var data = $("#form-submit").serialize();
			$.ajax({
				type: "POST",
				url: link + "/tambahData",
				data: data,
				success: function (response) {
					Swal.fire('Created!', 'Your file has been created.', 'success')
					$('#form-submit')[0].reset();
					$("#tbl_data").DataTable().ajax.reload(null, false);
					getSidebar();
					$("#modalform").modal('hide');
				},
			});
		}
	})
});
$("#reset").click(function () {
	$.ajax({
		type: "POST",
		url: link + "/reset",
		success: function (response) {
			$("#tbl_data").DataTable().ajax.reload(null, false);
			$('#sumtotal').val("");
			$('#customer').val("");
			$('#cash').val("");
		},
	});
});
$("#tbl_data").on("click", ".btn_hapus", function () {
	var id = $(this).attr("data-id");
	Swal.fire({
		title: 'Kamu yakin ingin menghapus?',
		text: "Setelah berhasil menghapus, data tidak dapat dikembalikan lagi.",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#007bff',
		cancelButtonColor: 'Crimson',
		background: '#2d2d2d',
		confirmButtonText: 'Hapus sekarang'
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: link + "/hapusData",
				type: "POST",
				data: {
					id: id
				},
				success: function (response) {
					Swal.fire('Berhasil!', 'Pesan telah berhasil dihapus.', 'success')
					$("#tbl_data").DataTable().ajax.reload(null, false);
				},
			});
		}
	})
});
$("#tbl_data").on("click", ".btn_hapus_detail", function () {
	var id = $(this).attr("data-id");
	Swal.fire({
		title: 'Are you sure?',
		text: "You won't be able to revert this!",
		icon: 'warning',
		showCancelButton: true,
		confirmButtonColor: '#007bff',
		cancelButtonColor: 'Crimson',
		background: '#2d2d2d',
		confirmButtonText: 'Yes, delete it!'
	}).then((result) => {
		if (result.isConfirmed) {
			$.ajax({
				url: link + "/hapusDataDetail",
				type: "POST",
				data: {
					id: id
				},
				success: function (response) {
					Swal.fire('Deleted!', 'The item has been deleted.', 'success')
					$("#tbl_data").DataTable().ajax.reload(null, false);
				},
			});
		}
	})
});
$("#tbl_data").on("click", ".btn_edit", function () {
	var id = $(this).attr("data-id");
	$.ajax({
		url: link + "/editData",
		type: "POST",
		data: {
			id: id
		},
		dataType: "json",
		success: function (response) {
			$("#editModal").modal("show");
			for (var i = 0; i <= response.key_count; i++) {
				$('#id_edit').val(response.data['id']);
				$('.modal-title').html(response.kontak);
				if (response.option_key[i] !== 0) {
					dummyval = response.option_key[i];
					$("#" + response.option_key[i] + '_edit').val(response.data[dummyval]).trigger('change');
				}
				if (response.key[i] !== 0) {
					dummyval = response.key[i];
					$("#" + response.key[i] + '_edit').val(response.data[dummyval]);
				}
				$("#m_status_edit").val(response.data['m_status']).trigger('change');
			}
			$("#tbl_data").DataTable().ajax.reload(null, false);
		},
	});
});
$("#btn_update_data").on("click", function () {
	if (link !== 'dashboard' || link !== 'profile') var set = 0
	else var set = 1;
	Swal.fire({
		title: 'Perbaharui pesan?',
		text: "Setelah menekan tombol update, data akan diperbaharui!",
		icon: 'success',
		showCancelButton: true,
		confirmButtonColor: '#007bff',
		cancelButtonColor: 'Crimson',
		background: '#2d2d2d',
		confirmButtonText: 'Perbaharui sekarang!'
	}).then((result) => {
		if (result.isConfirmed) {
			var data = $("#form-edit").serialize();
			$.ajax({
				url: link + "/perbaruiData",
				type: "POST",
				data: data,
				success: function (response) {
					Swal.fire('Berhasil!', 'Status pesan telah di perbaharui.', 'success')
					$("#editModal").modal("hide");
					$("#tbl_data").DataTable().ajax.reload(null, false);
				},
			});
		}
	})
});

function showDataTable(lfvalue, vhTable, vwTable = "", where, columnDefsVal = []) {
	var full_ajax_url = {
		url: link + "/get_data",
		type: "POST",
		data: {
			where: where,
		},
		dataSrc: function (json) {
			return json.data;
		},
	};
	columnDefsVal.push({
		targets: -1,
		width: vwTable + "px",
	});
	if (vhTable == null) vhTable = $(window).height() - 450;
	if (vwTable == null) vwTable = "100";
	//datatables
	if (lfvalue == 2) {
		var table = $("#tbl_data").DataTable({
			scrollY: vhTable + "px",
			scrollX: "300px",
			scrollCollapse: true,
			paging: false,
			autoWidth: false,
			lengthChange: true,
			paging: false,
			ordering: true,
			bPaginate: false,
			info: false,
			responsive: true,
			processing: true,
			serverSide: true,
			ajax: full_ajax_url
		});
	} else {
		var table = $("#tbl_data").DataTable({
			scrollY: vhTable + "px",
			scrollX: "100%",
			paging: false,
			ordering: true,
			info: true,
			processing: true,
			serverSide: true,
			lengthChange: true,
			bPaginate: false,
			columnDefs: columnDefsVal,
			fixedColumns: {
				leftColumns: 1,
				rightColumns: 1
			},
			ajax: full_ajax_url
		});
	};
	$('#searchbox').on('keyup', function () {
		table.search(this.value).draw();
	});
};
$.fn.dataTable.ext.errMode = 'none';
// var oldXHR = window.XMLHttpRequest;
// function newXHR() {
//     var realXHR = new oldXHR();
//     realXHR.addEventListener("readystatechange", function() {
//         if(realXHR.readyState==3){
//           alert('masuk');
//         }
//     }, false);
//     return realXHR;
// }
// window.XMLHttpRequest = newXHR;

var timeDisplay = document.getElementById("time");

function refreshTime() {
	var dateString = new Date().toLocaleString();
	var formattedString = dateString.replace(", ", " - ");
	timeDisplay.innerHTML = formattedString;
}
setInterval(refreshTime, 1000);
