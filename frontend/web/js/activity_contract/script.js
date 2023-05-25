$(document).ready(function () {
  $("#desc").summernote({
    height: $(window).height() - 500,
    callbacks: {
      onImageUpload: function (image) {
        uploadImage(image[0]);
      },
    },
  });
});

function uploadImage(image) {
  var data = new FormData();
  data.append("image", image);
  $.ajax({
    url: "upload-image",
    cache: false,
    contentType: false,
    processData: false,
    data: data,
    type: "post",
    success: function (url) {
      var url = JSON.parse(url);
      console.log(url);
      var image = $("<img>").attr("src", url.url);
      $("#desc").summernote("insertNode", image[0]);
    },
    error: function (data) {
      console.log(data);
    },
  });
}
