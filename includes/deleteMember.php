<?php
require 'checkSession.php';

$memberId = $_POST['memberId'];

if (isset($memberId)) {
    deleteFromJson($memberId);
}

function deleteFromJson ($memberId) {

    $file = "../../data/members.json";
    $jsondata = file_get_contents($file);
    $data = json_decode($jsondata);

    // Haal de member uit de array
    array_splice($data->members, $memberId, 1);

    $jsondata = json_encode($data, JSON_PRETTY_PRINT);
    
    // Schrijf de json data terug
    if(file_put_contents($file, $jsondata)) {
        echo true;
    } else {
        echo false;
    }
    
}
?>