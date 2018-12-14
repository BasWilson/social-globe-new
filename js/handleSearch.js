$(document).ready(function() { 
    $('#search-field').on('input',function () {
        getResults();
    })
}); 

var editId = -1;

function getResults () {

    const username = $('#search-field').val();

    if (username) {
        $.ajax({
            type: "POST",
            url: 'includes/profileFind.php',
            data: {
                username: username
            },
            success:function(data) {
                if (data != 0) {
                    $('#results-div').empty();
                    $('#results-div').append(data);
                } else {
                    showNotification(4000, "Er kan op dit moment niet gezocht worden, excuses voor het ongemak.", false);
                }     
            }
       });
    }
}
