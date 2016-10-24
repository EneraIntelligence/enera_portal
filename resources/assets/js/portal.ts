//how to import defiitelyTyped to compile 
// https://github.com/DefinitelyTyped/DefinitelyTyped

/// <reference path="typings/jquery.d.ts" />
/// <reference path="typings/materialize-css.d.ts" />
/// <reference path="typings/greensock.d.ts" />

module Enera
{
    export class Portal
    {
        private termsCheckbox:JQuery;
        private termsCard:Card;
        private welcomeCard:Card;
        private adsCard:Card;
        private btnCard:Card;
        private grantURL:string;

        constructor(grantAccessURL:string)
        {
            this.grantURL = grantAccessURL;
            console.log("url: "+this.grantURL);
        }

        setup():void
        {
            //initialize modals
            $('.modal-trigger').leanModal();


            TweenLite.set(".welcome-container", {perspective:500});
            TweenLite.set(".ads-container", {perspective:500});

            this.termsCheckbox = $("#terms-checkbox");

            this.termsCard = new Card($("#terms-card"));
            this.welcomeCard = new Card($("#welcome-card"));
            this.adsCard = new Card($("#ads-card"));
            this.btnCard = new BtnCard($("#btn-card"),this.clickInternet);
            this.btnCard.hideUp(.3);

            TweenLite.set("#ads-card",{display:'none'});
            TweenLite.set("#btn-card",{display:'none'});


            this.termsCheckbox.change(this.acceptedTerms);
        }

        private acceptedTerms=():void=>
        {

            TweenLite.to("#progress-bar",1, {width:"50%"});
            TweenLite.to("#step-2",.3, { delay:1, backgroundColor:"#2196F3"});
            TweenLite.to("#step-2-text",.3, { delay:1, color:"#2196F3"});
            TweenLite.to("#step-2",.5, { delay:1,  scale:1.1, ease:Elastic.easeOut});

            this.termsCard.hideUp(.3);
            setTimeout(
                this.welcomeCard.flipHide
            ,300);

            setTimeout(
                this.adsCard.flipShow
                ,600);

            setTimeout(
                this.btnCard.showUp
            ,1500,.3);

            setTimeout(
                this.btnCard.countDown
                ,1500,.3);
        }

        private clickInternet=():void=>
        {
            TweenLite.to("#progress-bar",1, {width:"100%"});

            TweenLite.to("#step-2",.3, { scale:1});

            TweenLite.to("#step-3",.3, { delay:1, backgroundColor:"#2196F3"});
            TweenLite.to("#step-3-text",.3, { delay:1, color:"#2196F3"});
            TweenLite.to("#step-3",.5, { delay:1,  scale:1.1, ease:Elastic.easeOut});

            this.btnCard.hideUp(.3);
            setTimeout(
                this.adsCard.flipHide
                ,300);

            setTimeout(
                function()
                {
                    TweenLite.set('.final-message',{opacity:0, display:"block"});
                    TweenLite.to('.final-message',.3,{opacity:1});

                }
                ,600);

            setTimeout(this.grantAccess
                ,1200);
        }

        public grantAccess=():void=>
        {
            // console.log("grant url: "+this.grantURL);
            window.location.href = this.grantURL;
        }

    }

    class Card
    {
        private cardHeight:number;
        private card:JQuery;

        constructor(card:JQuery)
        {
            this.card=card;
            this.cardHeight = card.outerHeight();
        }

        public hideUp=(time:number):void =>{
            TweenLite.to(this.card, time, {
                y: -this.cardHeight,
                ease: Quad.easeIn,
                onComplete: this.invisible
            });

        };

        public showUp=(time:number):void =>{

            this.visible();

            TweenLite.to(this.card, time, {
                y: 0,
                ease: Quad.easeOut,
            });
        };

        public flipHide=():void=>
        {
            TweenLite.to(this.card, .3, {
                rotationY: -90,
                ease: Quad.easeOut,
                onComplete: this.invisible
            });
        };

        public flipShow=():void=>
        {
            this.visible();
            TweenLite.fromTo(this.card, .3,
                {
                    rotationY: 90,

                },
                {
                rotationY: 0,
                ease: Quad.easeIn,
            });
        };

        private invisible=():void=>
        {
            this.card.css('display','none');
        };

        private visible=():void=>
        {
            this.card.css('display','block');
        }
    }

    class BtnCard extends Card
    {
        private btn:JQuery;
        private count:number;
        private btnAction;

        constructor(card:JQuery, btnAction:Function)
        {
            super(card);
            this.btnAction = btnAction;
        }

        public countDown=():void=>
        {
            this.btn = this.card.find(".btn");
            this.btn.text("Espera 5 segundos");
            this.count = 5;
            setTimeout(this.updateCountDown,1000);
        };

        private updateCountDown=():void=>
        {
            this.count--;
            if(this.count>0)
            {
                if(this.count>1)
                    this.btn.text("Espera "+this.count+" segundos");
                else
                    this.btn.text("Espera "+this.count+" segundo");

                setTimeout(this.updateCountDown,1000);
            }
            else
            {
                this.btn.text("Navegar en internet");
                this.btn.removeClass("disabled");
                this.btn.click(this.btnAction);

            }
        }
    }

}