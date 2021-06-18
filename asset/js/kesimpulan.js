 $(function () {
 	var where = {
 		status: 0,
 	};
 	showDataTable(2, "720", "70", where);
 });

 $(document).ready(function () {
 	$('.myTable').dataTable({
 		"bPaginate": false,
 		"bLengthChange": false,
 		"bFilter": true,
 		"bInfo": false,
 		"bAutoWidth": false
 	});
 	tworesult();
 	threeresult();
 	fourresult();
 	colokresult();
 });

 function tworesult() {
 	$.ajax({
 		type: "POST",
 		url: link + "/download2d",
 		dataType: "json",
 		success: function (response) {
 			console.log(response);
 		},
 	});
 }

 function threeresult() {
 	$.ajax({
 		type: "POST",
 		url: link + "/download3d",
 		dataType: "json",
 		success: function (response) {
 			console.log(response);
 		},
 	});
 }


 function fourresult() {
 	$.ajax({
 		type: "POST",
 		url: link + "/download4d",
 		dataType: "json",
 		success: function (response) {
 			console.log(response);
 		},
 	});
 }

 function colokresult() {
 	$.ajax({
 		type: "POST",
 		url: link + "/downloadcolok",
 		dataType: "json",
 		success: function (response) {
 			console.log(response);
 		},
 	});
 }
