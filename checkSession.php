<?php

// Kijk of er al een session betaat, anders start hem
if (session_status() != 2) {
    session_start();
    if ($_SESSION['username'] && $_SESSION['sessionToken']) {
            verifiyToken();
            verifiyEmail();
    } else {
        session_destroy();
        header('Location: login.php');
        exit;
    }
}

function verifiyToken () {
    $file = "data/users.json";
    $jsondata = file_get_contents($file);
    $data = json_decode($jsondata);
    
    foreach ($data->users as $key => $user) {

        // Kijk of de username en sessionToken gelijk zijn als die in de DB (json)
        if (!$user->username == strtolower($_SESSION['username']) && !$user->sessionToken == $_SESSION['sessionToken'] ) {
            session_destroy();
            header('Location: login.php');
            exit;
        }
    }
    
}
function verifiyEmail () {

    $file = "data/users.json";
    $jsondata = file_get_contents($file);
    $data = json_decode($jsondata);
    
    foreach ($data->users as $key => $user) {
    
        // Kijk of de user is geverifieerd
        if ($user->username == strtolower($_SESSION['username']) && $user->verified) {
            // Is geverifieerd
        } else if ($user->username == strtolower($_SESSION['username']) && !$user->verified) {
            // Is niet geverifieerd
            header('Location: verify.php');
        }
    }
    
}