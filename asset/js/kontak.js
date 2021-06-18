$(function() {
    var where = {
        status: 0,
    };
    var columnDefsVal = [{
        orderable: false,
        targets: [1, -2],
        width: 160 + "px",
    }];
    showDataTable(1, "520", "150", where, columnDefsVal);
});