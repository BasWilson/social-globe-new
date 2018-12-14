<?php

require 'checkSession.php';
include 'chromeLogger.php';

// De users file
$fileUsers = "../data/users.json";
$jsondataUsers = file_get_contents($fileUsers);
$dataUsers = json_decode($jsondataUsers);

// De posts file
$filePosts = "../data/posts.json";
$jsondataPosts = file_get_contents($filePosts);
$dataPosts = json_decode($jsondataPosts);

// Initializeer de $html variable, deze wordt later ge-echod, alles wat hier in komt komt op de pagina
$html = "";
$notifications = "";

// Kijk of er members zijn
if (empty($dataUsers->users->following)) {
  $notifications .= '<div class="tip-div"><p><strong>TIP: </strong>Door mensen te volgen zal je feed wat leuker worden.</p></div>';
} 

// Vind nu alle posts
if (empty($dataPosts->posts)) {
  $notifications .= '<div class="tip-div"><p>BIG OOPSIE, er zijn op dit moment nog geen posts, tijd om daar verandering in te brengen!</p></div>';
}

// Draai de array om, om het in chronologische orde te laten zien
$postsArray = $dataPosts->posts;

foreach ($postsArray as $postKey => $post) {

  // Eerst uitvinden wat de poster zijn privacy instellingen zijn
  // Loop door de users heen
  foreach ($dataUsers->users as $userKey => $user) {

    // Als we poster vinden
    if ($user->username == $post->posterUsername) {
      // Kijk naar de public instelling
      if ($user->public) {
        // Oke we kunnen de post laten zien aan iedereen
        $html .= createPostHTML($postKey, $postsArray, $user);
      } else {
        // De poster is niet public, kijk of we hem wel volgen
        foreach ($user->followers as $key => $follower) {
          // Kijk of wij een van zijn volgers zijn
          if ($follower == $_SESSION['username']) {
            // Bouw de HTML op voor de post
            $html .= createPostHTML($postKey, $postsArray, $user);
          }
        }
      }
    }
  }
}

// Stuur de volle HTML naar de user
$returnJSON = (object) [
  'html' => $html,
  'notifications' => $notifications
];

echo json_encode($returnJSON);

// Deze functie bouwt de HTML code voor een post
function createPostHTML ($postId, $postsArray, $user) {

  // Selecteer de post uit de posts array
  $post = $postsArray[$postId];

  // Begin met de post maken
  $htmlcode = '
    <div class="post-div">
      <div class="post-top">
      <img src="images/profilePics/'.$user->profilePic.'" />
      <a href="user.php?username='.$post->posterUsername.'" >@'.$post->posterUsername.'</a>
      </div>

      <p class="post-body">'.$post->body.'</p>';

      if ($post->image != 0) {
        $htmlcode .= '
        <img src="images/postImages/'.$post->image.'"/><br>';
      }
      $htmlcode .= '<a id="like-btn-'.$postId.'" onclick="likePost('.$postId.')" >'.$post->likes.' likes</a>';

      // Kijk of er comments zijn
      if (!empty($post->comments)) {
        $htmlcode .= '<a id="comment-btn-'.$postId.'" onclick="toggleCommentsContainer('.$postId.')"> | Bekijk comments</a>';
      }

      $htmlcode .= '<div class="post-comments-div" id="post-comments-div-'.$postId.'">';
  // Haal al de comments op voor deze post
  foreach ($post->comments as $commentKey => $comment) {
    ChromePhp::Log($comment);
    $htmlcode .= '
      <div class="post-comment-div">
        <a href="user.php?username='.$comment->commenterUsername.'" >@'.$comment->commenterUsername.'</a>
        <p>'.$comment->comment.'</p>
      </div>
    ';
  }
  // Sluit de post-comments-div en de post-div
  $htmlcode .= '
    </div>
    <div class="new-comment-div">
      <input id="comment-input-'.$postId.'" type="text" placeholder="Laat iets leuks achter..." />
      <button onclick="saveComment('.$postId.')" >Plaats comment</button>
    </div>
  </div>
  ';
  return $htmlcode;
}
?> 
