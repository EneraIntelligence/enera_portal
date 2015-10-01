var logs;
logs = function () {

    this.welcome = function welcome() {

    }

    this.joined = function joined() {

    }

    this.requested = function requested() {

    }

    this.loaded = function loaded() {
        console.log('cargado');
        //ajax(data);
    }

    this.completed = function metodoCompleted(link) {
        console.log('presiono boton navegar');

        //ajax(data);
        //ajax('request', 'http://www.enera.mx');
        //cuando termina el ajax
        redirectOut(link)
    }


    function redirectOut(url) {
        window.location.href = url;
    }

    function ajax(data) {
        var request;
        request = $.ajax({
            url: '/requested',
            type: 'POST',
            dataType: 'JSON',
            data: {_token: '{!! csrf_token() !!}', link: "{{ $data['link']}}", body: 'body', valor3: 'valor3'}
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