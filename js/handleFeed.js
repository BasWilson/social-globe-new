$(document).ready(function() { 
    refreshFeed();

    const ptr = PullToRefresh.init({
        mainElement: 'body',
        distThreshold: 100,
        distMax: 120,
        instructionsRefreshing: "AWHHHHGGGGHWWH",
        instructionsPullToRefresh: "Trek mij af",
        instructionsReleaseToRefresh: "Laat me komen",
        onRefresh() {
          refreshFeed();
        },
      });
      
}); 


var editId = -1;

function refreshFeed () {

    $.ajax({
        type: "POST",
        url: 'includes/getUserFeed.php',
        dataType : 'json',
        success:function(data) {
            if (data != 0) {
                $('#feed-div').empty();
                $('#feed-div').append(data.html);
                $('#notifications-div').empty();
                $('#notifications-div').append(data.notifications);
                $('#feed-div').reverseChildren();
                showNotification(2500, "Feed ververst", true);
            } else {
                showNotification(4000, "We kunnen op dit moment niet je feed laden", false);
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
  