var logs;
logs = function () {

    this.welcome = function welcome(paso) {
        // in WelcomeLogJob
    };

    this.joined = function joined(data) {
        ajax(data, 'joined');
    };

    this.requested = function requested(paso) {
        // in RequestedLogJob
    };

    this.loaded = function loaded(data) {
        console.log(data);
        ajax(data, 'loaded');
    };

    this.completed = function Completed(data, success_callback, fail_callback){
        console.log('presionó botón navegar');

        var url= '/interaction/logs/completed';
        ajaxWithCallback(data,url,success_callback,fail_callback);
    };

    this.redirectOut = function redirectOut(url) {
        window.location.href = url;
    };

    function ajax(json_data, paso) {
        $.ajax({
            url: '/interaction/logs/' + paso,
            type: 'POST',
            dataType: 'JSON',
            data: json_data
        }).done(function (data) {
            console.log("success");
            console.log(data);
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        }).always(function () {
            console.log("complete-");
        });
    }

    this.saveMail = function saveMail(json_data, success_callback, fail_callback){
        var saveMailURL = '/campaign/action/saveMail';
        ajaxWithCallback(json_data, saveMailURL, success_callback, fail_callback);
    };

    this.saveUserLike = function saveUserLike(json_data, success_callback, fail_callback){
        var saveLikeURL = '/campaign/action/saveUserLike';
        ajaxWithCallback(json_data, saveLikeURL, success_callback, fail_callback);
    };

    function ajaxWithCallback(json_data, url, success_callback, fail_callback){
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'JSON',
            data: json_data
        }).done(function (data) {
            success_callback();
        }).fail(function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            fail_callback();
        });
    }
};