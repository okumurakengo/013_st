$(function() {

    var focus = function() {
        $('#focus').focus();
    };

    focus();

    $('#small_chapters').on('change',function(){
        focus();
    });

    var s_keyCode = 83;
    var t_keyCode = 84;
    var up_keyCode = 38;
    var down_keyCode = 40;
    $(window).keydown(function(e){
        if(e.ctrlKey){
            switch (e.keyCode) {
                case s_keyCode:
                    $('button[type=submit]').focus();
                    $('#add_form').submit();
                    break;
                case t_keyCode:
                    // 対象外ショートカット
                    $('#status').val('4');
                    $('#add_form').submit();
                    break;
            }
            return false;
        }

        // プルダウン選択ショートカット
        var json_data = JSON.parse($('#json_data').html());
        var select_small_chapter = $('#small_chapters').val();
        var select_number = $.inArray(select_small_chapter, json_data);
        if (e.keyCode === down_keyCode) {
            $('#small_chapters').val(json_data[select_number + 1]);
            return false;
        } else if (e.keyCode === up_keyCode) {
            $('#small_chapters').val(json_data[select_number - 1]);
            return false;
        }
    });

});