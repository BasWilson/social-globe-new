<?php


$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

if (isset($username) && isset($password) && isset($email)) {

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 0;
        return;
    }
    writeToJson($username, $password, $email);

} else {
    echo 0;
    return;
}

function writeToJson($username, $password, $email) {

    $file = "../data/users.json";
    $jsondata = file_get_contents($file);
    $data = json_decode($jsondata);

    foreach ($data->users as $key => $user) {
        if ($user->username == $username) {
            echo 0;
            return;
        }
    }
    $date = new DateTime();

    // Maak het user object
    $user = (object) [
        'username' => strip_tags($username),
        'password' => password_hash($password, PASSWORD_BCRYPT),
        'email' => $email,
        'sessionToken' => 0,
        'lastSignIn' => 0,
        'memberSince' => $date->getTimestamp(),
        'public' => true,
        'profilePic' => "default.png",
        'followers' => (array) [],
        'following' => (array) []
    ];

    // Push die in de array
    array_push($data->users, $user);

    $jsondata = json_encode($data, JSON_PRETTY_PRINT);

    // Schrijf de json data terug
    if(file_put_contents($file, $jsondata)) {
        // User is aangemaakt
        echo 1;
    } else {
        echo 0;
    }

}

?>

