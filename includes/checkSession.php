<?php

// Kijk of er al een session betaat, anders start hem
if (session_status() != 2) {
    session_start();
    if ($_SESSION['username'] && $_SESSION['sessionToken']) {
        verifiyToken();
    } else {
        session_destroy();
        header('Location: login.php');
        exit;
    }
}

function verifiyToken () {

    $file = "../data/users.json";
    $jsondata = file_get_contents($file);
    $data = json_decode($jsondata);
    
    foreach ($data->users as $key => $user) {
    
        // Kijk of de username en sessionToken gelijk zijn als die in de DB (json)
        if (!$user->username == $_SESSION['username'] && !$user->sessionToken == $_SESSION['sessionToken'] ) {
            session_destroy();
            header('Location: login.php');
            exit;
        }
    }
    
}
