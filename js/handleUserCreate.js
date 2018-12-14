
function register () {
    const username = $('#username').val();
    const email = $('#email').val();
    const password = $('#password').val();

    if (username == "" || password == "" || email == "") {
        return showNotification(3000, "Vul graag alle velden in", false);
    }

    $.ajax({
         type: "POST",
         url: 'includes/userCreate.php',
         data: {
           username: username,
           email: email,
           password: password
         },
         success:function(data) {
            if (data != 0) {
                setTimeout(() => {
                    showNotification(1500, "Account created :)", true);
                }, 2000);
                window.location.href = "index.php"
            } else {
                showNotification(3000, "You did an oopsie", false);
            }
         }
    });
    
}

