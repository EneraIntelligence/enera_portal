//how to import defiitelyTyped to compile 
// https://github.com/DefinitelyTyped/DefinitelyTyped
var __extends = (this && this.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
};
/// <reference path="typings/jquery.d.ts" />
/// <reference path="typings/materialize-css.d.ts" />
/// <reference path="typings/greensock.d.ts" />
var Enera;
(function (Enera) {
    var Portal = (function () {
        function Portal(grantAccessURL) {
            var _this = this;
            this.acceptedTerms = function () {
                TweenLite.to("#progress-bar", 1, { width: "50%" });
                TweenLite.to("#step-2", .3, { delay: 1, backgroundColor: "#2196F3" });
                TweenLite.to("#step-2-text", .3, { delay: 1, color: "#2196F3" });
                TweenLite.to("#step-2", .5, { delay: 1, scale: 1.1, ease: Elastic.easeOut });
                _this.termsCard.hideUp(.3);
                setTimeout(_this.welcomeCard.flipHide, 300);
                setTimeout(_this.adsCard.flipShow, 600);
                setTimeout(_this.btnCard.showUp, 1500, .3);
                setTimeout(_this.btnCard.countDown, 1500, .3);
            };
            this.clickInternet = function () {
                TweenLite.to("#progress-bar", 1, { width: "100%" });
                TweenLite.to("#step-2", .3, { scale: 1 });
                TweenLite.to("#step-3", .3, { delay: 1, backgroundColor: "#2196F3" });
                TweenLite.to("#step-3-text", .3, { delay: 1, color: "#2196F3" });
                TweenLite.to("#step-3", .5, { delay: 1, scale: 1.1, ease: Elastic.easeOut });
                _this.btnCard.hideUp(.3);
                setTimeout(_this.adsCard.flipHide, 300);
                setTimeout(function () {
                    TweenLite.set('.final-message', { opacity: 0, display: "block" });
                    TweenLite.to('.final-message', .3, { opacity: 1 });
                }, 600);
                setTimeout(_this.grantAccess, 1200);
            };
            this.grantAccess = function () {
                // console.log("grant url: "+this.grantURL);
                window.location.href = _this.grantURL;
            };
            this.grantURL = grantAccessURL;
            console.log("url: " + this.grantURL);
        }
        Portal.prototype.setup = function () {
            //initialize modals
            $('.modal-trigger').leanModal();
            TweenLite.set(".welcome-container", { perspective: 500 });
            TweenLite.set(".ads-container", { perspective: 500 });
            this.termsCheckbox = $("#terms-checkbox");
            this.termsCard = new Card($("#terms-card"));
            this.welcomeCard = new Card($("#welcome-card"));
            this.adsCard = new Card($("#ads-card"));
            this.btnCard = new BtnCard($("#btn-card"), this.clickInternet);
            this.btnCard.hideUp(.3);
            TweenLite.set("#ads-card", { display: 'none' });
            TweenLite.set("#btn-card", { display: 'none' });
            this.termsCheckbox.change(this.acceptedTerms);
        };
        return Portal;
    }());
    Enera.Portal = Portal;
    var Card = (function () {
        function Card(card) {
            var _this = this;
            this.hideUp = function (time) {
                TweenLite.to(_this.card, time, {
                    y: -_this.cardHeight,
                    ease: Quad.easeIn,
                    onComplete: _this.invisible
                });
            };
            this.showUp = function (time) {
                _this.visible();
                TweenLite.to(_this.card, time, {
                    y: 0,
                    ease: Quad.easeOut
                });
            };
            this.flipHide = function () {
                TweenLite.to(_this.card, .3, {
                    rotationY: -90,
                    ease: Quad.easeOut,
                    onComplete: _this.invisible
                });
            };
            this.flipShow = function () {
                _this.visible();
                TweenLite.fromTo(_this.card, .3, {
                    rotationY: 90
                }, {
                    rotationY: 0,
                    ease: Quad.easeIn
                });
            };
            this.invisible = function () {
                _this.card.css('display', 'none');
            };
            this.visible = function () {
                _this.card.css('display', 'block');
            };
            this.card = card;
            this.cardHeight = card.outerHeight();
        }
        return Card;
    }());
    var BtnCard = (function (_super) {
        __extends(BtnCard, _super);
        function BtnCard(card, btnAction) {
            var _this = this;
            _super.call(this, card);
            this.countDown = function () {
                _this.btn = _this.card.find(".btn");
                _this.btn.text("Espera 5 segundos");
                _this.count = 5;
                setTimeout(_this.updateCountDown, 1000);
            };
            this.updateCountDown = function () {
                _this.count--;
                if (_this.count > 0) {
                    if (_this.count > 1)
                        _this.btn.text("Espera " + _this.count + " segundos");
                    else
                        _this.btn.text("Espera " + _this.count + " segundo");
                    setTimeout(_this.updateCountDown, 1000);
                }
                else {
                    _this.btn.text("Navegar en internet");
                    _this.btn.removeClass("disabled");
                    _this.btn.click(_this.btnAction);
                }
            };
            this.btnAction = btnAction;
        }
        return BtnCard;
    }(Card));
})(Enera || (Enera = {}));
//# sourceMappingURL=portal.js.map