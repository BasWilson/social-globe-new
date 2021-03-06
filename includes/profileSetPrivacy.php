<?php

require 'checkSession.php';
include 'chromeLogger.php';

ChromePhp::Log($_SESSION['username']);
if (!isset($_SESSION['username'])) {
    echo 0;
    return false;
}

// Plaats de comment

    $file = "../data/users.json";
    $jsondata = file_get_contents($file);
    $data = json_decode($jsondata);
    foreach ($data->users as $key => $user) {
        // Vind de gerbuiker die we willen verifieren
        if ($user->username == $_SESSION['username']) {
            if ($user->public) {
                // Stel in als verified
                $user->public = false;
            } else {
                $user->public = true;
            }
    
            $jsondata = json_encode($data, JSON_PRETTY_PRINT);
    
            // Schrijf de json data terug
            if(file_put_contents($file, $jsondata)) {
                // privacy is aangepast
                echo 1;
                return true;
            } else {
                echo 0;
                return false;
            }
        }
    }
    echo 0;
    return false;

?>