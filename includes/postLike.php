<?php

require 'checkSession.php';

$postId = $_POST['postId'];
$username = $_SESSION['username'];

if (!isset($username)|| !isset($postId)) {
    echo "Invalid post id";
    return false;
}

// Plaats de comment
likeComment($postId, $username);


function likeComment ($id, $username) {

    $file = "../data/posts.json";
    $jsondata = file_get_contents($file);
    $data = json_decode($jsondata);

    // Voeg de like toe
    $data->posts[$id]->likes = intval($data->posts[$id]->likes) + 1;

    $jsondata = json_encode($data, JSON_PRETTY_PRINT);

    //write json data into data.json file
    if(file_put_contents($file, $jsondata)) {
        echo true;
    } else {
        echo false;
    }
}
?>