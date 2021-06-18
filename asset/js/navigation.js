$(function() {
    var where = {
        status: 0
    };
    var columnDefsVal = [{
        orderable: false,
        targets: [1, -2],
        width: 250 + "px",
    }];
    showDataTable(2, "950", "190", where, columnDefsVal);
    getRoot($(this).val());
    $("#tipe").change(function() {
        getRoot($(this).val());
        $("#root").val($(this).val()).trigger('change');
    });
    getRootEdit($(this).val());
    $("#tipe_edit").change(function() {
        getRootEdit($(this).val());
        $("#root_edit").val($(this).val()).trigger('change');
    });
});
$("#tbl_data").on("click", ".editroot", function() {
    var id = $(this).attr("data-id");
    $.ajax({
        url: link + "/editroot",
        type: "POST",
        data: {
            id: id
        },
        dataType: "json",
        success: function(response) {
            $("#editModal").modal("show");
            for (var i = 0; i <= response.key_count; i++) {
                dummyval = response.key[i];
                $('#id_edit').val(response.data['id']);
                $("#" + response.key[i] + '_edit').val(response.data[dummyval]);
            }
            $("#tipe_edit").val(response.data['tipe']).trigger('change');
            $("#root_edit").val(response.data['root']).trigger('change');
            $("#tbl_data").DataTable().ajax.reload(null, false);
        },
    });
});

function getRoot(value) {
    $.ajax({
        url: link + "/optionRoot",
        type: 'POST',
        data: {
            tipe: value,
        },
        dataType: 'json',
        success: function(response) {
            if (response.display) {
                $("#root_display").attr("style", "display:show;");
                $('#root').html(response.preview);
            } else $("#root_display").attr("style", "display:none;");
        }
    });
};

function getRootEdit(value) {
    $.ajax({
        url: link + "/optionRootedit",
        type: 'POST',
        data: {
            tipe_edit: value,
        },
        dataType: 'json',
        success: function(response) {
            if (response.display) {
                $("#root_edit_display").attr("style", "display:show;");
                $('#root_edit').html(response.preview);
            } else $("#root_edit_display").attr("style", "display:none;");
        }
    });
};