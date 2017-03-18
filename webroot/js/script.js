$(function() {

    var focus = function() {
        $('#focus').focus();
    };

    focus();

    $('#small_chapters').on('change',function(){
        focus();
    });

    var s_keyCode = 83;
    $(window).keydown(function(e){
        if(event.ctrlKey){
            if(e.keyCode === s_keyCode){
                $('button[type=submit]').focus();
                return false;
            }
        }
    });

});