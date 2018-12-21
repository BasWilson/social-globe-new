<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Social Globe - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="stylesheet" href="css/queries.css" type="text/css">
</head>
<body>
  <div class="login-container">
    <img style="filter:invert(0); opacity:0.3;" src="css/socialglobe_logo.png">
    <p>Inloggen op Social Globe</p><br>
    <input id="username" type="text" placeholder="Username">
    <input id="password" type="password" placeholder="Password">
    <button onclick="login()">Log in</button><br>
    <a href="register.php">Nog geen account? Registreer hier.</a>
    <p style="
      color: black;
      opacity: 0.3;
      margin-top: 80px;
      font-size: 12px;
    ">Alle rechten voorbehouden - <a style="margin-left:0px; color:black;"href="https://github.com/baswilson">Social Globe 2018</a></p>
  </div>
  
  
  <div id="noti-box" class="noti-box"> 
        <div class="noti-content">
            <p id="noti-text">Some notification to be shown</p>
        </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="js/tools.js"></script>
  <script src="js/handleUserLogin.js"></script>

</body>
</html>
