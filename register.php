<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Social Globe - New account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <link rel="stylesheet" href="css/light.css" type="text/css">
</head>
<body>
  <div style="text-align:center">
    <img style="display: none; margin-top: 30%; width: 50px;" class="loader" src="css/loader.svg" />
    <div class="form-container login-container">
        <img style="filter:invert(0); opacity:0.3;" src="css/socialglobe_logo.png">
        <p>Nieuw account maken op Social Globe</p><br>
        <input id="username" type="text" placeholder="Username">
        <input id="email" type="email" placeholder="Email">
        <input id="password" type="password" placeholder="Password">
        <button onclick="register()">Registreer</button><br>
        <a href="login.php">Al een account? Log hier in.</a>
        <p style="
        color: black;
        opacity: 0.3;
        margin-top: 80px;
        font-size: 12px;
        ">Alle rechten voorbehouden - <a style="margin-left:0px; color:black;"href="https://github.com/baswilson">Social Globe 2018</a></p>
    </div>

  </div>
  

  
  <div id="noti-box" class="noti-box"> 
        <div class="noti-content">
            <p id="noti-text">Some notification to be shown</p>
        </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <script src="js/tools.js"></script>
  <script src="js/handleUserCreate.js"></script>

</body>
</html>
