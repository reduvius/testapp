$(document).ready(function(){
    var stats = $("#stats");
    $("#show").click(function(){
        stats.slideToggle(800);
        var show = $(this);
        if (show.text() == 'Hide user info ▴') {
            show.text('Show user info ▾');
        } else {
            show.text('Hide user info ▴');
        }
        return false;
    });
});
