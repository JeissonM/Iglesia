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
                @if($n!==null)
                <div class="section-header">
                    <h2 class="section-title text-center wow fadeInDown">{{$n->titulo}}</h2>
                    <p class="text-center wow fadeInDown">ALCANCE: {{$n->tipo}}</p>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="blog-post blog-large wow fadeInLeft" data-wow-duration="300ms" data-wow-delay="0ms">
                            <article>
                                <header class="entry-header">
                                    <div class="entry-thumbnail">
                                        @if($n->imagen!='NO')
                                        <img class="img-responsive" src="{{asset('docs/anuncios/'.$n->imagen)}}" alt="">
                                        @endif
                                        <span class="post-format post-format-video"><i class="fa fa-bullhorn"></i></span>
                                    </div>
                                    <div class="entry-date">PUBLICADO: {{$n->created_at}}</div>
                                    <h2 class="entry-title"><a href="#">{{$n->titulo}}</a></h2>
                                </header>

                                <div class="entry-content">
                                    <p>{!!$n->contenido!!}</p>
                                </div>

                                <footer class="entry-meta">
                                    <span class="entry-author"><i class="fa fa-pencil"></i> <a href="#">{{$n->autor}}</a></span>
                                    <span class="entry-category"><i class="fa fa-folder-o"></i> <a href="#">
                                        @if($n->tipo=='LOCAL')
                                        {{$n->iglesia->nombre}}
                                        @endif
                                        @if($n->tipo=='DISTRITO')
                                        {{$n->distrito->nombre}}
                                        @endif
                                        @if($n->tipo=='ASOCIACION')
                                        {{$n->asociacion->nombre}}
                                        @endif
                                        </a></span>
                                    <span class="entry-comments"><i class="fa fa-comments-o"></i> <a href="#">0</a></span>
                                </footer>
                            </article>
                        </div>
                    </div><!--/.col-sm-6-->
                </div>
                @else
                <p style="color:red; font-size: 20px; font-weight: bold;">Anuncio no encontrada! <a href="{{url('/')}}">Regresar</a></p>
                @endif
            </div>
        </section>
        <footer id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        &copy; 2017 IASD. Todos los Derechos Reservados. Desarrollado por <a target="_blank" href="https://www.facebook.com/jorgejeisson" title="Facebook">Jeisson Mandon & Luis Quiróz</a>
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