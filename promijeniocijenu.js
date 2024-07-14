$(document).ready(function() {
    var btn = $("#rate");

    btn.on("click", function(e) {
        var ocjena = $("#rating_select").val();
        var user_id = $("#js_user_id").val();
        var movie_id = $("#js_movie_id").val();

        $.ajax({
            method: 'post',
            url: "promijeniocijenu.php",
            data: {
                ocjena: ocjena,
                user_id: user_id,
                movie_id: movie_id
            },
            success: function(data) {
                $("#js_averagerating").html(data.average);
                $("#js_yourrating").html(data.your); 
            },
            error: function(xhr, status) {
                if(status !== null)
                    console.log("Greška prilikom Ajax poziva: " + status);
            }
        });
    });
});

