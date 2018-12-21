<?php

include 'chromeLogger.php';
require 'checkSession.php';

$username = $_POST['username'];

if (!isset($username)) {
    echo "Invalid username";
    return false;
}


// Plaats de comment
ChromePhp::Log(find($username));
echo find($username);


function find ($username) {


    $file = "../data/users.json";
    $jsondata = file_get_contents($file);
    $data = json_decode($jsondata);
    $count = 0;
    $html = "";
    foreach ($data->users as $key => $user) {
        // Vind de gerbuiker die we willen volgen

        if ($username == "") {
            return '<div class="search-result"><h3>Voer een gebruikersnaam in van een persoon</h3></div>';
        }

        if (strpos($user->username, strtolower($username)) !== false) {
            $count++;
            $html .= '
            <div class="search-result">
                <img src="images/profilePics/'.$user->profilePic.'" />
                <a href="user.php?username='.$user->username.'" class="pf-item">@'.$user->username.'</a>
                <p class="pf-item">Volgers: '.sizeof($user->followers).'</p>
                <p class="pf-item">Volgend: '.sizeof($user->following).'</p>
            </div>
        ';
        }
        // Na 20 resultaten stop.
        if ($count > 20) {
            return $html;
        }
        // if ($user->username == $username) {
        //     $html .= '
        //         <div class="search-result">
        //             <img src="images/profilePics/'.$user->profilePic.'" />
        //             <a href="user.php?username='.$user->username.'" class="pf-item">@'.$user->username.'</a>
        //             <p class="pf-item">Volgers: '.sizeof($user->followers).'</p>
        //             <p class="pf-item">Volgend: '.sizeof($user->following).'</p>
        //         </div>
        //     ';
        //     return $html;
        // } 
    }
    if ($html == "") {
        return '<div class="search-result"><h3>Kan geen gebruiker vinden met deze gebruikersnaam</h3></div>';
    } else {
        return $html;
    }

}
?>