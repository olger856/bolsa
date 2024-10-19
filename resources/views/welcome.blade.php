<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Laravel</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">


  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="#" class="logo d-flex align-items-center me-auto">
        <img src="images/logo2.png" alt="">
        <h1 class="sitename">Ofertas Laborales</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
            <li><a href="{{ url('/') }}#hero" class="active">Inicio</a></li>
            <li><a href="{{ url('/') }}#about">Nosotros</a></li>
            <li><a href="{{ url('/') }}#features">Características</a></li>
            <li><a href="{{ url('/') }}#services">Servicios</a></li>

            @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="navbar-login">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="navbar-login">Iniciar Sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="navbar-login">Registrarse</a>
                        @endif
                    @endauth
                @endif
        </ul>

        <!-- Icon for mobile menu toggle -->
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>

        <!-- Authentication Links -->
    </nav>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">
      <div class="hero-bg">
        <img src="assets/img/hero-bg-light.webp" alt="">
      </div>
      <div class="container text-center">
        <div class="d-flex flex-column justify-content-center align-items-center">
          <h1 data-aos="fade-up">Ven y busca tus mejores<span>OFERTAS LABORALES</span></h1>
          <p data-aos="fade-up" data-aos-delay="100">Ve por un buen camino<br></p>
          <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
            <a href="https://youtu.be/WwYSOuSZB8g?si=qfLk7Wm7n3XMi29o" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>
          </div>
          <img src="assets/img/hero-services-img.webp" class="img-fluid hero-img" alt="" data-aos="zoom-out" data-aos-delay="300">
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- Featured Services Section -->
    <section id="featured-services" class="featured-services section light-background">

      <div class="container">

        <div class="row gy-4">

          <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <div class="service-item d-flex">
              <div class="icon flex-shrink-0"><i class="bi bi-briefcase"></i></div>
              <div>
                <h4 class="title"><a href="#" class="stretched-link">Un trabajo hecho a tu mano</a></h4>
                <p class="description">un trabajo que esta hecho a tu medida que esperas</p>
              </div>
            </div>
          </div>
          <!-- End Service Item -->

          <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="200">
            <div class="service-item d-flex">
              <div class="icon flex-shrink-0"><i class="bi bi-card-checklist"></i></div>
              <div>
                <h4 class="title"><a href="#" class="stretched-link">Escoge tu mejor oferta</a></h4>
                <p class="description">Todo esta a la palma de tu mano para un mejor futuro</p>
              </div>
            </div>
          </div><!-- End Service Item -->


        </div>

      </div>

    </section><!-- /Featured Services Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container">

        <div class="row gy-4">

            <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                <p class="who-we-are">Quiénes Somos</p>
                <h3>Desatando el Potencial con Estrategia Creativa</h3>
                <p class="fst-italic">
                    En nuestra plataforma, conectamos talento con oportunidades, facilitando el camino hacia el éxito profesional.
                </p>
                <ul>
                    <li><i class="bi bi-check-circle"></i> <span>Ofrecemos oportunidades laborales en diversas industrias.</span></li>
                    <li><i class="bi bi-check-circle"></i> <span>Nos comprometemos a proporcionar un servicio de calidad tanto a empleadores como a solicitantes de empleo.</span></li>
                </ul>
                <a href="#" class="read-more"><span>Leer Más</span><i class="bi bi-arrow-right"></i></a>
            </div>


          <div class="col-lg-6 about-images" data-aos="fade-up" data-aos-delay="200">
            <div class="row gy-4">
              <div class="col-lg-6">
                <img src="assets/img/about-company-1.jpg" class="img-fluid" alt="">
              </div>
              <div class="col-lg-6">
                <div class="row gy-4">
                  <div class="col-lg-12">
                    <img src="assets/img/about-company-2.jpg" class="img-fluid" alt="">
                  </div>
                  <div class="col-lg-12">
                    <img src="assets/img/about-company-3.jpg" class="img-fluid" alt="">
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>

      </div>
    </section><!-- /About Section -->

    <!-- Features Section -->
    <section id="features" class="features section">

            <!-- Título de la Sección -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Características</h2>
            <p>Descubre cómo nuestras funciones pueden ayudarte a encontrar el trabajo ideal y a conectar con empleadores destacados.</p>
        </div><!-- Fin del Título de la Sección -->


      <div class="container">
        <div class="row justify-content-between">

          <div class="col-lg-5 d-flex align-items-center">

            <ul class="nav nav-tabs" data-aos="fade-up" data-aos-delay="100">
                <li class="nav-item">
                    <a class="nav-link active show" data-bs-toggle="tab" data-bs-target="#features-tab-1">
                        <i class="bi bi-binoculars"></i>
                        <div>
                            <h4 class="d-none d-lg-block">Búsqueda de Empleo</h4>
                            <p>
                                Encuentra oportunidades laborales que se ajusten a tus habilidades y aspiraciones profesionales.
                            </p>
                        </div>
                    </a>
                </li>
            </ul><!-- Fin de la Navegación por Pestañas -->


          </div>

          <div class="col-lg-6">

            <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

              <div class="tab-pane fade active show" id="features-tab-1">
                <img src="assets/img/tabs-1.jpg" alt="" class="img-fluid">
              </div><!-- End Tab Content Item -->

              <div class="tab-pane fade" id="features-tab-2">
                <img src="assets/img/tabs-2.jpg" alt="" class="img-fluid">
              </div><!-- End Tab Content Item -->

              <div class="tab-pane fade" id="features-tab-3">
                <img src="assets/img/tabs-3.jpg" alt="" class="img-fluid">
              </div><!-- End Tab Content Item -->
            </div>

          </div>

        </div>

      </div>

    </section><!-- /Features Section -->

    <!-- Features Details Section -->
    <section id="features-details" class="features-details section">

      <div class="container">

        <div class="row gy-4 justify-content-between features-item">

          <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
            <img src="assets/img/features-1.jpg" class="img-fluid" alt="">
          </div>

          <div class="col-lg-5 d-flex align-items-center" data-aos="fade-up" data-aos-delay="200">
            <div class="content">
                <h3>Oportunidades para Crecer Profesionalmente</h3>
                <p>
                    Conectamos a los candidatos con empleadores que valoran el talento y la dedicación. Nuestro objetivo es facilitar el proceso de búsqueda de empleo y ayudar a los profesionales a alcanzar sus metas.
                </p>
                <a href="#" class="btn more-btn">Más Información</a>
            </div>
        </div>


        </div><!-- Features Item -->

        <div class="row gy-4 justify-content-between features-item">

          <div class="col-lg-5 d-flex align-items-center order-2 order-lg-1" data-aos="fade-up" data-aos-delay="100">

            <div class="content">
                <h3>Conéctate con Empleadores de Calidad</h3>
                <p>
                    Facilitamos la conexión entre candidatos y empleadores, asegurando que cada oportunidad se ajuste a tus habilidades y aspiraciones.
                </p>
                <ul>
                    <li><i class="bi bi-easel flex-shrink-0"></i> Ofertas laborales en diversas industrias.</li>
                </ul>
                <p></p>
                <a href="#" class="btn more-btn">Más Información</a>
            </div>

          </div>

          <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="200">
            <img src="assets/img/features-2.jpg" class="img-fluid" alt="">
          </div>

        </div><!-- Features Item -->

      </div>

    </section><!-- /Features Details Section -->

    <!-- Services Section -->
    <section id="services" class="services section light-background">

        <!-- Título de la Sección -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Servicios</h2>
            <p>Descubre cómo nuestras soluciones pueden ayudarte a encontrar el empleo ideal y a conectar con empleadores destacados.</p>
        </div><!-- Fin del Título de la Sección -->

        <div class="container">

            <div class="row g-5">

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item item-cyan position-relative">
                        <i class="bi bi-activity icon"></i>
                        <div>
                            <h3>Búsqueda Personalizada</h3>
                            <p>Encuentra oportunidades laborales que se ajusten a tus habilidades y aspiraciones profesionales.</p>
                            <a href="#" class="read-more stretched-link">Más Información <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div><!-- Fin del Servicio -->

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item item-orange position-relative">
                        <i class="bi bi-broadcast icon"></i>
                        <div>
                            <h3>Proceso de Selección</h3>
                            <p>Te guiamos a través de cada etapa del proceso de selección, asegurando que estés preparado para cada entrevista.</p>
                            <a href="#" class="read-more stretched-link">Más Información <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div><!-- Fin del Servicio -->

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-item item-teal position-relative">
                        <i class="bi bi-easel icon"></i>
                        <div>
                            <h3>Desarrollo Profesional</h3>
                            <p>Ofrecemos recursos y consejos para ayudarte a crecer profesionalmente y alcanzar tus metas laborales.</p>
                            <a href="#" class="read-more stretched-link">Más Información <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div><!-- Fin del Servicio -->

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-item item-red position-relative">
                        <i class="bi bi-bounding-box-circles icon"></i>
                        <div>
                            <h3>Conexión con Empleadores</h3>
                            <p>Facilitamos la conexión entre candidatos y empleadores, asegurando que cada oportunidad se ajuste a tus habilidades y aspiraciones.</p>
                            <a href="#" class="read-more stretched-link">Más Información <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div><!-- Fin del Servicio -->

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="service-item item-indigo position-relative">
                        <i class="bi bi-calendar4-week icon"></i>
                        <div>
                            <h3>Eventos y Talleres</h3>
                            <p>Organizamos eventos y talleres para ayudarte a mejorar tus habilidades y ampliar tu red profesional.</p>
                            <a href="#" class="read-more stretched-link">Más Información <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div><!-- Fin del Servicio -->

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="600">
                    <div class="service-item item-pink position-relative">
                        <i class="bi bi-chat-square-text icon"></i>
                        <div>
                            <h3>Asesoramiento Personalizado</h3>
                            <p>Ofrecemos asesoramiento personalizado para ayudarte a tomar decisiones informadas sobre tu carrera profesional.</p>
                            <a href="#" class="read-more stretched-link">Más Información <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div><!-- Fin del Servicio -->

            </div>

        </div>

    </section><!-- /Sección de Servicios -->


    <!-- More Features Section -->
    <section id="more-features" class="more-features section">

        <div class="container">

            <div class="row justify-content-around gy-4">

                <div class="col-lg-6 d-flex flex-column justify-content-center order-2 order-lg-1" data-aos="fade-up" data-aos-delay="100">
                    <h3>Conéctate con Oportunidades Laborales</h3>
                    <p>Facilitamos la conexión entre candidatos y empleadores, asegurando que cada oportunidad se ajuste a tus habilidades y aspiraciones.</p>

                    <div class="row">

                        <div class="col-lg-6 icon-box d-flex">
                            <i class="bi bi-easel flex-shrink-0"></i>
                            <div>
                                <h4>Oportunidades Diversas</h4>
                                <p>Encuentra ofertas laborales en una amplia variedad de industrias y sectores.</p>
                            </div>
                        </div><!-- Fin del Icono -->

                        <div class="col-lg-6 icon-box d-flex">
                            <i class="bi bi-patch-check flex-shrink-0"></i>
                            <div>
                                <h4>Apoyo Constante</h4>
                                <p>Te acompañamos en cada paso del proceso de selección para asegurar tu éxito.</p>
                            </div>
                        </div><!-- Fin del Icono -->

                        <div class="col-lg-6 icon-box d-flex">
                            <i class="bi bi-brightness-high flex-shrink-0"></i>
                            <div>
                                <h4>Desarrollo Profesional</h4>
                                <p>Ofrecemos recursos y consejos para ayudarte a crecer profesionalmente.</p>
                            </div>
                        </div><!-- Fin del Icono -->

                        <div class="col-lg-6 icon-box d-flex">
                            <i class="bi bi-brightness-high flex-shrink-0"></i>
                            <div>
                                <h4>Conexiones Valiosas</h4>
                                <p>Conéctate con empleadores que valoran tu talento y dedicación.</p>
                            </div>
                        </div><!-- Fin del Icono -->

                    </div>

                </div>

                <div class="features-image col-lg-5 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="200">
                    <img src="assets/img/features-3.jpg" alt="">
                </div>

            </div>

        </div>

    <!-- Sección de Testimonios -->
