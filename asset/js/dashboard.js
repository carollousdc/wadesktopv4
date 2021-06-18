$("#btn_update_data").on("click", function () {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'success',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, update it!'
      }).then((result) => {
      if (result.isConfirmed) {
        var data = $("#form-edit").serialize();
        $.ajax({
          url: link + "/perbaruiData",
          type: "POST",
          data: data,
          success: function (response) {
            Swal.fire(
                'Updated!',
                'Your file has been updated.',
                'success'
                )
            getSidebar();
          },
        });
      }
      })
    });
    
    $(document).ready(function () {
        bsCustomFileInput.init();
      });