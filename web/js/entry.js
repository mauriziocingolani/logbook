var start = /@/ig; // @ Match
var word = /@(^[a-z]{1}[a-z0-9_]+[a-z0-9]{1}$)/ig; //@x_abc1234 Match
var projectid;
var users;
var hashtags;
$(function () {
    $.ajax('user/default/list', {
        dataType: 'json',
        success: function (json) {
            $('#entry-entrytext').usersAutocomplete({
                source: json,
                hidden: '#hidden_users_inputbox',
            });
        }
    });
    $('#entry-entrytext').hashtagsAutocomplete({
        hidden: '#hidden_hashtags_inputbox',
    });
});