<section id="testimonials" class="testimonials section light-background">

    <!-- Título de la Sección -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Testimonios</h2>
        <p>Conoce las experiencias de nuestros usuarios y cómo hemos ayudado a conectar talento con oportunidades.</p>
    </div><!-- Fin del Título de la Sección -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
            <script type="application/json" class="swiper-config">
                {
                    "loop": true,
                    "speed": 600,
                    "autoplay": {
                        "delay": 5000
                    },
                    "slidesPerView": "auto",
                    "pagination": {
                        "el": ".swiper-pagination",
                        "type": "bullets",
                        "clickable": true
                    },
                    "breakpoints": {
                        "320": {
                            "slidesPerView": 1,
                            "spaceBetween": 40
                        },
                        "1200": {
                            "slidesPerView": 3,
                            "spaceBetween": 1
                        }
                    }
                }
            </script>
            <div class="swiper-wrapper">

                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <div class="stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p>
                            Gracias a esta plataforma, encontré el trabajo de mis sueños en una empresa que valora mi talento y dedicación.
                        </p>
                        <div class="profile mt-auto">
                            <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                            <h3>Saul Goodman</h3>
                            <h4>CEO & Fundador</h4>
                        </div>
                    </div>
                </div><!-- Fin del Testimonio -->

                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <div class="stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p>
                            La asistencia y recursos proporcionados me ayudaron a prepararme para las entrevistas y asegurar una posición en una empresa líder.
                        </p>
                        <div class="profile mt-auto">
                            <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                            <h3>Sara Wilsson</h3>
                            <h4>Diseñadora</h4>
                        </div>
                    </div>
                </div><!-- Fin del Testimonio -->

                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <div class="stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p>
                            Encontré múltiples oportunidades laborales que se ajustaban a mis habilidades y experiencia, facilitando mi transición profesional.
                        </p>
                        <div class="profile mt-auto">
                            <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                            <h3>Jena Karlis</h3>
                            <h4>Propietaria de Tienda</h4>
                        </div>
                    </div>
                </div><!-- Fin del Testimonio -->

                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <div class="stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p>
                            La plataforma me conectó con empleadores que valoran mi experiencia y me ofrecieron un entorno de trabajo ideal.
                        </p>
                        <div class="profile mt-auto">
                            <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
                            <h3>Matt Brandon</h3>
                            <h4>Freelancer</h4>
                        </div>
                    </div>
                </div><!-- Fin del Testimonio -->

                <div class="swiper-slide">
                    <div class="testimonial-item">
                        <div class="stars">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p>
                            Gracias a esta plataforma, pude encontrar un trabajo que se ajusta perfectamente a mis habilidades y expectativas.
                        </p>
                        <div class="profile mt-auto">
                            <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
                            <h3>John Larson</h3>
                            <h4>Emprendedor</h4>
                        </div>
                    </div>
                </div><!-- Fin del Testimonio -->

            </div>
            <div class="swiper-pagination"></div>
        </div>

    </div>

</section><!-- /Sección de Testimonios -->


  </main>

  <footer id="footer" class="footer position-relative light-background">



    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">QuickStart</strong><span>All Rights Reserved</span></p>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you've purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
        Designed by <a href="#">ofertas laborales</a>
      </div>
    </div>

  </footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
