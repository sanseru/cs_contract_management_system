$(document).on("click", ".btn-modal", function (e) {
  $("#myModal").modal("show");
});

$(document).on("submit", "#my-form", function (e) {
  e.preventDefault();
  console.log($(this).serialize());
  $.ajax({
    type: "post",
    url: "/client-contract/create",
    data: $(this).serialize(),
    dataType: "json",
    success: function (data) {
      if (data.status == "success") {
        $("#my-form")[0].reset();
        $("#myModal").modal("hide");
        $.pjax.reload({ container: "#my-pjax" });
        Swal.fire({
          icon: 'success',
          title: 'Data has been saved',
          showConfirmButton: true,
          timer: 1500
        })
      } else {
        alert("Failed Save To Server");
      }
      // do something with the response data
    },
    error: function () {
      alert("An error occurred while submitting the form.");
    },
  });
});
