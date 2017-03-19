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
    var json_data = $('#json_data').length > 0 ? JSON.parse($('#json_data').html()) : '';
    $(window).keydown(function(e){
        if(e.ctrlKey){
            switch (e.keyCode) {
                case s_keyCode:
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
        var pull_keydown = $('.pull_keydown').val();
        var select_number = $.inArray(parseInt(pull_keydown), json_data);
        if (e.keyCode === down_keyCode) {
            $('.pull_keydown').val(json_data[select_number + 1]);
            $('.pull_change').submit();
            return false;
        } else if (e.keyCode === up_keyCode) {
            $('.pull_keydown').val(json_data[select_number - 1]);
            $('.pull_change').submit();
            return false;
        }
    });

});