<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }
            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <style>
            #container {
                min-width:300px;
                min-height:200px;
                border:3px dashed #000;
            }
        </style>
        <div id='container'></div>
        <script>
            function addDNDListener(obj){
                obj.addEventListener('dragover',function(e){
                    e.preventDefault();
                    e.stopPropagation();
                },false);
                obj.addEventListener('dragenter',function(e){
                    e.preventDefault();
                    e.stopPropagation();
                },false);

                obj.addEventListener('drop',function(e){
                    e.preventDefault();
                    e.stopPropagation();
                    var ul = document.createElement("ul");
                    var fileList = e.dataTransfer.files;
                    for(var i=0;i<fileList.length;i++){
                        var file = fileList[i];
                        var li = document.createElement('li');
                        li.innerHTML = '<label id="'+file.name+'">'+file.name+':</label><progress value="0"max="100"></progress>';
                        ul.appendChild(li);
                    }
                    document.getElementById('container').appendChild(ul);
                    for(var i=0;i<fileList.length;i++){
                        var file = fileList[i];
                        uploadFile(file);
                    }
                },false);
            }
            function uploadFile(file){
                var chunk = 8*1024*1024;
                var progress = document.getElementById(file.name).nextSibling;
                var reader = new FileReader();
                reader.readAsArrayBuffer(file);
                reader.onloadstart = function (e) {

                };
                reader.onprogress = function(e){
                    progress.value = (e.loaded/e.total) * 100;
                };
                reader.onload = function(e){
                    var start = 0;
                    var chunks = [];
                    var buf = new Int8Array(e.target.result);

                    for (var i = 0; i < Math.ceil(e.total/chunk); i++) {
                        var end = start + chunk;
                        chunks[i] = buf.slice(start,end);
                        start = end;
                    }

                    var query = {
                        fileName: new Date().getTime(),
                        fileSize: e.total,
                        dataSize: chunk,
                        extend: chunk
                    };

                    var queryStr = Object.getOwnPropertyNames(query).map( key => {
                        return key + "=" + query[key];
                }).join("&");

                    var xhr = new XMLHttpRequest();
                    // xhr.timeout = 90000;

                    for (var j = 0; j < chunks.length;j++){
                        if (j === 0 || xhr.status === 200){
                            xhr.open("POST", "/welcome/test?="+queryStr+"&num="+j,false);
                            xhr.setRequestHeader("X-CSRF-TOKEN","{{ csrf_token()}}");
                            xhr.send(chunks[j]);
                            console.log(j);
                            console.log(xhr.status);
                        }else {
                            console.log("失败");
                        }
                    }
                };
            }
            window.onload = function(){
                addDNDListener(document.getElementById('container'));
            };
        </script>
        {{--<div class="flex-center position-ref full-height">--}}
            {{--@if (Route::has('login'))--}}
                {{--<div class="top-right links">--}}
                    {{--@auth--}}
                        {{--<a href="{{ url('/home') }}">Home</a>--}}
                    {{--@else--}}
                        {{--<a href="{{ route('login') }}">Login</a>--}}
                        {{--<a href="{{ route('register') }}">Register</a>--}}
                    {{--@endauth--}}
                {{--</div>--}}
            {{--@endif--}}

            {{--<div class="content">--}}
                {{--<div class="title m-b-md">--}}
                    {{--Laravel--}}
                {{--</div>--}}

                {{--<div class="links">--}}
                    {{--<a href="https://laravel.com/docs">Documentation</a>--}}
                    {{--<a href="https://laracasts.com">Laracasts</a>--}}
                    {{--<a href="https://laravel-news.com">News</a>--}}
                    {{--<a href="https://forge.laravel.com">Forge</a>--}}
                    {{--<a href="https://github.com/laravel/laravel">GitHub</a>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    </body>
</html>
