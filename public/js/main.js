$(document).ready(function () {
    // By default submit button is disabled
    $('#submit').attr('disabled', 'disabled');

    // If confirm human checkbox is checked, submit button is enabled.
    $('#enable').click(function() {
        if ($(this).is(':checked')) {
            $('#submit').removeAttr('disabled');
        } else {
            $('#submit').attr('disabled', 'disabled');
        }
    });

    var form = $('#post-comment');
    var commentsDiv = $('#posts-list');

    var action = form.attr("action");

    // Disable browser cache for ajax calls.
    $.ajaxSetup({ cache: false });

    form.submit(function(){
        // Make POST request via ajax to leave a comment.
        $.ajax({
            type: "POST",
            url: form.attr("action"),
            data: form.serialize(),
            success: function(data){
                var response = $.parseJSON(data);
                console.log(response);
                console.log(response.spam);
                if (response.spam) {
                    console.log("spammer");
                    $('#spam-message').text(response.message);
                } else {
                    var newComment = comment_insert(response);
                    commentsDiv.append(newComment);
                }
            },
            error: function (data) {
                alert("ERROR: ");
                for(var key in data) {
                    $('#msgid').append(key);
                    $('#msgid').append('=' + data[key] + '<br />');
                }
            }
        });

        clearInputs('post-comment');

        return false;
    });

    var postId = $('#post_id').val();

    getComments(postId);

    /**
     * Set interval to 3 sec to auto load comments and append them to comments section.
     */
    setInterval(function() {
        var postId = $('#post_id').val();

        getComments(postId);
    }, 3000);

    /**
     * Get comments via ajax GET request.
     *
     * @param postId
     */
    function getComments(postId){
        $.ajax({
            type: "GET",
            url: '/comments?id='+ postId,
            success:function(data){
                commentsDiv.empty();

                var comments = $.parseJSON(data);
                $.each(comments, function(index, comment) {
                    commentsDiv.append(comment_insert(comment));
                });
            }
        });
    }

    /**
     * Clear form inputs based on form id.
     *
     * @param formId
     */
    function clearInputs(formId)
    {
        $(':input','#' + formId).not('#post_id').val('').removeAttr('checked').removeAttr('selected');
    }

    /**
     * Append comment to comments section.
     *
     * @param data
     * @returns {string}
     */
    function comment_insert(data)
    {
        var comment = '';
        comment += '<li>';
        comment += '<article class="hentry well">';
        comment += '<footer class="post-info">';
        comment += '<abbr class="published" title="' + data.created_at + '">';
        comment += data.created_at;
        comment += '</abbr>';
        comment += '<address class="vcard author">';
        comment += 'By <a class="url fn" href="#">' + data.name + '</a>';
        comment += '</address>';
        comment += '</footer>';
        comment += '<div class="entry-content">';
        comment += '<p>' + data.message + '</p>';
        comment += '</div>';
        comment += '</article>';
        comment += '</li>';

        return comment;
    }

});
