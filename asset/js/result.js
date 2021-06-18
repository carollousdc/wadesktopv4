$(function() {
    $("#btn_result").on("click", function() {
        getResult();
    });
    ajaxResult();
    $("#percobaan").on("click", function() {
        console.log('masuk');
     });
});
$(document).on('keypress', function(e) {
    if (e.which == 13) {
        getResult();
    }
});

function getResult() {
    Swal.fire({
        title: 'Proses hasil ?',
        text: "Proses data pemain sekarang !",
        showCancelButton: true,
        confirmButtonColor: '#007bff',
        cancelButtonColor: 'Crimson',
        confirmButtonText: 'Process',
        background: '#2d2d2d',
    }).then((result) => {
        if (result.isConfirmed) {
            ajaxResult();
        }
    })
}

function ajaxResult() {
    $.ajax({
        url: link + "/check_result",
        type: "POST",
        data: {
            hasil: $("#hasil").val(),
        },
        dataType: 'json',
        beforeSend: function() {
            $("#loading").show();
            $(".error-page").hide();
        },
        success: function(response) {
            $("#hasil").val(response.result);
            $("#call-player-winner").html(response.preview);
            if (response.preview.length < 1) {
                $(".error-page").show();
            } else $(".error-page").hide();
        },
        complete: function(data) {
            $("#loading").hide();
        },
        error: function(data) {
            $("#loading").show();
            $(".error-page").show();
        },
    });
}