$(document).ready(function() { 
    refreshFeed();
}); 

var editId = -1;

function refreshFeed () {

    $.ajax({
        type: "POST",
        url: 'includes/profileGet.php',
        dataType : 'json',
        success:function(data) {
            if (data != 0) {
                $('#profile-div').empty();
                $('#profile-div').append(data.profileHTML);
                $('#posts-div').empty();
                $('#posts-div').append(data.postsHTML);
                $('#posts-div').append("<h3 style='text-align: center;'>Jouw posts</h3>");
                $('#posts-div').reverseChildren();
            } else {
                showNotification(4000, "We kunnen op dit moment niet je profiel laden", false);
        }
        }
   });
}


$.fn.reverseChildren = function() {
    return this.each(function(){
      var $this = $(this);
      $this.children().each(function(){
        $this.prepend(this);
      });
    });
  };