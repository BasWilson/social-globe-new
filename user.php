<?php
    require 'checkSession.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>User - Social Globe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Include the required files -->
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="css/queries.css" type="text/css">

</head>
<body>
  <nav>
    <p>Social Globe</p>
    <div class="nav-container">
      <a href="index.php" class="active">Feed</a>
      <a href="find.php" style="margin-left:40px;" class="active">Vind mensen</a>
      <a href="myprofile.php" id="new-member-btn" style="color:blue; margin-left:40px;cursor:pointer;">My profile</a>
      <a href="includes/userLogout.php" style="color:#FF1943; margin-left:40px;">Log out</a>
    </div>
  </nav>


    <div class="profile-body">
        <div class="profile-div" id="profile-div">
        </div>

        <div class="posts-div" id="posts-div">
        </div>
    </div>



    <div id="noti-box" class="noti-box"> 
        <div class="noti-content">
            <p id="noti-text">Some notification to be shown</p>
        </div>
    </div>

    
    <footer>
        <p>Alle rechten voorbehouden. Social Globe 2018</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="js/fileUploader.js"></script>
    <script src="js/tools.js"></script>
    <script src="js/handlePosts.js"></script>
    <script src="js/handleProfileOther.js"></script>

</body>
</html>
