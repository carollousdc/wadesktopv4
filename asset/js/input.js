 $(function() {
     var where = {
         status: 0,
     };
     showDataTable(2, "720", "70", where);
     send_message();
     $("#kontak").change(function() {
         previewChat(this.value, $("#name").val());
     });
     $("#name").on('input', function(e) {
         previewChat($("#kontak").val(), e.target.value);
     });
 });

 function send_message() {
     $("#form-send").on('submit', function(e) {
         e.preventDefault();
         Swal.fire({
             title: 'Kamu yakin ingin menginput pesan?',
             text: "Input pesan tidak dapat dibatalkan setelah menekan tombol kirim sekarang.",
             icon: 'info',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: 'Crimson',
             background: '#2d2d2d',
             confirmButtonText: 'Input sekarang',
         }).then((result) => {
             if (result.isConfirmed) {
                 var data = $("#form-send").serialize();
                 $.ajax({
                     type: "POST",
                     url: link + "/inputwa",
                     data: data,
                     success: function(response) {
                         // Swal.fire(response.send, response.message);
                         $("#name").val("");
                     },
                 });
             }
         })
     });
 };

 function previewChat(kontak, value = "") {
     $.ajax({
         type: "POST",
         url: link + "/getpreviewchat",
         data: {
             kontak: kontak,
             name: value,
         },
         dataType: "json",
         success: function(response) {
             $("#preview-chat").html(response.preview);
             $("#label4d").text(response.count4d);
         },
     });
 }