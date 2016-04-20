$(document).ready(function ()
{
    //inicializacion de modales
    $('.modal-trigger').leanModal();

    welcome.setup();
    $("#terms-checkbox").change(welcome.acceptedTerms);
});

welcome = {
    setup: function ()
    {
        var termsCard = $("#terms-card");
        var loginCard = $("#login-card");
        var dif = loginCard.outerHeight()-termsCard.outerHeight();

        termsCard.css("margin-bottom",20+dif);
    },
    acceptedTerms: function ()
    {
        var termsCard = $("#terms-card");
        var cardHeight = termsCard.outerHeight();
        TweenLite.to(termsCard, .3, {
            y: -cardHeight,
            ease: Quad.easeIn,
            onComplete: welcome.showLoginButtons
        });
    },
    showLoginButtons: function ()
    {
        var loginCard = $("#login-card");
        var cardHeight = loginCard.outerHeight();

        var termsCard = $("#terms-card");

        //show hide termsCard and show login card
        termsCard.css("display", "none");
        loginCard.css("display", "block");

        TweenLite.fromTo(loginCard, .3,
            {
                y: -cardHeight
            },
            {
                y: 0,
                ease: Quad.easeOut
            }
        );
    }
};