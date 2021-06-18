$(function() {
    var where = {
        status: 0,
    };
    var columnDefsVal = [{
        orderable: false,
        targets: [1, -2],
        width: 250 + "px",
    }];
    showDataTable(2, "450", "100", where, columnDefsVal);
    callWhatsappAPi();
    $("#tbl_data").on("click", ".btnAddkontak", function() {
        var id = $(this).attr("data-id");
        $("#phone").val($(this).attr("data-id"));
        $("#addkontakModal").modal("show");
    });
    setInterval(function() {
        callWhatsappAPi();
    }, 5000);
    $("#name_edit").on('input', function(e) {
        previewChat($("#id_edit").val(), e.target.value);
    });
});
$("#tbl_data").on("click", ".btn_edit", function() {
    var id = $(this).attr("data-id");
    $.ajax({
        url: link + "/editData",
        type: "POST",
        data: {
            id: id
        },
        dataType: "json",
        success: function(response) {
            $("#editModal").modal("show");
            $("#history-chat").html(response.data_detail);
            $("#count-chat").html(response.detail_count);
            previewChat(id, response.data['name']);
            for (var i = 0; i <= response.key_count; i++) {
                dummyval = response.key[i];
                $('#id_edit').val(response.data['id']);
                $("#" + response.key[i] + '_edit').val(response.data[dummyval]);
                $("#m_status_edit").val(response.data['m_status']).trigger('change');
            }
            $('.modal-title-edit').html("Pesan Masuk: " + response.kontak);
            $("#tbl_data").DataTable().ajax.reload(null, false);
        },
    });
});
$(".btn_kontak").on("click", function() {
    Swal.fire({
        title: 'Perbaharui pesan?',
        text: "Setelah menekan tombol update, data akan diperbaharui!",
        icon: 'success',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Perbaharui sekarang!'
    }).then((result) => {
        if (result.isConfirmed) {
            var data = $("#form-add-kontak").serialize();
            $.ajax({
                url: "kontak" + "/tambahData",
                type: "POST",
                data: data,
                success: function(response) {
                    Swal.fire('Berhasil!', 'Status pesan telah di perbaharui.', 'success')
                    $('#form-add-kontak')[0].reset();
                    $("#addkontakModal").modal("hide");
                    $("#tbl_data").DataTable().ajax.reload(null, false);
                },
            });
        }
    })
});

function callWhatsappAPi() {
    $.ajax({
        type: "POST",
        url: link + "/tambahData",
        dataType: "json",
        success: function(response) {
            if (response.data['connected']) {
                if (response.data['flag']) {
                    notificationToast(response.data['toastInfo'], response.data['sender']);
                    $("#tbl_data").DataTable().ajax.reload(null, false);
                }
            }
        },
    });
};

function previewChat(id, value = "") {
    $.ajax({
        type: "POST",
        url: link + "/getpreviewchat",
        data: {
            id: id,
            name: value,
        },
        dataType: "json",
        success: function(response) {
            $("#preview-chat").html(response.preview);
            $("#label4d").text(response.count4d);
        },
    });
}

function getHistoryMessage(id = "") {
    $.ajax({
        type: "POST",
        url: link + "/getHistoryMessage",
        data: {
            id: id,
        },
        dataType: "json",
        success: function(response) {
            $("#history-chat").html(response.callback);
            $("#count-chat").html(response.countmessage);
            $("#name_edit").val(response.data.name);
        },
    });
}

function notificationToast(status = "", message = "") {
    if (status == null) status = 'success';
    if (message == null) message = 'New Notification';
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 8000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })
    Toast.fire({
        icon: status,
        title: message,
    })
}
// Get the modal
// Get the <span> element that closes the modal
// When the user clicks on <span> (x), close the modal
$(document).ready(function() {
    $('body').on('click', 'img', function() {
        $("#imgMessageModal").attr("style", "display:block;");
        $('#img01').attr('src', this.src);
        $('#caption').html(this.alt);
    });
    $('body').on('click', '.closes', function() {
        $("#imgMessageModal").attr("style", "display:none;");
    });
});