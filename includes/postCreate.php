<?php

require 'checkSession.php';
include 'chromeLogger.php';

$path = "../images/postImages/";
if (!file_exists($path)) {
    mkdir($path, 0777, true);
}

$body = $_POST['postBody'];
$username = $_SESSION['username'];
$valid_formats = array(
    "jpg",
    "png",
    "gif",
    "bmp",
    "jpeg",
    "JPEG",
    "JPG",
    "PNG",
    "GIF",
    "BMP"
);

if (!isset($username)|| !isset($body)) {
    echo "There is no text added to this post.";
    return false;
}

if (strlen(strip_tags($body)) > 150) {
    echo "You went over the maximum 150 characters per post.";
    return false;
}


if (isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST") {

    if ($_FILES['file']['size'] == 0) {
        if (postText($body, 0, $username)) {
            echo 1;
            return;
        }
    }
    $name = $_FILES['file']['name'];
    $size = $_FILES['file']['size'];

    if ($size < 50000000) {

    if (strlen($name)) {

        list($txt, $ext) = explode(".", $name);
        if (in_array($ext, $valid_formats)) {

                // Regel een timestamp voor de naam van foto
                $date = new DateTime();

                $actual_image_name = $date->getTimestamp() . "." . $ext;
                $tmp = $_FILES['file']['tmp_name'];
                if (move_uploaded_file($tmp, $path . $actual_image_name)) {
                    // Sla de post op
                    postText($body, $actual_image_name, $username);
                } else
                    echo "failed";
        } else
            echo "Invalid file format..";
    } else
        echo "Please select image..!";
    exit;
}
}

function postText ($body, $imageName, $username) {

    $file = "../data/posts.json";
    $jsondata = file_get_contents($file);
    $data = json_decode($jsondata);

    // Maak het nieuwe post object
    $post = (object) [
        'body' => strip_tags($body),
        'image' => $imageName,
        'comments' => (array) [],
        'likes' => 0,
        'posterUsername' => strip_tags($username)
    ];

    // Push image name to array
    array_push($data->posts, $post);

    $jsondata = json_encode($data, JSON_PRETTY_PRINT);

    //write json data into data.json file
    if(file_put_contents($file, $jsondata)) {
        return true;
    } else {
        return false;
    }
}
?>