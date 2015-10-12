var logs;
logs = function () {

    this.welcome = function welcome(paso) {
        // in WelcomeLogJob
    }

    this.joined = function joined(data) {
        ajax(data, 'joined');
    }

    this.requested = function requested(paso) {
        // in RequestedLogJob
    }

    this.loaded = function loaded(data) {
        console.log(data);
        ajax(data, 'loaded');
    }

    this.completed = function Completed(data) {
        console.log('presiono boton navegar');
        ajax(data, 'completed');
    }

    this.redirectOut = function redirectOut(url) {
        window.location.href = url;
    }

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

    this.saveMail = function saveMail(json_data){
        $.ajax({
            url: '/campaign/action/saveMail',
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
};