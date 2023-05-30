$(document).on("click", ".btn-modal", function (e) {
  $("#myModal").modal("show");
});

$(document).on("submit", "#my-form", function (e) {
  e.preventDefault();
  var $submitButton = $(this).find(":submit");
  $submitButton.prop("disabled", true);
  $submitButton.html('Processing <i class="fa fa-spinner fa-spin"></i>');
  $.ajax({
    type: "post",
    url: "/client-contract/createss",
    data: $(this).serialize(),
    dataType: "json",
    success: function (data) {
      if (data.status == "success") {
        $("#my-form")[0].reset();
        $("#myModal").modal("hide");
        $.pjax.reload({ container: "#my-pjax" });
        Swal.fire({
          icon: "success",
          title: "Data has been saved",
          showConfirmButton: true,
          timer: 1500,
        });
        $submitButton.prop("disabled", false);
        $submitButton.html("Save");
      } else {
        alert("Failed Save To Server");
        $submitButton.prop("disabled", false);
        $submitButton.html("Save");
      }
      // do something with the response data
    },
    error: function () {
      alert("An error occurred while submitting the form.");
      $submitButton.prop("disabled", false);
      $submitButton.html("Save");
    },
  });
});
