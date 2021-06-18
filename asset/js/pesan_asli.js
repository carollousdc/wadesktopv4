$(function() {
    getHistoryMessage();
});

function getHistoryMessage() {
    $.ajax({
        url: link + "/getHistoryMessage",
        type: "POST",
        dataType: 'json',
        beforeSend: function() {
            $("#loading").show();
        },
        success: function(response) {
            console.log(response);
            $("#tablerow").html(response.html_view);
        },
        complete: function(data) {
            $("#loading").hide();
        },
        error: function(data) {
            $("#loading").show();
        },
    });
}