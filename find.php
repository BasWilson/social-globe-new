<?php
    require 'checkSession.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Vind mensen - Social Globe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/posts.css">
    <link rel="stylesheet" href="css/search.css">
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

      <a href="index.php">Feed</a>
      <a href="find.php"  class="active"  style="margin-left:40px;">Vind mensen</a>
      <a href="myprofile.php"style="margin-left:40px;cursor:pointer;">My profile</a>
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
        <textarea placeholder="Schrijf iets in je post..." id="post-body" cols="60" rows="10"></textarea>
        <br>
        <div id="drop-area-post">
            <p>Sleep je foto hier heen (Optioneel)</p>
            <input type="file" title="Of klik hier"><br>
            <progress id="imageUploadProgress" value="0" max="100">0%</progress>
        </div>
        <button onclick="createPost()" >Plaats bericht</button>
    </div>

    <div id="notifications-div">
    </div>

    <div class="field-container search-div" id="search-div">
        <h3>Vind hier nieuwe mensen</h3>
        <input type="text" placeholder="Zoek hier naar mensen" id="search-field" />
    </div>

    <div id="results-div">
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
    <script src="js/fileUploader.js"></script>
    <script src="js/tools.js"></script>
    <script src="js/handleNewPost.js"></script>
    <script src="js/handleSearch.js"></script>

</body>
</html>
