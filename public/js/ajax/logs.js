var logs;
logs = function () {

    this.welcome = function welcome(paso) {

    }

    this.joined = function joined(paso) {

    }

    this.requested = function requested(paso) {

    }

    this.loaded = function loaded(token,paso) {
        console.log('->cargado');
        console.log(paso);
        ajax(token,paso);
    }

    this.completed = function metodoCompleted(token,link,paso) {
        console.log('presiono boton navegar');

        ajax(token,paso);
        //ajax('request', 'http://www.enera.mx');
        //cuando termina el ajax
        //redirectOut(link)
    }


    function redirectOut(url) {
        window.location.href = url;
    }

    function ajax(token,paso) {
        var request;
        request = $.ajax({
            url: '/interaction/logs/'+paso,
            type: 'POST',
            dataType: 'JSON',
            data: {_token:token,entro:'entro' }
        });
        request.done(function (data) {
            console.log("success");
            console.log(data);

            //window.location.href ='http://www.enera.mx'
            //redirectOut(url);
        })
        request.fail(function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
        })
        request.always(function () {
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