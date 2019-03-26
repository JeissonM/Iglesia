<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>404 | {{config('app.name')}}</title>
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        <!-- Bootstrap Core Css -->
        <link href="{{asset('css/plugins/bootstrap/css/bootstrap.css')}}" rel="stylesheet">
        <!-- Waves Effect Css -->
        <link href="{{asset('css/plugins/node-waves/waves.css')}}" rel="stylesheet" />
        <!-- Custom Css -->
        <link href="{{asset('css/style.css')}}" rel="stylesheet">
    </head>
    <body class="four-zero-four">
        <div class="four-zero-four-container">
            <div class="error-code">404</div>
            <div class="error-message">Recurso no encontrado!</div>
            <div class="button-place">
                <a href="{{url()->previous()}}" class="btn btn-default btn-lg waves-effect"> REGRESAR</a>
            </div>
        </div>
        <!-- Jquery Core Js -->
        <script src="{{asset('js/jquery/jquery.min.js')}}"></script>
        <!-- Bootstrap Core Js -->
        <script src="{{asset('js/bootstrap/js/bootstrap.js')}}"></script>
        <!-- Waves Effect Plugin Js -->
        <script src="{{asset('js/node-waves/waves.js')}}"></script>
    </body>
</html>                            