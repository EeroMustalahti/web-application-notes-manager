$(document).ready(function(){

    var setCSRFtoken = function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    };

    var setMessage = function(data) {
        var msg = '<div id="message" class="alert alert-info">'+data.message+'</div>';
        if($('#message').length) {
            $('#message').replaceWith(msg);
        } else {
            $('#layout').prepend(msg);
        }
    };

    $('.delete-note').click(function() {
        setCSRFtoken();
        var note_id = $(this).val();
        $.ajax({
            type: 'POST',
            url: '/notes/' + note_id,
            success:function(data){
                setMessage(data);
                if(data.success) {
                    $('#note' + note_id).remove();
                }
            },
        });
    });

    $('.delete-user').click(function() {
        setCSRFtoken();
        var user_slug = $(this).val();
        $.ajax({
            type: 'POST',
            url: '/users/' + user_slug,
            success:function(data){
                setMessage(data);
                if(data.success) {
                    $('#user' + user_slug).remove();
                }
            },
        });
    });

    $('.make-mode').click(function() {
        setCSRFtoken();
        var user_slug = $(this).val();
        $.ajax({
            type: 'POST',
            url: '/' + user_slug,
            success:function(data){
                setMessage(data);
                if(data.success) {
                    if($('#mode' + user_slug).text() == 'Make moderator') {
                        $('#mode' + user_slug).text('Remove moderator');
                    } else {
                        $('#mode' + user_slug).text('Make moderator');
                    }
                }
            },
            error:function() {
                alert('NO');
            }
        });
    });

});
