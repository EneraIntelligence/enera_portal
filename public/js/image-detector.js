$(document).ready(function ()
{
    $( window ).resize(function() {
        imageSelector.update();
    });

    imageSelector.setup();
});

var imageSelector =
{
    setup:function()
    {

        $(".image-small").css("display","block");
        $(".image-large").css("display","none");

        $(".image-small").load( imageSelector.update );
    },
    update:function()
    {
        //console.log( $(window).height() );
        console.log( $(".image-small").height() );

        if($(".image-small").height()+200 < $(window).height())
        {
            $(".image-small").css("display","none");
            $(".image-large").css("display","block");
        }
        else
        {
            $(".image-small").css("display","block");
            $(".image-large").css("display","none");
        }
    }
};