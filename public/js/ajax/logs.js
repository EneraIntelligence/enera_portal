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
        ajax(data, 'loaded');
    }

    this.completed = function metodoCompleted(token, link, paso) {
        console.log('presiono boton navegar');

        ajax(token, paso);
        //ajax('request', 'http://www.enera.mx');
        //cuando termina el ajax
        //redirectOut(link)
    }


    function redirectOut(url) {
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
};


//$("#navegarL").click(function() {
//    var url= $("#navegar").attr('data');
//    url="http://www."+url;
//    console.log(url);
//    window.location.href = url;
//});

//var url= $("#navegar").attr('data');
//                var token = $('input:hidden[name=_token]').val();
//                url="http://www.";
//                console.log(url);
//                window.location.href = url;
//{{--var link = 'enera.mx';--}}
//{{--var _token = '{!! csrf_token() !!}'--}}
/*var url= '/requested';
 var data = {_token: '{!! csrf_token() !!}'  , link:'{{$data['link']}}'}
 $.post(url,data,function (result) {
 console.log(result);
 });*/