
function login () {
    const username = $('#username').val();
    const password = $('#password').val();

    if (username == ""|| password == "") {
        return alert("Zorg er graag voor dat alle velden zijn ingevuld");
    }

    $.ajax({
         type: "POST",
         url: 'includes/userLogin.php',
         data: {
           username: username,
           password: password
         },
         success:function(data) {
             console.log(data)
            if (data == 1) {
                showNotification(1500, "Logged in :)", true);
                setTimeout(() => {
                    window.location.href = "index.php"
                }, 2000);
            } else {
                showNotification(1500, "Login is incorrect :(", false);
            }
         }
    });
    
}

