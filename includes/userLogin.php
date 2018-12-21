<?php


$username = strtolower($_POST['username']);
$password = $_POST['password'];

$file = "../data/users.json";
$jsondata = file_get_contents($file);
$data = json_decode($jsondata);

if (isset($username) && isset($_POST["password"])) {

    foreach ($data->users as $key => $user) {
        // Vind de user
        if ($user->username == $username) {
            // Kijk of de password overeenkomt met de opgeslagen hash
            if (password_verify($_POST["password"], $user->password)) {

                session_start();
                $date = new DateTime();
                // Maak de session token aan
                $sessionToken = bin2hex(openssl_random_pseudo_bytes(64));
                // Sla de variabelen op
                $user->sessionToken = $sessionToken;
                $user->lastSignIn = $date->getTimestamp();
                $_SESSION['sessionToken'] = $sessionToken;
                $_SESSION['username'] = strtolower($user->username);
                $_SESSION['darkMode'] = $user->darkMode;

                // Kijk of het goed is opgeslagen
                if ($_SESSION['sessionToken'] == $sessionToken) {

                    // Sla de data op
                    $jsondata = json_encode($data, JSON_PRETTY_PRINT);

                    if(file_put_contents($file, $jsondata)) {
                        // User is ingelogd
                        echo 1;
                    } else {
                        echo 0;
                    }
                    return;

                } else {
                    echo 0;
                    return;
                }
            }
        }
    }

} else {
    session_start();
    session_destroy();
    echo 0;
    return;
}
