$(document).ready(function() { 

});
var likedPosts = [];

function saveComment (id) {

    var comment = $("#comment-input-"+id).val();


    if (comment) {

        // Check of het alleen maar spaties zijn
        if (comment.replace(/\s/g, '').length) {
            if (comment.length > 150) {
                return showNotification(2000, "Maximaal 150 karakters per comment.", false);
            }
            $.ajax({
                type: "POST",
                url: 'includes/postCreateComment.php',
                data: {
                  comment: comment,
                  postId: id
                },
                success:function(data) {
                   if (data != 0) {
                        showNotification(2500, "Comment is geplaatst", true);
                        refreshFeed();
                    } else {
                        showNotification(2500, "Kon de comment niet plaatsen :(", false);
                    }
                }
           });

        }

    }

}

function likePost (id) {


    if (likedPosts.indexOf(id) == -1) {
        if (id) {
            $.ajax({
                type: "POST",
                url: 'includes/postLike.php',
                data: {
                  postId: id
                },
                success:function(data) {
                   if (data != 0) {
                       var likes = parseInt($('#like-btn-'+id).text());
                       likedPosts.push(id);
                       likes++;
                       if (likes != 1) {
                            $('#like-btn-'+id).text(likes + " likes");
                       } else {
                            $('#like-btn-'+id).text(likes + " like");
                       }
                    } else {
                        showNotification(2500, "Kon de comment niet plaatsen :(", false);
                    }
                }
           });
        }
    }


}

function deletePost (id) {

    if (id) {
        $.ajax({
            type: "POST",
            url: 'includes/postDelete.php',
            data: {
                postId: id
            },
            success:function(data) {
                if (data != 0) {
                    refreshFeed();
                } else {
                    showNotification(2500, "Kon de post niet verwijderen.", false);
                }
            }
        });
    }

}

function toggleCommentsContainer (id) {
    if ($('#post-comments-div-'+id).css('display') == 'none') {
        $('#post-comments-div-'+id).show('fast');
        $('#comment-btn-'+id).text(' | Verberg comments');

    } else {
        $('#post-comments-div-'+id).hide('fast');
        $('#comment-btn-'+id).text(' | Bekijk comments');
    }
}