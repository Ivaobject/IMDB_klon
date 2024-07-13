$( document ).ready( function()
{
    var txt = $( "#txt_search" );

    txt.on( "input", function(e)
    {
        var unos = $( this ).val(); 
        $.ajax(
        {
            method: 'get',
            url: "searchSuggest.php",
            data:
            {
                q: unos
            },
            success: function( data )
            {
                $( "#datalist_search" ).empty();
                
                for ( var i = 0; i < data.movies.length; ++i )
                {
                    var option = $( '<option></option>' );
                    option.attr( 'value', data.movies[i].title );
                    $( "#datalist_search" ).append( $option );
                }
                    
            },
            error: function( xhr, status )
            {
                if( status !== null )
                    console.log( "Greška prilikom Ajax poziva: " + status );
            }
        } );
    } );
} );