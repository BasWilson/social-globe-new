$(document).ready(function() { 
    verify();
}); 

function verify () {

    const token = findGetParameter("token");

    $.ajax({
        type: "POST",
        url: 'includes/userVerify.php',
        data: {
            token: token
        },
        success:function(data) {
            if (data != 0) {
                showNotification(2000000, "Uw email is geverifieerd, u wordt automatisch doorverwezen.", true);

                setTimeout(() => {
                    location.href = "index.php";
                }, 3000);
            } else {
                showNotification(2000000, "Bekijk uw email voor een verificatie link", false);
        }
        }
   });
   
}


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