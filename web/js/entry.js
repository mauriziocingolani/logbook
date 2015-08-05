var start = /@/ig; // @ Match
var word = /@(^[a-z]{1}[a-z0-9_]+[a-z0-9]{1}$)/ig; //@x_abc1234 Match

$(function () {
    var options = $('#users option');
    var values = $.map(options, function (option) {
        return option.value;
    });
    console.log(values);
    $('#entry-entrytext').triggeredAutocomplete({
        hidden: '#hidden_inputbox',
        source: values,
        trigger: "@"
    });
    $('#entry-entrytext').triggeredAutocomplete({
        hidden: '#hidden_inputbox_2',
        source: values,
        trigger: "#"
    });
});