<?php
require 'checkSession.php';

$postId = $_POST['postId'];

if (isset($postId)) {
    deleteFromJson($postId);
}

function deleteFromJson ($postId) {

    $file = "../data/posts.json";
    $jsondata = file_get_contents($file);
    $data = json_decode($jsondata);

    if ($data->posts[$postId]->posterUsername == $_SESSION['username']) {
        // Haal de member uit de array
        array_splice($data->posts, $postId, 1);

        $jsondata = json_encode($data, JSON_PRETTY_PRINT);
        
        // Schrijf de json data terug
        if(file_put_contents($file, $jsondata)) {
            echo true;
        } else {
            echo false;
        }
    }

    
}
?>