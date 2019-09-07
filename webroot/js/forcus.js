$(function() {
    //最初のinputにfocusしてあげる気が利く系処理
    $('input[type=text]:first').focus();
    $('input').bind("keydown", function(e) {
        var n = $("input").length;
        //13=エンターkeyです
        if (e.which == 13)
        {
            e.preventDefault();
            var nextIndex = $('input').index(this) + 1;
            if(nextIndex < n) {
                //次のやつにfocus
                $('input')[nextIndex].focus();
            } else {
                //最後のやつなので#login-btnをクリック
                $('input')[nextIndex-1].blur();
                $('#login-btn').click();
            }
        }
    });
});