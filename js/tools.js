var notificationTimeout = -1;

function showNotification (duration, text, status) {
    var notiText = document.getElementById('noti-text');
    var notiBox = document.getElementById('noti-box');
    clearTimeout(notificationTimeout);
    
    notiText.innerHTML = text;
    
    if (status) {
        notiBox.style.backgroundColor = "rgba(255, 238, 0, 0.5)";
    } else {
        notiBox.style.backgroundColor = "rgba(255, 0, 0, 0.5)";        
    }
    $('.noti-box').fadeIn("fast");
    
    //Stel de tijd in in ms dat het boxje er moet blijven dmv de setTimeout functie. 
    notificationTimeout = setTimeout(function () {
        notiText.innerHTML = "";
        $('.noti-box').fadeOut("fast");
        notificationTimeout = -1;
    }, duration)

}

function darkMode () {
    $.ajax({
        type: "POST",
        url: 'includes/profileSetDarkMode.php',
        success:function(data) {
           if (data != 0) {
               location.reload();
            } else {
                showNotification(2000, "Er is iets fout gegaan", false);
            }
        }
   });
}