$(document).ready(function() { 


$("#drop-area-post").dmUploader({
    url: 'includes/postCreate.php',
    multiple: false,
    auto: false,
    queue: false,
    extraData: function() {

        return {
          "postBody": $('#post-body').val()
        };
    },
    extFilter: ["jpg", "jpeg", "png", "gif", "JPG", "JPEG", "PNG", "GIF"],
    onInit: function(){
      console.log('Callback: Plugin initialized');
    },
    onUploadComplete: function () {
        showNotification(2500, "Bericht is geplaatst", true);
        $('#post-body').val("");
        $('#imageUploadProgress').hide();
        $('#imageUploadProgress').val(0);
        $('#imageUploadProgress').text("0%");
        $("#drop-area-post").dmUploader("reset");
        toggleNewPostContainer();
        refreshFeed();
        imageSet = false;
    },
    onUploadError: function () {
        alert("Upload failed");
    },
    onUploadProgress: function (id, percent) {
        $('#imageUploadProgress').val(percent);
        $('#imageUploadProgress').text(percent+"%");
    },
    onNewFile: function (id, file){
        imageSet = true;
        $('#image-name').html('Foto geselecteerd: <span style="color: #FFD400;">'+file.name+'</span>');
    }
  });

});

var imageSet = false;

function createPost() {

    var body = $('#post-body').val();
    // Kijk of er iets in ingevuld
    if (body) {
        // Kijk of er een foto bij is gevoegd
        if (!imageSet) {
            $.ajax({
                type: "POST",
                url: 'includes/postCreate.php',
                data: {
                  postBody: body
                },
                success:function(data) {
                   if (data != 0) {
                        showNotification(2500, "Bericht is geplaatst", true);
                        toggleNewPostContainer();
                        refreshFeed();

                    } else {
                        showNotification(2500, "Kon de post niet plaatsen :(", false);
                    }
                }
           });
        } else {
            // Start de upload
            $('#imageUploadProgress').show();
            $("#drop-area-post").dmUploader("start");

        }
    } else {
        showNotification(2500, "Kon de post niet plaatsen :(", false);
    }
    
}

function toggleNewPostContainer () {
    if ($('#new-post-div').css('display') == 'none') {
        $('#new-post-div').show('fast');
        $('#post-body').focus();
        $(".new-post-btn-image").attr("src","css/cross.png");


    } else {
        $('#new-post-div').hide('fast');
        $(".new-post-btn-image").attr("src","css/newpostwhite.png");
    }
}