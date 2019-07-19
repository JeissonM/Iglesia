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

    <body id="home" class="homepage" style="color: #000000;">

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
                        <a class="navbar-brand" href="{{config('app.url')}}"><img src="{{asset('img/logo2.png')}}" alt="logo"  width="150"></a>
                    </div>

                    <div class="collapse navbar-collapse navbar-right">
                        <ul class="nav navbar-nav">
                            <li class="scroll active"><a href="#main-slider">Inicio</a></li>
                            <li class="scroll"><a href="#features">Institucional</a></li>
                            <li class="scroll"><a href="#portfolio">Jardín de Oración</a></li>
                            <li class="scroll"><a href="#about">Directorio Iglesias</a></li>
                            <li class="scroll"><a href="#meet-team">Recursos Ministeriales</a></li>
                            <li class="scroll"><a href="#pricing">Cronograma Eventos</a></li>
                            <li class="scroll"><a href="#blog">Encuentre una Iglesia</a></li>                       
                        </ul>
                    </div>
                </div><!--/.container-->
            </nav><!--/nav-->
        </header><!--/header-->

        <section id="main-slider">
            <div class="owl-carousel">
                @if($anuncios!=null)
                @foreach($anuncios as $a)
                <div class="item" style="background-image: url({{asset('docs/anuncios/'.$a['anuncio']->imagen)}});">
                    <div class="slider-inner">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="carousel-content">
                                        <h2><span>Atención</span> {{$a['anuncio']->titulo}}</h2>
                                        <p>{{$a['relacion'][0]->nombre}}</p>
                                        <a class="btn btn-primary btn-lg" href="{{route('anuncio',$a['anuncio']->id)}}">Leer más...</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.item-->
                @endforeach
                @endif
            </div><!--/.owl-carousel-->
        </section><!--/#main-slider-->

        <section id="cta" class="wow fadeIn">
            <div class="container">
                <div class="row">
                    <div class="col-sm-9">
                        <h2>Nuestras Creencias</h2>
                        <p>Las creencias adventistas tienen el propósito de impregnar toda la vida. Surgen a partir de escrituras que presentan un retrato convincente de Dios, y nos invitan a explorar, experimentar y conocer a Aquel que desea restaurarnos a la plenitud.</p>
                    </div>
                    <div class="col-sm-3 text-right">
                        <a class="btn btn-primary btn-lg" href="{{route('creencias')}}">Leer más...</a>
                    </div>
                </div>
            </div>
        </section><!--/#cta-->

        <section id="features">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title text-center wow fadeInDown">INSTITUCIONAL</h2>
                    <p class="text-center wow fadeInDown">Conozca nuestra historia, misión, visión y los valores de nuestra organisación.</p>
                </div>
                <div class="row">
                    <div class="col-sm-6 wow fadeInLeft">
                        <img class="img-responsive" src="{{asset('multi/images/main-feature.png')}}" alt="">
                    </div>
                    <div class="col-sm-6">
                        <div class="media service-box wow fadeInRight">
                            <div class="pull-left">
                                <i class="fa fa-history"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Historia</h4>
                                <p>Conozca la historia de la iglesia adventista del séptimo día, descubra el origen de sus creencias y el simiento que la sostiene.</p>
                            </div>
                        </div>

                        <div class="media service-box wow fadeInRight">
                            <div class="pull-left">
                                <i class="fa fa-cubes"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Misión</h4>
                                <p>Enterese de la misión que tiene nuestra organización y su compromiso con la humanidad.</p>
                            </div>
                        </div>

                        <div class="media service-box wow fadeInRight">
                            <div class="pull-left">
                                <i class="fa fa-eye-slash"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Visión</h4>
                                <p>Cada miembro del cuerpo de Cristo, preparado para el reino de Dios.</p>
                            </div>
                        </div>

                        <div class="media service-box wow fadeInRight">
                            <div class="pull-left">
                                <i class="fa fa-list-alt"></i>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">Valores</h4>
                                <p>Los valores muestran el prodecer de una organización, conozca la nuestra!</p>
                            </div>
                        </div>

                        <div class="media service-box wow fadeInRight">
                            <div class="pull-left">
                                <i class="fa fa-link"></i>
                            </div>
                            <div class="media-body">
                                <a class="btn btn-primary btn-lg" href="{{route('institucionalp')}}">Leer más...</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="portfolio">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title text-center wow fadeInDown">JARDÍN DE ORACIÓN</h2>
                    <p class="text-center wow fadeInDown">Realiza tu pedido de oración y ten por seguro que oraremos por tí. <br> Puedes revisar el estado de tu pedido de oración.</p>
                </div>

                <div class="text-center">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <h2>Hacer Pedido de Oración</h2>
                            <form name="contact-form" method="POST" action="{{route('hacerpedido')}}">
                                @csrf 
                                <div class="form-group">
                                    <input type="text" name="persona" class="form-control" placeholder="Nombres y apellidos" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="correo" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <textarea name="pedido" class="form-control" rows="8" placeholder="Mensaje" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Enviar Pedido</button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <h2>Rastrear Pedido de Oración</h2>
                            <form method="POST" action="{{route('consultarpedido')}}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" name="id" class="form-control" placeholder="Escriba el ID para rastrear su pedido" required>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">Consultar el estado de su pedido</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!--/.container-->
        </section><!--/#portfolio-->

        <section id="about">
            <div class="container">

                <div class="section-header">
                    <h2 class="section-title text-center wow fadeInDown">Directorio de Iglesias</h2>
                    <p class="text-center wow fadeInDown">Conozca las iglesias adventistas mas cercanas</p>
                </div>

                <div class="row">
                    <div class="col-md-12 wow fadeInRight">
                        <div class="table-responsive">
                            <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed dataTable js-exportable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>NOMBRE</th>
                                        <th>CIUDAD</th>
                                        <th>DISTRITO</th>
                                        <th>TIPO</th>
                                        <th>CORREO</th>
                                        <th>SITIO WEB</th>
                                        <th>PASTOR</th>
                                        <th>ESTADO</th>
                                    </tr>
                                </thead>
                                <tbody id='tb2'>
                                    @foreach($iglesias as $d)
                                    <tr>
                                        <td>{{$d->nombre}}</td>
                                        <td>{{$d->ciudad[0]->nombre}}</td>
                                        <td>{{$d->distrito[0]->nombre}}</td>
                                        <td>{{$d->tipo}}</td>
                                        <td>{{$d->email}}</td>
                                        <td>{{$d->sitioweb}}</td>
                                        <td>{{$d->pastor}}</td>
                                        <td>
                                            @if($d->activa=='1')
                                            <label class="label label-success">ACTIVA</label>
                                            @else
                                            <label class="label label-danger">INACTIVA</label>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section><!--/#about-->

        <section id="work-process">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title text-center wow fadeInDown">Últimos Ministerios Registrados</h2>
                    <p class="text-center wow fadeInDown">Los ministerios no oficiales de la Iglesia publican sus actividades y materiales <br> que puede observar desde acá, visualice los últimos ministerios registrados a continuación...</p>
                </div>

                <div class="row text-center">
                    @if(count($ministerios)>0)
                    <?php
                    $i = 1;
                    ?>
                    @foreach($ministerios as $m)
                    <div class="col-md-2 col-md-4 col-xs-6">
                        <div class="wow fadeInUp" data-wow-duration="400ms" data-wow-delay="0ms">
                            <div class="icon-circle">
                                <span>{{$i}}</span>
                                <i class="fa fa-folder-open fa-2x"></i>
                            </div>
                            <h3>{{$m->nombre}}</h3>
                        </div>
                    </div>
                    <?php
                    $i = $i + 1;
                    ?>
                    @endforeach
                    @endif
                </div>
            </div>
        </section><!--/#work-process-->

        <section id="meet-team">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title text-center wow fadeInDown">RECURSOS Y MULTIMEDIA MINISTERIAL</h2>
                    <p class="text-center wow fadeInDown">Encuentre evidencias de las actividades, eventos, encuentre noticias,<br> recursos multimedia, entre muchos otros recursos publicados por los ministerios no oficiales de la Iglesia.</p>
                </div>

                <div class="row">
                    @if(count($ministerios2)>0)
                    @foreach($ministerios2 as $m2)
                    <div class="col-sm-6 col-md-3">
                        <div class="team-member wow fadeInUp" data-wow-duration="400ms" data-wow-delay="0ms">
                            <div class="team-img">
                                <img class="img-responsive" src="{{asset('img/banner01.jpg')}}" alt="">
                            </div>
                            <div class="team-info">
                                <h3>{{$m2->nombre}}</h3>
                            </div>
                            <p>{{$m2->descripcion}}</p>
                            <ul class="social-icons">
                                <li><a href="{{route('minextraver',$m2->id)}}"><i class="fa fa-arrow-right"></i></a></li>

                            </ul>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>

                <div class="divider"></div>
            </div>
        </section><!--/#meet-team-->

        <section id="pricing">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title text-center wow fadeInDown">Calendario de Eventos (Agenda Asociación)</h2>
                    <p class="text-center wow fadeInDown">Documento que contiene la programación de trabajo para un período ecleciástico.</p>
                </div>

                <div class="row">
                    <div class="col-md-12 wow fadeInRight">
                        <div class="table-responsive">
                            <table id="tabla" class="table table-bordered table-striped table-hover table-responsive table-condensed dataTable js-exportable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>DOCUMENTO</th>
                                        <th>ASOCIACIÓN</th>
                                        <th>PERÍODO</th>
                                        <th>DESCARGAR/VER</th>
                                    </tr>
                                </thead>
                                <tbody id='tb2'>
                                    @foreach($agendas as $a)
                                    <tr>
                                        <td>{{$a->documento}}</td>
                                        <td>{{$a->asociacion[0]->nombre}}</td>
                                        <td>{{$a->periodo[0]->etiqueta}}</td>
                                        <td><a target="_blank" href="{{asset('docs/agenda/'.$a->documento)}}">DESCARGAR/VER</a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section><!--/#pricing-->

        <section id="blog">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title text-center wow fadeInDown">Encuentre una Iglesia</h2>
                    <p class="text-center wow fadeInDown">Seleccione ciudad y encuentre las iglesias que se encuentran allí, posteriormente seleccione una para visualizarla en el mapa y si desea puede planificar una ruta.</p>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label class="control-label">Ciudad de Ubicación</label>
                                <select class="form-control  select2"  style="width: 100%;" required="required" id="ciudad" name="ciudad_id" onchange="getIglesias()"/>
                                <option value="">--Seleccione una opción--</option>
                                @foreach($ciudades as $c)
                                <option value="{{$c->id}}">{{$c->nombre."  -  PAÍS: ".$c->pais[0]->nombre}}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="form-line">
                                <label class="control-label">Iglesia</label>
                                <select class="form-control  select2"  style="width: 100%;" onchange="mapa()" required="required" id="iglesia"/>
                                <option value="">--Seleccione una opción--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12" id="mapa"></div>
                </div>

            </div>
        </section>

        <section id="get-in-touch">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title text-center wow fadeInDown">Ingresar al sistema</h2>
                    <p class="text-center wow fadeInDown"><a class="btn btn-floating btn-lg btn-default" href="{{route('login')}}">Iniciar Sesión</a></p>
                </div>
            </div>
        </section><!--/#get-in-touch-->

        <footer id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        &copy; 2017 - 2019 IASD. Iglesia Adventista del Séptimo Día, Todos los Derechos Reservados. Desarrollado por <a target="_blank" href="https://www.facebook.com/jorgejeisson" title="Facebook">Jeisson Mandon & Luis Quiróz</a>
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
        <script type="text/javascript">

                                    var ciudades = null;

                                    function getIglesias() {
                                        var id = $("#ciudad").val();
                                        var url = "<?php config('app.url'); ?>";
                                        $.ajax({
                                            type: 'GET',
                                            url: url + "ciudadp/" + id + "/iglesia",
                                            data: {},
                                        }).done(function (msg) {
                                            $('#iglesia option').each(function () {
                                                $(this).remove();
                                            });
                                            var m = JSON.parse(msg);
                                            if (m.error != "SI") {
                                                ciudades = null;
                                                ciudades = m.data;
                                                $.each(m.data, function (index, item) {
                                                    $("#iglesia").append("<option value='" + item.id + "'>" + item.nombre + "</option>");
                                                });
                                            } else {
                                                alert('Atención: ' + m.mensaje);
                                            }
                                        });
                                    }

                                    function mapa() {
                                        $("#mapa").html("");
                                        var i = $("#iglesia").val();
                                        var mapa = null;
                                        $.each(ciudades, function (index, item) {
                                            if (item.id == i) {
                                                if (item.iglesiamapa != null) {
                                                    mapa = item.iglesiamapa.mapa;
                                                }
                                            }
                                        });
                                        if (mapa != null) {
                                            $("#mapa").html(mapa);
                                        } else {
                                            alert("No hay mapa para la iglesia seleccionada.");
                                        }
                                    }
        </script>
    </body>
</html>