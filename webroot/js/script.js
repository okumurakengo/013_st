$(function() {

    var focus = function() {
        $('#focus').focus();
    };

    focus();

    $('#small_chapters').on('change',function(){
        focus();
    });

});