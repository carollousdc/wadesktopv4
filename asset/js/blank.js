// var link = $(location)
// 	.attr("pathname")
// 	.replace(/[0-9`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, "");
var masterlink = "mastermenu";

$(function () {
	$("#tbl_data").on("click", ".btn_hapus", function () {
		var id = $(this).attr("data-id");
		var status = confirm("Yakin ingin menghapus?");
		if (status) {
			$.ajax({
				url: link + "/hapusData",
				type: "POST",
				data: { id: id },
				success: function (response) {
					$("#tbl_data").DataTable().ajax.reload(null, false);
				},
			});
		}
	});

	$("#tombol-simpan").click(function () {
		var data = $("#form-submit").serialize();
		console.log(data);
		$.ajax({
			type: "POST",
			url: link + "/tambahData",
			data: data,
			success: function (response) {
				console.log(response);
				$('input[name="id"]').val("");
				$('input[name="email"]').val("");
				$('input[name="firstname"]').val("");
				$('input[name="lastname"]').val("");
				$('input[name="password"]').val("");
				$("#tbl_data").DataTable().ajax.reload(null, false);
			},
		});
	});

	$("#tbl_data").on("click", ".btn_edit", function () {
		var id = $(this).attr("data-id");
		$.ajax({
			url: link + "/ambilDataById",
			type: "POST",
			data: { id: id },
			dataType: "json",
			success: function (response) {
				$("#editModal").modal("show");
				$('input[name="id_edit"]').val(response[0].id);
				$('input[name="email_edit"]').val(response[0].email);
				$('input[name="firstname_edit"]').val(response[0].firstname);
				$('input[name="lastname_edit"]').val(response[0].lastname);
				$("#tbl_data").DataTable().ajax.reload(null, false);
			},
		});
	});

	$("#btn_update_data").on("click", function () {
		var id = $('input[name="id_edit"]').val();
		var email = $('input[name="email_edit"]').val();
		var firstname = $('input[name="firstname_edit"]').val();
		var lastname = $('input[name="lastname_edit"]').val();
		$.ajax({
			url: link + "/perbaruiData",
			type: "POST",
			data: {
				id: id,
				email: email,
				firstname: firstname,
				lastname: lastname,
			},
			success: function (response) {
				$('input[name="id_edit"]').val("");
				$('input[name="email_edit"]').val("");
				$('input[name="firstname_edit"]').val("");
				$('input[name="lastname_edit"]').val("");
				$("#editModal").modal("hide");
				$("#tbl_data").DataTable().ajax.reload(null, false);
			},
		});
	});
});

$(function () {
	var loc = window.location.pathname;
	$("#nav")
		.find("#" + link)
		.each(function () {
			$(this).addClass("nav-link active", $(this).attr("href") == loc);
		});
	$("#nav")
		.find("#" + masterlink)
		.each(function () {
			$(this).addClass("nav-link active", $(this).attr("href") == loc);
		});
	$("#nav")
		.find("#" + masterlink + "1")
		.each(function () {
			$(this).addClass(
				"nav-item has-treeview menu-open",
				$(this).attr("href") == loc
			);
		});
});

var table;
$(function () {
	$(document).ready(function () {
		var link = $(location).attr("pathname");
		//datatables
		table = $("#tbl_data").DataTable({
			responsive: true,
			processing: true,
			serverSide: true,
			autoWidth: false,
			sScrollY: "300",
			sScrollX: "100%",
			bSort: true,
			iDisplayLength: 25,
			bLengthChange: false,
			order: [],
			ajax: {
				url: link + "/get_data",
				type: "POST",
			},
			columnDefs: [
				{
					targets: [0, 3],
					orderable: false,
				},
				{
					targets: -1,
					width: "200",
					orderable: false,
				},
			],
		});
	});
});
