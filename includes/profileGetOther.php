<?php

require 'checkSession.php';
include 'chromeLogger.php';

$username = $_POST['username'];
// De users file
$fileUsers = "../data/users.json";
$jsondataUsers = file_get_contents($fileUsers);
$dataUsers = json_decode($jsondataUsers);

// De posts file
$filePosts = "../data/posts.json";
$jsondataPosts = file_get_contents($filePosts);
$dataPosts = json_decode($jsondataPosts);

// Initializeer de $postsHTML variable, deze wordt later ge-echod, alles wat hier in komt komt op de pagina
$postsHTML = "";
$profileHTML = createProfileHTML($dataUsers, $username);


// // Kijk of er members zijn
// if (empty($dataUsers->users->following)) {
//   $notifications .= '<div class="tip-div"><p><strong>TIP: </strong>Door mensen te volgen zal je feed wat leuker worden.</p></div>';
// } 

// // Vind nu alle posts
// if (empty($dataPosts->posts)) {
//   $notifications .= '<div class="tip-div"><p>BIG OOPSIE, er zijn op dit moment nog geen posts, tijd om daar verandering in te brengen!</p></div>';
// }

// Draai de array om, om het in chronologische orde te laten zien
$postsArray = $dataPosts->posts;

foreach ($postsArray as $postKey => $post) {
    // vind alleen onze egien posts
    if ($post->posterUsername == $username) {
        // Bouw de html op
        $postsHTML .= createPostHTML($postKey, $postsArray, $username, $dataUsers);

        if (!$postsHTML) {
            $postsHTML = "<h3 style='text-align:center; margin-top: 20px;'>U moet deze gebruiker volgen om zijn/haar posts te zien.</h3>";
        }
    }
}

// Stuur de volle HTML naar de user
$returnJSON = (object) [
  'postsHTML' => $postsHTML,
  'profileHTML' => $profileHTML
];

echo json_encode($returnJSON);

// Deze functie bouwt de HTML code voor een post
function createPostHTML ($postId, $postsArray, $userToGet, $users) {

  // Selecteer de post uit de posts array
  $post = $postsArray[$postId];
  $postsHTMLcode = "";

  foreach ($users->users as $key => $user) {
    // vind het profiel
    if ($user->username == $userToGet) {
            // Kijk of de user hem/haar volgt of of het het eigen account is
            if (in_array($_SESSION['username'], $user->followers) || $_SESSION['username'] == $userToGet && !$user->public) {
                // Hij volgt
                // Begin met de post maken
                $postsHTMLcode .= '
                <div class="post-div">
                <a href="user.php?username='.$post->posterUsername.'" >@'.$post->posterUsername.'</a>
                <p class="post-body">'.$post->body.'</p>';

                if ($post->image != 0) {
                    $postsHTMLcode .= '
                    <img src="images/postImages/'.$post->image.'"/><br>';
                }
                $postsHTMLcode .= '<a id="like-btn-'.$postId.'" onclick="likePost('.$postId.')" >'.$post->likes.' likes</a>';

                // Kijk of er comments zijn
                if (!empty($post->comments)) {
                    $postsHTMLcode .= '<a id="comment-btn-'.$postId.'" onclick="toggleCommentsContainer('.$postId.')"> | Bekijk comments</a>';
                }

                $postsHTMLcode .= '<div class="post-comments-div" id="post-comments-div-'.$postId.'">';
                // Haal al de comments op voor deze post
                foreach ($post->comments as $commentKey => $comment) {
                    $postsHTMLcode .= '
                    <div class="post-comment-div">
                        <a href="user.php?username='.$comment->commenterUsername.'" >@'.$comment->commenterUsername.'</a>
                        <p>'.$comment->comment.'</p>
                    </div>
                    ';
                }
                // Sluit de post-comments-div en de post-div
                $postsHTMLcode .= '
                    </div>
                    <div class="new-comment-div">
                    <input id="comment-input-'.$postId.'" type="text" placeholder="Laat iets leuks achter..." />
                    <button onclick="saveComment('.$postId.')" >Plaats comment</button>
                    </div>
                </div>
                ';
                return $postsHTMLcode;
            } else if ($user->public) {
                // Public post

                $postsHTMLcode .= '
                <div class="post-div">
                <a href="user.php?username='.$post->posterUsername.'" >@'.$post->posterUsername.'</a>
                <p class="post-body">'.$post->body.'</p>';

                if ($post->image != 0) {
                    $postsHTMLcode .= '
                    <img src="images/postImages/'.$post->image.'"/><br>';
                }
                $postsHTMLcode .= '<a id="like-btn-'.$postId.'" onclick="likePost('.$postId.')" >'.$post->likes.' likes</a>';

                // Kijk of er comments zijn
                if (!empty($post->comments)) {
                    $postsHTMLcode .= '<a id="comment-btn-'.$postId.'" onclick="toggleCommentsContainer('.$postId.')"> | Bekijk comments</a>';
                }

                $postsHTMLcode .= '<div class="post-comments-div" id="post-comments-div-'.$postId.'">';
                // Haal al de comments op voor deze post
                foreach ($post->comments as $commentKey => $comment) {
                    $postsHTMLcode .= '
                    <div class="post-comment-div">
                        <a href="user.php?username='.$comment->commenterUsername.'" >@'.$comment->commenterUsername.'</a>
                        <p>'.$comment->comment.'</p>
                    </div>
                    ';
                }
                // Sluit de post-comments-div en de post-div
                $postsHTMLcode .= '
                    </div>
                    <div class="new-comment-div">
                    <input id="comment-input-'.$postId.'" type="text" placeholder="Laat iets leuks achter..." />
                    <button onclick="saveComment('.$postId.')" >Plaats comment</button>
                    </div>
                </div>
                ';
                return $postsHTMLcode;

                
            } else {
                return false;
            }
    }
}

  return $postsHTMLcode;
}

function createProfileHTML ($users, $userToGet) {

    $html = "";

    foreach ($users->users as $key => $user) {
        // vind het profiel
        if ($user->username == $userToGet) {

                // HTML opbouwen nu
                $date = date("l", $user->memberSince) . " " . date("F", $user->memberSince) . " " . date("w", $user->memberSince) . ", " .  date("Y", $user->memberSince) . ".";

                $html .= '
                    <img src="images/profilePics/'.$user->profilePic.'" />
                    <a href="user.php?username='.$user->username.'" class="pf-item">@'.$user->username.'</a>
                    <a class="pf-item">Volgers: '.sizeof($user->followers).'</a>
                    <a class="pf-item">Volgend: '.sizeof($user->following).'</a>
                    <p class="pf-item">Lid sinds: '.$date.'</p>
                ';
                
                if (in_array($_SESSION['username'], $user->followers)) {
                    $html .= '<button style="margin: 10px;"  onclick="follow(\''.$userToGet.'\')" >Ontvolg</button>';
                } else if ($_SESSION['username'] ==  $userToGet) {
                    $html .= '<p class="pf-item">Dit is hoe andere jouw profiel zien</p>';
                } else {
                    $html .= '<button style="margin: 10px;" onclick="follow(\''.$userToGet.'\')" >Volg</button>';
                }


        }
    }

    return $html;
}
?> 
