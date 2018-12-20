<?php

include 'chromeLogger.php';

$token = $_POST['token'];

if (!isset($token)) {
    echo 0;
    return false;
}

// Plaats de comment
ChromePhp::Log($token);
verify($token);

function verify ($token) {

    $file = "../data/users.json";
    $jsondata = file_get_contents($file);
    $data = json_decode($jsondata);
    foreach ($data->users as $key => $user) {
        // Vind de gerbuiker die we willen verifieren
        if ($user->emailVerification == $token) {

            // Stel in als verified
            $user->verified = true;

            $jsondata = json_encode($data, JSON_PRETTY_PRINT);

            // Schrijf de json data terug
            if(file_put_contents($file, $jsondata)) {
                // User is aangemaakt
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

}
?>