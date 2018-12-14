<?php

require 'checkSession.php';
include 'chromeLogger.php';

$comment = $_POST['comment'];
$postId = $_POST['postId'];
$username = $_SESSION['username'];

if (!isset($username)|| !isset($comment)) {
    echo "Invalid comment";
    return false;
}

if (strlen(strip_tags($comment)) > 150) {
    echo "You went over the maximum 150 characters per comment.";
    return false;
}

// Plaats de comment
postComment($comment, $postId, $username);


function postComment ($comment, $id, $username) {

    $file = "../data/posts.json";
    $jsondata = file_get_contents($file);
    $data = json_decode($jsondata);

    // Maak het nieuwe comment object
    $comment = (object) [
        'comment' => strip_tags($comment),
        'commenterUsername' => $username
    ];

    // Push image name to array
    array_push($data->posts[$id]->comments, $comment);

    $jsondata = json_encode($data, JSON_PRETTY_PRINT);

    //write json data into data.json file
    if(file_put_contents($file, $jsondata)) {
        echo true;
    } else {
        echo false;
    }
}
?>