<?php session_start(); ?>
<html lang="pt-br">
	<head>
		<meta charset="utf-8">
		<title>Study Timer</title>
		<meta content="width=device-width, initial-scale=1.0" name="viewport">
		<meta content="" name="keywords">
		<meta content="" name="description">
		<meta charset="utf-8" />

		<!-- Favicons -->
		<link href="img/icon.png" rel="icon">
		<link href="img/icon.png" rel="apple-touch-icon">

		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800" rel="stylesheet">

		<!-- Bootstrap CSS File -->
		<link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

		<!-- Libraries CSS Files -->
		<link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<link href="lib/animate/animate.min.css" rel="stylesheet">
		<link href="lib/venobox/venobox.css" rel="stylesheet">
		<link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

		<!-- Main Stylesheet File -->
		<link href="css/style.css" rel="stylesheet">
		<link rel="stylesheet" href="css/main.css">
		
		<!-- Validações Javascript File -->
		<script src="js/validacao.js"></script>
	</head>
	<body>
		<?php
			include_once("conexao/conexao.php");
			if(isset($_SESSION['log'])){
				$codigo = $_SESSION['cd_usuario'];
			}
			if(isset($_SESSION['erro'])){
				echo "<script>alert('".$_SESSION['erro']."');</script>";
				unset($_SESSION['erro']);
			}
			if(isset($_SESSION['msg'])){
				echo "<script>alert('".$_SESSION['msg']."');</script>";
				unset($_SESSION['msg']);
			}
			
			if(isset($_SESSION['notificacao'])){
				echo "<script>alert('".$_SESSION['notificacao']."');</script>";
				unset($_SESSION['notificacao']);
			}
			
		?>
		<!--==========================
			Header
		============================-->
		<header id="header">
			<div class="container">

				<div id="logo" class="pull-left">
					<!-- Uncomment below if you prefer to use a text logo -->
					<!-- <h1><a href="#main">C<span>o</span>nf</a></h1>-->
					<a href="#intro" class="scrollto"><img src="img/logo.png" alt="" title=""></a>
				</div>

				<nav id="nav-menu-container">
					<ul class="nav-menu">
						<li class="menu-active"><a href="#intro"><i class="fa fa-home" aria-hidden="true"></i>&nbsp Home</a></li>
						<?php if(isset($_SESSION['log'])){ ?>
						<!--<li><a href="#about"><i class="fa fa-calendar-check-o" aria-hidden="true"></i>&nbsp Tarefa</a></li>
						<!--<li><a href="#speakers">Speakers</a></li>-->
						<li><a href="#schedule"><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp  Cronograma</a></li>
						<?php } ?>
						<!--<li><a href="#venue">Venue</a></li>
						<li><a href="#hotels">Hotels</a></li>
						<li><a href="#gallery">Gallery</a></li>
						<li><a href="#supporters">Sponsors</a></li>-->
						<li><a href="#contact"><i class="fa fa-phone" aria-hidden="true"></i>&nbsp Contato</a></li>
						<!-- <li class="buy-tickets"><a href="#buy-tickets">Buy Tickets</a></li> -->
						<?php if(isset($_SESSION['log'])){ ?>
							<div class="d-flex">
							  <div class="btn-group">
								<button type="button" class="btn-dropdown dropdown-toggle dropdown-toggle-split" id="dropdownMenuReference" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-reference="parent">
								  <?php echo $_SESSION['nm_login']; ?>
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
								  <a class="dropdown-item" href="conta.php"><i class="fa fa-user" aria-hidden="true"></i>&nbsp Conta</a>
								  <a class="dropdown-item" href="status.php"><i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp Status</a>
								  <a class="dropdown-item" href="sair.php"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp Sair</a>
								</div>
							  </div>
							</div>
						<?php }else{ ?>
						<li class="buy-tickets"><a href="#" data-toggle="modal" data-target="#login-modal" data-ticket-type="premium-access">Login/Cadastro</a></li>
						<?php } ?>
					</ul>

				</nav>
				<!-- #nav-menu-container -->
			</div>

		</header>
		<!-- #header -->
		<!-- Load -->
		<div id="loader-wrapper">
			<div id="loader"><img src="img/tomate1.gif" width="300px" height="300px" /></div>

			<div class="loader-section section-left"></div>
			<div class="loader-section section-right"></div>

		</div>
		<!-- Modal Order Form Login/Cadastro -->
		<div id="login-modal" class="modal fade" align="center">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-body forms">
					<form name="formCad" method="POST" action="cadastro_usuario.php" class="register-form" onSubmit="return validacao();">
						<div class="modal-header">
							<h4 class="modal-title">Cadastro</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<input type="text" class="form-control" name="nome" id="nome" placeholder="Nome" maxlength="100" autofocus  />
						<input type="text" class="form-control" name="login" id="login" placeholder="Login"  maxlength="45" />
						<input type="password" class="form-control" name="senha" id="senha" placeholder="Senha" maxlength="45" />
						<input type="password" class="form-control" name="confirmaSenha" id="confirmaSenha" placeholder="ConfirmaSenha" maxlength="45" />
						<input type="text" class="form-control" name="email" id="email" placeholder="Email"  maxlength="45" />
						<!--<button type="submit" class="btn">Cadastrar</button>-->
						<input class="btn" name="btnCad" id="btnCad" type="submit" value="Cadastrar" style="background-color: #c2210f"/>
						<p class="message">Já registrado?  <a href="#">Entre aqui</a></p>
					</form>
					<form name="formLog" action="valida_login.php" method="POST" class="login-form" onSubmit="return validacaoLog();">
						<div class="modal-header">
							<h4 class="modal-title">Login</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<input type="text" class="form-control" id="login" name="login" placeholder="Login" autofocus  />
						<input type="password" class="form-control" id="senha" name="senha" placeholder="Senha"  />
						<div class="text-center">
							<!--<button type="submit" class="btn">login</button>-->
							<input class="btn" name="btnLogin" type="submit" value="Login" style="background-color: #c2210f"/>
						</div>
						<p class="message">Não registrado? <a href="#">Crie a sua conta aqui</a></p>
					</form>
				</div>
			</div>
		</div>

		<!--==========================
			Intro Section
		============================-->
		<section id="intro">
			<div class="intro-container wow fadeIn">
				<div id="timer-panel">
					
					<span id="img"><img src="img/lendo-livro-1.gif" width="550px" height="300px" /></span>
					<div id="timer-panel">
						<h1 class="mb-4 pb-0"><span id="showtime"></span></h1>
						<!-- Start, Pause and Stop Buttons -->
						
						<div class="col-xs-12" id="button-panel">
							<span id="startResume">
								<button type="button" class="btn btn-transparent" id="start" onclick="start()"><i class="fa fa-play" aria-hidden="true"></i></button>
							</span>
							<button type="button" class="btn btn-transparent" id="pause" onclick="pause()"><i class="fa fa-pause" aria-hidden="true"></i></button>
							
							<button type="button" class="btn btn-transparent" id="reset" onclick="reset()"><i class="fa fa-repeat" aria-hidden="true"></i></button>
						</div>
					</div>
				<!-- end of xs-12 -->
				
				</div>
				<a data-toggle="modal" data-target="#myModalConf" class="about-btn scrollto">Configurações</a>
				<!--<h1 class="mb-4 pb-0">The Annual<br><span>Marketing</span> Conference</h1>
				<p class="mb-4 pb-0">10-12 December, Downtown Conference Center, New York</p>
				<a href="https://www.youtube.com/watch?v=jDDaplaOz7Q" class="venobox play-btn mb-4" data-vbtype="video" data-autoplay="true"></a>
				<a href="#about" class="about-btn scrollto">About The Event</a>-->
			</div>
			<!-- Inicio Modal de Configurações -->
			<div class="modal fade" id="myModalConf" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
						<h4 class="modal-title text-center" id="myModalLabel">Configurações</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							
						</div>
						<div class="modal-body" align="center">
							<div class="col-xs-12" id="heading-panel">
								<!-- main heading -->
								<h3> Pomodoro </h3>
								<i class="far fa-stopwatch" style="font-size:100px;"></i>
							</div>
							<!-- end of xs-12 -->
							<!-- Work Section -->
							<div  id="work-duration">
								<h7> Duração do pomodoro </h7><br>
								<button class="btn btn-default upperpanelBtn" id="addWorkButton">+</button>
								<h7 id="work-display"> 25</h7>
								<button class="btn btn-default upperpanelBtn" id="minusWorkButton">-</button>
							</div>
							<!-- end of xs-12 -->
							<!-- Break Div -->
							<div  id="break-duration">
								<h7> Duração da pausa </h7><br>
								<button class="btn btn-default upperpanelBtn" id="addBreakButton"> + </button>
								<h7 id="break-display">5</h7>
								<button class="btn btn-default upperpanelBtn" id=minusBreakButton> - </button>
							</div>
							<!-- end of xs-12 -->
							
							<!-- Timer Div -->
							
							<!-- end of xs-12 -->
						</div>
					</div>
				</div>
			</div><!-- Fim Modal -->
		</section>

		<main id="main">

			<!--==========================
				About Section
			============================-->
			<!--<section id="about">
				<div class="container">
					
					<div class="row">
						<div class="col-lg-12">
						
						</div>
					</div>
				</div>
			</section>-->

			<!--==========================
				Speakers Section
			============================-->
			<!--<section id="speakers" class="wow fadeInUp">
				<div class="container">
					<div class="section-header">
						<h2>Event Speakers</h2>
						<p>Here are some of our speakers</p>
					</div>

					<div class="row">
						<div class="col-lg-4 col-md-6">
							<div class="speaker">
								<img src="img/speakers/1.jpg" alt="Speaker 1" class="img-fluid">
								<div class="details">
									<h3><a href="speaker-details.html">Brenden Legros</a></h3>
									<p>Quas alias incidunt</p>
									<div class="social">
										<a href=""><i class="fa fa-twitter"></i></a>
										<a href=""><i class="fa fa-facebook"></i></a>
										<a href=""><i class="fa fa-google-plus"></i></a>
										<a href=""><i class="fa fa-linkedin"></i></a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="speaker">
								<img src="img/speakers/2.jpg" alt="Speaker 2" class="img-fluid">
								<div class="details">
									<h3><a href="speaker-details.html">Hubert Hirthe</a></h3>
									<p>Consequuntur odio aut</p>
									<div class="social">
										<a href=""><i class="fa fa-twitter"></i></a>
										<a href=""><i class="fa fa-facebook"></i></a>
										<a href=""><i class="fa fa-google-plus"></i></a>
										<a href=""><i class="fa fa-linkedin"></i></a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="speaker">
								<img src="img/speakers/3.jpg" alt="Speaker 3" class="img-fluid">
								<div class="details">
									<h3><a href="speaker-details.html">Cole Emmerich</a></h3>
									<p>Fugiat laborum et</p>
									<div class="social">
										<a href=""><i class="fa fa-twitter"></i></a>
										<a href=""><i class="fa fa-facebook"></i></a>
										<a href=""><i class="fa fa-google-plus"></i></a>
										<a href=""><i class="fa fa-linkedin"></i></a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="speaker">
								<img src="img/speakers/4.jpg" alt="Speaker 4" class="img-fluid">
								<div class="details">
									<h3><a href="speaker-details.html">Jack Christiansen</a></h3>
									<p>Debitis iure vero</p>
									<div class="social">
										<a href=""><i class="fa fa-twitter"></i></a>
										<a href=""><i class="fa fa-facebook"></i></a>
										<a href=""><i class="fa fa-google-plus"></i></a>
										<a href=""><i class="fa fa-linkedin"></i></a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="speaker">
								<img src="img/speakers/5.jpg" alt="Speaker 5" class="img-fluid">
								<div class="details">
									<h3><a href="speaker-details.html">Alejandrin Littel</a></h3>
									<p>Qui molestiae natus</p>
									<div class="social">
										<a href=""><i class="fa fa-twitter"></i></a>
										<a href=""><i class="fa fa-facebook"></i></a>
										<a href=""><i class="fa fa-google-plus"></i></a>
										<a href=""><i class="fa fa-linkedin"></i></a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-md-6">
							<div class="speaker">
								<img src="img/speakers/6.jpg" alt="Speaker 6" class="img-fluid">
								<div class="details">
									<h3><a href="speaker-details.html">Willow Trantow</a></h3>
									<p>Non autem dicta</p>
									<div class="social">
										<a href=""><i class="fa fa-twitter"></i></a>
										<a href=""><i class="fa fa-facebook"></i></a>
										<a href=""><i class="fa fa-google-plus"></i></a>
										<a href=""><i class="fa fa-linkedin"></i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</section>-->
			<?php 
				if(isset($_SESSION['log'])){ 
					include_once('tarefa.php');
					include_once('cronograma.php');
				}
			?>
			<div id="id_frame" ></div>
			<!--==========================
				Venue Section
			============================-->
			<!--<section id="venue" class="wow fadeInUp">

				<div class="container-fluid">

					<div class="section-header">
						<h2>Event Venue</h2>
						<p>Event venue location info and gallery</p>
					</div>

					<div class="row no-gutters">
						<div class="col-lg-6 venue-map">
							<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" style="border:0" allowfullscreen></iframe>
						</div>

						<div class="col-lg-6 venue-info">
							<div class="row justify-content-center">
								<div class="col-11 col-lg-8">
									<h3>Downtown Conference Center, New York</h3>
									<p>Iste nobis eum sapiente sunt enim dolores labore accusantium autem. Cumque beatae ipsam. Est quae sit qui voluptatem corporis velit. Qui maxime accusamus possimus. Consequatur sequi et ea suscipit enim nesciunt quia velit.</p>
								</div>
							</div>
						</div>
					</div>

				</div>

				<div class="container-fluid venue-gallery-container">
					<div class="row no-gutters">

						<div class="col-lg-3 col-md-4">
							<div class="venue-gallery">
								<a href="img/venue-gallery/1.jpg" class="venobox" data-gall="venue-gallery">
									<img src="img/venue-gallery/1.jpg" alt="" class="img-fluid">
								</a>
							</div>
						</div>

						<div class="col-lg-3 col-md-4">
							<div class="venue-gallery">
								<a href="img/venue-gallery/2.jpg" class="venobox" data-gall="venue-gallery">
									<img src="img/venue-gallery/2.jpg" alt="" class="img-fluid">
								</a>
							</div>
						</div>

						<div class="col-lg-3 col-md-4">
							<div class="venue-gallery">
								<a href="img/venue-gallery/3.jpg" class="venobox" data-gall="venue-gallery">
									<img src="img/venue-gallery/3.jpg" alt="" class="img-fluid">
								</a>
							</div>
						</div>

						<div class="col-lg-3 col-md-4">
							<div class="venue-gallery">
								<a href="img/venue-gallery/4.jpg" class="venobox" data-gall="venue-gallery">
									<img src="img/venue-gallery/4.jpg" alt="" class="img-fluid">
								</a>
							</div>
						</div>

						<div class="col-lg-3 col-md-4">
							<div class="venue-gallery">
								<a href="img/venue-gallery/5.jpg" class="venobox" data-gall="venue-gallery">
									<img src="img/venue-gallery/5.jpg" alt="" class="img-fluid">
								</a>
							</div>
						</div>

						<div class="col-lg-3 col-md-4">
							<div class="venue-gallery">
								<a href="img/venue-gallery/6.jpg" class="venobox" data-gall="venue-gallery">
									<img src="img/venue-gallery/6.jpg" alt="" class="img-fluid">
								</a>
							</div>
						</div>

						<div class="col-lg-3 col-md-4">
							<div class="venue-gallery">
								<a href="img/venue-gallery/7.jpg" class="venobox" data-gall="venue-gallery">
									<img src="img/venue-gallery/7.jpg" alt="" class="img-fluid">
								</a>
							</div>
						</div>

						<div class="col-lg-3 col-md-4">
							<div class="venue-gallery">
								<a href="img/venue-gallery/8.jpg" class="venobox" data-gall="venue-gallery">
									<img src="img/venue-gallery/8.jpg" alt="" class="img-fluid">
								</a>
							</div>
						</div>

					</div>
				</div>

			</section>

			<!--==========================
				Hotels Section
			============================-->
			<!--<section id="hotels" class="section-with-bg wow fadeInUp">

				<div class="container">
					<div class="section-header">
						<h2>Hotels</h2>
						<p>Her are some nearby hotels</p>
					</div>

					<div class="row">

						<div class="col-lg-4 col-md-6">
							<div class="hotel">
								<div class="hotel-img">
									<img src="img/hotels/1.jpg" alt="Hotel 1" class="img-fluid">
								</div>
								<h3><a href="#">Hotel 1</a></h3>
								<div class="stars">
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
								</div>
								<p>0.4 Mile from the Venue</p>
							</div>
						</div>

						<div class="col-lg-4 col-md-6">
							<div class="hotel">
								<div class="hotel-img">
									<img src="img/hotels/2.jpg" alt="Hotel 2" class="img-fluid">
								</div>
								<h3><a href="#">Hotel 2</a></h3>
								<div class="stars">
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star-half-full"></i>
								</div>
								<p>0.5 Mile from the Venue</p>
							</div>
						</div>

						<div class="col-lg-4 col-md-6">
							<div class="hotel">
								<div class="hotel-img">
									<img src="img/hotels/3.jpg" alt="Hotel 3" class="img-fluid">
								</div>
								<h3><a href="#">Hotel 3</a></h3>
								<div class="stars">
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
								</div>
								<p>0.6 Mile from the Venue</p>
							</div>
						</div>

					</div>
				</div>

			</section>

			<!--==========================
				Gallery Section
			============================-->
			<!--<section id="gallery" class="wow fadeInUp">

				<div class="container">
					<div class="section-header">
						<h2>Gallery</h2>
						<p>Check our gallery from the recent events</p>
					</div>
				</div>

				<div class="owl-carousel gallery-carousel">
					<a href="img/gallery/1.jpg" class="venobox" data-gall="gallery-carousel"><img src="img/gallery/1.jpg" alt=""></a>
					<a href="img/gallery/2.jpg" class="venobox" data-gall="gallery-carousel"><img src="img/gallery/2.jpg" alt=""></a>
					<a href="img/gallery/3.jpg" class="venobox" data-gall="gallery-carousel"><img src="img/gallery/3.jpg" alt=""></a>
					<a href="img/gallery/4.jpg" class="venobox" data-gall="gallery-carousel"><img src="img/gallery/4.jpg" alt=""></a>
					<a href="img/gallery/5.jpg" class="venobox" data-gall="gallery-carousel"><img src="img/gallery/5.jpg" alt=""></a>
					<a href="img/gallery/6.jpg" class="venobox" data-gall="gallery-carousel"><img src="img/gallery/6.jpg" alt=""></a>
					<a href="img/gallery/7.jpg" class="venobox" data-gall="gallery-carousel"><img src="img/gallery/7.jpg" alt=""></a>
					<a href="img/gallery/8.jpg" class="venobox" data-gall="gallery-carousel"><img src="img/gallery/8.jpg" alt=""></a>
				</div>

			</section>

			<!--==========================
				Sponsors Section
		============================-->
			<!--<section id="supporters" class="section-with-bg wow fadeInUp">

				<div class="container">
					<div class="section-header">
						<h2>Sponsors</h2>
					</div>

					<div class="row no-gutters supporters-wrap clearfix">

						<div class="col-lg-3 col-md-4 col-xs-6">
							<div class="supporter-logo">
								<img src="img/supporters/1.png" class="img-fluid" alt="">
							</div>
						</div>

						<div class="col-lg-3 col-md-4 col-xs-6">
							<div class="supporter-logo">
								<img src="img/supporters/2.png" class="img-fluid" alt="">
							</div>
						</div>

						<div class="col-lg-3 col-md-4 col-xs-6">
							<div class="supporter-logo">
								<img src="img/supporters/3.png" class="img-fluid" alt="">
							</div>
						</div>

						<div class="col-lg-3 col-md-4 col-xs-6">
							<div class="supporter-logo">
								<img src="img/supporters/4.png" class="img-fluid" alt="">
							</div>
						</div>

						<div class="col-lg-3 col-md-4 col-xs-6">
							<div class="supporter-logo">
								<img src="img/supporters/5.png" class="img-fluid" alt="">
							</div>
						</div>

						<div class="col-lg-3 col-md-4 col-xs-6">
							<div class="supporter-logo">
								<img src="img/supporters/6.png" class="img-fluid" alt="">
							</div>
						</div>

						<div class="col-lg-3 col-md-4 col-xs-6">
							<div class="supporter-logo">
								<img src="img/supporters/7.png" class="img-fluid" alt="">
							</div>
						</div>

						<div class="col-lg-3 col-md-4 col-xs-6">
							<div class="supporter-logo">
								<img src="img/supporters/8.png" class="img-fluid" alt="">
							</div>
						</div>

					</div>

				</div>

			</section>

			<!--==========================
		  F.A.Q Section
		============================-->
			<!--<section id="faq" class="wow fadeInUp">

				<div class="container">

					<div class="section-header">
						<h2>F.A.Q </h2>
					</div>

					<div class="row justify-content-center">
						<div class="col-lg-9">
							<ul id="faq-list">

								<li>
									<a data-toggle="collapse" class="collapsed" href="#faq1">Non consectetur a erat nam at lectus urna duis? <i class="fa fa-minus-circle"></i></a>
									<div id="faq1" class="collapse" data-parent="#faq-list">
										<p>
											Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.
										</p>
									</div>
								</li>

								<li>
									<a data-toggle="collapse" href="#faq2" class="collapsed">Feugiat scelerisque varius morbi enim nunc faucibus a pellentesque? <i class="fa fa-minus-circle"></i></a>
									<div id="faq2" class="collapse" data-parent="#faq-list">
										<p>
											Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
										</p>
									</div>
								</li>

								<li>
									<a data-toggle="collapse" href="#faq3" class="collapsed">Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi? <i class="fa fa-minus-circle"></i></a>
									<div id="faq3" class="collapse" data-parent="#faq-list">
										<p>
											Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis
										</p>
									</div>
								</li>

								<li>
									<a data-toggle="collapse" href="#faq4" class="collapsed">Ac odio tempor orci dapibus. Aliquam eleifend mi in nulla? <i class="fa fa-minus-circle"></i></a>
									<div id="faq4" class="collapse" data-parent="#faq-list">
										<p>
											Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
										</p>
									</div>
								</li>

								<li>
									<a data-toggle="collapse" href="#faq5" class="collapsed">Tempus quam pellentesque nec nam aliquam sem et tortor consequat? <i class="fa fa-minus-circle"></i></a>
									<div id="faq5" class="collapse" data-parent="#faq-list">
										<p>
											Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim suspendisse in est ante in. Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit adipiscing bibendum est. Purus gravida quis blandit turpis cursus in
										</p>
									</div>
								</li>

								<li>
									<a data-toggle="collapse" href="#faq6" class="collapsed">Tortor vitae purus faucibus ornare. Varius vel pharetra vel turpis nunc eget lorem dolor? <i class="fa fa-minus-circle"></i></a>
									<div id="faq6" class="collapse" data-parent="#faq-list">
										<p>
											Laoreet sit amet cursus sit amet dictum sit amet justo. Mauris vitae ultricies leo integer malesuada nunc vel. Tincidunt eget nullam non nisi est sit amet. Turpis nunc eget lorem dolor sed. Ut venenatis tellus in metus vulputate eu scelerisque. Pellentesque diam volutpat commodo sed egestas egestas fringilla phasellus faucibus. Nibh tellus molestie nunc non blandit massa enim nec.
										</p>
									</div>
								</li>

							</ul>
						</div>
					</div>

				</div>

			</section>

			<!--==========================
		  Subscribe Section
		============================-->
			<!--<section id="subscribe">
				<div class="container wow fadeInUp">
					<div class="section-header">
						<h2>Newsletter</h2>
						<p>Rerum numquam illum recusandae quia mollitia consequatur.</p>
					</div>

					<form method="POST" action="#">
						<div class="form-row justify-content-center">
							<div class="col-auto">
								<input type="text" class="form-control" placeholder="Enter your Email">
							</div>
							<div class="col-auto">
								<button type="submit">Subscribe</button>
							</div>
						</div>
					</form>

				</div>
			</section>

			<!--==========================
		  Buy Ticket Section
		============================-->
			<!--<section id="buy-tickets" class="section-with-bg wow fadeInUp">
				<div class="container">

					<div class="section-header">
						<h2>Buy Tickets</h2>
						<p>Velit consequatur consequatur inventore iste fugit unde omnis eum aut.</p>
					</div>

					<div class="row">
						<div class="col-lg-4">
							<div class="card mb-5 mb-lg-0">
								<div class="card-body">
									<h5 class="card-title text-muted text-uppercase text-center">Standard Access</h5>
									<h6 class="card-price text-center">$150</h6>
									<hr>
									<ul class="fa-ul">
										<li><span class="fa-li"><i class="fa fa-check"></i></span>Regular Seating</li>
										<li><span class="fa-li"><i class="fa fa-check"></i></span>Coffee Break</li>
										<li><span class="fa-li"><i class="fa fa-check"></i></span>Custom Badge</li>
										<li class="text-muted"><span class="fa-li"><i class="fa fa-times"></i></span>Community Access</li>
										<li class="text-muted"><span class="fa-li"><i class="fa fa-times"></i></span>Workshop Access</li>
										<li class="text-muted"><span class="fa-li"><i class="fa fa-times"></i></span>After Party</li>
									</ul>
									<hr>
									<div class="text-center">
										<button type="button" class="btn" data-toggle="modal" data-target="#buy-ticket-modal" data-ticket-type="standard-access">Buy Now</button>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4">
							<div class="card mb-5 mb-lg-0">
								<div class="card-body">
									<h5 class="card-title text-muted text-uppercase text-center">Pro Access</h5>
									<h6 class="card-price text-center">$250</h6>
									<hr>
									<ul class="fa-ul">
										<li><span class="fa-li"><i class="fa fa-check"></i></span>Regular Seating</li>
										<li><span class="fa-li"><i class="fa fa-check"></i></span>Coffee Break</li>
										<li><span class="fa-li"><i class="fa fa-check"></i></span>Custom Badge</li>
										<li><span class="fa-li"><i class="fa fa-check"></i></span>Community Access</li>
										<li class="text-muted"><span class="fa-li"><i class="fa fa-times"></i></span>Workshop Access</li>
										<li class="text-muted"><span class="fa-li"><i class="fa fa-times"></i></span>After Party</li>
									</ul>
									<hr>
									<div class="text-center">
										<button type="button" class="btn" data-toggle="modal" data-target="#buy-ticket-modal" data-ticket-type="pro-access">Buy Now</button>
									</div>
								</div>
							</div>
						</div>
						<!-- Pro Tier -->
						<!--<div class="col-lg-4">
							<div class="card">
								<div class="card-body">
									<h5 class="card-title text-muted text-uppercase text-center">Premium Access</h5>
									<h6 class="card-price text-center">$350</h6>
									<hr>
									<ul class="fa-ul">
										<li><span class="fa-li"><i class="fa fa-check"></i></span>Regular Seating</li>
										<li><span class="fa-li"><i class="fa fa-check"></i></span>Coffee Break</li>
										<li><span class="fa-li"><i class="fa fa-check"></i></span>Custom Badge</li>
										<li><span class="fa-li"><i class="fa fa-check"></i></span>Community Access</li>
										<li><span class="fa-li"><i class="fa fa-check"></i></span>Workshop Access</li>
										<li><span class="fa-li"><i class="fa fa-check"></i></span>After Party</li>
									</ul>
									<hr>
									<div class="text-center">
										<button type="button" class="btn" data-toggle="modal" data-target="#buy-ticket-modal" data-ticket-type="premium-access">Buy Now</button>
									</div>

								</div>
							</div>
						</div>
					</div>

				</div>

				<!-- Modal Order Form -->
				<!--<div id="buy-ticket-modal" class="modal fade">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">Buy Tickets</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form method="POST" action="#">
									<div class="form-group">
										<input type="text" class="form-control" name="your-name" placeholder="Your Name">
									</div>
									<div class="form-group">
										<input type="text" class="form-control" name="your-email" placeholder="Your Email">
									</div>
									<div class="form-group">
										<select id="ticket-type" name="ticket-type" class="form-control">
											<option value="">-- Select Your Ticket Type --</option>
											<option value="standard-access">Standard Access</option>
											<option value="pro-access">Pro Access</option>
											<option value="premium-access">Premium Access</option>
										</select>
									</div>
									<div class="text-center">
										<button type="submit" class="btn">Buy Now</button>
									</div>
								</form>
							</div>
						</div>
						<!-- /.modal-content -->
					<!--</div>
					<!-- /.modal-dialog -->
				<!--</div>
				<!-- /.modal -->

			<!--</section>

			<!--==========================
		  Contato Section
		============================-->
			<section id="contact" class="section-bg wow fadeInUp">

				<div class="container">

					<div class="section-header">
						<h2>Contato</h2>
						<p></p>
					</div>

					<div class="row contact-info">

						<div class="col-md-4">
							<div class="contact-address">
								<i class="ion-ios-location-outline"></i>
								<h3>Endereço</h3>
								<address>Praia Grande, SP</address>
							</div>
						</div>

						<div class="col-md-4">
							<div class="contact-phone">
								<i class="ion-ios-telephone-outline"></i>
								<h3>Número de Telefone</h3>
								<p><a href="tel:"></a></p>
							</div>
						</div>

						<div class="col-md-4">
							<div class="contact-email">
								<i class="ion-ios-email-outline"></i>
								<h3>Email</h3>
								<p><a href="mailto:studytimeretec2019@gmail.com">studytimeretec2019@gmail.com</a></p>
							</div>
						</div>

					</div>

					<div class="form">
						<div id="sendmessage">Sua mensagem foi enviada. Obrigado!</div>
						<div id="errormessage"></div>
						<form action="" method="post" role="form" class="contactForm">
							<div class="form-row">
								<div class="form-group col-md-6">
									<input type="text" name="nome" class="form-control" id="nome" placeholder="Nome" data-rule="minlen:4" data-msg="Por favor, insira pelo menos 4 caracteres" value="<?php if(isset($_SESSION['log'])){echo $_SESSION['nm_usuario'];}?>"/>
									<div class="validation"></div>
								</div>
								<div class="form-group col-md-6">
									<input type="email" class="form-control" name="email" id="email" placeholder="Email" data-rule="email" data-msg="Por favor digite um email válido" value="<?php if(isset($_SESSION['log'])){echo $_SESSION['nm_email'];}?>"/>
									<div class="validation"></div>
								</div>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="assunto" id="assunto" placeholder="Assunto" data-rule="minlen:4" data-msg="Por favor, insira pelo menos 8 caracteres de assunto" />
								<div class="validation"></div>
							</div>
							<div class="form-group">
								<textarea class="form-control" name="mensagem" rows="5" data-rule="required" data-msg="Por favor, escreva algo para nós" placeholder="Mensagem"></textarea>
								<div class="validation"></div>
							</div>
							<div class="text-center">
								<button type="submit">Enviar mensagem</button>
							</div>
						</form>
					</div>

				</div>
			</section>
			<!-- #contact -->

		</main>

		<!--==========================
		Footer
	  ============================-->
		<footer id="footer">
			<div class="footer-top">
				<div class="container">
					<div class="row">

						<div class="col-lg-4 col-md-6 footer-info">
							<img src="img/logo.png" alt="TheEvenet">
							<!--<p>In alias aperiam. Placeat tempore facere. Officiis voluptate ipsam vel eveniet est dolor et totam porro. Perspiciatis ad omnis fugit molestiae recusandae possimus. Aut consectetur id quis. In inventore consequatur ad voluptate cupiditate debitis accusamus repellat cumque.</p>-->
						</div>

						<div class="col-lg-4 col-md-6 footer-links">
							<h4>LINKS ÚTEIS</h4>
							<ul>
								<li><i class="fa fa-angle-right"></i> <a href="#">Home</a></li>
								<li><i class="fa fa-angle-right"></i> <a href="#">Sobre nós</a></li>
								<li><i class="fa fa-angle-right"></i> <a href="#">Serviços</a></li>
								<li><i class="fa fa-angle-right"></i> <a href="#">Termos de serviço</a></li>
								<li><i class="fa fa-angle-right"></i> <a href="#">Política de Privacidade</a></li>
							</ul>
						</div>

						<div class="col-lg-4 col-md-6 footer-contact">
							<h4>CONTATE-NOS</h4>
							<p>
								Praia Grande
								<br> São Paulo
								<br> Brasil
								<br>
								<strong>Telefone:</strong> 
								<br>
								<strong>Email:</strong> studytimeretec2019@gmail.com
								<br>
							</p>

							<div class="social-links">
								<a href="#" class="twitter"><i class="fa fa-twitter"></i></a>
								<a href="https://www.facebook.com/M%C3%A9todo-de-gerenciamento-de-estudos-para-ingressantes-Etec-1071422383043482/" class="facebook"><i class="fa fa-facebook"></i></a>
								<a href="#" class="instagram"><i class="fa fa-instagram"></i></a>
								<a href="#" class="google-plus"><i class="fa fa-google-plus"></i></a>
								<a href="#" class="linkedin"><i class="fa fa-linkedin"></i></a>
							</div>

						</div>

					</div>
				</div>
			</div>

			<div class="container">
				<!--<div class="copyright">
					&copy; Copyright <strong>TheEvent</strong>. All Rights Reserved
				</div>
				<div class="credits">-->
					<!--
			  All the links in the footer should remain intact.
			  You can delete the links only if you purchased the pro version.
			  Licensing information: https://bootstrapmade.com/license/
			  Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/buy/?theme=TheEvent
			-->
					<!--Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>-->
				</div>
			</div>
		</footer>
		<!-- #footer -->

		<a href="#" class="back-to-top"><i class="fa fa-angle-up"></i></a>

		<!-- JavaScript Libraries -->
		<script src="lib/jquery/jquery.min.js"></script>
		<script src="lib/jquery/jquery-migrate.min.js"></script>
		<script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="lib/easing/easing.min.js"></script>
		<script src="lib/superfish/hoverIntent.js"></script>
		<script src="lib/superfish/superfish.min.js"></script>
		<script src="lib/wow/wow.min.js"></script>
		<script src="lib/venobox/venobox.min.js"></script>
		<script src="lib/owlcarousel/owl.carousel.min.js"></script>

		<!-- Contact Form JavaScript File -->
		<script src="contactform/contactform.js"></script>

		<!-- Template Main Javascript File -->
		<script src="js/main.js"></script>
		
		<!-- Timer Javascript File -->
		<script src="js/timer.js"></script>
		
		
		
		<script>
			
			
			function recarrega()
            {
                //O método $.ajax(); é o responsável pela requisição
                $.ajax
                        ({
                            //Configurações
                            type: 'POST',//Método que está sendo utilizado.
                            dataType: 'html',//É o tipo de dado que a página vai retornar.
                            url: 'cronograma.php',//Indica a página que está sendo solicitada.
                            //função que vai ser executada assim que a requisição for enviada
                            beforeSend: function () {
                                $("#i_frame").html("Carregando...");
                            },
                            data: {palavra: palavra},//Dados para consulta
                            //função que será executada quando a solicitação for finalizada.
                            success: function (msg)
                            {
                                $("#i_frame").html(msg);
                            }
                        });
            }
			console.log(recarrega());
		</script>
		
	</body>

</html>