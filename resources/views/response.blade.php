<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="JEISSON MANDON">
        <title>{{config('app.name')}}</title>
        <!-- core CSS -->
        <link href="{{asset('multi/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{asset('multi/css/font-awesome.min.css')}}" rel="stylesheet">
        <link href="{{asset('multi/css/animate.min.css')}}" rel="stylesheet">
        <link href="{{asset('multi/css/owl.carousel.css')}}" rel="stylesheet">
        <link href="{{asset('multi/css/owl.transitions.css')}}" rel="stylesheet">
        <link href="{{asset('multi/css/prettyPhoto.css')}}" rel="stylesheet">
        <link href="{{asset('multi/css/main.css')}}" rel="stylesheet">
        <link href="{{asset('multi/css/responsive.css')}}" rel="stylesheet">
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->       
        <link rel="shortcut icon" href="{{asset('img/logomi.png')}}">
    </head><!--/head-->
    <body id="home" class="homepage">
        <header id="header">
            <nav id="main-menu" class="navbar navbar-default navbar-fixed-top" role="banner">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('img/logo2.png')}}" alt="logo"></a>
                    </div>
                    <div class="collapse navbar-collapse navbar-right">
                        <ul class="nav navbar-nav">
                            <li class="scroll active"><a href="{{url('/')}}">Inicio</a></li>
                        </ul>
                    </div>
                </div><!--/.container-->
            </nav><!--/nav-->
        </header><!--/header-->
        <section id="blog">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title text-center wow fadeInDown">{{$titulo}}</h2>
                    <p class="text-center wow fadeInDown">{!!$mensaje!!}</p>
                </div>
            </div>
        </section>
        <footer id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        &copy; 2017 IASD. Todos los Derechos Reservados. Desarrollado por <a target="_blank" href="http://facebook.com/jorgejeisson" title="Facebook">Jeisson Mandon</a>
                    </div>
                    <div class="col-sm-6">
                        <ul class="social-icons">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                            <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                            <li><a href="#"><i class="fa fa-behance"></i></a></li>
                            <li><a href="#"><i class="fa fa-flickr"></i></a></li>
                            <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-github"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer><!--/#footer-->

        <script src="{{asset('multi/js/jquery.js')}}"></script>
        <script src="{{asset('multi/js/bootstrap.min.js')}}"></script>
        <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <script src="{{asset('multi/js/owl.carousel.min.js')}}"></script>
        <script src="{{asset('multi/js/mousescroll.js')}}"></script>
        <script src="{{asset('multi/js/smoothscroll.js')}}"></script>
        <script src="{{asset('multi/js/jquery.prettyPhoto.js')}}"></script>
        <script src="{{asset('multi/js/jquery.isotope.min.js')}}"></script>
        <script src="{{asset('multi/js/jquery.inview.min.js')}}"></script>
        <script src="{{asset('multi/js/wow.min.js')}}"></script>
        <script src="{{asset('multi/js/main.js')}}"></script>
    </body>
</html>