$(function(){
    resize();
});

$( window ).resize(resize);

function resize() {
    resizeBanner("#banner-vertical");
    resizeBanner("#banner-horizontal");

}

function resizeBanner(idBanner)
{
    var bannerImg = $( idBanner );
    bannerImg.height('auto');
    var imgHeight = bannerImg.height();

    var bottomHeight = $( ".bottom-container" ).height();
    var windowHeight = $( window ).height();
    if(imgHeight>windowHeight-bottomHeight)
    {
        bannerImg.height(windowHeight-bottomHeight);
    }
}