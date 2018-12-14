var notificationTimeout = -1;

function showNotification (duration, text, status) {
    var notiText = document.getElementById('noti-text');
    var notiBox = document.getElementById('noti-box');
    clearTimeout(notificationTimeout);
    
    notiText.innerHTML = text;
    
    if (status) {
        notiBox.style.backgroundColor = "#FFD400";
    } else {
        notiBox.style.backgroundColor = "rgba(255, 0, 0, 0.8)";        
    }
    $('.noti-box').show("fast");

    //Stel de tijd in in ms dat het boxje er moet blijven dmv de setTimeout functie. 
    notificationTimeout = setTimeout(function () {
        notiText.innerHTML = "";
        $('.noti-box').hide("fast");
        notificationTimeout = -1;
    }, duration)

}