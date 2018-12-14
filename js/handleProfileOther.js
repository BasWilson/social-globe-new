$(document).ready(function() { 
    refreshProfile();
}); 

var editId = -1;

function refreshProfile () {

    const username = findGetParameter("username");

    if (username) {
        $.ajax({
            type: "POST",
            url: 'includes/profileGetOther.php',
            dataType : 'json',
            data: {
                username: username
            },
            success:function(data) {
                if (data != 0) {
                    $('#profile-div').empty();
                    $('#profile-div').append("<h3 style='text-align: center;'>Profiel</h3>");
                    $('#profile-div').append(data.profileHTML);
                    $('#posts-div').empty();
                    $('#posts-div').append(data.postsHTML);
                    $('#posts-div').append("<h3 style='text-align: center;'>Posts</h3>");
                    $('#posts-div').reverseChildren();
                } else {
                    showNotification(4000, "We kunnen op dit moment niet het profiel laden", false);
                }     
            }
       });
    }
}


$.fn.reverseChildren = function() {
    return this.each(function(){
      var $this = $(this);
      $this.children().each(function(){
        $this.prepend(this);
      });
    });
  };


  function findGetParameter(parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
          tmp = item.split("=");
          if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}

function follow (username) {

    console.log(username)
    if (username) {
        $.ajax({
            type: "POST",
            url: 'includes/profileFollow.php',
            data: {
                usernameToFollow: username
            },
            success:function(data) {
                if (data != 0) {
                    location.reload();
                } else {
                    showNotification(2500, "Kon het profiel niet volgen :(", false);
                }
            }
        });
    }
}
