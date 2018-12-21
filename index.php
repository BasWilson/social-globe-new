<?php
    require 'checkSession.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Feed - Social Globe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/posts.css">

    <?php 
        // Check what color mode
        if ($_SESSION['darkMode']) {
            echo '
            <link rel="stylesheet" href="css/dark.css" type="text/css">
            ';
        } else {
            echo '
            <link rel="stylesheet" href="css/light.css" type="text/css">
            ';
        }
    ?>
</head>
<body>
  <nav>
    <h3>Social Globe</h3>
    <div class="nav-container">

      <a href="index.php" class="active">Feed</a>
      <a href="find.php" style="margin-left:40px;">Vind mensen</a>
      <a href="myprofile.php"  style="margin-left:40px;cursor:pointer;">My profile</a>
      <a href="includes/userLogout.php" style="color:#FF1943; margin-left:40px;">Log out</a>
      <?php 
        // Check what color mode
        if ($_SESSION['darkMode']) {
            echo '<img onclick="darkMode()" src="css/lightmode.png" style="margin:0px 25px 0px 40px; cursor: pointer" />';
        } else {
            echo '<img onclick="darkMode()" src="css/darkmode.png" style="margin:0px 25px 0px 40px; cursor: pointer" />';
        }
        ?>
    </div>
  </nav>

    <div class="field-container new-post-div" id="new-post-div">
        <h3>Nieuwe post maken</h3>
        <textarea placeholder="Schrijf iets in je post..." id="post-body" cols="25" rows="6"></textarea>
        <br>
        <div id="drop-area-post">
            
            <button style="padding: 0px 0px;"><p style="margin-top: 10px;">Sleep je foto hier heen (Optioneel)</p><input style="opacity: 0; padding: 10px; cursor:pointer" type="file"></button>
            <br>
            <p id="image-name" ></p>
            <progress id="imageUploadProgress" value="0" max="100">0%</progress>
        </div> 
        <button onclick="createPost()" >Plaats bericht</button>
    </div>

    <div id="notifications-div">
    </div>

    <div class="field-container " id="feed-div">
    </div>

    <div id="noti-box" class="noti-box"> 
        <div class="noti-content">
            <p id="noti-text">Some notification to be shown</p>
        </div>
    </div>

    <div onclick="toggleNewPostContainer()" class="new-post-btn">
        <p style="color: black;">Plaats post</p>
    </div>

    <footer>
        <p>Alle rechten voorbehouden. Social Globe 2018</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pulltorefreshjs/0.1.14/pulltorefresh.min.js"></script>
    <script src="js/fileUploader.js"></script>
    <script src="js/tools.js"></script>
    <script src="js/handleNewPost.js"></script>
    <script src="js/handlePosts.js"></script>
    <script src="js/handleFeed.js"></script>

</body>
</html>
