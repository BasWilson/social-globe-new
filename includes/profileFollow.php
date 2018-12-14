<?php

include 'chromeLogger.php';
require 'checkSession.php';

$username = $_POST['usernameToFollow'];

if (!isset($username)) {
    echo "Invalid username";
    return false;
}


// Plaats de comment
follow($username);


function follow ($username) {


    $file = "../data/users.json";
    $jsondata = file_get_contents($file);
    $data = json_decode($jsondata);
    $count = 0;
    foreach ($data->users as $key => $user) {
        // Vind de gerbuiker die we willen volgen
        if ($user->username == $username) {
            // Kijk of we al volgen
            if (in_array($_SESSION['username'], $user->followers)) {
                // We volgen al, dus ontvolg
                array_splice($user->followers, array_search($user->followers, $_SESSION['username']), 1);

            } else {
                // We volgen nog niet, dus voeg toe
                array_push($user->followers, $_SESSION['username']);
            }
            $count++;
            // Nu de following aanpassen
        } else if ($user->username == $_SESSION['username']) {
            // Kijk of we al volgen
            if (in_array($username, $user->following)) {
                // We volgen al, dus ontvolg
                array_splice($user->following, array_search($user->followers, $username), 1);
            } else {
                // We volgen nog niet, dus voeg toe
                array_push($user->following, $username);
            }
            $count++;
        }

        if ($count == 2) {
            $jsondata = json_encode($data, JSON_PRETTY_PRINT);

            //write json data into data.json file
            if(file_put_contents($file, $jsondata)) {
                echo true;
            } else {
                echo false;
            }

            return;
        }
    }


}
?>