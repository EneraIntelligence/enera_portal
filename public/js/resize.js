$(function(){
    resize();
});

$( window ).resize(resize);

function resize() {
    resizeBanner("#banner-vertical");
    resizeBanner("#banner-horizontal");

    setButtonToBottom("#navegar");
}

function setButtonToBottom(buttonId)
{
    var portalContentHeight = $("#portal_content").height();
    console.log("portalContentHeight: "+portalContentHeight);

}
/*
//not used anymore
function resizeBanner(idBanner)
{
    var bannerImg = $( idBanner );
    bannerImg.height('auto');
    var imgHeight = bannerImg.height();

    if(imgHeight==0)
    {
        console.log("component not loaded, retry resizing: "+idBanner)
        //image not loaded, retry resizing
        setTimeout(function()
        {
            resizeBanner(idBanner);
        },100);
    }
    else
    {
        var bottomHeight = $( ".bottom-container" ).height();
        var windowHeight = $( window ).height();
        if(imgHeight>windowHeight-bottomHeight)
        {
            bannerImg.height(windowHeight-bottomHeight);
        }

        console.log("component resized: "+idBanner)
    }

}*/